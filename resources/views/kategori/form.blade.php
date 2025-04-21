<x-modal>
    <x-slot name="title">Tambah Data Kategori</x-slot>

    <div class="form-group row">
        <label for="nama_kategori" class="col-lg-3">Kategori</label>
        <div class="col-lg-9">
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required autofocus>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="keterangan" class="col-lg-3">Keterangan</label>
        <div class="col-lg-9">
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
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