<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="modalFormLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="pembelianForm">
                <div class="modal-body border-top border-bottom">
                    <input type="hidden" name="uuid" id="uuid">
                    <div class="mb-3">
                        <label for="kode_supplier">Pilih Supplier</label>
                        <select class="form-control" id="kode_supplier" name="kode_supplier">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($supplier as $suppliers)
                                <option value="{{ $suppliers->kode_supplier }}"><span
                                        class="font-bold">{{ $suppliers->nama_supplier }}</span> -
                                    {{ $suppliers->kode_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_beli">Tanggal Beli
                        </label>
                        <input type="date" class="form-control" id="tanggal_beli" name="tanggal_beli">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSubmit"></button>
                </div>
            </form>
        </div>
    </div>
</div>
