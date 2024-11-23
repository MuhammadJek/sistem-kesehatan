@extends('layouts.app')
@section('content')
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Pembelian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pembelian</a></div>
                    {{-- <div class="breadcrumb-item">Default Layout</div> --}}
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">This is List Daftar Pembelian</h2>
                <p class="section-lead">Di sini letak daftar semua Pembelian.</p>
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h4>List Pembelian</h4>
                        <button class="btn btn-info" href="javascript:void(0)" onclick="showCreateModal()"> Add New
                            Pembelian</button>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered my-3" id="data-table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>No Transaksi</th>
                                        <th>Kode supplier</th>
                                        <th class="text-center">tanggal beli</th>
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
    @include('pembelian.modal-form')
    @include('layouts.footer')

    @push('scripts')
        <!-- Laravel Javascript Validation -->
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

        {!! JsValidator::formRequest('App\Http\Requests\PembelianRequest', '#pembelianForm') !!}
        <script>
            let save_method;
            $(document).ready(function() {
                pembelianTable();
            });

            function pembelianTable() {
                $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('transaksi.index') }}",
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
                            data: 'kode_supplier',
                            name: 'kode_supplier',
                        },

                        {
                            data: 'tanggal_beli',
                            name: 'tanggal_beli',
                            className: 'text-center',
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
                $('#pembelianForm')[0].reset();
                save_method = 'create';
                resetValidation();
                $('#modalForm').modal('show');
                $('.modal-title').text('Create Pembelian');
                $('.btnSubmit').text('Create');
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
                    url: "transaksi/" + id,
                    success: function(response) {
                        let result = response.data;
                        $('#no_transaksi').val(result.no_transaksi);
                        $('#kode_supplier').val(result.kode_supplier);
                        $('#tanggal_beli').val(result.tanggal_beli);
                        $('#uuid').val(result.uuid);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
                // $('#pembelianForm')[0].reset();
                $('#modalForm').modal('show');
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
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "DELETE",
                        url: "transaksi/" + id,
                        dataType: "json",
                        success: function(response) {
                            // $('#modalForm').modal('hide');
                            $('#data-table').DataTable().ajax.reload();
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    })
                });
            }
            //Store dan Update data
            $('#pembelianForm').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                let url, method;
                url = "{{ Route('transaksi.store') }}";
                method = "POST";

                if (save_method == 'update') {
                    url = "transaksi/" + $('#uuid').val();
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
                        $('#modalForm').modal('hide');
                        $('#data-table').DataTable().ajax.reload();
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                })
            });
        </script>
    @endpush
@endsection
