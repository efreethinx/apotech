@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                </x-slot>

                <x-table id="table">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Role</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('user.form')
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
                    url: '{{ route('user.data') }}',
                    type: 'GET',
                    dataSrc: function(json) {
                        json.data.forEach(function(item) {
                            item.tanggal_lahir = new Date(item.tanggal_lahir)
                                .toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                });
                        });
                        return json.data;
                    }
                },
                language: {
                    url: '{{ asset('json/Indonesian.json') }}'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'no_telepon'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'tempat_lahir'
                    },
                    {
                        data: 'tanggal_lahir'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    }
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
            $('#modal-form .modal-title').text('Tambah Pengguna');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();
            $('#modal-form [name=password]').attr('required', true);
            $('#modal-form [name=password_confirmation]').attr('required', true);
        }

        function editForm(id_user) {
            const url = '{{ route('user.edit', ':id') }}'.replace(':id', id_user);

            $.get(url)
                .done((response) => {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Pengguna');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', '{{ route('user.update', ':id') }}'.replace(':id', id_user));
                    $('#modal-form [name=_method]').val('put');
                    $('#modal-form [name=password]').attr('required', false);
                    $('#modal-form [name=password_confirmation]').attr('required', false);

                    $('#modal-form [name=name]').val(response.data.name);
                    $('#modal-form [name=email]').val(response.data.email);
                    $('#modal-form [name=no_telepon]').val(response.data.no_telepon);
                    $('#modal-form [name=alamat]').val(response.data.alamat);
                    $('#modal-form [name=tempat_lahir]').val(response.data.tempat_lahir);
                    $('#modal-form [name=tanggal_lahir]').val(response.data.tanggal_lahir.split('T')[0]);
                    $('#modal-form [name=role]').val(response.data.role);
                })
                .fail((errors) => {
                    showAlert(errors.responseJSON.message, 'danger');
                });
        }

        function deleteData(id_user) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                const url = '{{ route('user.destroy', ':id') }}'.replace(':id', id_user);
                $.post(url, {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        '_method': 'DELETE'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        showAlert(response.message, 'success')
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    })
            }
        }
    </script>
@endpush
