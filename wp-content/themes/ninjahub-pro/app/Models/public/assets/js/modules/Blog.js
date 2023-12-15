/**
 * @Filename: Blog.js
 * @Description:
 * @User: Ahmed Gamal
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';
import _      from 'lodash';

class NhBlog extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    toggleFavorite(formData, $el)
    {
        let that                    = this;
        this.ajaxRequests.toggleFav = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_toggle_favorite_ajax`,
                data: formData,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    console.log('el', $el);
                    console.log('active', res.data.fav_active);
                    if (res.data.fav_active == 0) {
                        $el.find('.fav-star').toggleClass('bbc-star-o bbc-star');
                    } else {
                        $el.find('.fav-star').toggleClass('bbc-star bbc-star-o');
                    }
                    if (res.data.updated_text && $('.fav-text').length) {
                        $('.fav-text').html(res.data.updated_text);
                    }
                    UiCtrl.blockUI($el, false);
                    if($('#articleSuccess').length){
                        $('#articleSuccess').remove();
                    }
                    $('body').append(_.template($('#ninja_modal_article_request_success').html())({
                        msg: res.msg,
                        button_text: res.data.button_text,
                    }));
                    let successModal = new bootstrap.Modal(document.getElementById('articleSuccess'), {});
                    successModal.show();
                }
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            },
        });
    }

    ignoreArticle(formData, $el)
    {
        let that                    = this;
        this.ajaxRequests.toggleFav = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_ignore_article_ajax`,
                data: formData,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    if (res.data.ignore_active == 0) {
                        $el.find('.ignore-star').toggleClass('bbc-thumbs-down bbc-thumbs-up');
                    } else {
                        $el.find('.ignore-star').toggleClass('bbc-thumbs-up bbc-thumbs-down');
                    }
                    if (res.data.updated_text && $('.ignore-text').length) {
                        $('.ignore-text').html(res.data.updated_text);
                    }
                    UiCtrl.blockUI($el, false);
                    if($('#articleSuccess').length){
                        $('#articleSuccess').remove();
                    }
                    $('body').append(_.template($('#ninja_modal_article_request_success').html())({
                        msg: res.msg,
                        button_text: res.data.button_text,
                    }));
                    let successModal = new bootstrap.Modal(document.getElementById('articleSuccess'), {});
                    successModal.show();
                }
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            },
        });
    }

    // Method for creating a new token
    createNewToken()
    {
        grecaptcha.ready(function () {
            grecaptcha.execute(nhGlobals.publicKey).then(function (token) {
                $('input[name="g-recaptcha-response"]').val(token);
            });
        });
    }
}

export default NhBlog;
