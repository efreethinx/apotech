@extends('layouts.app')

@section('title')
    Pengaturan
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('setting.update') }}" method="post" class="form-setting" novalidate
                enctype="multipart/form-data">
                @csrf

                <x-card>
                    <x-slot name="header">
                        <h5 class="card-title">Pengaturan Apotek</h5>
                    </x-slot>
                    <div class="form-group row">
                        <label for="nama_apotek" class="col-lg-2 control-label">Nama Apotek</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_apotek" class="form-control" id="nama_apotek"
                                value="{{ $setting->nama_apotek }}" required autofocus>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama_owner" class="col-lg-2 control-label">Nama Owner</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_owner" class="form-control" id="nama_owner"
                                value="{{ $setting->nama_owner }}" required>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat" class="col-lg-2 control-label">Alamat</label>
                        <div class="col-lg-6">
                            <textarea name="alamat" class="form-control" id="alamat" rows="3" required>{{ $setting->alamat }}</textarea>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_telepon" class="col-lg-2 control-label">No. Telepon</label>
                        <div class="col-lg-6">
                            <input type="text" name="no_telepon" class="form-control" id="no_telepon"
                                value="{{ $setting->no_telepon }}" required>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email_apotek" class="col-lg-2 control-label">Email Apotek</label>
                        <div class="col-lg-6">
                            <input type="email" name="email_apotek" class="form-control" id="email_apotek"
                                value="{{ $setting->email_apotek }}" required>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jam_buka" class="col-lg-2 control-label">Jam Buka</label>
                        <div class="col-lg-6">
                            <input type="time" name="jam_buka" class="form-control" id="jam_buka"
                                value="{{ $setting->jam_buka }}" required>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jam_tutup" class="col-lg-2 control-label">Jam Tutup</label>
                        <div class="col-lg-6">
                            <input type="time" name="jam_tutup" class="form-control" id="jam_tutup"
                                value="{{ $setting->jam_tutup }}" required>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diskon_member" class="col-lg-2 control-label">Diskon Member (%)</label>
                        <div class="col-lg-2">
                            <input type="number" name="diskon_member" class="form-control" id="diskon_member"
                                value="{{ $setting->diskon_member }}" required>
                            <x-invalid-feedback />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="path_logo" class="col-lg-2 control-label">Logo</label>
                        <div class="col-lg-4">
                            <input type="file" name="path_logo" class="form-control" id="path_logo"
                                onchange="preview('.tampil-logo', this.files[0])">
                            <x-invalid-feedback />
                            <img class="tampil-logo mt-3" src="{{ $setting->url_logo }}" width="120" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="path_kartu_member" class="col-lg-2 control-label">Kartu Member</label>
                        <div class="col-lg-4">
                            <input type="file" name="path_kartu_member" class="form-control" id="path_kartu_member"
                                onchange="preview('.tampil-kartu-member', this.files[0])">
                            <x-invalid-feedback />
                            <img class="tampil-kartu-member mt-3" src="{{ $setting->url_kartu_member }}"
                                height="200" />
                        </div>
                    </div>

                    <x-slot name="footer">
                        <button class="btn btn-sm btn-primary float-right"><i class="fas fa-save"></i> Simpan
                            Perubahan</button>
                    </x-slot>
                </x-card>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $('.form-setting').validator().on('submit', function(e) {
                e.preventDefault();

                if (!this.checkValidity()) return;

                $.post({
                        url: $(this).attr('action'),
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false
                    })
                    .done((response) => {
                        $('.brand-image, .tampil-logo').attr('src', response.data.url_logo);
                        $('[rel=icon]').attr('href', response.data.url_logo);

                        showAlert(response.message, 'success');
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            });
        });
    </script>
@endpush
