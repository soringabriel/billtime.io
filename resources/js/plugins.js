/**
 * Place any jQuery/helper plugins in here.
 */

import 'jquery-datetimepicker'

$(function () {
    /**
     * Checkbox tree for permission selecting
     */
    let permissionTree = $('.permission-tree :checkbox');

    permissionTree.on('click change', function (){
        if($(this).is(':checked')) {
            $(this).siblings('ul').find('input[type="checkbox"]').attr('checked', true).attr('disabled', true);
        } else {
            $(this).siblings('ul').find('input[type="checkbox"]').removeAttr('checked').removeAttr('disabled');
        }
    });

    permissionTree.each(function () {
        if($(this).is(':checked')) {
            $(this).siblings('ul').find('input[type="checkbox"]').attr('checked', true).attr('disabled', true);
        }
    });

    /**
     * Disable submit inputs in the given form
     *
     * @param form
     */
    function disableSubmitButtons(form) {
        form.find('input[type="submit"]').attr('disabled', true);
        form.find('button[type="submit"]').attr('disabled', true);
    }

    /**
     * Enable the submit inputs in a given form
     *
     * @param form
     */
    function enableSubmitButtons(form) {
        form.find('input[type="submit"]').removeAttr('disabled');
        form.find('button[type="submit"]').removeAttr('disabled');
    }

    /**
     * Disable all submit buttons once clicked
     */
    $('form').submit(function () {
        disableSubmitButtons($(this));
        return true;
    });

    /**
     * Add a confirmation to a delete button/form
     */
    $('body').on('submit', 'form[name=delete-item]', function(e) {
        e.preventDefault();

        Swal.fire({
            title: $(this).attr('data-overrirde-message') ?? 'Are you sure you want to delete this item?',
            showCancelButton: true,
            confirmButtonText: 'Confirm Delete',
            cancelButtonText: 'Cancel',
            icon: 'warning'
        }).then((result) => {
            if (result.value) {
                this.submit()
            } else {
                enableSubmitButtons($(this));
            }
        });
    })
        .on('submit', 'form[name=confirm-item]', function (e) {
            e.preventDefault();

            Swal.fire({
                title: $(this).attr('data-overrirde-message') ?? 'Are you sure you want to do this?',
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                icon: 'warning'
            }).then((result) => {
                if (result.value) {
                    this.submit()
                } else {
                    enableSubmitButtons($(this));
                }
            });
        })
        .on('click', 'a[name=confirm-item]', function (e) {
        /**
         * Add an 'are you sure' pop-up to any button/link
         */
        e.preventDefault();
        Swal.fire({
            title: $(this).attr('data-overrirde-message') ?? 'Are you sure you want to do this?',
            showCancelButton: true,
            confirmButtonText: 'Continue',
            cancelButtonText: 'Cancel',
            icon: 'info',
        }).then((result) => {
            result.value && window.location.assign($(this).attr('href'));
        });
    });

    // Remember tab on page load
    $('a[data-toggle="tab"], a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        let hash = $(e.target).attr('href');
        history.pushState ? history.pushState(null, null, hash) : location.hash = hash;
    });

    let hash = window.location.hash;
    if (hash) {
        $('.nav-link[href="'+hash+'"]').tab('show');
    }

    // Enable tooltips everywhere
    $('[data-toggle="tooltip"]').tooltip();
    let date = new Date(); 

    $('.datetimepicker').each(function(){
        $(this).datetimepicker({
            step: 5,
            format: 'Y-m-d H:i',
            defaultDate: date,
            maxDate: date
        });
    })

    $(".datetimepicker-action").on('click', function(){
        let current_formatted_datetime = dateToYYYYMMDDHHIISS(new Date());
        $(this).prev().val(current_formatted_datetime);
    })

    // Livewires bulk selections
    $(".bulk-checkbox").on('change', function(){
        let checked;
        try {
            checked = JSON.parse($(".bulk-checkbox-values").first().val());
        } catch (e) {
            checked = [];
        }
        $(".bulk-checkbox").each(function(){
            var index = checked.indexOf($(this).val());
            if ($(this).is(":checked")) {
                if (index == -1) {
                    checked.push($(this).val());
                }
            } else {
                var index = checked.indexOf($(this).val());
                if (index !== -1) {
                    checked.splice(index, 1);
                }
            }
        })
        $(".bulk-checkbox-values").each(function(){
            $(this).val(JSON.stringify(checked));
            $(this)[0].dispatchEvent(new Event('change'));
        })
    })

    $("#checkRowsPage").on('change', function(){
        if ($(this).is(":checked")) {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', true);
            })
        } else {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', false);
            })
        }
        var values = [];
        $(".bulk-checkbox").each(function(){
            if ($(this).is(":checked")) {
                values.push($(this).val());
            }
        });
        $(".bulk-checkbox-values").each(function(){
            $(this).val(JSON.stringify(values));
            $(this)[0].dispatchEvent(new Event('change'));
        })
    })

    $("#checkAllRows").on('change', function(){
        if ($(this).is(":checked")) {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', true);
            })
            $(".bulk-checkbox-values").each(function(){
                $(this).val($("#allRows").val());
                $(this)[0].dispatchEvent(new Event('change'));
            })
        } else {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', false);
            })
            $(".bulk-checkbox-values").each(function(){
                $(this).val("[]");
                $(this)[0].dispatchEvent(new Event('change'));
            })
        }
    })

    $(".bulk-checkbox-values").on('change', function(){
        setTimeout(() => {
            $("#checkedTimesValues")[0].dispatchEvent(new Event('change'));
        }, 1500);
    });

});

$(function () {
    $(".open-chat").on("click", function(){
        if (typeof $crisp !== 'undefined') {
            if ($crisp.is("chat:opened")) {
                $crisp.push(['do', 'chat:close']);
            } else {
                $crisp.push(['do', 'chat:open']);
            }
        }
    })
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
  
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function dateToYYYYMMDDHHIISS(datetime) {
    let month = (datetime.getMonth() + 1);
    let day = datetime.getDate();
    let hour = datetime.getHours();
    let minutes = datetime.getMinutes();
    if (month < 10) {
        month = "0" + month;
    }
    if (day < 10) {
        day = "0" + day;
    }
    if (hour < 10) {
        hour = "0" + hour;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    return datetime.getFullYear() + "-" + month + "-" + day + " " + hour + ":" + minutes;
}