@extends('layouts.app')

@section('title', 'Stock Opname')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Stock Opname</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!-- Daftar Stok Obat -->
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('stok-opname.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                </x-slot>

                <x-table id="stok-table">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                            <th>Tanggal Update</th>
                            <th>Stok Status</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>

            <!-- Riwayat Tambah Stok -->
            <x-card>
                <x-slot name="header">
                    <h5>Riwayat Tambah Stok</h5>
                </x-slot>

                <x-table id="opname-table">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Obat</th>
                            <th>Stok Tercatat</th>
                            <th>Stok Fisik</th>
                            <th>Jumlah Selisih</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('stockopname.form')
@endsection

@push('js')
    <script>
        let stokTable, opnameTable;

$(function() {
    stokTable = $('#stok-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('stok.data') }}',
        },
        language: {
            url: '{{ asset('json/Indonesian.json') }}'
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                searchable: false, 
                sortable: false, 
                className: 'text-center' 
            },
            { data: 'obat.nama_obat' },
            { data: 'stok' },
            { data: 'tanggal_update' },
            {
    data: 'stok_status',
    render: function(data, type, row) {
        if (row.stok === 0) {
            return `<span class="badge bg-danger">Stok Habis</span>`;
        }
        return `<span class="badge bg-primary">Stok Tersedia</span>`;
    }
}

        ]
    });

    opnameTable = $('#opname-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('stok_opname.data') }}',
        },
        language: {
            url: '{{ asset('json/Indonesian.json') }}'
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                searchable: false, 
                sortable: false, 
                className: 'text-center' 
            },
            { data: 'obat.nama_obat' },
            { data: 'stok_tercatat' },
            { data: 'stok_fisik' },
            { data: 'jumlah' },
            { 
                data: 'aksi',
                searchable: false,
                sortable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-danger btn-sm" onclick="deleteData(${row.id})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    `;
                }
            }
        ]
    });
});



        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Data Stock');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        function deleteData(id) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                const url = '{{ route('stok-opname.destroy', ':id') }}'.replace(':id', id);
                $.post(url, {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        '_method': 'DELETE'
                    })
                    .done((response) => {
                        opnameTable.ajax.reload();
                        showAlert(response.message, 'success');
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            }
        }
    </script>
@endpush
