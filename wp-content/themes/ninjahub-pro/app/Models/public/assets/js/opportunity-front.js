/**
 * @Filename: opportunity-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator   from './helpers/Validator';
import NhUiCtrl      from './inc/UiCtrl';
import NhOpportunity from './modules/Opportunity';
import tinymce       from 'tinymce/tinymce';
import 'tinymce/themes/silver';  // Import the theme
import 'tinymce/plugins/link';   // Import a plugin
import 'tinymce/icons/default';  // Import the icons
import 'tinymce/models/dom';  // Import the dom

class NhOpportunityFront extends NhOpportunity
{
    constructor()
    {
        super();
        this.UiCtrl        = new NhUiCtrl();
        this.$el           = this.UiCtrl.selectors = {
            opportunity: {
                form: $(`#${KEY}_create_opportunity_form`),
                parent: $(`#${KEY}_create_opportunity_form`).parent(),
                category: $(`#${KEY}_category`).parent(),
                opportunity_type: $(`#${KEY}_opportunity_type`).parent(),
            },
            filter_opportunity: {
                form: $(`#${KEY}_filter_opportunity_form`),
                parent: $(`#${KEY}_filter_opportunity_form`).parent(),
            },
            favorite: {
                form: $(`.${KEY}-add-to-fav-form`),
                parent: $(`.${KEY}-add-to-fav-form`).parent(),
            },
            ignore: {
                form: $(`.${KEY}-create-ignore-opportunity-form`),
                parent: $(`.${KEY}-create-ignore-opportunity-form`).parent(),
            },
        };
        this.attachment    = {
            currentSize: 0,
            totalSize: 26214400,
        };
        this.max_file_size = 5242880;
        this.initialization();
    }

    initialization()
    {
        this.CreateOpportunityFront();
        this.FilterOpportunityFront()
        this.CreateOpportunityFormFieldsFront();
        this.upload();
        this.remove();
        this.toggle_fav_opportunity();
        this.ignore_opportunity();
        this.list_grid_switch();
        this.reset_form();
        this.toggleControllers();
    }

    CreateOpportunityFormFieldsFront()
    {
        let that         = this,
            $opportunity = this.$el.opportunity,
            ajaxRequests = this.ajaxRequests;

        tinymce.init({
            selector: `#${KEY}_extra_details`,
            base_url: '/wp-content/themes/ninjahub-pro/node_modules/tinymce',
            suffix: '.min',
            menubar: false,
            height: 250
        }).then();

        $opportunity.opportunity_type.on('change', $opportunity.parent, function (e) {
            let $this   = $(e.currentTarget),
                $target = $this.find(':selected').attr('data-target');

            $('.nh-opportunities-fields').hide();
            $('#' + $target + '_target').show();

            console.log('#' + $target + '_target');
        });
    }

    CreateOpportunityFront()
    {
        let that         = this,
            $opportunity = this.$el.opportunity,
            ajaxRequests = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initOpportunityValidation($opportunity, 'createOpportunity');

        // Handle form submission
        $opportunity.form.on('submit', $opportunity.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            formData.extra_details = tinymce.get(`${KEY}_extra_details`).getContent();

            // Abort any ongoing registration requests
            if (typeof ajaxRequests.createOpportunity !== 'undefined') {
                ajaxRequests.createOpportunity.abort();
            }

            // Validate the form and perform registration if valid
            if ($this.valid()) {
                that.createOpportunity(formData, $this);
            }
        });
    }

    FilterOpportunityFront()
    {
        let that         = this,
            $opportunity = this.$el.filter_opportunity,
            ajaxRequests = this.ajaxRequests;

        // Initialize form validation
        NhValidator.initOpportunityValidation($opportunity, 'filterOpportunity');

        // Handle form submission
        $opportunity.form.on('submit', $opportunity.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();

            // Abort any ongoing registration requests
            if (typeof ajaxRequests.filterOpportunity !== 'undefined') {
                ajaxRequests.filterOpportunity.abort();
            }

            // Validate the form and perform registration if valid
            if ($this.valid()) {
                that.filterOpportunity(formData, $this);
            }
        });
    }

    upload()
    {
        let that         = this,
            $opportunity = this.$el.opportunity,
            ajaxRequests = this.ajaxRequests;

        $('.ninja-attachment-uploader').on('change', $opportunity, function (e) {
            e.preventDefault();
            let $this      = $(e.currentTarget),
                form_data  = new FormData(),
                files      = $this[0].files,
                target     = $(this).attr('data-target'),
                $recaptcha = $this.closest('form').find('#g-recaptcha-response').val();

            form_data.append('action', `${KEY}_upload_attachment`);
            form_data.append('g-recaptcha-response', $recaptcha);

            if (typeof ajaxRequests.ninjaAttacmentUpload !== 'undefined') {
                ajaxRequests.ninjaAttacmentUpload.abort();
            }
            if (files.length > 0) {
                if (!that.checkExt(files[0].name)) {
                    NhUiCtrl.notices($this.closest('form'), 'extension error');
                    $('html, body').animate({
                        scrollTop: $('.ninja-form-notice.result').offset().top - 200,
                    }, 500);
                    NhUiCtrl.blockUI($opportunity.form, false);
                    return;
                }
                if (files[0].size > that.max_file_size) {
                    NhUiCtrl.notices($this.closest('form'), 'The file size can\'t be more than ' + (that.max_file_size / 1024 / 1024) + 'MB.');
                    $('html, body').animate({
                        scrollTop: $('.ninja-form-notice.result').offset().top - 200,
                    }, 500);
                    NhUiCtrl.blockUI($opportunity.form, false);
                    return;
                }

                if (files[0].size <= that.max_file_size) {
                    form_data.append('file', files[0]);
                    that.ajax_upload($this.parent(), form_data, target, $this, $opportunity);
                } else {
                    NhUiCtrl.notices($this.closest('form'), 'invalid file size');
                    $('html, body').animate({
                        scrollTop: $('.ninja-form-notice.result').offset().top - 200,
                    }, 500);
                    NhUiCtrl.blockUI($opportunity.form, false);
                }

            }

        });
    }

    remove()
    {
        let that         = this,
            $opportunity = this.$el.opportunity,
            ajaxRequests = this.ajaxRequests;

        $(document).on('click', '.ninja-remove-attachment', function (e) {
            e.preventDefault();
            let $this      = $(e.currentTarget),
                form_data  = new FormData(),
                $recaptcha = $this.closest('form').find('#g-recaptcha-response').val(),
                target     = $this.parent().parent().parent().find('input[type="file"]').attr('data-target');
            form_data.append('action', `${KEY}_remove_attachment`);
            form_data.append('g-recaptcha-response', $recaptcha);

            form_data.append('attachment_id', $(`input[name="${target}"]`).val());

            if (typeof ajaxRequests.ninjaAttacmentRemove !== 'undefined') {
                ajaxRequests.ninjaAttacmentRemove.abort();
            }

            that.ajax_remove($this.parent(), form_data, $this, $opportunity);
        });
    }

    createAttachment(filename)
    {
        return '<div class="col-sm-2 ninja-single-attachment-wrapper"><div class="ninja-single-attachment"><i class="bbc-file"></i><p class="ninja-attachment-name">' + filename + '</p><div class="ninja-attachment-progress"><span class="ninja-progress"></span></div><a href="javascript:;" class="ninja-remove-attachment"><i class="bbc-x-circle"></i></a></div></div>';
    };

    renameFile(filename)
    {
        let splice               = filename.split('.'),
            ext                  = splice[splice.length - 1],
            name                 = splice[0],
            subStringingFileName = name.substring(0, 5) + '...';
        return subStringingFileName + ext;
    };

    checkExt(filename)
    {
        let splice       = filename.split('.'),
            availableExt = [
                'jpg',
                'jpeg',
                'png',
            ],
            ext          = splice[splice.length - 1];

        return $.inArray(ext.toLowerCase(), availableExt) >= 0;
    };

    toggle_fav_opportunity()
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

                    that.toggleFavoriteOpportunity(formData, $this);
            });
    }

    ignore_opportunity()
    {
        let that         = this,
        $ignore   = this.$el.ignore,
        ajaxRequests = this.ajaxRequests;
        
        $ignore.form.on('submit', $ignore.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget),
                formData = $this.serializeObject();
    
            // Abort any ongoing registration requests
            if (typeof ajaxRequests.ignoreOpportunity !== 'undefined') {
                ajaxRequests.ignoreOpportunity.abort();
            }

                that.ignoreOpportunity(formData, $this);
        });
    }

    list_grid_switch(){
        let that = this;

        $(document).on("click", '.grid-switch', function(e){
            let old_value = $('.grid-switch.active').attr('data-view');
            $('.grid-switch.active').removeClass('active');
            $(this).addClass('active');
            that.setCookie('grid_view', $(this).attr('data-view'), 1);
            $('.opportunity-list .row').removeClass(old_value);
            $('.opportunity-list .row').addClass($(this).attr('data-view'));
        });
    }
    setCookie(name, value, daysToLive) {
        // Encode value in order to escape semicolons, commas, and whitespace
        var cookie = name + "=" + encodeURIComponent(value);

        if(typeof daysToLive === "number") {
            /* Sets the max-age attribute so that the cookie expires
            after the specified number of days */
            cookie += "; max-age=" + (daysToLive*24*60*60);

            document.cookie = cookie;
        }
    }
    getCookie(name) {
        // Split cookie string and get all individual name=value pairs in an array
        var cookieArr = document.cookie.split(";");

        // Loop through the array elements
        for(var i = 0; i < cookieArr.length; i++) {
            var cookiePair = cookieArr[i].split("=");

            /* Removing whitespace at the beginning of the cookie name
            and compare it with the given string */
            if(name == cookiePair[0].trim()) {
                // Decode the cookie value and return
                return decodeURIComponent(cookiePair[1]);
            }
        }

        // Return null if not found
        return null;
    }
    reset_form(){
        $(document).on("click", ".reset-btn", function(e){
            $('#ninja_filters_form :input').not('input[type=range]').val('');
            $('#ninja_filters_form input[type=range]').each(function() {
                var defaultValue = this.min;
                $(this).val(defaultValue);
                var rangeId = $(this).attr('id');
                $('#rangeValue-' + rangeId).text(defaultValue);
            });
            if (history.pushState) {
                var reset_url = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({path:reset_url}, '', reset_url);
            }
        });
    }
    toggleControllers(){
        $(document).on("click", ".show-controllers", function(e){
            $(this).siblings('.opportunity-item-controllers').toggleClass('ninja-hidden');
        });
    }
}

new NhOpportunityFront();
