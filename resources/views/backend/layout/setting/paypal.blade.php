@extends('backend.app')

@section('title', 'paypal setting')

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
                                        <h5 class="card-title">Paypal Setting</h5>
                                        <form method="post" action="{{ route('admin.setting.paypalstore') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="paypal_client" class="form-label">PAYPAL_CLIENT_ID</label>
                                                <input type="text"
                                                    class="form-control @error('paypal_client') is-invalid @enderror"
                                                    name="paypal_client" id="paypal_client"
                                                    value="{{ env('PAYPAL_CLIENT_ID') }}" placeholder="Enter your name">
                                                @error('paypal_client')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="paypal_secret" class="form-label">PAYPAL_SECRET</label>
                                                <input type="text"
                                                    class="form-control @error('paypal_secret') is-invalid @enderror"
                                                    name="paypal_secret" id="paypal_secret"
                                                    value="{{ env('PAYPAL_SECRET') }}" placeholder="Enter your email">
                                                @error('paypal_secret')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="sandbox" class="form-label">PAYPAL_MODE</label>
                                                <input type="text"
                                                    class="form-control @error('sandbox') is-invalid @enderror"
                                                    name="sandbox" id="sandbox"
                                                    value="{{ env('PAYPAL_MODE') }}" placeholder="Enter your email">
                                                @error('sandbox')
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
