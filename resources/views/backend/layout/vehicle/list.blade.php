@extends('backend.app')

@section('title', 'Vehicle List')

@push('style')
    <style>
        #data-table th,
        #data-table td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush
@section('content')
    <main class="app-content content">
        <div class="row">
            <div class="col-lg-12 mb-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">Vehicle List</h4>
                    </div>
                    <div class="card-body">
                        <table id="data-table" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>sl</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    {{-- Datatable --}}
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            $(document).ready(function() {
                if (!$.fn.DataTable.isDataTable('#data-table')) {
                    $('#data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('vehicle.list') }}",
                        columns: [
                            {
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'brand',
                                name: 'brand'
                            },
                            {
                                data: 'category',
                                name: 'category'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'model',
                                name: 'model'
                            },
                            {
                                data: 'year',
                                name: 'year'
                            },
                            {
                                data: 'price',
                                name: 'price'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'status',
                                name: 'status',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                }
            });

        });
    </script>
@endpush

@push('script')
<script>
    function updateStatus(id) {
        $.ajax({
            url: "{{ route('vehicle.status') }}",
            type: "GET",
            data: {
                id: id
            },
            success: function(response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something Went Wrong'
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@endpush
