@extends('backend.app')

@section('title', 'Create Vehicle')

@push('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .dropify-wrapper {
            height: 200px !important;
        }
    </style>
@endpush

@section('content')
    <main class="app-content content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('vehicle.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <h6 class="card_heading mb-4">Vehicle Information</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Vehicle Name <span
                                                class="text-danger">(required)</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="model" class="form-label">Vehicle Model <span
                                                class="text-danger">(required)</span></label>
                                        <input type="text" class="form-control" id="model" name="model"
                                            value="{{ old('model') }}">
                                        @error('model')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="submodel" class="form-label">Vehicle SubModel</label>
                                        <input type="text" class="form-control" id="submodel" name="submodel"
                                            value="{{ old('submodel') }}">
                                        @error('submodel')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="make" class="form-label">Brand/Make <span
                                                class="text-danger">(required)</span></label>
                                        <select name="make" class="form-control" id="make">
                                            <option value="">-- Select Make --</option>
                                            @foreach ($brands as $make)
                                                <option {{ old('make') == $make->id ? 'selected' : '' }}
                                                    value="{{ $make->id }}">{{ $make->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('make')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category <span
                                                class="text-danger">(required)</span></label>
                                        <select name="category" class="form-control" id="category">
                                            <option value="">-- Select Category --</option>
                                            @foreach ($categories as $category)
                                                <option {{ old('category') == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year <span
                                                class="text-danger">(required)</span></label>
                                        <select name="year" class="form-control" id="">
                                            <option value="">-- Select Year --</option>
                                            @for ($i = date('Y'); $i >= 1900; $i--)
                                                <option {{ old('year') == $i ? 'selected' : '' }}
                                                    value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('year')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price <span
                                                class="text-danger">(required)</span></label>
                                        <input type="text" class="form-control" id="price" name="price"
                                            value="{{ old('price') }}">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="color" class="form-label">Color <span
                                                class="text-danger">(required)</span></label>
                                        <select name="color" class="form-control" id="">
                                            <option value="">-- Select Color --</option>
                                            @foreach ($colors as $color)
                                                <option {{ old('color') == $color->id ? 'selected' : '' }}
                                                    value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('color')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="engine" class="form-label">Condition <span
                                                class="text-danger">(required)</span></label>
                                        <select name="condition" class="form-control" id="">
                                            <option value="">-- Select Condition --</option>
                                            <option {{ old('condition') == 'new' ? 'selected' : '' }} value="new">New
                                            </option>
                                            <option {{ old('condition') == 'used' ? 'selected' : '' }} value="used">Used
                                            </option>
                                        </select>
                                        @error('condition')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h6 class="card_heading mb-4">Vehicle Specification</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="mileage" class="form-label">Mileage</label>
                                        <select name="mileage" class="form-control" id="mileage">
                                            <option value="">-- Select Mileage --</option>
                                            @foreach ($mileage as $mileage)
                                                <option {{ old('mileage') == $mileage->id ? 'selected' : '' }}
                                                    value="{{ $mileage->id }}">{{ $mileage->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('mileage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="body_type" class="form-label">Body Type</label>
                                        <select name="body_type" class="form-control" id="body_type">
                                            <option value="">-- Select Body Type --</option>
                                            @foreach ($body_type as $body_type)
                                                <option {{ old('body_type') == $body_type->id ? 'selected' : '' }}
                                                    value="{{ $body_type->id }}">{{ $body_type->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('body_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="transmission" class="form-label">Transmission</label>
                                        <select name="transmission" class="form-control" id="transmission">
                                            <option value="">-- Select Transmission --</option>
                                            @foreach ($transmission as $transmission)
                                                <option {{ old('transmission') == $transmission->id ? 'selected' : '' }}
                                                    value="{{ $transmission->id }}">{{ $transmission->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('transmission')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <select name="size" class="form-control" id="size">
                                            <option value="">-- Select Size --</option>
                                            @foreach ($sizes as $size)
                                                <option {{ old('size') == $size->id ? 'selected' : '' }}
                                                    value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach

                                        </select>
                                        @error('size')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="doors" class="form-label">Doors</label>
                                        <select name="doors" class="form-control" id="doors">
                                            <option value="">-- Select Doors --</option>
                                            @foreach ($doors as $door)
                                                <option {{ old('doors') == $door->id ? 'selected' : '' }}
                                                    value="{{ $door->id }}">{{ $door->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('doors')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="exterior_color"
                                            class="form-label
                                            ">Exterior
                                            Color</label>
                                        <select name="exterior_color" class="form-control" id="exterior_color">
                                            <option value="">-- Select Exterior Color --</option>
                                            @foreach ($colors as $exterior_color)
                                                <option
                                                    {{ old('exterior_color') == $exterior_color->id ? 'selected' : '' }}
                                                    value="{{ $exterior_color->id }}">{{ $exterior_color->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('exterior_color')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="interior_color"
                                            class="form-label
                                            ">Interior
                                            Color</label>
                                        <select name="interior_color" class="form-control" id="interior_color">
                                            <option value="">-- Select Interior Color --</option>
                                            @foreach ($colors as $interior_color)
                                                <option
                                                    {{ old('interior_color') == $interior_color->id ? 'selected' : '' }}
                                                    value="{{ $interior_color->id }}">{{ $interior_color->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('interior_color')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="drivetrain"
                                            class="form-label
                                            ">Drivetrain</label>
                                        <select name="drivetrain" class="form-control" id="drivetrain">
                                            <option value="">-- Select Drivetrain --</option>
                                            @foreach ($drivetrains as $drivetrain)
                                                <option {{ old('drivetrain') == $drivetrain->id ? 'selected' : '' }}
                                                    value="{{ $drivetrain->id }}">{{ $drivetrain->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('drivetrain')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="cylinder"
                                            class="form-label
                                            ">Cylinder</label>
                                        <select name="cylinder" class="form-control" id="cylinder">
                                            <option value="">-- Select Cylinder --</option>
                                            @foreach ($cylinders as $cylinder)
                                                <option {{ old('cylinder') == $cylinder->id ? 'selected' : '' }}
                                                    value="{{ $cylinder->id }}">{{ $cylinder->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cylinder')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="mpg" class="form-label">MPG</label>
                                        <select name="mpg" class="form-control" id="mpg">
                                            <option value="">-- Select MPG --</option>
                                            @foreach ($mpgs as $mpg)
                                                <option {{ old('mpg') == $mpg->id ? 'selected' : '' }}
                                                    value="{{ $mpg->id }}">{{ $mpg->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('mpg')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="fuel_type" class="form-label">Fuel Type</label>
                                        <select name="fuel_type" class="form-control" id="fuel_type">
                                            <option value="">-- Select Fuel Type --</option>
                                            @foreach ($fuel_types as $fuel_type)
                                                <option {{ old('fuel_type') == $fuel_type->id ? 'selected' : '' }}
                                                    value="{{ $fuel_type->id }}">{{ $fuel_type->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('fuel_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h6 class="card_heading mb-4">Vehicle Description</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description <span
                                                class="text-danger">(required)</span></label>

                                        <textarea class="ck-editor" name="description">{!! old('description') !!}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="features" class="form-label">Features</label>
                                        <textarea class="ck-editor" name="features">{!! old('features') !!}</textarea>
                                        @error('features')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="history" class="form-label">History</label>

                                        <textarea class="ck-editor" name="history">{!! old('history') !!}</textarea>
                                        @error('history')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="history" class="form-label">Warrenty</label>

                                        <textarea class="ck-editor" name="warrenty">{!! old('warrenty') !!}</textarea>
                                        @error('warrenty')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h6 class="card_heading mb-4">Vehicle Exterior Images</h6>
                            <div class="row">
                                @foreach ($exterior_image_types as $exterior_img)
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="image_one" class="form-label">{{ $exterior_img->name }}
                                                Image</label>
                                            <input class="form-control dropify" type="file"
                                                name="image[{{ $exterior_img->id }}]">
                                            @error('front_image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <h6 class="card_heading mb-4">Vehicle Interior Images</h6>
                            <div class="row">
                                @foreach ($interior_image_types as $interior_img)
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="image_one" class="form-label">{{ $interior_img->name }}
                                                Image</label>
                                            <input class="form-control dropify" type="file"
                                                name="image[{{ $interior_img->id }}]">
                                            @error('front_image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <h6 class="card_heading mb-4">Vehicle Video</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="video_link_01" class="form-label">Video Url</label>
                                        <input class="form-control" type="text" id="video_link_01"
                                            name="video_link_01" value="{{ old('video_link_01') }}">
                                        @error('video_link_01')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div id="preview_01" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="video_link_02" class="form-label">Video Url <span
                                                class="text-danger">Optional</span></label>
                                        <input class="form-control" type="text" id="video_link_02"
                                            name="video_link_02" value="{{ old('video_link_02') }}">
                                        @error('video_link_02')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div id="preview_02" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="card_heading mb-4">Vehicle Tag</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tags" class="form-label">Tags <span
                                            class="text-danger">(required)</span></label>
                                        <select name="tags[]" id="tagsSelect" class="form-control" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('tags')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Selected Tags</label>
                                        <div id="selectedTags" class="border p-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-success">Create</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('script')
    @include('backend.partials.ckeditor')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <!-- Add Select2 CSS & JS -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <script>
        $('.dropify').dropify();
    </script>

    <script>
        $(document).ready(function() {
            function updatePreview(inputId, previewId) {
                $("#" + inputId).on("input", function() {
                    var url = $(this).val().trim();
                    var embedUrl = "";

                    if (url.includes("youtube.com") || url.includes("youtu.be")) {
                        // Extract YouTube Video ID
                        var videoId = url.split("v=")[1]?.split("&")[0] || url.split("youtu.be/")[1]?.split(
                            "?")[0];
                        if (videoId) {
                            embedUrl = "https://www.youtube.com/embed/" + videoId;
                        }
                    } else if (url.includes("vimeo.com")) {
                        // Extract Vimeo Video ID
                        var videoId = url.split("vimeo.com/")[1]?.split("?")[0];
                        if (videoId) {
                            embedUrl = "https://player.vimeo.com/video/" + videoId;
                        }
                    }

                    if (embedUrl) {
                        $("#" + previewId).html('<iframe width="100%" height="250" src="' + embedUrl +
                            '" frameborder="0" allowfullscreen></iframe>');
                    } else {
                        $("#" + previewId).html("");
                    }
                });
            }

            updatePreview("video_link_01", "preview_01");
            updatePreview("video_link_02", "preview_02");
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tagsSelect').select2({
                placeholder: "-- Select Tags --",
                allowClear: true
            }).on('change', function() {
                let selectedTags = $(this).find(':selected').map(function() {
                    return `<span class="badge bg-primary m-1">${$(this).text()}</span>`;
                }).get().join(' ');

                $('#selectedTags').html(selectedTags || '<span class="text-muted">No tags selected</span>');
            });
        });
    </script>
@endpush
