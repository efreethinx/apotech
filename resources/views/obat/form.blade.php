<x-modal>
    <x-slot name="title">Tambah Data Obat</x-slot>

    <div class="form-group row">
        <label for="id_kategori" class="col-lg-3">Kategori</label>
        <div class="col-lg-9">
            <select name="id_kategori" id="id_kategori" class="form-control" required autofocus>
                <option value="">Pilih Kategori</option>
                @foreach ($kategori as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="id_satuan" class="col-lg-3">Satuan</label>
        <div class="col-lg-9">
            <select name="id_satuan" id="id_satuan" class="form-control" required>
                <option value="">Pilih Satuan</option>
                @foreach ($satuan as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="kode_obat" class="col-lg-3">Kode Obat</label>
        <div class="col-lg-9">
            <input type="text" name="kode_obat" id="kode_obat" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="nama_obat" class="col-lg-3">Nama Obat</label>
        <div class="col-lg-9">
            <input type="text" name="nama_obat" id="nama_obat" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="merk_obat" class="col-lg-3">Merk Obat</label>
        <div class="col-lg-9">
            <input type="text" name="merk_obat" id="merk_obat" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="harga_beli" class="col-lg-3">Harga Beli</label>
        <div class="col-lg-9">
            <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="harga_jual" class="col-lg-3">Harga Jual</label>
        <div class="col-lg-9">
            <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="keterangan" class="col-lg-3">Keterangan</label>
        <div class="col-lg-9">
            <input type="text" name="keterangan" id="keterangan" class="form-control" required>
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
