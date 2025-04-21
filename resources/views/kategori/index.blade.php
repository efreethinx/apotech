@extends('layouts.app')

@section('title', 'Data Kategori')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                </x-slot>

                <x-table id="table">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('kategori.form')
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
                    url: '{{ route('kategori.data') }}',
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
                        data: 'nama_kategori'
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
            $('#modal-form .modal-title').text('Tambah Data Kategori');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_kategori]').focus();
        }

        function editForm(id_kategori) {
            const url = '{{ route('kategori.edit', ':id') }}'.replace(':id', id_kategori);

            $.get(url)
                .done((response) => {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Data Kategori');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', '{{ route('kategori.update', ':id') }}'.replace(':id',
                        id_kategori));
                    $('#modal-form [name=_method]').val('put');

                    $('#modal-form [name=nama_kategori]').val(response.data.nama_kategori);
                    $('#modal-form [name=keterangan]').val(response.data.keterangan);
                })
                .fail((errors) => {
                    showAlert(errors.responseJSON.message, 'danger');
                });
        }

        function deleteData(id_kategori) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                const url = '{{ route('kategori.destroy', ':id') }}'.replace(':id', id_kategori);
                $.post(url, {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
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
