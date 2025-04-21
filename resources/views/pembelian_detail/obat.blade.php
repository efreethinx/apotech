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
                <x-table class="table-obat">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Harga Beli</th>
                            <th class="text-center" style="width: 10%;"><i class="fas fa-cog"></i></th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>
</div>
