@extends('backend.app')

@section('title', 'stripe setting')

@push('style')
    <style>
        .nav-tabs.nav-justified {
            width: 400px;
        }
    </style>
@endpush

@section('content')
    <!--app-content open-->
    <div class="app-content content">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="row" id="user-profile">
                    <div class="col-lg-12">
                        <div class="tab-content mt-4">
                            <div class="tab-pane fade {{ session('type') ? (session('type') == 'profile' ? 'show active' : '') : 'show active' }}"
                                id="editProfile">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Stripe Setting</h5>
                                        <form method="post" action="{{ route('admin.setting.stripestore') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">STRIPE_KEY</label>
                                                <input type="text"
                                                    class="form-control @error('stripe_key') is-invalid @enderror"
                                                    name="stripe_key" id="stripe_key" value="{{ env('STRIPE_KEY') }}"
                                                    placeholder="Enter your name">
                                                @error('stripe_key')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="stripe_secret" class="form-label">STRIPE_SECRET</label>
                                                <input type="text"
                                                    class="form-control @error('stripe_secret') is-invalid @enderror"
                                                    name="stripe_secret" id="stripe_secret"
                                                    value="{{ env('STRIPE_SECRET') }}" placeholder="Enter your email">
                                                @error('stripe_secret')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
