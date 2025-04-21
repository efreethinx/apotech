@extends('layouts.app')

@section('title', 'Data Supplier')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('supplier.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                </x-slot>

                <x-table id="table">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('supplier.form')
@endsection

@push('js')
    <script>
        let table;

        $(function() {
            table = $('#table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('supplier.data') }}',
                },
                language: {
                    url: '{{ asset('json/Indonesian.json') }}'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                        className: 'text-center',
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'no_telepon'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('#modal-form form').validator().on('submit', function(e) {
                e.preventDefault();

                if (!this.checkValidity()) return;

                $.post($(this).attr('action'), $(this).serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        showAlert(response.message, 'success');
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            });
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Data Supplier');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        function editForm(id_supplier) {
            const url = '{{ route('supplier.edit', ':id') }}'.replace(':id', id_supplier);

            $.get(url)
                .done((response) => {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Data Supplier');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', '{{ route('supplier.update', ':id') }}'.replace(':id',
                        id_supplier));
                    $('#modal-form [name=_method]').val('put');

                    $('#modal-form [name=nama]').val(response.data.nama);
                    $('#modal-form [name=no_telepon]').val(response.data.no_telepon);
                    $('#modal-form [name=alamat]').val(response.data.alamat);
                })
                .fail((errors) => {
                    showAlert('Data tidak ditemukan', 'danger');
                });
        }

        function deleteData(id_supplier) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                const url = '{{ route('supplier.destroy', ':id') }}'.replace(':id', id_supplier);
                $.post(url, {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        '_method': 'DELETE'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        showAlert(response.message, 'success');
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            }
        }
    </script>
@endpush
