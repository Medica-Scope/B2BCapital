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
            favorite: {
                form: $(`.${KEY}-add-to-fav-form`),
                parent: $(`.${KEY}-add-to-fav-form`).parent(),
            },
            ignore: {
                form: $(`.${KEY}-create-ignore-article-form`),
                parent: $(`.${KEY}-create-ignore-article-form`).parent(),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.toggleFav();
        this.ignore_article();
        this.toggleControllers();
    }

    toggleFav()
    {
        let that         = this,
            $favorite   = this.$el.favorite,
            ajaxRequests = this.ajaxRequests;
            
            $favorite.form.on('submit', $favorite.parent, function (e) {
                e.preventDefault();
                let $this    = $(e.currentTarget),
                    formData = $this.serializeObject();
        
                // Abort any ongoing registration requests
                if (typeof ajaxRequests.toggleFav !== 'undefined') {
                    ajaxRequests.toggleFav.abort();
                }
                    that.toggleFavorite(formData, $this);
            });
    }
    ignore_article(){

            let that         = this,
            $ignore   = this.$el.ignore,
            ajaxRequests = this.ajaxRequests;
            
            $ignore.form.on('submit', $ignore.parent, function (e) {
                e.preventDefault();
                let $this    = $(e.currentTarget),
                    formData = $this.serializeObject();
        
                // Abort any ongoing registration requests
                if (typeof ajaxRequests.ignoreArticle !== 'undefined') {
                    ajaxRequests.ignoreArticle.abort();
                }

                    that.ignoreArticle(formData, $this);
            });
    }
    toggleControllers(){
        $(document).on("click", ".show-controllers", function(e){
            $(this).siblings('.opportunity-item-controllers').toggleClass('ninja-hidden');
        });
    }
}

new NhBlogFront();