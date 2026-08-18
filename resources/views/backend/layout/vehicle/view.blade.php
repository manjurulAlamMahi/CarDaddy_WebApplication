@extends('backend.app')

@section('title', 'View Vehicle Details')


@section('content')
    <main class="app-content content">
        <div class="row">
            <div class="col-lg-6 mb-1">
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Details</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <table class="table no-border">
                        <tr>
                            <td><b>Name:</b></td>
                            <td>{{ $vehicle->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Slug:</b></td>
                            <td>{{ $vehicle->slug }}</td>
                        </tr>
                        <tr>
                            <td><b>Model:</b></td>
                            <td>{{ $vehicle->model }}</td>
                        </tr>
                        <tr>
                            <td><b>Year:</b></td>
                            <td>{{ $vehicle->year }}</td>
                        </tr>
                        <tr>
                            <td><b>Price:</b></td>
                            <td>{{ $vehicle->price }}</td>
                        </tr>
                        <tr>
                            <td><b>Brand:</b></td>
                            <td>{{ $vehicle->brand->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Category:</b></td>
                            <td>{{ $vehicle->cate->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Color:</b></td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="gap: 10px;">
                                    <span class="color_box"
                                        style="height: 30px; width: 30px; border-radius: 50%; border: 1px solid #ccc; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); background-color: {{ $vehicle->relTo_color->code }};"></span>
                                    <span>{{ $vehicle->relTo_color->name }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Condition:</b></td>
                            <td>{{ $vehicle->condition == 'used' ? 'Used' : 'New'}}</td>
                        </tr>
                    </table>
                </div>
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Specifications</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <table class="table no-border">
                        <tr>
                            <td><b>Body Type:</b></td>
                            <td>{{ optional($vehicle->relTo_bodyType)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Transmission:</b></td>
                            <td>{{ optional($vehicle->relTo_transmission)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Size:</b></td>
                            <td>{{ optional($vehicle->relTo_size)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Doors:</b></td>
                            <td>{{ optional($vehicle->relTo_doors)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Exterior Color:</b></td>
                            <td>{{ optional($vehicle->relTo_exteriorColor)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Interior Color:</b></td>
                            <td>{{ optional($vehicle->relTo_interiorColor)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Drivetrain:</b></td>
                            <td>{{ optional($vehicle->relTo_drivetrain)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Cylinder:</b></td>
                            <td>{{ optional($vehicle->relTo_cylinder)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>MPG:</b></td>
                            <td>{{ optional($vehicle->relTo_mpg)->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Fuel Type:</b></td>
                            <td>{{ optional($vehicle->relTo_fuelType)->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Tags</h6>
                    <hr>
                    <div class="d-flex flex-wrap justify-content-start align-items-center">
                        @foreach ($vehicle->tags as $tag)
                            <span class="badge badge-primary mr-2 mb-2">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Interior Image</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <div class="row">
                        @foreach ($vehicle_interior_images as $interior_image)
                            <div class="col-lg-2">
                                <div class="text-center">
                                    <img class="w-100 image-fluid" src="{{ asset($interior_image->image) }}" alt=""
                                        class="img-fluid">
                                    <h6 class="mt-2">{{ $interior_image->imageType->name }}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Exterior Image</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <div class="row">
                        @foreach ($vehicle_exterior_images as $exterior_image)
                            <div class="col-lg-2">
                                <div class="text-center">
                                    <img class="w-100 image-fluid" src="{{ asset($exterior_image->image) }}" alt=""
                                        class="img-fluid">
                                    <h6 class="mt-2">{{ $exterior_image->imageType->name }}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Video</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <iframe width="100%" src="https://www.youtube.com/embed/{{ $vehicle->video_link_01 }}"
                                frameborder="0"></iframe>
                        </div>
                        <div class="col-lg-6">
                            <iframe width="100%" src="https://www.youtube.com/embed/{{ $vehicle->video_link_02 }}"
                                frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Description</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <p class="m-0">{!! $vehicle->description !!}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Features</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <p class="m-0">{!! $vehicle->features !!}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle History</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <p class="m-0">{!! $vehicle->history !!}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-body">
                    <h6 class="card_heading">Vehicle Warrenty</h6>
                    <h4 class="m-0"></h4>
                    <hr>
                    <p class="m-0">{!! $vehicle->warrenty !!}</p>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="text-start">
                    <a href="{{ route('vehicle.edit', $vehicle->id) }}" class="btn btn-primary">Edit</a>
                    <button type="button" onclick="deleteData('{{ route('vehicle.destroy', $vehicle->id) }}')"
                        class="btn btn-danger del">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection
