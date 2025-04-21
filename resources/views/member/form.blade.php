<x-modal>
    <x-slot name="title">Tambah Data Member</x-slot>

    <div class="form-group row">
        <label for="nama" class="col-lg-3">Nama</label>
        <div class="col-lg-9">
            <input type="text" name="nama" id="nama" class="form-control" required autofocus>
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
            <textarea name="alamat" id="alamat" rows="3" class="form-control"></textarea>
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
