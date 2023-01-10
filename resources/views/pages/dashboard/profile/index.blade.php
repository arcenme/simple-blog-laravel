@extends('layout.dashboard.app')

@section('title', 'Profile')

@section('content')

    <div class="card ">
        <div class="d-flex justify-content-center">
            <div class="col-md-6 ">
                <form action="{{ route('dashboard.profile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>User Profile</h4>
                    </div>
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

@endsection
