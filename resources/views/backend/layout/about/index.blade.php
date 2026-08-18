@extends('backend.app')

@section('title', 'About Page')

@push('style')
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
        <form action="{{ route('about.update') }}" enctype="multipart/form-data" method="POST">@csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-body">
                        <h6 class="card_heading">Images</h6>
                        <div class="row mb-3">
                            <label for="" class="col-lg-4 col-form-label">Image One <span class="text-danger">(820 x
                                    580)</span></label>
                            <div class="col-lg-8">
                                <input class="form-control dropify" type="file" name="image_one" id="image_one"
                                    data-default-file="{{ asset($about->image_one) }}">
                                @error('image_one')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-lg-4 col-form-label">Image Two <span class="text-danger">(305 x
                                    580)</span></label>
                            <div class="col-lg-8">
                                <input class="form-control dropify" type="file" name="image_two" id="image_two"
                                    data-default-file="{{ asset($about->image_two) }}">
                                @error('image_two')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" style="height: 100%">
                    <div class="card card-body">
                        <h6 class="card_heading">Content</h6>
                        <textarea rows="10" name="desp" id="desp" class="ck-editor form-control @error('desp') is-invalid @enderror">{!! old('desp',$about->desp) !!}</textarea>
                        @error('desp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script>
        $('.dropify').dropify();
    </script>

    @include('backend.partials.ckeditor')
@endpush
