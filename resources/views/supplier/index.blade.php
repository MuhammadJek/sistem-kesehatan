@extends('layouts.app')
@section('content')
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Supplier</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Supplier</a></div>
                    {{-- <div class="breadcrumb-item">Default Layout</div> --}}
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">This is List Daftar Supplier</h2>
                <p class="section-lead">Di sini letak daftar semua Supplier.</p>
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h4>List Supplier</h4>
                        {{-- <a class="btn btn-info" href="javascript:void(0)" id="createNewProduct"> Add New Product</a> --}}

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered my-3" id="data-table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>kode supplier</th>
                                        <th>nama supplier</th>
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
    @include('supplier.modal-detail')
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
                    ajax: "{{ route('supplier.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'kode_supplier',
                            name: 'kode_supplier',
                        },
                        {
                            data: 'nama_supplier',
                            name: 'nama_supplier',
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
                    url: "supplier/" + id,
                    success: function(response) {
                        $('#kode_supplier').text(response.data.kode_supplier);
                        $('#nama_supplier').text(response.data.nama_supplier);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
                $('#modalDetailSupplier').modal('show');
            }
        </script>
    @endpush
@endsection
