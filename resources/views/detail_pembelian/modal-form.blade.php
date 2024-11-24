<!-- Modal -->
<div class="modal fade" id="modalFormDetail" tabindex="-1" aria-labelledby="modalFormDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="modalFormDetailLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="detailPembelianForm">
                <div class="modal-body border-top border-bottom">
                    <input type="hidden" name="uuid" id="uuid">
                    <input type="hidden" name="no_transaksi" value="{{ $pembelian->no_transaksi }}">
                    <div class="mb-3">
                        <label for="kode_barang">Pilih Barang</label>
                        <select class="form-control" id="kode_barang" name="kode_barang">
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->kode_barang }}">{{ $barang->nama_barang }} -
                                    {{ $barang->kode_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga_beli">Harga Beli
                        </label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Quantity
                        </label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="diskon_barang">Diskon (%)</label>
                        <input type="number" class="form-control" id="diskon_barang" name="diskon_barang"
                            min="1" max="100" required>
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
