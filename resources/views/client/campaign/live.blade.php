@extends('layouts.client.app')

@section('content')

   <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <a href="{{ UrlLang('client/campaigns') }}">
                <h3 class="mb-1">
                <i class="ti ti-arrow-{{ AppLang() == 'ar' ? 'right' : 'left' }} fw-bold"></i>
                {{ __('trans.campaign.live_campaign') }}
            </h3>
        </a>

        <div class="nav-align-top mt-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <ul class="nav nav- campaign_tabs" role="tablist">
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border active" data-type="all"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-all" aria-controls="navs-pills-top-all" aria-selected="true">
                            {{ __('trans.global.all') }}
                        </button>
                    </li>
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border" data-type="live"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-live" aria-controls="navs-pills-top-live" aria-selected="false">
                            {{ __('trans.campaign.live_campaign') }}
                        </button>
                    </li>
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border" data-type="scheduled"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-scheduled" aria-controls="navs-pills-top-scheduled" aria-selected="false">
                            {{ __('trans.campaign.scheduled_campaign') }}
                        </button>
                    </li>
                    <li class="nav-item m-1">
                        <button type="button" class="nav-link shadow-none rounded bg-white border" data-type="finished"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-finished" aria-controls="navs-pills-top-finished" aria-selected="false">
                            {{ __('trans.campaign.finished_campaign') }}
                        </button>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="grid_btn btn bg-white border me-2">
                        <i class="ti ti-layout-grid fs-3"></i>
                    </a>

                    <a href="javascript:void(0);" class="grid_btn active btn bg-white border me-2">
                        <i class="ti ti-list fs-3"></i>
                    </a>

                    <a href="{{ UrlLang('client/campaigns/create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>
                        {{ __('trans.campaign.add_new') }}
                    </a>
                </div>
            </div>

            <div class="tab-content shadow-none p-0">
                <div class="row patient_list">
                    {{-- content --}}
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('css')
    <style>
        .campaign_tabs .nav-link.active{
            background: #0077b6 !important;
            border: 1px solid #0077b6 !important;
            color: #fff !important;
        }

        .grid_btn{
            width: 50px;
            height: 40px;
            color: #000;
        }
        .grid_btn.active{
            border: 1px solid #0077b6 !important;
            color: #0077b6 !important;
        }
    </style>
@endsection
