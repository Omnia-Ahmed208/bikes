<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme rounded position-relative h-100">
    <div class="app-brand demo" style="height: 125px">
        <div href="javascript:void(0);" class="h-100 w-100">
            <span class="app-brand-logo demo text-center w-100 h-100 d-flex justify-content-center align-items-center position-relative">
                <div id="sidebarImage">
                    @if ($doctor->image)
                        <img src="{{ asset($doctor->image) }}" alt="" class="rounded-circle" style="width: 112px; height: 112px; object-fit: cover;">
                    @else
                        <div class="avatar-fallback" style="width: 112px; height: 112px">
                            {{ Str::upper(mb_substr($doctor->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- edit --}}
                <i class="menu-item-icon tf-icons bx bx-edit-alt text-white bg-primary rounded-circle p-2 position-absolute"
                @if (AppDir() === 'ar')
                    style="left: 40px; bottom: 5px;cursor: pointer;"
                @else
                    style="right: 40px; bottom: 5px;cursor: pointer;"
                @endif
                data-bs-toggle="modal" data-bs-target="#editProfileModal"
                ></i>
            </span>
        </div>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <h5 class="text-dark fw-bold text-center">{{ __('trans.doctor.dr') }} {{ $doctor->name }}</h5>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 pb-3">
        <!-- profile -->
        <li class="menu-item">
            <a href="{{ UrlLang('doctor/profile') }}" class="menu-link">
                <div data-i18n="profile">{{ __('trans.doctor.profile') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ UrlLang('doctor/bank-account') }}" class="menu-link">
                <div data-i18n="bank_account">{{ __('trans.doctor.bank_account') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ UrlLang('doctor/appointments/create') }}" class="menu-link">
                <div data-i18n="appointments">{{ __('trans.doctor.appointments') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ UrlLang('doctor/reviews') }}" class="menu-link">
                <div data-i18n="reviews">{{ __('trans.doctor.reviews') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ UrlLang('doctor/privacy-terms') }}" class="menu-link">
                <div data-i18n="privacy_terms">{{ __('trans.doctor.privacy_terms') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ UrlLang('doctor/contact-us') }}" class="menu-link">
                <div data-i18n="contact_us">{{ __('trans.doctor.contact_us') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <div data-i18n="logout">{{ __('trans.auth.logout') }}</div>
            </a>
        </li>
    </ul>
</aside>


{{-- edit profile --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center p-0">
                <div id="img-profile-section">
                    @if ($doctor->image)
                        <img id="profilePreview" src="{{ asset($doctor->image) }}" alt=""
                        class="w-px-150 h-px-150 rounded-circle" style="object-fit: cover;">
                    @else
                        <div class="avatar-fallback w-px-150 h-px-150" id="profilePreviewFallback">
                            {{ Str::upper(mb_substr($doctor->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <form id="editProfileImageForm" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <div class="mb-3 position-relative">
                        <input id="imageInput" type="file" name="image" class="form-control position-absolute" style="opacity: 0;z-index: 1;" accept="image/*">
                        <a href="javascript:void(0)" class="btn btn-primary w-100" id="uploadImageBtn">{{ __('trans.doctor.edit_image') }}</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('trans.global.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- logout --}}
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center p-0">
                <h4 class="fw-bold text-dark text-center">{{ __('trans.alert.are_you_sure_to_logout') }}</h4>
                <p>{{ __('trans.alert.logout_text') }}</p>
            </div>
            <div class="modal-footer pb-2">
                <div class="row w-100">
                    <div class="col-6">
                        <a href="{{ UrlLang('doctor/logout') }}" class="btn btn-primary w-100" id="logoutBtn">{{ __('trans.auth.logout') }}</a>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">{{ __('trans.global.cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const imageInput = document.getElementById("imageInput");

            imageInput.addEventListener("change", function (e) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const profilePreview = document.getElementById("profilePreview");
                    const profilePreviewFallback = document.getElementById("profilePreviewFallback");

                    if(profilePreviewFallback){
                        profilePreviewFallback.innerHTML =
                        `<img src="${e.target.result}" alt="" class="w-px-150 h-px-150 my-4 rounded-circle" style="object-fit: cover;">`;
                    }
                    else if(profilePreview){
                        profilePreview.src = e.target.result;
                    }
                };

                reader.readAsDataURL(file);
            });


            const form = document.getElementById("editProfileImageForm");
            form.addEventListener("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(form);

                fetch("{{ route('doctor.profile.update_image') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById("editProfileModal")).hide();

                        if (data.image_url) {
                            // sidebar image
                            const sidebarImage = document.getElementById("sidebarImage");
                            let img = sidebarImage.querySelector("img");
                            if (img) {
                                img.src = data.image_url;
                            } else {
                                sidebarImage.innerHTML =
                                `<img src="${data.image_url}" alt="" class="rounded-circle" style="width: 112px; height: 112px; object-fit: cover;">`;
                            }

                            // navbar images
                            const navbarImages = document.querySelectorAll(".avatar.avatar-navbar");
                            navbarImages.forEach(image => {
                                const internalImage = image.querySelector("img");
                                if (internalImage) {
                                    internalImage.src = data.image_url;
                                } else{
                                    image.innerHTML = `<img src="${data.image_url}" alt="" class="rounded-circle">`;
                                }
                            })
                        }

                        Swal.fire({
                            icon: 'success',
                            text: data.message,
                            showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: data.message,
                            showConfirmButton: false,
                        });
                    }
                })
                .catch(err => {
                    console.error(err);

                    Swal.fire({
                        icon: 'success',
                        text: "{{ __('trans.alert.error.something_went_wrong') }}",
                        showConfirmButton: false,
                    });
                });
            });

        });

    </script>
@endpush
