<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        $user = User::all();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->editColumn('tanggal_lahir', fn($user) => $user->tanggal_lahir = Carbon::parse($user->tanggal_lahir))
            ->addColumn('aksi', function ($user) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(' . $user->id . ')" class="btn btn-sm btn-info">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button onclick="deleteData(' . $user->id . ')" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
            })
            ->rawColumns(['select_all', 'aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'no_telepon' => 'required',
            'role' => 'required|in:admin,kasir',
            'alamat' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'role' => $request->role,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        return $this->ok($user, 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        return $this->ok($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:6',
            'no_telepon' => 'required',
            'role' => 'required|in:admin,kasir',
            'alamat' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $user = User::find($id);
        if (!$user) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $data = $request->only(['name', 'email', 'no_telepon', 'role', 'alamat', 'tempat_lahir', 'tanggal_lahir']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return $this->ok($user, 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $user->delete();

        return $this->ok($user, 'User berhasil dihapus');
    }

    public function profil()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'no_telepon' => 'required',
            'alamat' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            'path_foto' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $user = User::find(auth()->id());
        $attributes = $request->except('path_foto', 'role');

        if ($request->hasFile('path_foto')) {
            delete_file($user->path_foto);
            $attributes['path_foto'] = upload_file('user', $request->file('path_foto'), 'path_foto');
        }

        $user->update($attributes);

        return $this->ok($user, 'Data berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->oops('Password lama tidak sesuai', 422);
        }

        if ($request->new_password !== $request->new_password_confirmation) {
            return $this->oops('Konfirmasi password tidak sesuai', 422);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return $this->ok($user, 'Password berhasil diperbarui');
    }
}
