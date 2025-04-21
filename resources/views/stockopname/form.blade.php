<x-modal>
    <x-slot name="title">Tambah Data Stock</x-slot>

    <div class="form-group row">
        <label for="id_obat" class="col-lg-3">Nama Obat</label>
        <div class="col-lg-9">
            <select name="id_obat" id="id_obat" class="form-control" required autofocus>
                <option value="">Pilih Obat</option>
                @foreach ($obat as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="stok_tercatat" class="col-lg-3">Stock Tercatat</label>
        <div class="col-lg-9">
            <input type="number" name="stok_tercatat" id="stok_tercatat" class="form-control" readonly required>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="stok_fisik" class="col-lg-3">Stock Fisik</label>
        <div class="col-lg-9">
            <input type="number" name="stok_fisik" id="stok_fisik" class="form-control" required>
            <x-invalid-feedback />
        </div>
    </div>

    <div class="form-group row">
        <label for="jumlah_selisih" class="col-lg-3">Jumlah Selisih</label>
        <div class="col-lg-9">
            <input type="number" name="jumlah_selisih" id="jumlah_selisih" class="form-control" readonly required>
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

@push('js')
<script>
    $('#id_obat').change(function() {
    const id = $(this).val();
    if (id) {
        $.get(`/stok-obat/${id}`, function(response) {
            $('#stok_tercatat').val(response.stok || 0);
        }).fail(function() {
            $('#stok_tercatat').val(0);
            alert('Data stok tidak ditemukan!');
        });
    }
});

$('#stok_fisik').on('input', function() {
    const stokTercatat = parseInt($('#stok_tercatat').val()) || 0;
    const stokFisik = parseInt($(this).val()) || 0;
    $('#jumlah_selisih').val(stokFisik - stokTercatat);
});

</script>
@endpush
