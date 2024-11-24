@extends('layouts.app')
@section('content')
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Barang Pembelian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Pembelian</a></div>
                    <div class="breadcrumb-item">Detail Pembelian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="d-flex align-items-center row">
                    <div class="d-block col">
                        <h2 class="section-title">Nomor Transaksi</h2>
                        <p class="section-lead">{{ $pembelian->no_transaksi }}</p>
                    </div>
                    <div class="d-block col">
                        <h2 class="section-title">Kode Supplier</h2>
                        <p class="section-lead">{{ $pembelian->kode_supplier }}</p>
                    </div>
                    <div class="d-block col">
                        <h2 class="section-title">Nama Supplier</h2>
                        <p class="section-lead">{{ $pembelian->supplier->nama_supplier }}</p>
                    </div>
                    <div class="d-block col">
                        <h2 class="section-title">Tanggal Beli</h2>
                        <p class="section-lead">
                            {{ Carbon\Carbon::parse($pembelian->tanggal_beli)->toFormattedDayDateString() }}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h4>List Barang Pembelian</h4>
                        <button class="btn btn-info" href="javascript:void(0)" onclick="showCreateModal()"
                            data-id="{{ $pembelian->uuid }}"> Add New Barang
                            Pembelian</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered my-3" id="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Transaksi</th>
                                        <th>Kode Barang</th>
                                        <th>Harga Beli</th>
                                        <th>Quantity</th>
                                        <th>Diskon</th>
                                        <th>Total Diskon Harga </th>
                                        <th class="text-center">Total Harga</th>
                                        <th style="width: auto;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        This is card footer
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('detail_pembelian.modal-form')
    @include('detail_pembelian.modal-detail')

    @include('layouts.footer')

    @push('scripts')
        <!-- Laravel Javascript Validation -->
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

        {!! JsValidator::formRequest('App\Http\Requests\DetailPembelianRequest', '#detailPembelianForm') !!}
        <script>
            let save_method;
            var notransaksi = "{{ $pembelian->no_transaksi }}";
            $(document).ready(function() {
                pembelianTable();
            });

            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp ' + rupiah;
            }

            function pembelianTable() {
                $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "/data-table/" + notransaksi,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-left',
                        },
                        {
                            data: 'no_transaksi',
                            name: 'no_transaksi',
                        },
                        {
                            data: 'kode_barang',
                            name: 'kode_barang',
                        },
                        {
                            data: 'harga_beli',
                            name: 'harga_beli',
                            className: 'text-center',
                            render: function(data, type, row) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(data);
                                // Output: Rp 1.000.000
                            },
                        },
                        {
                            data: 'quantity',
                            name: 'quantity',
                        },
                        {
                            data: 'diskon_barang',
                            name: 'diskon_barang',
                            render: function(data, type, row) {
                                return data + '%';
                                // Jika data 75, output: 75%
                            }
                        },
                        {
                            data: 'total_diskon_barang',
                            name: 'total_diskon_barang',
                            render: function(data, type, row) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(data);
                                // Output: Rp 1.000.000
                            },
                        },
                        {
                            data: 'total_harga_beli',
                            name: 'total_harga_beli',
                            render: function(data, type, row) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(data);
                                // Output: Rp 1.000.000
                            },
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                        },
                    ],

                });
            }

            function resetValidation() {
                $('.is-invalid').removeClass('is-invalid');
                $('.is-valid').removeClass('is-valid');
                $('span.invalid-feedback').remove();
            }

            function showCreateModal() {
                $('#detailPembelianForm')[0].reset();
                save_method = 'create';
                resetValidation();
                $('#modalFormDetail').modal('show');
                $('.modal-title').text('Create Barang Pembelian');
                $('.btnSubmit').text('Create');
            }

            function showDetailModal(e) {
                let id = e.getAttribute('data-id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "/detail-transaksi/" + notransaksi + "/" +
                        id,
                    success: function(response) {
                        let result = response.data;
                        $('#no_transaksis').text(result.no_transaksi);
                        $('#kode_barangs').text(result.kode_barang);
                        $('#harga_belis').text(formatRupiah(result.harga_beli));
                        $('#quantitys').text(result.quantity);
                        $('#diskon_barangs').text(result.diskon_barang + "%");
                        $('#total_diskon_barangs').text(formatRupiah(result.total_diskon_barang));
                        $('#total_harga_belis').text(formatRupiah(result.total_harga_beli));
                        // $('#uuid').text(result.uuid);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
                // $('#detailPembelianForm')[0].reset();
                $('#modalDetailPembelian').modal('show');
                // $('.modal-title').text('Edit Pembelian');
                // $('.btnSubmit').text('Update');
            }

            function showEditModal(e) {
                let id = e.getAttribute('data-id');

                save_method = 'update';
                resetValidation();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "/detail-transaksi/" + notransaksi + "/" +
                        id,
                    success: function(response) {
                        let result = response.data;
                        $('#kode_barang').val(result.kode_barang);
                        $('#harga_beli').val(result.harga_beli);
                        $('#quantity').val(result.quantity);
                        $('#diskon_barang').val(result.diskon_barang);
                        $('#uuid').val(result.uuid);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
                // $('#detailPembelianForm')[0].reset();
                $('#modalFormDetail').modal('show');
                $('.modal-title').text('Edit Pembelian');
                $('.btnSubmit').text('Update');
            }

            function deleteModal(e) {
                let id = e.getAttribute('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: "/detail-transaksi/" + notransaksi + "/" + id,
                            dataType: "json",
                            success: function(response) {
                                // $('#modalForm').modal('hide');
                                $('#data-table').DataTable().ajax.reload();

                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                });

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        })
                    }
                });
            }
            //Store dan Update data
            $('#detailPembelianForm').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                let url, method;
                url = "{{ route('detail.dataTable.store') }}";
                method = "POST";

                if (save_method == 'update') {
                    url = "/detail-transaksi/" + notransaksi + "/" + $('#uuid').val();
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: method,
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modalFormDetail').modal('hide');
                        $('#data-table').DataTable().ajax.reload();
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR);
                    }
                })
            });
        </script>
    @endpush
@endsection
