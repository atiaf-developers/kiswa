
var Main = function () {


    var init = function () {
        handleChangeLang();
        handleDailyReportNoti();


    }

    var handleDailyReportNoti = function () {
        var lastDailyReport = localStorage.getItem('lastDailyReport'),
                time_now = (new Date()).getTime();
        if (lastDailyReport == null) {
            localStorage.setItem('lastDailyReport', time_now);
        } else {
            $24_hours = 1000 * 60 * 60 * 24;
            $one_hour = 1000 * 60 * 60 ;
            //$hours = 1;
            if ((time_now - lastDailyReport) > $one_hour) {

                localStorage.removeItem('lastDailyReport', time_now);

                localStorage.setItem('lastDailyReport', time_now);
                bootbox.dialog({
                    message: '<p class="text-center">' + lang.daily_message + '</p>',
                    title: lang.message,
                    buttons: {
                        ok: {
                            label: "yes",
                            className: 'btn-danger',
                            callback: function () {
                                window.location.href=config.admin_url+'/delegates_report?type=1'
                                return false;
                            }
                        },
                        noclose: {
                            label: "no",
                            className: 'btn-warning',
                            callback: function () {

                            }
                        },
                    }
                });
            }
        }


    }




    var handleChangeLang = function () {
        $(document).on('change', '#change-lang', function () {
            var lang_code = $(this).val();
            var action = config.admin_url + '/change_lang';
            $.ajax({
                url: action,
                data: {lang_code: lang_code},
                async: false,
                success: function (data) {
                    console.log(data);
                    if (data.type == 'success') {

                        window.location.reload()

                    }


                },
                error: function (xhr, textStatus, errorThrown) {
                    My.ajax_error_message(xhr);
                },
                dataType: "JSON",
                type: "GET"
            });

            return false;
        });
    }




    return {
        init: function () {
            init();
        },

    }

}();

jQuery(document).ready(function () {
    Main.init();
});


