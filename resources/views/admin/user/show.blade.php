@extends('layouts.admin.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <section class="rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                class="rounded-circle img-fluid" style="width: 150px;"> --}}
                            <div class="img d-flex justify-content-center align-items-center"
                                style="
                                border-radius: 50px;
                                height: 140px;
                                width: 150px;
                                "
                                {{-- box-shadow: 2px 3px 10px #696969; --}}
                                {{-- background: linear-gradient(141.11deg, #2D4FA9 0%, #3678C6 35.36%, #4084CD 82.51%, #2D4FA9 97.8%); --}}
                            >
                                <img src="{{ asset($user->img ?? 'backend/assets/imgs/user.svg') }}" width="100px" class="rounded-circle" alt="">
                            </div>
                            <h5 class="my-3">{{ $user->name }}</h5>
                            <p class="text-muted mb-1">
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </p>
                            <p class="text-muted mb-1">
                                <a href="tel:+20{{ $user->phone }}">{{ $user->phone }}</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('trans.auth.name') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-dark mb-0">{{ $user->name }}</p>
                                </div>
                            </div>
                            {{-- <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-dark mb-0">Bay Area, San Francisco, CA</p>
                                </div>
                            </div> --}}

                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('trans.auth.street') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-dark mb-0">{{ $user->street ?? '-' }}</p>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('trans.auth.country') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-dark mb-0">{{ $user->country ?? '-' }}</p>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('trans.auth.city') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-dark mb-0">{{ $user->city ?? '-' }}</p>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('trans.auth.zip_code') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-dark mb-0">{{ $user->zip_code ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($user->orders as $order)
                        <div class="card mb-4">
                            <div class="card-header">
                                <strong>{{ __('trans.order.order') }} #{{ $order->id }}</strong>
                                 - {{ $order->date }}
                                 -
                                @if ($order->status == 'delivered')
                                    {{ __('trans.order.delivered') }}
                                @elseif('trans.order.waiting')
                                    {{ __('trans.order.delivered') }}
                                @else
                                    {{ __('trans.order.canceled') }}
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('trans.product.name') }}</th>
                                            <th>{{ __('trans.order.price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    {{-- @if ($user->orders->count() > 0)
                        <div class="card mb-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="exp-col">#</th>
                                        <th class="exp-col">{{ __('trans.product.name') }}</th>
                                        <th class="exp-col">{{ __('trans.global.created_at') }}</th>
                                        <th class="exp-col">{{ __('trans.order.total_price') }}</th>
                                        <th class="exp-col">{{ __('trans.order.status') }}</th>
                                        <th>{{__('trans.global.details')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($user->orders as $index => $item)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>
                                            <div class="{{$item->status == 'delivered' ? 'badge bg-label-success fs-6' : 'badge bg-label-warning fs-6'}}">
                                                {{ $item->status }}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{url("/admin/orders/$item->id")}}" class="btn btn-sm rounded-pill btn-primary"><i class="ti ti-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="exp-col">#</th>
                                        <th class="exp-col">{{ __('trans.product.name') }}</th>
                                        <th class="exp-col">{{ __('trans.global.created_at') }}</th>
                                        <th class="exp-col">{{ __('trans.order.total_price') }}</th>
                                        <th class="exp-col">{{ __('trans.order.status') }}</th>
                                        <th>{{__('trans.global.details')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
