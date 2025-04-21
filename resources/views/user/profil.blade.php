@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <ul class="nav nav-pills" id="profileTabsContent" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="editProfileTab" data-toggle="tab" href="#editProfile"
                                role="tab" aria-controls="editProfile" aria-selected="true">Edit Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="changePasswordTab" data-toggle="tab" href="#changePassword"
                                role="tab" aria-controls="changePassword" aria-selected="false">Ulang Password</a>
                        </li>
                    </ul>
                </x-slot>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="profileTabsContent">
                    <!-- Edit Profile Tab -->
                    <div class="tab-pane fade show active" id="editProfile" role="tabpanel"
                        aria-labelledby="editProfileTab">
                        <form action="{{ route('user.update_profil') }}" method="post" class="form-profil" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="alert alert-info alert-dismissible" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-check"></i> Perubahan berhasil disimpan
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-lg-2 control-label">Nama</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="name" class="form-control" id="name" required
                                            autofocus value="{{ $profil->name }}">
                                        <x-invalid-feedback />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-6">
                                        <input type="email" name="email" class="form-control" id="email" required
                                            value="{{ $profil->email }}">
                                        <x-invalid-feedback />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="path_foto" class="col-lg-2 control-label">Profil</label>
                                    <div class="col-lg-4">
                                        <input type="file" name="path_foto" class="form-control" id="path_foto"
                                            onchange="preview('.tampil-foto', this.files[0])">
                                        <x-invalid-feedback />
                                        <img class="tampil-foto mt-3" src="{{ $profil->url_foto }}" width="120" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_telepon" class="col-lg-2 control-label">No. Telepon</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="no_telepon" class="form-control" id="no_telepon"
                                            required value="{{ $profil->no_telepon }}">
                                        <x-invalid-feedback />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="alamat" class="col-lg-2 control-label">Alamat</label>
                                    <div class="col-lg-6">
                                        <textarea name="alamat" class="form-control" id="alamat" rows="3">{{ $profil->alamat }}</textarea>
                                        <x-invalid-feedback />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tempat_lahir" class="col-lg-2 control-label">Tempat Lahir</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                            value="{{ $profil->tempat_lahir }}">
                                        <x-invalid-feedback />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tanggal_lahir" class="col-lg-2 control-label">Tanggal Lahir</label>
                                    <div class="col-lg-6">
                                        <input type="date" name="tanggal_lahir" class="form-control"
                                            id="tanggal_lahir"
                                            value="{{ now()->parse($profil->tanggal_lahir)->format('Y-m-d') }}">
                                        <x-invalid-feedback />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="role" class="col-lg-2 control-label">Role</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="role" id="role"
                                            value="{{ $profil->role }}" disabled>
                                    </div>
                                </div>

                            </div>
                            <div class="box-footer text-right">
                                <button class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Tab -->
                    <div class="tab-pane fade" id="changePassword" role="tabpanel" aria-labelledby="changePasswordTab">
                        <form action="{{ route('user.updatePassword') }}" method="post" class="form-change-password"
                            novalidate>
                            @csrf
                            <div class="form-group row">
                                <label for="old_password" class="col-lg-2 control-label">Password Lama</label>
                                <div class="col-lg-6">
                                    <input type="password" name="old_password" id="old_password" class="form-control"
                                        minlength="6" required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-lg-2 control-label">Password Baru</label>
                                <div class="col-lg-6">
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        minlength="6" required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-lg-2 control-label">Konfirmasi
                                    Password</label>
                                <div class="col-lg-6">
                                    <input type="password" name="new_password_confirmation"
                                        id="new_password_confirmation" class="form-control" data-match="#new_password"
                                        required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="box-footer text-right">
                                <button class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Ubah Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $('#old_password').on('keyup', function() {
                if ($(this).val() != "") {
                    $('#new_password, #new_password_confirmation').attr('required', true);
                } else {
                    $('#new_password, #new_password_confirmation').attr('required', false);
                }
            });

            $('.form-profil, .form-change-password').validator().on('submit', function(e) {
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
                        if ($(this).hasClass('form-profil')) {
                            $('.user-photo').attr('src', response.data.url_foto);
                            $('.user-name').text(response.data.name)
                        } else {
                            $(this)[0].reset()
                        }

                        showAlert(response.message, 'success');
                    })
                    .fail((errors) => {
                        showAlert(errors.responseJSON.message, 'danger');
                    });
            });
        });
    </script>
@endpush
