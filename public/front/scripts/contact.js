var Contact= function () {

    var init = function () {
        handle_submit();
    }

       var handle_submit = function () {
        $("#contact-form").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true
                },
                type: {
                    required: true
                },
                message: {
                    required: true
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');

            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(element).closest('.form-group').find('.help-block').html('');

            },
            errorPlacement: function (error, element) {
                errorElements1.push(element);
                $(element).closest('.form-group').find('.help-block').html($(error).html());
            }

        });
       $('#contact-form .submit-form').click(function () {

            if ($('#contact-form').validate().form()) {
                $('#contact-form .submit-form').prop('disabled', true);
                $('#contact-form .submit-form').html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>');
                setTimeout(function () {
                    $('#contact-form').submit();
                }, 1000);
            }
            return false;
        });
        $('#contact-form').submit(function () {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: config.url + "/contact_us",
                type: 'POST',
                dataType: 'json',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data)
                {
                    console.log(data);

                    $('#contact-form .submit-form').prop('disabled', false);
                    $('#contact-form .submit-form').html(lang.contact_now);
                    if (data.type == 'success') {
                        $('.alert-danger').hide();
                        $('.alert-success').show().find('.message').html(data.message);
                        setTimeout(function () {
                            window.location.href = config.url + '/login';
                        }, 3000);

                    } else {
                        $('#contact-form .submit-form').prop('disabled', false);
                        $('#contact-form .submit-form').html(lang.contact);
                        if (typeof data.errors !== 'undefined') {
                            console.log(data.errors);
                            for (i in data.errors)
                            {
                                $('[name="' + i + '"]')
                                        .closest('.form-group').addClass('has-error').removeClass("has-success");
                                $('[name="' + i + '"]').closest('.form-group').find(".help-block").html(data.errors[i][0])
                            }
                        }
                        if (typeof data.message !== 'undefined') {
                            $('.alert-success').hide();
                            $('.alert-danger').show().find('.message').html(data.message);
                        }
                    }


                },
                error: function (xhr, textStatus, errorThrown) {
                    $('#contact-form .submit-form').prop('disabled', false);
                    $('#contact-form .submit-form').html(lang.contact);
                    App.ajax_error_message(xhr);

                },
            });

            return false;
        });

    }





    return{

        init: function () {
            init();
        },

    }


}();

$(document).ready(function () {
    Contact.init();
});





