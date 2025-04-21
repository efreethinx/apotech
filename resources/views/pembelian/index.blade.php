@extends('layouts.app')

@section('title')
    Data Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm('{{ route('pembelian.store') }}')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Transaksi Baru
                    </button>
                    @if (session()->has('id_supplier'))
                        <a href="{{ route('pembelian.transaksi.index') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus-circle"></i> Transaksi Aktif
                        </a>
                    @endif
                </x-slot>

                <x-table id="table-pembelian">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('pembelian.supplier')
    @include('pembelian.detail')
@endsection

@push('js')
    <script>
        let table, table1, table2;

        $(function() {
            table = $('#table-pembelian').DataTable({
                responsive: true,
                processing: false,
                serverSide: false,
                autoWidth: false,
                language: {
                    url: '{{ asset('json/Indonesian.json') }}'
                },
                ajax: {
                    url: '{{ route('pembelian.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'supplier'
                    },
                    {
                        data: 'total_item'
                    },
                    {
                        data: 'total_harga'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'bayar'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            table1 = $('#table-detail').DataTable({
                responsive: true,
                processing: false,
                serverSide: false,
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_obat'
                    },
                    {
                        data: 'nama_obat'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'subtotal'
                    },
                ]
            });

            table2 = $('#table-supplier').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('pembelian.supplier.data') }}',
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
        });

        function addForm() {
            $('#modal-supplier').modal('show');
        }

        function showDetail(url) {
            $('#modal-detail').modal('show');

            table1.ajax.url(url);
            table1.ajax.reload();
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
    </script>
@endpush
