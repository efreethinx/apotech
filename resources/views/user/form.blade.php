<x-modal id="modal-form">
    <x-slot name="title">Tambah Data Pengguna</x-slot>

    <div class="form-group row">
        <label for="name" class="col-lg-3">Nama</label>
        <div class="col-lg-9">
            <input type="text" name="name" id="name" class="form-control" required autofocus>
            <x-invalid-feedback />
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-lg-3">Email</label>
        <div class="col-lg-9">
            <input type="email" name="email" id="email" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>
    <div class="form-group row">
        <label for="no_telepon" class="col-lg-3">No Telepon</label>
        <div class="col-lg-9">
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>
    <div class="form-group row">
        <label for="alamat" class="col-lg-3">Alamat</label>
        <div class="col-lg-9">
            <input type="text" name="alamat" id="alamat" class="form-control">
            <x-invalid-feedback />
        </div>
    </div>
    <div class="form-group row">
        <label for="tempat_lahir" class="col-lg-3">Tempat Lahir</label>
        <div class="col-lg-9">
            <textarea type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"></textarea>
            <x-invalid-feedback />
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_lahir" class="col-lg-3">Tanggal Lahir</label>
        <div class="col-lg-9">
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
            <x-invalid-feedback />
        </div>
    </div>
    <div class="form-group row">
        <label for="role" class="col-lg-3">Role</label>
        <div class="col-lg-9">
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-lg-3">Password</label>
        <div class="col-lg-9">
            <input type="password" class="form-control" name="password" id="password" required>
            <x-invalid-feedback />
        </div>
    </div>
    <div class="form-group row">
        <label for="password_confirmation" class="col-lg-3">Konfirmasi Password</label>
        <div class="col-lg-9">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                required>
            <x-invalid-feedback />
        </div>
    </div>

    <x-slot name="footer">
        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="fas fa-arrow-circle-left"></i> Batal
        </button>
    </x-slot>
</x-modal>
