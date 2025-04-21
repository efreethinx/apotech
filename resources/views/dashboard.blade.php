@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ format_uang(0) }}</h3>

                    <p>Data Kategori</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cube"></i>
                </div>
                <a href="{{ route('kategori.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ format_uang(0) }}</h3>

                    <p>Data Obat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-pills"></i>
                </div>
                <a href="{{ route('obat.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ format_uang(0) }}</h3>

                    <p>Data Pengguna</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('user.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ format_uang(0) }}</h3>

                    <p>Data Supplier</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="{{ route('supplier.index') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Komponen Obat -->
    <div class="row">
        <section class="col-lg-12 connectedSortable">
            <x-card>
                <x-slot name="header">
                    <h3 class="card-title">
                        <i class="fas fa-capsules mr-1"></i>
                        Komponen Obat
                    </h3>
                </x-slot>

                <div class="card-body">
                    <table class="table-bordered table">
                        <tbody>
                            <tr>
                                <td>Telah Kedaluwarsa</td>
                                <td style="width: 70%">
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 83%;">83%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kedaluwarsa Bulan Ini</td>
                                <td style="width: 70%">
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 80%;">80%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kedaluwarsa 6 Bulan ke Depan</td>
                                <td style="width: 70%">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" style="width: 40%;">40%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Stok Habis</td>
                                <td style="width: 70%">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width: 60%;">60%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Obat Terlaris</td>
                                <td style="width: 70%">
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 90%;">90%</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
        </section>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="nav-icon fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Penjualan Hari Ini</span>
                    <span class="info-box-number">Rp 0,-</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        <br>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="nav-icon fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Penjualan Bulan Ini</span>
                    <span class="info-box-number">Rp 0,-</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        <br>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="nav-icon fas fa-receipt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Pembelian Hari Ini</span>
                    <span class="info-box-number">Rp 0,-</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        <br>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="nav-icon fas fa-receipt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Pembelian Bulan ini</span>
                    <span class="info-box-number">Rp 0,-</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        <br>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row mt-3">
        <!-- Keuntungan Hari Ini -->
        <div class="col-lg-4 col-12">
            <div class="info-box">
                <div class="info-box-content text-center">
                    <p>Keuntungan Hari Ini</p>
                    <h3>Rp 0,-</h3>
                </div>
            </div>
        </div>

        <!-- Keuntungan Bulan Ini -->
        <div class="col-lg-4 col-12">
            <div class="info-box">
                <div class="info-box-content text-center">
                    <p>Keuntungan Bulan Ini</p>
                    <h3>Rp 0,-</h3>
                </div>
            </div>
        </div>

        <!-- Keuntungan Tahun Ini -->
        <div class="col-lg-4 col-12">
            <div class="info-box">
                <div class="info-box-content text-center">
                    <p>Keuntungan Tahun Ini</p>
                    <h3>Rp 0,-</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <x-card>
                <x-slot name="header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Laporan penjualan dan pembelian {{ date('Y') }}
                    </h3>
                </x-slot>

                <div class="mb-2 text-center">
                    {{ tanggal_indonesia(date('Y-01-01')) }} s/d {{ tanggal_indonesia(date('Y-12-31')) }}
                </div>

                <div>
                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
            </x-card>
        </section>
    </div>
@endsection

@push('js')
    <script>
        var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
        var salesChartData = {
            labels: @json([]),
            datasets: []
        }
        var salesChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }

        var salesChart = new Chart(salesChartCanvas, {
            type: 'line',
            data: salesChartData,
            options: salesChartOptions
        })
    </script>
@endpush
