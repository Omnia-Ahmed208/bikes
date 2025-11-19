@extends('layouts.back.app')

@section('content')

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex">
            <h5 class="text-md-start text-center mx-2">
                <a href="{{route('admin.users.index')}}">
                    {{ __('trans.user.title') }}
                </a>
            </h5>
            <h5 class="text-md-start text-center mx-2">:</h5>
            <h5 class="text-md-start text-center mx-2">{{ __('trans.user.add_new') }}</h5>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('trans.auth.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required>

                                @error('name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('trans.auth.email') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('trans.auth.phone') }} <span class="text-danger">*</span> </label>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input type="text" name="phone" id="phone"
                                    placeholder="{{__('trans.auth.phone')}}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    required/>
                                </div>

                                @error('phone')
                                    <span class="invalid-feedback text-danger @error('phone') d-block @enderror" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="img" class="form-label">{{ __('trans.auth.image') }} </label>
                                <input type="file" class="form-control @error('img') is-invalid @enderror" name="img">

                                @error('img')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">{{ __('trans.global.save') }}</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
