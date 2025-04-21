@extends('layouts.app')

@section('title')
    Transaksi Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}">Pembelian</a></li>
    <li class="breadcrumb-item active">Transaksi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <x-table class="table-bordered" style="margin: .5rem 0 !important;">
                        <tr>
                            <th style="width: 15%;">Supplier</th>
                            <td>{{ $supplier->nama }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $supplier->no_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $supplier->alamat }}</td>
                        </tr>
                    </x-table>
                </x-slot>

                <form class="form-obat">
                    @csrf
                    <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                    <input type="hidden" name="id_obat" id="id_obat">

                    <div class="form-group row">
                        <label for="nama_obat" class="col-lg-2">Nama Obat</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="text" class="form-control" name="nama_obat" id="nama_obat">
                                <div class="input-group-append">
                                    <button id="tombol-obat" class="btn btn-primary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <x-table class="table-pembelian">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Harga</th>
                            <th width="15%">Jumlah</th>
                            <th>SubTotal</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>

                <div class="row" style="transform: translateY(.75rem)">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary" id="tampil-bayar">Rp. 0</div>
                        <div class="tampil-terbilang">Rp. {{ terbilang(0) }}</div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                            @csrf
                            <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-3">Total</label>
                                <div class="col-lg-9">
                                    <input type="text" name="totalrp" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diskon" class="col-lg-3">Diskon</label>
                                <div class="col-lg-9">
                                    <input type="number" name="diskon" id="diskon" class="form-control" min="0"
                                        max="100" value="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bayarrp" class="col-lg-3">Bayar</label>
                                <div class="col-lg-9">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <x-slot name="footer">
                    <button type="submit" class="btn btn-primary btn-sm btn-simpan float-right">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                </x-slot>
            </x-card>
        </div>
    </div>

    @include('pembelian_detail.obat')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let table;

            table = $('.table-pembelian').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('pembelian.transaksi.data', $id_pembelian) }}',
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
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ],
                dom: 'Brt',
                bSort: false,
                paginate: false,
            }).on('draw.dt', function() {
                loadForm($('#diskon').val());
            });;

            $('.table-obat').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('pembelian.obat.data') }}',
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
                        data: 'kode_obat'
                    },
                    {
                        data: 'nama_obat'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('#tombol-obat').on('click', () => {
                $('#modal-obat').modal('show');
            });

            $(document).on('click', '.pilih-obat', function(e) {
                e.preventDefault();
                $('#id_obat').val($(this).data('id'));
                $('#nama_obat').val($(this).data('nama'));

                $.post('{{ route('pembelian.transaksi.store') }}', $('.form-obat').serialize())
                    .done(response => {
                        $('#nama_obat').focus();
                        $('#modal-obat').modal('hide');

                        table.ajax.reload();
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                    });
            });

            $(document).on('input', '.quantity', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const jumlah = parseInt($(this).val());

                if (jumlah < 1) {
                    $(this).val(1);
                    alert('Jumlah tidak boleh kurang dari 1');
                    return;
                }

                $.post('{{ route('pembelian.transaksi.update', ':id') }}'.replace(':id', id), {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'PUT',
                        'id_pembelian': '{{ $id_pembelian }}',
                        'jumlah': jumlah
                    })
                    .done(response => {
                        $(this).on('mouseout', function() {
                            table.ajax.reload(() => loadForm($('#diskon').val()));
                        });
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            });

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                $.post('{{ route('pembelian.transaksi.destroy', ':id') }}'.replace(':id', id), {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'DELETE',
                        'id_pembelian': '{{ $id_pembelian }}',
                    })
                    .done(response => {
                        table.ajax.reload();
                    })
                    .fail(errors => {
                        alert('Tidak dapat menghapus data');
                    });
            });

            $(document).on('input', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($(this).val());
            });

            $('.btn-simpan').on('click', function() {
                $('.form-pembelian').submit();
            });
        });

        function loadForm(diskon = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ route('pembelian.transaksi.load_form', [':diskon', ':total']) }}`
                    .replace(':diskon', diskon)
                    .replace(':total', $('.total').text())
                )
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.data.totalrp);
                    $('#bayarrp').val('Rp. ' + response.data.bayarrp);
                    $('#bayar').val(response.data.bayar);
                    $('.tampil-bayar').text('Rp. ' + response.data.bayarrp);
                    $('.tampil-terbilang').text(response.data.terbilang);
                }).fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }
    </script>
@endpush
