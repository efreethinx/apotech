@extends('layouts.app')

@section('title', 'Data Member')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Member</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                    <button onclick="cetakMember('{{ route('member.cetak_member') }}')" class="btn btn-sm btn-dark">
                        <i class="fas fa-id-card"></i> Cetak Member
                    </button>
                </x-slot>

                <x-table id="table">
                    <x-slot name="thead">
                        <tr>
                            <th width="2.5%">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select_all" name="select_all">
                                    <label class="custom-control-label border-light" for="select_all"></label>
                                </div>
                            </th>
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

    @include('member.form')
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
                    url: '{{ route('member.data') }}',
                },
                language: {
                    url: '{{ asset('json/Indonesian.json') }}'
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false

                    },
                    {
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
                        showAlert(response.message, 'success')
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            });

            $('#select_all').on('click', function() {
                $(':checkbox').prop('checked', this.checked);
            });
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Member');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        function editForm(url) {

            $.get(url)
                .done((response) => {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Member');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('put');

                    $('#modal-form [name=nama]').val(response.data.nama);
                    $('#modal-form [name=no_telepon]').val(response.data.no_telepon);
                    $('#modal-form [name=alamat]').val(response.data.alamat);
                })
                .fail((errors) => {
                    showAlert(errors.responseJSON.message, 'danger');
                });
        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'DELETE'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        showAlert(response.message, 'success');
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message);
                    });
            }
        }

        function cetakMember(url) {
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak');
                return;
            } else {
                $('.form-member')
                    .attr('target', '_blank')
                    .attr('action', url)
                    .submit();
            }
        }
    </script>
@endpush
