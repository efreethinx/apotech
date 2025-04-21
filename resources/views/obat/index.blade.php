@extends('layouts.app')

@section('title', 'Data Obat')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Obat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('obat.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah
                    </button>
                    <button onclick="deleteSelected('{{ route('obat.delete_selected') }}')" class="btn btn-sm btn-danger"><i
                            class="fas fa-trash"></i> Hapus
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
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Merk Obat</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Keterangan</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>

                </x-table>
            </x-card>
        </div>
    </div>

    @include('obat.form')
@endsection

@push('js')
    <script>
        let table;

        // Menginisialisasi DataTable Untuk Menampilkan Data Dari Server
        $(function() {
            table = $('#table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('obat.data') }}',
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
                        data: 'kode_obat'
                    },
                    {
                        data: 'nama_obat'
                    },
                    {
                        data: 'nama_kategori'
                    },
                    {
                        data: 'nama_satuan'
                    },
                    {
                        data: 'merk_obat'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'harga_jual'
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
                        showAlert(response.message, 'success');
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            });

            $('[name=select_all]').on('click', function() {
                $('input[name="id_obat[]"]').prop('checked', this.checked);
            });
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Obat');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_obat]').focus();
        }


        function editForm(id_obat) {
            const url = '{{ route('obat.edit', ':id') }}'.replace(':id', id_obat);

            $.get(url)
                .done((response) => {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Data Obat');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', '{{ route('obat.update', ':id') }}'.replace(':id', id_obat));
                    $('#modal-form [name=_method]').val('put');

                    $('#modal-form [name=nama_obat]').val(response.data.nama_obat);
                    $('#modal-form [name=id_kategori]').val(response.data.id_kategori);
                    $('#modal-form [name=id_satuan]').val(response.data.id_satuan);
                    $('#modal-form [name=merk_obat]').val(response.data.merk_obat);
                    $('#modal-form [name=harga_beli]').val(response.data.harga_beli);
                    $('#modal-form [name=harga_jual]').val(response.data.harga_jual);
                    $('#modal-form [name=keterangan]').val(response.data.keterangan);
                })
                .fail((errors) => {
                    showAlert(errors.responseJSON.message, 'danger');
                });
        }

        function deleteData(id_obat) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                const url = '{{ route('obat.destroy', ':id') }}'.replace(':id', id_obat);
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
                    });
            }
        }

        function deleteSelected(url) {
            const selected = $('input[name="id_obat[]"]:checked'); // Ambil checkbox yang dipilih
            if (selected.length > 0) {
                if (confirm('Yakin ingin menghapus data terpilih?')) {
                    let ids = [];
                    selected.each(function() {
                        ids.push($(this).val());
                    });

                    $.post(url, {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'id_obat': ids // Kirim array ID
                        })
                        .done((response) => {
                            table.ajax.reload();
                            showAlert('Data berhasil dihapus', 'success');
                        })
                        .fail((errors) => {
                            showAlert('Tidak dapat menghapus data', 'danger');
                        });
                }
            } else {
                alert('Pilih data yang akan dihapus');
            }
        }
    </script>
@endpush
