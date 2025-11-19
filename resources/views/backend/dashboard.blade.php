@extends('layouts.back.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
      <div class="col-lg-4 mb-4 order-0">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary"> Devices list </h5>
            </div>
        </div>
      </div>

    <div class="col-lg-4 mb-4 order-0">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary"> Online </h5>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4 order-0">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary"> Offline </h5>
            </div>
        </div>
    </div>
</div>

@endsection
