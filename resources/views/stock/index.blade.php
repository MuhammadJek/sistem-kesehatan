@extends('layouts.app')
@section('content')
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Stock Barang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Stock Barang</div>1
                    {{-- <div class="breadcrumb-item">Default Layout</div> --}}
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">This is List Daftar Stock Barang</h2>
                <p class="section-lead">Di sini letak daftar semua Stock Barang.</p>
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h4>List Stock Barang</h4>
                        {{-- <a class="btn btn-info" href="javascript:void(0)" id="createNewProduct"> Add New Product</a> --}}

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered my-2" id="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="js-not-exportable">kode barang</th>
                                        <th>Nama barang</th>
                                        <th>Quantity</th>
                                        <th class="js-not-exportable">Action</th>
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
    @include('stock.modal-detail')
    @include('layouts.footer')

    @push('scripts')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                barangTable();
                showDetailModal();
            });

            function barangTable() {
                $('#data-table').DataTable({
                    layout: {
                        topStart: {
                            buttons: [{
                                extend: 'pdf',
                                text: 'Export PDF',
                                className: 'btn btn-danger',
                                exportOptions: {
                                    columns: ':visible :not(.js-not-exportable)'
                                }
                            }, {
                                extend: 'csv',
                                text: 'Export Excel',
                                className: 'btn btn-success',
                                exportOptions: {
                                    columns: ':visible :not(.js-not-exportable)'
                                }
                            }, ],

                        }
                    },
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('stock.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'kode_barang',
                            name: 'kode_barang',
                        },
                        {
                            data: 'nama_barang',
                            name: 'nama_barang',
                        },
                        {
                            data: 'quantity',
                            name: 'quantity',
                        },

                        {
                            data: 'action',
                            name: 'action',
                            exportable: false,
                            orderable: false,
                            searchable: false,
                            buttons: false,
                        },
                    ],
                });
            }

            function showDetailModal(e) {
                let id = e.getAttribute('data-id');
                // console.log(id);
                $.ajax({

                    type: "GET",
                    url: "stock/" + id,
                    success: function(response) {
                        $('#kode_barang').text(response.data.kode_barang);
                        $('#nama_barang').text(response.data.barang.nama_barang);
                        $('#quantity').text(response.data.quantity);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
                $('#modalDetail').modal('show');
            }
        </script>
    @endpush
@endsection
