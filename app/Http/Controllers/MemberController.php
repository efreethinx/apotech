<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use PDF;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $members = Member::select('id_member', 'nama', 'no_telepon', 'alamat')->get();

        return datatables()
            ->of($members)
            ->addIndexColumn()
            ->addColumn('select_all', function ($member) {
                return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkbox-' . $member->id_member . '" name="id_member[]" value="' . $member->id_obat . '">
                        <label class="custom-control-label" for="checkbox-' . $member->id_member . '"></label>
                    </div>
                ';
            })
            ->addColumn('aksi', function ($member) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`' . route('member.update', $member->id_member) . '`)" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" onclick="deleteData(`' . route('member.destroy', $member->id_member) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['select_all', 'aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:member,nama',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $member = Member::create($request->only(['nama', 'no_telepon', 'alamat']));

        return $this->ok($member, 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $member = Member::find($id);

        if (!$member) {
            // Menggunakan method oops() jika data tidak ditemukan
            return $this->oops('Data tidak ditemukan', 404);
        }

        // Menggunakan method ok() untuk mengembalikan data member yang ditemukan
        return $this->ok($member);
    }


    public function edit($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        return $this->ok($member);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $member = Member::find($id);
        if (!$member) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $member->update($request->only(['nama', 'no_telepon', 'alamat']));

        return $this->ok($member, 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $member->delete();

        return $this->ok($member, 'Data berhasil dihapus');
    }

    public function cetakMember(Request $request)
    {
        $dataMembers = Member::whereIn('id_member', $request->id_member)->get();

        if ($dataMembers->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data yang dipilih'], 400);
        }

        $no = 1;
        $pdf = PDF::loadView('member.cetak', compact('dataMembers', 'no'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');

        return $pdf->stream('member.pdf');
    }
}
