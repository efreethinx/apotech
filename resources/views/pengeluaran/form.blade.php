<x-modal>
    <x-slot name="title">Tambah Data Pengeluaran</x-slot>

    <div class="form-group row">
        <label for="deskripsi" class="col-lg-3">Deskripsi</label>
        <div class="col-lg-9">
            <input type="text" name="deskripsi" id="deskripsi" class="form-control" required autofocus>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="nominal" class="col-lg-3">Nominal</label>
        <div class="col-lg-9">
            <input type="text" name="nominal" id="nominal" class="form-control" required>
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
