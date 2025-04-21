@extends('layouts.app')

@section('title', 'Data Satuan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Satuan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('satuan.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                </x-slot>

                <x-table id="table-satuan">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Satuan</th>
                            <th>Keterangan</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('satuan.form')
@endsection

@push('js')
    <script>
        let table;

        $(function() {
            table = $('#table-satuan').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('satuan.data') }}',
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
                        data: 'nama_satuan'
                    },
                    {
                        data: 'keterangan'
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
                        showAlert(response.message, 'success')
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            });
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Data Satuan');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_satuan]').focus();
        }

        function editForm(id_satuan) {
            const url = '{{ route('satuan.edit', ':id') }}'.replace(':id', id_satuan);

            $.get(url)
                .done((response) => {
                    console.log(response);
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Data Satuan');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', '{{ route('satuan.update', ':id') }}'.replace(':id',
                        id_satuan));
                    $('#modal-form [name=_method]').val('put');

                    $('#modal-form [name=nama_satuan]').val(response.data.nama_satuan);
                    $('#modal-form [name=keterangan]').val(response.data.keterangan);
                })
                .fail((errors) => {
                    showAlert(errors.responseJSON.message, 'danger');
                });
        }

        function deleteData(id_satuan) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                const url = '{{ route('satuan.destroy', ':id') }}'.replace(':id', id_satuan);
                $.post(url, {
                        '_token': $('[name="csrf-token"]').attr('content'),
                        '_method': 'DELETE'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        showAlert(response.message, 'success')
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message);
                    })
            }
        }
    </script>
@endpush
