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

class NhBlog extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    toggleFavorite($el,user_id,post_id)
    {
        let that                      = this;
        this.ajaxRequests.toggleFav = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_toggle_favorite_ajax`,
                user_id: user_id,
                post_id: post_id,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    if(res.data.fav_active == 0){
                        $el.addClass('btn-dark');
                    }else{
                        $el.removeClass('btn-dark');
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

    ignoreArticle($el,user_id,post_id)
    {
        let that                      = this;
        this.ajaxRequests.toggleFav = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_ignore_article_ajax`,
                user_id: user_id,
                post_id: post_id,
            },
            beforeSend: function () {
                UiCtrl.beforeSendPrepare($el);
            },
            success: function (res) {
                if (res.success) {
                    if(res.data.ignore_active == 0){
                        $el.removeClass('btn-outline-light');
                        $el.addClass('btn-outline-dark');
                    }else{
                        $el.removeClass('btn-outline-dark');
                        $el.addClass('btn-outline-light');
                    }
                    if(res.data.updated){
                        $('.blogs-list').html(res.data.updated);
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

export default NhBlog;
