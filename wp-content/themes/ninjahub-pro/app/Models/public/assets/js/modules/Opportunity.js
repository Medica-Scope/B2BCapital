/**
 * @Filename: Opportunity.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';

class NhOpportunity extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    // getNhACFCusomForm(formData, $el) {
    //     let that = this;
    //     // Creating an AJAX request for login
    //     this.ajaxRequests.getForm = $.ajax({
    //         url: nhGlobals.ajaxUrl,
    //         type: 'POST',
    //         data: {
    //             action: `${KEY}_acf_custom_form_ajax`,
    //             data: formData,
    //         },
    //         beforeSend: function() {
    //             $el.find('input, button').prop('disabled', true);
    //             UiCtrl.beforeSendPrepare($el);
    //         },
    //         success: function(res) {
    //             $('input').prop('disabled', false);
    //
    //             if (res.success) {
    //                 UiCtrl.notices($el, res.msg, 'success');
    //             } else {
    //                 UiCtrl.notices($el, res.msg);
    //             }
    //
    //             $('.nh-custom-form').show();
    //             $('.nh-acf-form').html(res.data.html);
    //
    //             // $el.find('input, button').prop('disabled', false);
    //
    //             UiCtrl.blockUI($el, false);
    //         },
    //         error: function(xhr) {
    //             let errorMessage = `${xhr.status}: ${xhr.statusText}`;
    //             if (xhr.statusText !== 'abort') {
    //                 console.error(errorMessage);
    //             }
    //         },
    //     });
    // }

    createOpportunity(formData, $el) {
        let that = this;
        // Creating an AJAX request for login
        this.ajaxRequests.getForm = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_create_opportunity_ajax`,
                data: formData,
            },
            beforeSend: function() {
                $el.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el);
            },
            success: function(res) {
                $('input').prop('disabled', false);

                if (res.success) {
                    UiCtrl.notices($el, res.msg, 'success');
                    window.location.href = res.data.redirect_url;
                } else {
                    UiCtrl.notices($el, res.msg);
                }

                $el.find('input, button').prop('disabled', false);
                that.createNewToken();
                UiCtrl.blockUI($el, false);
            },
            error: function(xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
                that.createNewToken();
            },
        });
    }

    // Method for creating a new token
    createNewToken() {
        grecaptcha.ready(function() {
            grecaptcha.execute(nhGlobals.publicKey).then(function(token) {
                $('#g-recaptcha-response').val(token);
            });
        });
    }

    ajax_upload($wrapper, data, target, $input, $el) {
        let that = this,
            ajaxRequests = this.ajaxRequests;
        let file = data.get('file');
        let file_name = that.renameFile(file.name);
        let $file = $(that.createAttachment(file_name));

        ajaxRequests.ninjaAttacmentUpload = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            beforeSend: function () {

                $el.form.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.form);
            },
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = evt.loaded / evt.total,
                            progress = $file.find('.ninja-progress');
                        percentComplete = parseInt(percentComplete * 100);
                        progress.width(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function (res) {
                if (res.success) {
                    // BLOCK UI
                    $el.form.find('input, button').prop('disabled', false);
                    UiCtrl.beforeSendPrepare($el.form);

                    // Remove attachment wrapper if exists
                    let label_id = $(`input[data-target="${target}"]`).attr('id');
                    $(`label[for="${label_id}"]`).hide();
                    if ($wrapper.find('.ninja-single-attachment-wrapper').length) {
                        $wrapper.find('.ninja-single-attachment-wrapper').remove();
                    }
                    $wrapper.append($file);


                    // Show the new attachment then add it to the form
                    let input_file = $('<input type="hidden" name="files[]" />');
                    $file.find('.ninja-attachment-progress').remove();
                    $file.find('.ninja-single-attachment').append(input_file);
                    input_file.attr('data-imgID', res.data.attachment_ID);
                    $(`input[name="${target}"]`).val(res.data.attachment_ID);
                    that.createNewToken();
                    UiCtrl.blockUI($el.form, false);

                } else {
                    // Reset Input
                    $input.val('');
                    $(`input[name="${target}"]`).val(""); // input that should hold the attachment ID
                    $(`input[data-target="${target}"]`).val(""); // file input type
                    $el.form.find('input, button').prop('disabled', false);
                    UiCtrl.notices($wrapper.closest('form'), res.msg);
                    UiCtrl.blockUI($el.form, false);

                    // Scroll the page to the target element
                    $('html, body').animate({
                        scrollTop: $('.ninja-form-notice.result').offset().top - 200,
                    }, 500); // Adjust the duration as needed

                }
            },
            complete: function () {
                $wrapper.find('input').prop('disabled', false);
            },
            error: function (xhr, status, error) {
                let errorMessage = xhr.status + ': ' + xhr.statusText;
                if (xhr.statusText !== 'abort') {
                    $file.remove();
                    $el.form.find('input, button').prop('disabled', false);
                    $(`input[name="${target}"]`).val(""); // input that should hold the attachment ID
                    $(`input[data-target="${target}"]`).val(""); // file input type
                    // UiCtrl.notices($wrapper.closest('form'), res.msg);
                    UiCtrl.blockUI($el.form, false);
                    console.error(errorMessage);
                }
            },
        });
    }


    ajax_remove($wrapper, data, $btn, $el) {
        let that = this,
            ajaxRequests = this.ajaxRequests;

        ajaxRequests.ninjaAttacmentRemove = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            beforeSend: function () {
                $el.form.find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.form);
            },
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = evt.loaded / evt.total;
                    }
                }, false);
                return xhr;
            },
            success: function (res) {
                if (res.success) {
                    // Remove attachment icon with it's parent
                    $btn.closest('.ninja-single-attachment-wrapper').fadeOut(200, function () {
                        $btn.closest('.ninja-single-attachment-wrapper').remove();
                    });


                    // TODO:: SHOULD BE ENHANCED
                    // ========================= //
                    let target = $btn.parent().parent().parent().find('input[type="file"]').attr('data-target');
                    $(`input[name="${target}"]`).val('');
                    $(`input[data-target="${target}"]`).val('');
                    let label_id = $(`input[data-target="${target}"]`).attr('id');
                    $(`label[for="${label_id}"]`).show();
                    // ========================= //


                    $wrapper.find('.ninja-attachment-uploader').val('');
                    $el.form.find('input, button').prop('disabled', false);
                    that.createNewToken();
                    UiCtrl.blockUI($el.form, false);

                } else {
                    $el.form.find('input, button').prop('disabled', false);
                    UiCtrl.notices($wrapper.closest('form'), res.msg);
                    UiCtrl.blockUI($el.form, false);

                    // Scroll the page to the target element
                    $('html, body').animate({
                        scrollTop: $('.ninja-form-notice.result').offset().top - 200,
                    }, 500); // Adjust the duration as needed
                }
            },
            complete: function () {
                $wrapper.find('input').prop('disabled', false);
                $wrapper.find('input').val('');
            },
            error: function (xhr, status, error) {
                let errorMessage = xhr.status + ': ' + xhr.statusText;
                if (xhr.statusText !== 'abort') {
                    $el.form.find('input, button').prop('disabled', false);
                    // UiCtrl.notices($wrapper.closest('form'), res.msg);
                    UiCtrl.blockUI($el.form, false);
                    console.error(errorMessage);
                }
            },
        });
    }

    toggleFavoriteOpportunity(formData, $el)
    {
        let that                      = this;
        this.ajaxRequests.toggleFav = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_toggle_favorite_opportunity_ajax`,
                data: formData,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    if(res.data.fav_active == 0){
                        $el.find('.fav-star').toggleClass('bbc-star-o bbc-star');
                    }else{
                        $el.find('.fav-star').toggleClass('bbc-star bbc-star-o');
                    }
                    UiCtrl.blockUI($el, false);

                }
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }

    ignoreOpportunity(formData, $el)
    {
        let that                      = this;
        this.ajaxRequests.ignoreOpportunity = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_ignore_opportunity_ajax`,
                data: formData,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    if(res.data.ignore_active == 0){
                        $el.find('.fav-star').toggleClass('bbc-star-o bbc-star');
                    }else{
                        $el.find('.fav-star').toggleClass('bbc-star bbc-star-o');
                    }
                    if(res.data.updated){
                        $('.opportunity-list .card-group').html(res.data.updated);
                    }
                    UiCtrl.blockUI($el, false);

                }
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            }
        });
    }
}

export default NhOpportunity;
