@extends('layouts.app')

@section('title', 'Pengeluaran')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pengeluaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('pengeluaran.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                </x-slot>

                <x-table id="table-pengeluaran">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('pengeluaran.form')
@endsection

@push('js')
    <script>
        let table;

        $(function() {
            table = $('#table-pengeluaran').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('pengeluaran.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                        className: 'text-center',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'deskripsi'
                    },
                    {
                        data: 'nominal'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });


            // Validator form
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
            $('#modal-form .modal-title').text('Tambah Pengeluaran');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=deskripsi]').focus();
        }

        function editForm(id_pengeluaran) {
            const url = '{{ route('pengeluaran.edit', ':id') }}'.replace(':id', id_pengeluaran);
            console.log("Edit URL: ", url);
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Pengeluaran');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', '{{ route('pengeluaran.update', ':id') }}'.replace(':id', id_pengeluaran));
            $('#modal-form [name=_method]').val('put');

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=deskripsi]').val(response.data.deskripsi);
                    $('#modal-form [name=nominal]').val(response.data.nominal);
                })
                .fail((errors) => {
                    showAlert(errors.responseJSON.message, 'danger');
                });
        }

        function deleteData(id_pengeluaran) {
            if (confirm('Yakin ingin menghapus pengeluaran ini?')) {
                const url = '{{ route('pengeluaran.destroy', ':id') }}'.replace(':id', id_pengeluaran);
                $.post(url, {
                        '_token': $('[name="csrf-token"]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        showAlert(response.message, 'success')
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message);
                    });
            }
        }
    </script>
@endpush
