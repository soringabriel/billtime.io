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
            title: 'Are you sure you want to delete this item?',
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
                title: 'Are you sure you want to do this?',
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
            title: 'Are you sure you want to do this?',
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
        let current_datetime = new Date();
        let month = (current_datetime.getMonth() + 1);
        let day = current_datetime.getDate();
        let hour = current_datetime.getHours();
        let minutes = current_datetime.getMinutes();
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
        let formatted_date = current_datetime.getFullYear() + "-" + month + "-" + day + " " + hour + ":" + minutes;
        $(this).prev().val(formatted_date);
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
        })
    })

    $("#checkRowsPage").on('change', function(){
        if ($(this).is(":checked")) {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', true);
                $(this).trigger('change');
            })
        } else {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', false);
                $(this).trigger('change');
            })
        }
    })

    $("#checkAllRows").on('change', function(){
        if ($(this).is(":checked")) {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', true);
                $(this)[0].dispatchEvent(new Event('change'));
            })
            $(".bulk-checkbox-values").each(function(){
                $(this).val($("#allRows").val());
            })
        } else {
            $(".bulk-checkbox").each(function(){
                $(this).prop('checked', false);
                $(this)[0].dispatchEvent(new Event('change'));
            })
            $(".bulk-checkbox-values").each(function(){
                $(this).val("[]");
            })
        }
    })
});
