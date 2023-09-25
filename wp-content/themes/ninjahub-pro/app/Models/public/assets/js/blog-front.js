/**
 * @Filename: blog-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator    from './helpers/Validator';
import NhUiCtrl       from './inc/UiCtrl';
import NhBlog from './modules/Blog';

class NhBlogFront extends NhBlog
{
    constructor()
    {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            controlls: {
                favBtn: $(`.${KEY}-add-to-fav`),
                ignoreBtn: $(`.${KEY}-add-to-ignore`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.toggleFav();
        this.ignore_article();
    }

    toggleFav()
    {
        let that           = this,
            $controlls = this.$el.controlls,
            ajaxRequests   = this.ajaxRequests;


        $controlls.favBtn.on('click', $controlls.favBtn.parent(), function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);
            let user_id = $this.attr('data-uID');
            let post_id = $this.attr('data-id');

            if (typeof ajaxRequests.toggleFav !== 'undefined') {
                ajaxRequests.toggleFav.abort();
            }

            that.toggleFavorite($this,user_id,post_id);
        });
    }

    ignore_article(){
        let that           = this,
            $controlls = this.$el.controlls,
            ajaxRequests   = this.ajaxRequests;


        $controlls.ignoreBtn.on('click', $controlls.ignoreBtn.parent(), function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget);
            let user_id = $this.attr('data-uID');
            let post_id = $this.attr('data-id');

            if (typeof ajaxRequests.ignoreArticle !== 'undefined') {
                ajaxRequests.ignoreArticle.abort();
            }
            console.log('clicked');
            that.ignoreArticle($this,user_id,post_id);
        });
    }
}

new NhBlogFront();