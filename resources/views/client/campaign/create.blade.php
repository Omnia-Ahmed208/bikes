@extends('layouts.client.app')

@section('content')

   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">

       <a href="{{ UrlLang('client/campaigns') }}">
           <h3 class="mb-1">
               <i class="ti ti-arrow-{{ AppLang() == 'ar' ? 'right' : 'left' }} fw-bold"></i>
               {{ __('trans.campaign.add_new') }}
           </h3>
       </a>

        <div class="progress-steps mt-5 mx-md-5 px-md-5">
            <div class="progress px-1 ms-4" style="height: 3px;">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div class="step-container d-flex justify-content-between">
                <div class="d-flex flex-column align-items-center">
                    <div class="step-circle active" data-step="1">1</div>
                    <div class="step-label active">{{ __('trans.campaign.campaign_details') }}</div>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <div class="step-circle" data-step="2">2</div>
                    <div class="step-label">{{ __('trans.campaign.media_and_capacity') }}</div>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <div class="step-circle" data-step="3">3</div>
                    <div class="step-label">{{ __('trans.campaign.payment') }}</div>
                </div>
            </div>

        </div>

        @if ($errors->any())
            <div class="form_error alert alert-danger mt-4 mx-3 d-block">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="multi-step-form" class="mt-4" action="{{ route('client.campaigns.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- campaign details --}}
            <div class="step step-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bold mb-1">{{ __('trans.campaign.campaign_details') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="h5 mb-2" for="title">{{ __('trans.campaign.name') }}</label>
                            <input type="text" class="form-control" id="title" name="title"
                            placeholder="{{ __('trans.campaign.name') }}"
                            value="{{ old('title') }}"
                            required/>
                        </div>

                        <div class="mb-3">
                            <label class="h5 mb-2" for="country_id">{{ __('trans.campaign.country') }}</label>
                            <select class="form-select select2 @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                                <option value="" disabled selected>{{ __('trans.global.select') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if(old('country_id') == $country->name) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>

                            @error('country_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="h5 mb-2" for="region_id">{{__('trans.campaign.region')}}</label>
                            <select class="form-select select2" name="region_id" id="region_id" required></select>
                        </div>

                        <div class="mb-3">
                            <label class="h5 mb-2" for="bikes_count">{{ __('trans.campaign.bikes_count') }}</label>
                            <input type="text" class="form-control" id="bikes_count" name="bikes_count"
                            placeholder="{{ __('trans.campaign.bikes_count') }}"
                            value="{{ old('bikes_count') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            required/>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary next-step">{{ __('trans.global.next') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- media and capacity --}}
            <div class="step step-2 d-none">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bold mb-1">{{ __('trans.campaign.media_and_capacity') }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 dragable_media_box">
                            <label class="h5 mb-2" for="media">{{ __('trans.campaign.media') }}</label>
                            <div class="upload_image_box w-100 p-4 mt-2 rounded fw-bold text-center">
                                <span class="dragBox">
                                    <img src="{{ asset('backend/img/icons/upload.svg') }}" alt="upload icon">
                                    <h6 class="my-3">
                                        {{ __('trans.campaign.drag_and_drop') }}
                                    </h6>
                                    <h6 class="my-3">
                                        {{ __('trans.campaign.file_size') }}
                                    </h6>

                                    <input type="file" name="media" id="uploadFile" onChange="dragNdrop(event)"
                                    ondragover="drag()" ondrop="drop()" accept="image/jpeg, image/png, image/jpg, video/mp4"
                                    required/>
                                </span>

                                <label for="uploadFile" class="btn btn-outline-primary position-relative" style="z-index: 1">
                                    {{ __('trans.campaign.browse_file') }}
                                </label>
                            </div>

                            <div id="preview" class="mt-3"></div>
                        </div>

                        <div class="mb-3">
                            <label class="h5 mb-2" for="media_duration">{{ __('trans.campaign.media_duration') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="media_duration" name="media_duration"
                                placeholder="{{ __('trans.campaign.media_duration') }}"
                                value="{{ old('media_duration') }}"
                                required>

                                <span class="input-group-text text-dark px-lg-4" style="font-size: 18px">{{ __('trans.campaign.second') }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="h5 mb-2" for="campaign_duration">{{ __('trans.campaign.campaign_duration') }}</label>
                            <select class="form-select select2 @error('campaign_duration') is-invalid @enderror" id="campaign_duration" name="campaign_duration" required>
                                <option value="" disabled selected>{{ __('trans.global.select') }}</option>
                                <option value="12_hour" @if(old('campaign_duration') == '12_hour') selected @endif>{{ __('trans.campaign.12_hour') }}</option>
                                <option value="1_day" @if(old('campaign_duration') == '1_day') selected @endif>{{ __('trans.campaign.1_day') }}</option>
                                <option value="3_days" @if(old('campaign_duration') == '3_days') selected @endif>{{ __('trans.campaign.3_days') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="h5 mb-2" for="date_time">{{ __('trans.campaign.date_time') }}</label>
                            <input type="text" class="form-control dateRange dateRange_total"
                            id="date_time" name="date_time" dir="{{ AppDir() }}" required/>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary prev-step">{{ __('trans.global.previous') }}</button>
                            <button type="button" class="btn btn-primary next-step">{{ __('trans.global.next') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- payment --}}
            <div class="step step-3 d-none">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bold mb-1">{{ __('trans.campaign.payment') }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 p-3 px-md-4 pt-md-4 rounded bg-light">
                            <h5>{{ __('trans.campaign.summary') }}</h5>

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6>{{ __('trans.campaign.name') }}:</h6>
                                <h6 id="summary_title"></h6>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6>{{ __('trans.campaign.country') }}:</h6>
                                <h6 id="summary_country"></h6>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6>{{ __('trans.campaign.region') }}:</h6>
                                <h6 id="summary_region"></h6>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6>{{ __('trans.campaign.bikes_count') }}:</h6>
                                <h6 id="summary_bikes_count"></h6>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6>{{ __('trans.campaign.media_duration') }}:</h6>
                                <h6 id="summary_media_duration"></h6>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6>{{ __('trans.campaign.campaign_duration') }}:</h6>
                                <h6 id="summary_campaign_duration"></h6>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6>{{ __('trans.campaign.date_time') }}:</h6>
                                <h6 id="summary_date_time"></h6>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h6>{{ __('trans.campaign.total_price') }}:</h6>
                            <h5 class="fw-bold text-primary">
                                {{ number_format(5000, 0) }}
                                <img src="{{ asset('backend/img/sar.png') }}" class="img_primary mb-2" width="20" alt="currency">
                            </h5>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary prev-step">{{ __('trans.global.previous') }}</button>
                            <button type="submit" class="btn btn-primary next-step">{{ __('trans.global.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
   </div>
    <!-- / Content -->

@endsection

@section('css')
    <link rel="stylesheet" href="{{url('backend')}}/select2/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@push('js')
    <script src="{{url('backend')}}/select2/select2.js"></script>
    <script src="{{url('backend')}}/js/progress-steps.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('#campaign_duration').select2({
                minimumResultsForSearch: Infinity // hide the search box
            });

            flatpickr(".dateRange", {
                mode: "range",
                enableTime: true,
                time_24hr: true,
                dateFormat: "Y-m-d H:i",
                locale: "{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}",
                disableMobile: true,
                onChange: function(selectedDates, dateStr, instance) {
                    // Format display in single input
                    if (selectedDates.length === 2) {
                        const dateFrom = flatpickr.formatDate(selectedDates[0], "Y-m-d H:i");
                        const dateTo = flatpickr.formatDate(selectedDates[1], "Y-m-d H:i");
                        instance.input.value = dateFrom + " — " + dateTo;
                    }
                }
            });

            function fetchRegions() {
                var countryId = $('#country_id').val();

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
                            console.log(res, countryId)
                            $("#region_id").html("<option disabled selected>{{ __('trans.global.select') }}</option>");
                            $.each(res.data, function(key, val) {
                                $("#region_id").append("<option value='" + val.id + "'>" + val.name + "</option>");
                            });
                        }
                    });
                }
            }

            $('#country_id').on('change', fetchRegions);
            $(window).on('load', fetchRegions);

        });

        // =============================== Drag and Drop ===============================
        function dragNdrop(event) {
            var fileName = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("preview");
            preview.innerHTML = `
                ${event.target.files[0].name}
                <a href="${URL.createObjectURL(event.target.files[0])}" class="mx-2" target="_blank">
                    {{ __('trans.global.view') }}
                </a>
            `;
        }
        function drag() {
            document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
        }
        function drop() {
            document.getElementById('uploadFile').parentNode.className = 'dragBox';
        }

    </script>

    @if(session('payment_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    // icon: 'success', // نحذف هذا إذا استخدمنا صورة
                    imageUrl: "{{ url('backend/img/success.png') }}",
                    imageWidth: 100,      // العرض
                    imageHeight: 100,     // الارتفاع
                    imageAlt: 'Success',  // وصف بديل للصورة
                    // text: "{{ session('success') }}",
                    html: `<h5 class="mb-1">{{ __('trans.alert.success.payment_success') }}</h5>
                        <p class="mb-0">{{ __('trans.campaign.under_review') }}</p>`,
                    showConfirmButton: false,
                    showCloseButton: true,
                });
            });
        </script>
    @endif

@endpush
