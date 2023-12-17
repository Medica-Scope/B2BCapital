/**
 * @Filename: search-front.js
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
import NhSearch from './modules/Search';

class NhSearchFront extends NhSearch
{
    constructor()
    {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            search: {
                form: $(`.${KEY}_header_search`),
                parent: $(`.${KEY}_header_search`).parent(),
                icon: $(`.${KEY}-header-search-icon`),
                input: $(`#${KEY}_s`),
            },
            searchAjax: {
                form: $(`#${KEY}_search_form_ajax`),
                parent: $(`#${KEY}_search_form_ajax`).parent(),
                keyword_input: $(`#${KEY}_s_ajax`),
                search_result: $('.search-result'),
                search_empty: $('.search-empty'),
                search_post_type: $(`input[name="search_post_type"]`),
            },
            loadmore: {
                parent: $(`.search-con`),
                loop: $(`.search-success`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.showSearch();
        this.searchFront();
        this.searchLoadMoreFront();
    }

    showSearch()
    {
        let that           = this,
            $search = this.$el.search;


        $search.icon.on('click', $search.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget);

            $search.input.animate({ opacity: 1, width: '250px' }, 250);
            $search.input.focus();
            $search.input.val('');

        });

        $(document).on('click', function (e) {
            let $this = $(e.target);
                if ($('#ninja_s').css('opacity') === '1' && !$this.hasClass('ninja-header-search-icon') && !$this.parent().hasClass('ninja-s')) {
                $search.input.animate({ opacity: 0, width: '0' }, 250)
            }
        })
    }

    searchFront() {
        let that = this,
            $search = this.$el.searchAjax,
            ajaxRequests = this.ajaxRequests;
        $(document).on("click",".open-search",function(e){
            $('.search-con').toggleClass('popupMode');
            $('.open-search').toggleClass('show')
        });

        $(document).on("click",`.${KEY}-search-icon`,function(e){
            console.log("clicked");
            $search.keyword_input.trigger("keyup")
        });

        
        $search.form.on('submit', function (e) {
            e.preventDefault();
        });

        $search.keyword_input.on('keyup', function (e) {
            e.preventDefault();
            let $this = $(e.currentTarget),
                type = $search.search_post_type.val(),
                formData = $this.val();

            if (typeof ajaxRequests.search !== 'undefined') {
                ajaxRequests.search.abort();
            }

            if ((e.type === 'keyup' && e.keyCode === 13 && formData.length > 0) || (e.type === 'blur' && formData.length > 0)) {
                that.search(formData, type, $search.form);
            }
        });
    }

    searchLoadMoreFront() {
        let that = this,
            $search = this.$el.searchAjax,
            $loadmore = this.$el.loadmore,
            ajaxRequests = this.ajaxRequests;

        $loadmore.parent.on('scroll', function (e) {
            e.preventDefault();

            let $this = $(e.currentTarget),
                last = $(`.search-success`).attr('data-last'),
                formData = {
                    page: $(`.search-success`).attr('data-page'),
                    s: $search.keyword_input.val(),
                };

            if ($this[0].scrollHeight - $this.scrollTop() <= $this.outerHeight() + 10 && last == 'false') {
                if (typeof ajaxRequests.searchLoadmore !== 'undefined') {
                    ajaxRequests.searchLoSadmore.abort();
                }
                that.loadmore(formData, $loadmore);
            }

        });
    }
}

new NhSearchFront();