@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@push('css')
    <style>
        .tampil-bayar {
            font-size: 5em;
            text-align: center;
            height: 100px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Transaksi Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="tampilObat()" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-circle-right"></i> Pilih Obat
                    </button>
                </x-slot>

                <form class="form-obat">
                    @csrf
                    <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                    <input type="hidden" name="id_obat" id="id_obat">
                </form>

                <x-table class="table-striped table-bordered table-penjualan">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Obat</th>
                            <th>Harga</th>
                            <th width="15%">Jumlah</th>
                            <th>Diskon</th>
                            <th>Subtotal</th>
                            <th width="15%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>

                <div class="row mt-3">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nama" value="{{ $memberSelected->nama }}">
                                        <span class="input-group-btn">
                                            <button onclick="tampilMember()" class="btn btn-primary" type="button">
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{ !empty($memberSelected->id_member) ? $diskon : 0 }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="number" id="diterima" class="form-control" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm pull-right btn-simpan">
                        <i class="fas fa-floppy-o"></i> Simpan Transaksi
                    </button>
                </div>
            </x-card>
        </div>
    </div>

    @include('penjualan_detail.obat')
    @include('penjualan_detail.member')
@endsection

@push('js')
    <script>
        let table, table2;

        $(function() {
            $('body').addClass('sidebar-collapse');

            table = $('.table-penjualan').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('transaksi.data', $id_penjualan) }}',
                },
                language: {
                    url: '{{ asset('json/Indonesian.json') }}'
                },
                columns: [
                    { data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center' },
                    { data: 'nama_obat' },
                    { data: 'harga_jual' },
                    { data: 'jumlah' },
                    { data: 'diskon' },
                    { data: 'subtotal' },
                    { data: 'aksi', searchable: false, sortable: false }
                ],
                dom: 'Brt',
                bSort: false,
                paginate: false
            }).on('draw.dt', function() {
                loadForm($('#diskon').val());
                setTimeout(() => {
                    $('#diterima').trigger('input');
                }, 300);
            });

            table2 = $('.table-obat').DataTable();

            $(document).on('input', '.quantity', function() {
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());

                if (jumlah < 1) {
                    $(this).val(1);
                    alert('Jumlah tidak boleh kurang dari 1');
                    return;
                }
                if (jumlah > 10000) {
                    $(this).val(10000);
                    alert('Jumlah tidak boleh lebih dari 10000');
                    return;
                }

                $.post(`{{ url('/transaksi') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                }).done(response => {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                }).fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
            });

            $(document).on('input', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }
                loadForm($(this).val());
            });

            $('#diterima').on('input', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }
                loadForm($('#diskon').val(), $(this).val());
            }).focus(function() {
                $(this).select();
            });

            $('.btn-simpan').on('click', function() {
                $('.form-penjualan').submit();
            });
        });

        function tampilObat() {
            $('#modal-obat').modal('show');
        }

        function tampilMember() {
            $('#modal-member').modal('show');
        }

        function loadForm(diskon = 0, diterima = 0) {
            // Function to calculate total, bayar, and kembalian
        }
    </script>
@endpush
