var currentStep = 1;
var updateProgressBar;

$(document).ready(function() {

    // كلهم d-none ما عدا step-1
    $(".step").addClass("d-none");
    $(".step-1").removeClass("d-none");

    $(".next-step").click(function() {

        // تحقق من الحقول داخل الخطوة الحالية
        let isValid = true;
        let currentFields = $(".step-" + currentStep).find("input, select, textarea");

        currentFields.each(function() {
            if ($(this).prop("required") && $(this).val().trim() === "") {
                $(this).addClass("is-invalid");
                isValid = false;
            } else {
                $(this).removeClass("is-invalid");
            }
        });

        // لو في خطأ → وقف
        if (!isValid) {
            return;
        }

        // ---------------------
        // كمل لباقي كود الانتقال
        // ---------------------

        if (currentStep < 3) {
            $(".step-" + currentStep)
                .addClass("animate__animated animate__fadeOutLeft");

            currentStep++;

            setTimeout(function() {
                $(".step")
                    .addClass("d-none")
                    .removeClass("animate__animated animate__fadeOutLeft animate__fadeOutRight");

                $(".step-" + currentStep)
                    .removeClass("d-none")
                    .addClass("animate__animated animate__fadeInRight");

                updateProgressBar();
                updateStepCircles();
            }, 500);
        }

        // =========================== summery content
        if($(this).closest('.step').next('.step').hasClass('step-3')){
            updateSummary();
        }

        let form_error = $('.form-error');
        if (form_error.hasClass('d-block')) {
            form_error.addClass('d-none');
        }
    });

    $(".prev-step").click(function() {
        if (currentStep > 1) {
            $(".step-" + currentStep)
                .addClass("animate__animated animate__fadeOutRight");

            currentStep--;

            setTimeout(function() {
                $(".step")
                    .addClass("d-none")
                    .removeClass("animate__animated animate__fadeOutLeft animate__fadeOutRight");

                $(".step-" + currentStep)
                    .removeClass("d-none")
                    .addClass("animate__animated animate__fadeInLeft");

                updateProgressBar();
                updateStepCircles();
            }, 500);
        }
    });

    updateProgressBar = function() {
        var progressPercentage = ((currentStep - 1) / 2) * 100;
        $(".progress-bar").css("width", progressPercentage + "%");
    };

    function updateStepCircles() {
        $(".step-circle").each(function(index) {
            let stepIndex = index + 1;

            // ======== تحديث حالة الدوائر ========
            $(this).removeClass("active complete");
            $(this).html(stepIndex);

            if (stepIndex < currentStep) {
                $(this).addClass("complete");
                $(this).html('<i class="fa fa-check"></i>');
            }

            if (stepIndex === currentStep) {
                $(this).addClass("active");
            }
        });

        // ======== تحديث حالة الـ Labels ========
        $(".step-label").each(function(index) {
            let stepIndex = index + 1;

            if (stepIndex === currentStep) {
                $(this).addClass("active");
            } else if (stepIndex > currentStep) {
                $(this).removeClass("active");
            }
        });
    }

    function updateSummary() {
        $('#summary_title').text($('#title').val());
        $('#summary_country').text($('#country_id option:selected').text());
        $('#summary_region').text($('#region_id option:selected').text());
        $('#summary_bikes_count').text($('#bikes_count').val());
        $('#summary_media_duration').text($('#media_duration').val() + 's');
        $('#summary_campaign_duration').text($('#campaign_duration option:selected').text());
        $('#summary_date_time').text($('.dateRange_total').val());
    }

    updateStepCircles();
});
