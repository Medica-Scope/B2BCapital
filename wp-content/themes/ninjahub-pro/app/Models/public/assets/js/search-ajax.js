/**
 * Filename: search-ajax.js
 * Description:
 * User: Ahmed Gamal
 * Date: 7/9/2022
 */

/* global KEY*/
// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhUiCtrl from './inc/UiCtrl';
import NhSearch from './modules/Search';

class NhSearchAjaxFront extends NhSearch {
    constructor() {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el = this.UiCtrl.selectors = {
            search: {
                form: $(`#${KEY}_search_form_ajax`),
                parent: $(`#${KEY}_search_form_ajax`).parent(),
                keyword_input: $(`#${KEY}_s`),
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

    initialization() {
        this.searchFront();
        this.searchLoadMoreFront();
    }

    searchFront() {
        let that = this,
            $search = this.$el.search,
            ajaxRequests = this.ajaxRequests;
        $(document).on("click",".open-search",function(e){
            $('.search-con').toggleClass('popupMode');
            $('.open-search').toggleClass('show')
        });

        that.$el.search.form.on('submit', function (e) {
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
                that.search(formData, type, that.$el.search.form);
            }
        });
    }

    searchLoadMoreFront() {
        let that = this,
            $search = this.$el.search,
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
                    ajaxRequests.searchLoadmore.abort();
                }
                that.loadmore(formData, $loadmore);
            }

        });
    }
}

new NhSearchAjaxFront();