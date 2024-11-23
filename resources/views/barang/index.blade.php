@extends('layouts.app')
@section('content')
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Barang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Barang</a></div>
                    {{-- <div class="breadcrumb-item">Default Layout</div> --}}
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">This is List Daftar Barang</h2>
                <p class="section-lead">Di sini letak daftar semua barang.</p>
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h4>List Barang</h4>
                        {{-- <a class="btn btn-info" href="javascript:void(0)" id="createNewProduct"> Add New Product</a> --}}

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="data-table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>kode barang</th>
                                        <th>nama barang</th>
                                        <th>satuan barang</th>
                                        <th>Action</th>
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
    @include('barang.modal-detail')
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
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('barang.index') }}",
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
                            data: 'satuan_barang',
                            name: 'satuan_barang',
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

            function showDetailModal(e) {
                let id = e.getAttribute('data-id');
                // console.log(id);
                $.ajax({

                    type: "GET",
                    url: "barang/" + id,
                    success: function(response) {
                        $('#kode_barang').text(response.data.kode_barang);
                        $('#nama_barang').text(response.data.nama_barang);
                        $('#satuan_barang').text(response.data.satuan_barang);
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
