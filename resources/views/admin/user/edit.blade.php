@extends('layouts.admin.app')

@section('content')

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
           <div class="d-flex">
                <h5 class="text-md-start text-center mx-2">
                    <a href="{{route('admin.users.index')}}">
                        {{ __('trans.user.title') }}
                    </a>
                </h5>
                <h5 class="text-md-start text-center mx-2">:</h5>
                <h5 class="text-md-start text-center mx-2">{{ $user->name }}</h5>
           </div>
           <a href="{{ route('admin.users.index') }}" class="btn mb-2 btn-secondary">{{ __('trans.global.back') }}</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('trans.auth.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ $user->name }}" required>

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
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $user->email }}" required>

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
                                <input type="text" name="phone" id="phone"
                                placeholder="{{__('trans.auth.phone')}}"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}"
                                required/>

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

                                <div class="mt-2">
                                    @if ($user->img)
                                        <img src="{{ url($user->img) }}" alt="user Image" width="100">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">{{ __('trans.global.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
