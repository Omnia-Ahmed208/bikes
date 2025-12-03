@extends('layouts.admin.app')

@section('content')

   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">

       <a href="{{ route('admin.campaigns-pricing.index') }}">
            <h3>
               <i class="ti ti-arrow-{{ AppLang() == 'ar' ? 'right' : 'left' }} fw-bold"></i>
               {{ __('trans.pricing.add_new') }}
           </h3>
       </a>

        <div class="card">
            <div class="card-header pb-0">
                <h4 class="fw-bold">{{ __('trans.pricing.info') }}</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.campaigns-pricing.update', $ads_price->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="h6 mb-2" for="country_id">{{ __('trans.campaign.country') }}</label>
                                <select class="form-select select2 @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                                    <option value="" disabled selected>{{ __('trans.global.select') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" @if(old('country_id', $ads_price->country_id) == $country->id) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>

                                @error('country_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="h6 mb-2" for="region_id">{{__('trans.campaign.region')}}</label>
                                <select class="form-select select2" name="region_id" id="region_id" required></select>
                            </div>
                        </div>
                         <div class="col-12">
                            <div class="mb-3">
                                <label class="h6 mb-2" for="price">{{__('trans.pricing.price')}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="price" placeholder="{{ __('trans.pricing.price_text') }}"
                                    value="{{ old('price', $ads_price->price) ?? '' }}" required>
                                    {{-- aria-label="Amount (to the nearest dollar)"> --}}
                                    <span class="input-group-text">
                                        <img src="{{ asset('backend/img/sar.png') }}" width="18" alt="">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary">{{ __('trans.global.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('backend')}}/select2/select2.css">
@endsection

@push('js')
    <script src="{{url('backend')}}/select2/select2.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            function fetchRegions() {
                var countryId = $('#country_id').val();
                let old_region_id = "{{ old('region_id', $ads_price->region_id) }}";

                if (countryId) {
                    $.ajax({
                        type: 'get',
                        url: "{{ url('client/ajax/get/regions') }}",
                        data: {
                            country_id: countryId,
                        },
                        beforeSend: function() {
                            $("#region_id").html("<option disabled selected>{{ __('trans.global.loading') }}...</option>");
                        },
                        success: function(res) {
                            $("#region_id").html("<option disabled selected>{{ __('trans.global.select') }}</option>");
                            $.each(res.data, function(key, val) {
                                $("#region_id").append("<option value='" + val.id + "' >" + val.name + "</option>");
                            });

                            if (old_region_id) {
                                $("#region_id").val(old_region_id).trigger('change');
                            }
                        }
                    });
                }
            }

            $('#country_id').on('change', fetchRegions);
            $(window).on('load', fetchRegions);
        });
    </script>
@endpush
