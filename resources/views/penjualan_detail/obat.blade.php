<div class="modal fade" id="modal-obat" tabindex="-1" role="dialog" aria-labelledby="modal-obat">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Obat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-obat">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%">No</th>
                            <th>ID Obat</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obat as $key => $item)
                            <tr>
                                <td width="5%">{{ $key + 1 }}</td>
                                <td>{{ $item->id_obat }}</td>
                                <td>{{ $item->nama_obat }}</td>
                                <td>{{ $item->harga_jual }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs"
                                        onclick="pilihObat('{{ $item->id_obat }}', '{{ $item->nama_obat }}')">
                                        <i class="fas fa-check-circle"></i> Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    $(document).ready(function() {
        $('.table-obat').DataTable({
            paging: true,
            searching: true,
            language: {
                url: '{{ asset('json/Indonesian.json') }}'
            },
            // Pastikan serverSide dihilangkan jika Anda menampilkan data langsung dari HTML
            serverSide: false
        });
    });
</script>
@endpush
