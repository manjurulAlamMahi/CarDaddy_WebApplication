@extends('backend.app')

@section('title', 'Specification Page')

@push('style')
@endpush

@section('content')
    <main class="app-content content">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-body">
                    <h6 class="card_heading mb-4">Color Specification <span id="contentTitle">Create</span></h6>
                    <form id="createContent" action="{{ route('color.store') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <label for="inputEmail3" class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" placeholder="name..."
                                    value="{{ old('name') }}">
                                <div style="display: none" class="text-danger nameExists">
                                    <i>Name </i>Already Exists
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="colorPicker" class="col-3 col-form-label">Color</label>
                            <div class="col-3">
                                <input type="color" id="colorPicker" name="code"
                                    class="form-control form-control-color" value="{{ old('code', '#000000') }}">
                            </div>
                            <label for="colorPicker" class="col-3 col-form-label">Code</label>
                            <div class="col-3">
                                <input type="text" id="colorCode" class="form-control" placeholder="Enter hex code..."
                                    value="{{ old('code', '#000000') }}">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-sm btn-primary">Create</button>
                        </div>
                    </form>
                    <form id="editContent" action="{{ route('color.update') }}" method="POST" style="display: none">
                        <input type="hidden" name="id" value="">
                        @csrf
                        <div class="row mb-2">
                            <label for="inputEmail3" class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" placeholder="name..."
                                    value="{{ old('name') }}">
                                <div style="display: none" class="text-danger nameExists">
                                    <i>Name </i>Already Exists
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="colorPicker" class="col-3 col-form-label">Color</label>
                            <div class="col-3">
                                <input type="color" id="colorPicker_edit" name="code"
                                    class="form-control form-control-color" value="{{ old('code', '#000000') }}">
                            </div>
                            <label for="colorPicker" class="col-3 col-form-label">Code</label>
                            <div class="col-3">
                                <input type="text" id="colorCode_edit" class="form-control" placeholder="Enter hex code..."
                                    value="{{ old('code', '#000000') }}">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 mb-1">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card_heading mb-4">Color Specification List</h6>
                        <table id="data-table" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Action</th>
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
    <script>
        $(document).ready(function() {
            // When the color input changes, update the text input
            $('#colorPicker').on('input', function() {
                $('#colorCode').val($(this).val());
            });

            // When the text input changes, update the color picker
            $('#colorCode').on('input', function() {
                let color = $(this).val();
                if (/^#([0-9A-F]{3}){1,2}$/i.test(color)) { // Validate hex color
                    $('#colorPicker').val(color);
                }
            });
        });
        $(document).ready(function() {
            // When the color input changes, update the text input
            $('#colorPicker_edit').on('input', function() {
                $('#colorCode').val($(this).val());
            });

            // When the text input changes, update the color picker
            $('#colorCode_edit').on('input', function() {
                let color = $(this).val();
                if (/^#([0-9A-F]{3}){1,2}$/i.test(color)) { // Validate hex color
                    $('#colorPicker').val(color);
                }
            });
        });
    </script>
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
                        ajax: "{{ route('color.index') }}",
                        columns: [{
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'code',
                                name: 'code'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                }
            });

        });
    </script>

    {{-- Exists Check --}}
    <script>
        $('input[name="name"]').on('keyup', function() {
            let input = $(this).val();
            let cateId = $('input[name="id"]').val();
            checkContentName(cateId, input);
        });

        function checkContentName(id, name) {
            $.ajax({
                url: "{{ route('color.get') }}",
                type: "GET",
                data: {
                    id: id,
                    name: name,
                },
                success: function(response) {
                    if (response.length > 0) {
                        $('.nameExists').show();
                    } else {
                        $('.nameExists').hide();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>

    {{-- Edit --}}
    <script>
        function editContent(id) {
            $.ajax({
                url: "{{ route('color.get') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response) {
                        $('#contentTitle').text('Update');
                        $('#editContent').show();
                        $('#createContent').hide();
                        $('#editContent input[name="id"]').val(response[0].id);
                        $('#editContent input[name="name"]').val(response[0].name);
                        $('#colorPicker_edit').val(response[0].code);
                        $('#colorCode_edit').val(response[0].code);

                        $('html, body').animate({
                            scrollTop: 0
                        }, 'slow');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
