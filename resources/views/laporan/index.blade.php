@extends('layouts.app')

@section('title', 'Laporan Pendapatan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan Pendapatan</li>
@endsection

@section('content')
<div class="row">
    <!-- Card to hold the title and buttons -->
    <div class="col-lg-12">
        <x-card>
            <x-slot name="header">
                <!-- Button to open the Ubah Periode Modal -->
                <button onclick="updatePeriode()" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                <button class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Export PDF</button>
            </x-slot>

            <!-- Table of Laporan -->
            <x-table id="table">
                <x-slot name="thead">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Penjualan</th>
                        <th>Pembelian</th>
                        <th>Pengeluaran</th>
                        <th>Pendapatan</th>
                    </tr>
                </x-slot>
                <tbody>
                    @foreach ($laporan as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data['tanggal'] }}</td>
                            <td>{{ number_format($data['penjualan'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['pembelian'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['pendapatan'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        </x-card>
    </div>
</div>

@includeIf('laporan.form')
@endsection

@push('js')
<script>
function updatePeriode() {
        $('#modal-form').modal('show');
    }
</script>
@endpush
