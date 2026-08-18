@extends('backend.app')

@section('title', 'Testimonial Page')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .ck-powered-by {
            display: none !important;
        }

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
            <div class="col-lg-4">
                <form id="testi_form" action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-body">
                        <h6 class="card_heading">ADD TESTIMONIAL</h6>
                        <input type="hidden" name="id" value="{{ old('id') }}">

                        <div class="mb-2">
                            <label for="" class="form-label">Client Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Stars</label>
                            <div id="rateYo"></div>
                            <input type="hidden" name="rating" id="rating-value" value="{{ old('rating') }}">
                            @error('rating')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Review</label>
                            <textarea class="form-control @error('review') is-invalid @enderror" name="review" cols="30" rows="10">{{ old('review') }}</textarea>
                            @error('review')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="" class="form-label">Client Image</label>
                            <input class="form-control dropify @error('image') is-invalid @enderror" type="file"
                                name="image" id="image"
                                data-default-file="{{ old('image') ? asset(old('image')) : asset('default.jpg') }}">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-sm btn-success">ADD</button>
                    </div>
                </form>

            </div>
            <div class="col-lg-8">
                <div class="card card-body">
                    <h6 class="card_heading">LIST TESTIMONIAL</h6>
                    <table id="data-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Ratings</th>
                                <th>Review</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
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
                        ajax: "{{ route('testimonial.index') }}",
                        columns: [{
                                data: 'image',
                                name: 'image',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'rating',
                                name: 'rating'
                            },
                            {
                                data: 'review',
                                name: 'review'
                            },
                            {
                                data: 'status',
                                name: 'status',
                                orderable: false,
                                searchable: false
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
    <script>
        $(document).ready(function() {
            $('.dropify').dropify(); // Initialize Dropify on page load
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#rateYo").rateYo({
                rating: 5, // Default rating
                starWidth: "30px",
                halfStar: true, // Enable half-star selection
                ratedFill: "#ffcc00", // Star color
                onSet: function(rating) {
                    $("#rating-value").val(rating);
                    console.log("Selected Rating: " + rating);
                }
            });
        });
    </script>
    {{-- Edit --}}
    <script>
        function editTestimonial(id) {
            $.ajax({
                url: "{{ route('testimonial.get') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response) {
                        let data = response[0]; // Assuming response is an array
                        let imagePath = "{{ asset('') }}" + data.image;

                        // Update form fields
                        $('#testi_form button').text('Update');
                        $('#testi_form input[name="id"]').val(data.id);
                        $('#testi_form input[name="name"]').val(data.name);
                        $('#testi_form input[name="rating"]').val(data.rating);
                        $('#testi_form textarea[name="review"]').val(data.review);

                        // Set the new image path to the Dropify input

                        // Re-initialize Dropify
                        var dropify = $('#image').dropify(); // Initialize Dropify
                        dropify = dropify.data('dropify'); // Re-initialize it
                        dropify.destroy(); // Destroy the existing instance
                        dropify.init(); // Initialize it again

                        $('#testi_form input[name="image"]').attr('data-default-file',
                        imagePath); // Set the new image
                        $('#testi_form .dropify-preview .dropify-render img').attr('src',
                        imagePath); // Set the new image
                        // Update RateYo star rating
                        $("#rateYo").rateYo("option", "rating", data.rating);

                        // Scroll to top smoothly
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
    {{-- Status --}}
    <script>
        function statusTestimonial(id) {
            $.ajax({
                url: "{{ route('testimonial.status') }}",
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
