/**
 * @Filename: search-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global b2bGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import B2bValidator    from './helpers/Validator';
import B2bUiCtrl       from './inc/UiCtrl';

class B2bSearchFront
{
    constructor()
    {
        this.UiCtrl = new B2bUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            search: {
                form: $(`.${KEY}_header_search`),
                parent: $(`.${KEY}_header_search`).parent(),
                icon: $(`.${KEY}-header-search-icon`),
                input: $(`#${KEY}_s`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.showSearch();
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
                if ($('#b2b_s').css('opacity') === '1' && !$this.hasClass('b2b-header-search-icon') && !$this.parent().hasClass('b2b-s')) {
                $search.input.animate({ opacity: 0, width: '0' }, 250)
            }
        })
    }
}

new B2bSearchFront();