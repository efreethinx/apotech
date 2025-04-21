<x-modal>
    <x-slot name="title">Periode Laporan</x-slot>

    <!-- Tanggal Awal -->
    <div class="form-group row">
        <label for="tanggal_awal" class="col-lg-3 col-form-label">Tanggal Awal</label>
        <div class="col-lg-9">
            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control datepicker" required autofocus
                   value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
            <x-invalid-feedback />
        </div>
    </div>

    <!-- Tanggal Akhir -->
    <div class="form-group row">
        <label for="tanggal_akhir" class="col-lg-3 col-form-label">Tanggal Akhir</label>
        <div class="col-lg-9">
            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control datepicker" required
                   value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}" style="border-radius: 0 !important;">
            <x-invalid-feedback />
        </div>
    </div>

    <x-slot name="footer">
        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fa fa-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="fa fa-arrow-circle-left"></i> Batal
        </button>
    </x-slot>
</x-modal>
