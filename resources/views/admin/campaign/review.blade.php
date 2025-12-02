@extends('layouts.client.app')

@section('content')

   <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <a href="#">
                <h3 class="mb-1">
                <i class="ti ti-arrow-{{ AppLang() == 'ar' ? 'right' : 'left' }} fw-bold"></i>
                {{ __('trans.ads.title') }}
            </h3>
        </a>
    </div>

@endsection
