@extends('backend.app')

@section('title', 'Blog Page')

@push('style')
    <link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        /* .dropify-wrapper {
                width: 160px;
            } */
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
            <div class="col-lg-12 mb-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">Edit <span id="Categorytitle">Blog</span></h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('blog.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $blog->id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <div class="form-group">
                                            <label for="image" class="form-label">Image <span class="text-danger">(55 x
                                                    65)</span></label>
                                            <input class="form-control dropify" type="file" name="image" id="image"
                                                data-default-file="{{ asset($blog->image) }}">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="title..." value="{{ old('title',$blog->title) }}" required>
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control"
                                            value="{{ old('date',$blog->date) }}" required>
                                        @error('date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="short_desp" class="form-label">Short Description</label>
                                        <textarea name="short_desp" id="short_desp" class="form-control" required>{{ old('short_desp',$blog->short_desp) }}</textarea>
                                        @error('short_desp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="long_desp" class="form-label">Long Description</label>
                                        <textarea name="long_desp" id="long_desp" class="ck-editor form-control @error('long_desp') is-invalid @enderror">{!! old('long_desp',$blog->long_desp) !!}</textarea>
                                        @error('long_desp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script>
        $('.dropify').dropify();
    </script>

    @include('backend.partials.ckeditor')

@endpush
