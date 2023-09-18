/* globals jQuery, nhGlobals */
(function ($, nhGlobals, tinymce) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    const ajaxRequests = {};
    const KEY          = nhGlobals.domain_key;

    const main = {
        'init': function () {
            this.global();
            this.events();
            contact.init();
            social.init();
            apps.init();
            exportForm.init();
            importForm.init();
        },

        'global': function () {

            let forms = document.querySelectorAll('.needs-validation');
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        },

        'events': function () {

            $(document).on('nhConfig.updating', function (e, data = {}) {
                let that  = this,
                    $this = $(e.target),
                    $btn  = $this.find('[type="submit"]'),
                    html  = `
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="">${nhGlobals.loader_text}</span>
                    `;

                $this.block({
                    message: null,
                    overlayCSS: { backgroundColor: '#FFF' },
                });

                $btn.html(html);

            });

            $(document).on('nhConfig.updating-progress', function (e, data = {}) {
                let that            = this,
                    $this           = $(e.target),
                    $btn            = $this.find('[type="submit"]'),
                    htmlBtn         = `
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="">${nhGlobals.loader_text}</span>
                    `,

                    htmlProgressBar = `
                        <div class="nh-progress nh-importing-process">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%" role="progressbar" aria-valuenow="0"
                                     aria-valuemin="0"
                                     aria-valuemax="100">0%
                                </div>
                            </div>
                        </div>
                    `;

                $this.block({
                    message: null,
                    overlayCSS: { backgroundColor: '#FFF' },
                });

                $btn.html(htmlBtn);
                $('.nh-progress').remove();
                $btn.closest('.accordion-body').prepend(htmlProgressBar);

            });

            $(document).on('nhConfig.updated', function (e, data = {}) {
                let that            = this,
                    $this           = $(e.target),
                    $toastContainer = $('.toast-container'),
                    $btn            = $this.find('[type="submit"]'),
                    html            = $(`
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img src="${nhGlobals.icon}" class="rounded me-2" alt="'NH Logo">
                            <strong class="me-auto">${nhGlobals.toast_title}</strong>
                            <small class="text-muted">${nhGlobals.toast_time}</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body bg-white">
                            ${data.toast_msg}
                        </div>
                    </div>
                    `);

                // $('input').prop('disabled', false);
                // $this.find('input, button').prop('disabled', false);
                $btn.html(nhGlobals.submit_text);
                $this.unblock();

                $toastContainer.append(html);

                const toast = new bootstrap.Toast(html);

                toast.show();

            });

            $(document).on('nhConfig.updated:success', function (e, data = {}) {
                let that  = this,
                    $this = $(e.target),
                    html  = `
                        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <div>
                                ${data.msg}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        `;

                $('.nh-notices').html(html);
            });

            $(document).on('nhConfig.updated:failed', function (e, data = {}) {
                let that  = this,
                    $this = $(e.target),
                    html  = `
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                              </svg>
                            <div>
                                ${data.msg}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        `;

                $('.nh-notices').html(html);
            });

        },
    };

    const social = {
        'init': function () {
            this.options_form();
        },
        'options_form': function () {
            let that  = this,
                $form = $(`#${KEY}_social_form`);

            $form.on('submit', function (e) {
                e.preventDefault();
                let $this    = $(e.currentTarget),
                    formData = $this.serializeObject();

                if (typeof ajaxRequests.social !== 'undefined') {
                    ajaxRequests.social.abort();
                }

                if (!$this.isValid()) {
                    e.stopPropagation();
                } else {
                    $this.addClass('was-validated');
                    that.ajax(formData, $this);
                }

            });
        },

        'ajax': (formData, $el) => {
            ajaxRequests.social = $.ajax({
                url: nhGlobals.ajaxUrl,
                type: 'POST',
                data: {
                    action: `${KEY}_social_ajax`,
                    data: formData,
                },
                beforeSend: function () {
                    $el.trigger('nhConfig.updating', [formData]);
                },
                success: function (res) {
                    if (res.success) {
                        $el.trigger('nhConfig.updated:success', [res]);
                    } else {
                        $el.trigger('nhConfig.updated:failed', [res]);
                    }
                    $el.trigger('nhConfig.updated', [res]);
                },
                error: function (xhr) {
                    let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                    if (xhr.statusText !== 'abort') {
                        console.error(errorMessage);
                    }
                },
            });
        },
    };

    const apps = {
        'init': function () {
            this.options_form();
        },
        'options_form': function () {
            let that  = this,
                $form = $(`#${KEY}_apps_form`);

            $form.on('submit', function (e) {
                e.preventDefault();
                let $this    = $(e.currentTarget),
                    formData = $this.serializeObject();

                if (typeof ajaxRequests.apps !== 'undefined') {
                    ajaxRequests.apps.abort();
                }

                if (!$this.isValid()) {
                    e.stopPropagation();
                } else {
                    $this.addClass('was-validated');
                    that.ajax(formData, $this);
                }

            });
        },

        'ajax': (formData, $el) => {
            ajaxRequests.apps = $.ajax({
                url: nhGlobals.ajaxUrl,
                type: 'POST',
                data: {
                    action: `${KEY}_apps_ajax`,
                    data: formData,
                },
                beforeSend: function () {
                    $el.trigger('nhConfig.updating', [formData]);
                },
                success: function (res) {
                    if (res.success) {
                        $el.trigger('nhConfig.updated:success', [res]);
                    } else {
                        $el.trigger('nhConfig.updated:failed', [res]);
                    }
                    $el.trigger('nhConfig.updated', [res]);
                },
                error: function (xhr) {
                    let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                    if (xhr.statusText !== 'abort') {
                        console.error(errorMessage);
                    }
                },
            });
        },
    };

    const contact = {
        'init': function () {
            this.options_form();
        },
        'options_form': function () {
            let that  = this,
                $form = $(`#${KEY}_contact_form`);

            $form.on('submit', function (e) {
                e.preventDefault();
                let $this    = $(e.currentTarget),
                    formData = $this.serializeObject();

                if (typeof ajaxRequests.contact !== 'undefined') {
                    ajaxRequests.contact.abort();
                }

                if (!$this.isValid()) {
                    e.stopPropagation();
                } else {
                    $this.addClass('was-validated');
                    that.ajax(formData, $this);
                }

            });
        },

        'ajax': (formData, $el) => {
            ajaxRequests.contact = $.ajax({
                url: nhGlobals.ajaxUrl,
                type: 'POST',
                data: {
                    action: `${KEY}_contact_ajax`,
                    data: formData,
                },
                beforeSend: function () {
                    $el.trigger('nhConfig.updating', [formData]);
                },
                success: function (res) {
                    if (res.success) {
                        $el.trigger('nhConfig.updated:success', [res]);
                    } else {
                        $el.trigger('nhConfig.updated:failed', [res]);
                    }
                    $el.trigger('nhConfig.updated', [res]);
                },
                error: function (xhr) {
                    let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                    if (xhr.statusText !== 'abort') {
                        console.error(errorMessage);
                    }
                },
            });
        },
    };

    const exportForm = {
        'init': function () {
            this.options_form();
        },

        'options_form': function () {
            let that  = this,
                $form = $(`#${KEY}_export_form`);

            $form.on('submit', function (e) {
                e.preventDefault();
                let $this    = $(e.currentTarget),
                    formData = $this.serializeObject();

                if (typeof ajaxRequests.api_ids !== 'undefined') {
                    ajaxRequests.api_ids.abort();
                }

                if (!$this.isValid()) {
                    e.stopPropagation();
                } else {
                    $this.addClass('was-validated');
                    that.ajax(formData, $this);
                }

            });
        },

        'ajax': (formData, $el) => {
            ajaxRequests.stock = $.ajax({
                url: nhGlobals.ajaxUrl,
                type: 'POST',
                data: {
                    action: `${KEY}_export_ajax`,
                    data: formData,
                },
                beforeSend: function () {
                    $el.trigger('nhConfig.updating', [formData]);
                },
                success: function (res) {
                    if (res.success) {
                        $el.trigger('nhConfig.updated:success', [res]);

                        /*
                         * Make CSV downloadable
                         */
                        let downloadLink  = document.createElement('a');
                        downloadLink.href = res.file;

                        /*
                         * Actually download CSV
                         */
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);


                    } else {
                        $el.trigger('nhConfig.updated:failed', [res]);
                    }
                    $el.trigger('nhConfig.updated', [res]);
                    $el.find('[type="submit"]').html(nhGlobals.export_text);
                },
                error: function (xhr) {
                    let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                    if (xhr.statusText !== 'abort') {
                        console.error(errorMessage);
                    }
                },
            });
        },
    };

    const importForm = {
        'init': function () {
            this.options_form();
        },

        'options_form': function () {
            let that  = this,
                $form = $(`#${KEY}_import_form`);

            $form.on('submit', function (e) {
                e.preventDefault();


                let $this          = $(e.currentTarget),
                    serializedData = $this.serializeObject(),
                    file_data      = $(`[name='${KEY}_csv_file']`).prop('files')[0],
                    formData       = new FormData();

                formData.append('file', file_data);
                formData.append('action', `${KEY}_import_ajax`);
                formData.append('batches', serializedData[`${KEY}_batches`]);

                if (typeof ajaxRequests.import !== 'undefined') {
                    ajaxRequests.import.abort();
                }

                if (!$this.isValid()) {
                    e.stopPropagation();
                } else {
                    if (confirm('Are you confirming that you read and understood the warning message? Please confirm before proceeding.')) {
                        $this.addClass('was-validated');
                        that.ajax(formData, $this);
                    }
                }

            });
        },

        'ajax': function (formData, $el) {
            let that = this;

            ajaxRequests.import = $.ajax({
                url: nhGlobals.ajaxUrl,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function () {
                    $el.trigger('nhConfig.updating-progress', [formData]);
                },
                success: function (res) {
                    if (res.success) {
                        if (res.repeat) {
                            let percentage     = ((res.repeat_data.next + 1) * 100) / (res.repeat_data.batches_count + 1),
                                htmlPercentage = Math.ceil(percentage) < 0 ? 0 : Math.ceil(percentage);
                            $('.nh-importing-process .progress-bar').css('width', `${percentage}%`).html(`${htmlPercentage}%`)
                                                                    .attr('aria-valuenow', percentage);

                            that.ajax_repeat(res.repeat_data, $el);
                        } else {
                            $('.nh-importing-process .progress-bar').css('width', `100%`).html(`100%`);
                            setTimeout(function () {
                                $('.nh-importing-process').fadeOut(1000, function () {
                                    $(this).remove();
                                });
                            }, 500);

                            $el.trigger('nhConfig.updated:success', [res]);
                            $el.trigger('nhConfig.updated', [res]);
                        }

                    } else {
                        $('.nh-importing-process .progress-bar').css('width', `100%`).html(`100%`).addClass('bg-danger');
                        setTimeout(function () {
                            $('.nh-importing-process').fadeOut(1000, function () {
                                $(this).remove();
                            });
                        }, 1000);
                        $el.trigger('nhConfig.updated:failed', [res]); // Info
                        $el.trigger('nhConfig.updated', [res]); // Toast
                    }

                    $el.find('[type="submit"]').html(nhGlobals.import_text);
                },
                error: function (xhr) {
                    let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                    if (xhr.statusText !== 'abort') {
                        console.error(errorMessage);
                    }
                },
            });
        },

        'ajax_repeat': function (formData, $el) {
            let that = this;

            ajaxRequests.import_repeat = $.ajax({
                url: nhGlobals.ajaxUrl,
                type: 'POST',
                data: {
                    action: `${KEY}_import_repeat_ajax`,
                    data: formData,
                },
                beforeSend: function () {
                    // $el.trigger('nhConfig.updating', [formData]);
                },
                success: function (res) {
                    if (res.success) {
                        if (res.repeat) {
                            let percentage     = ((res.repeat_data.next + 1) * 100) / (res.repeat_data.batches_count + 1),
                                htmlPercentage = Math.ceil(percentage) < 0 ? 0 : Math.ceil(percentage);
                            $('.nh-importing-process .progress-bar').css('width', `${percentage}%`).html(`${htmlPercentage}%`)
                                                                    .attr('aria-valuenow', percentage);

                            that.ajax_repeat(res.repeat_data, $el);
                        } else {
                            $('.nh-importing-process .progress-bar').css('width', `100%`).html(`100%`);
                            setTimeout(function () {
                                $('.nh-importing-process').fadeOut(1000, function () {
                                    $(this).remove();
                                });
                            }, 500);
                            $el.trigger('nhConfig.updated:success', [res]);
                            $el.trigger('nhConfig.updated', [res]);
                        }
                    } else {
                        $('.nh-importing-process .progress-bar').css('width', `100%`).html(`100%`).addClass('bg-danger');
                        setTimeout(function () {
                            $('.nh-importing-process').fadeOut(1000, function () {
                                $(this).remove();
                            });
                        }, 1000);
                        $el.trigger('nhConfig.updated:failed', [res]);
                        $el.trigger('nhConfig.updated', [res]);
                    }

                    $el.find('[type="submit"]').html(nhGlobals.import_text);
                },
                error: function (xhr) {
                    let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                    if (xhr.statusText !== 'abort') {
                        console.error(errorMessage);
                    }
                },
            });
        },
    };

    $(function () {
        main.init();
        tinymce.init({
            selector: 'textarea',
        });
    });

})(jQuery, nhGlobals, tinymce);
