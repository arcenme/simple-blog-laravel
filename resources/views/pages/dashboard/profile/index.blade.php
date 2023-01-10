@extends('layout.dashboard.app')

@section('title', 'Profile')

@section('content')

    <div class="column">
        <div class="card ">
            <div class="d-flex justify-content-center">
                <div class="col-md-6 ">
                    <form action="{{ route('dashboard.profile') }}" id="profile-form" name="profile-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>User Profile</h4>
                        </div>
                        @if (session('success_profile'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success_profile') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card-body mt-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fullname</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? auth()->user()->name }}" required="">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email Address</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ?? auth()->user()->email }}" required="">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card ">
            <div class="d-flex justify-content-center">
                <div class="col-md-6 ">
                    <form action="{{ route('dashboard.profile.password') }}" id="password-form" name="password-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Passwor Management</h4>
                        </div>
                        @if (session('success_password'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success_password') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card-body mt-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Old Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" value="{{ old('old_password') }}" required="">
                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" value="{{ old('new_password') }}" required="">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" value="{{ old('confirm_password') }}" required="">
                                    @error('confirm_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
