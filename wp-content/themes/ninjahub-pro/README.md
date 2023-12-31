NH -
===============================================

`ninjaHub-Theme` is a theme based on starter theme called 'underscores', Requires PHP version 8.1+

Theme Structure
---------------

```bash
└─── nh
    │   404.php
│   archive.php
│   comments.php
│   footer.php
│   functions.php
│   gulpfile.babel.js
│   header.php
│   index.php
│   LICENSE
│   package-lock.json
│   package.json
│   page.php
│   README.md
│   screenshot-.png
│   screenshot.png
│   search.php
│   sidebar.php
│   single.php
│   style-rtl.css
│   style-rtl.min.css
│   style-rtl.min.css.map
│   style.css
│   style.min.css
│   style.min.css.map
│
├───app
│   ├───Classes
│   │       class-nh_cron.php
│   │       class-nh_init.php
│   │       class-nh_module.php
│   │       class-nh_post.php
│   │       class-nh_user.php
│   │
│   ├───helpers
│   │       class-nh_ajax_response.php
│   │       class-nh_bootstrap_navwalker.php
│   │       class-nh_cryptor.php
│   │       class-nh_forms.php
│   │       class-nh_hooks.php
│   │       class-nh_mail.php
│   │
│   ├───Models
│   │   ├───admin
│   │   │   │   class-nh_admin.php
│   │   │   │
│   │   │   ├───assets
│   │   │   │   ├───images
│   │   │   │   │       screenshot.png
│   │   │   │   │
│   │   │   │   ├───js
│   │   │   │   │   │   main.js
│   │   │   │   │   │   opportunity-front.js
│   │   │   │   │   │
│   │   │   │   │   ├───helpers
│   │   │   │   │   │       Validator.js
│   │   │   │   │   │
│   │   │   │   │   ├───inc
│   │   │   │   │   │       Functions.js
│   │   │   │   │   │       UiCtrl.js
│   │   │   │   │   │
│   │   │   │   │   └───modules
│   │   │   │   │           Nh.js
│   │   │   │   │           Opportunity.js
│   │   │   │   │
│   │   │   │   └───sass
│   │   │   │           style.scss
│   │   │   │
│   │   │   ├───css
│   │   │   │       style-rtl.css
│   │   │   │       style-rtl.min.css
│   │   │   │       style-rtl.min.css.map
│   │   │   │       style.css
│   │   │   │       style.min.css
│   │   │   │       style.min.css.map
│   │   │   │
│   │   │   ├───img
│   │   │   │       screenshot.webp
│   │   │   │
│   │   │   ├───js
│   │   │   │       main.js
│   │   │   │       main.min.js
│   │   │   │       main.min.js.map
│   │   │   │       opportunity-front.js
│   │   │   │       opportunity-front.min.js
│   │   │   │       opportunity-front.min.js.map
│   │   │   │       opportunity-gutenburg.js
│   │   │   │       opportunity-gutenburg.min.js
│   │   │   │       opportunity-gutenburg.min.js.map
│   │   │   │
│   │   │   ├───modules
│   │   │   │       class-nh_opportunity_admin.php
│   │   │   │       class-nh_profile_admin.php
│   │   │   │
│   │   │   └───vendors
│   │   │       ├───css
│   │   │       │   └───bootstrap5
│   │   │       │           bootstrap.css
│   │   │       │           bootstrap.css.map
│   │   │       │           bootstrap.min.css
│   │   │       │           bootstrap.min.css.map
│   │   │       │           bootstrap.rtl.css
│   │   │       │           bootstrap.rtl.css.map
│   │   │       │           bootstrap.rtl.min.css
│   │   │       │           bootstrap.rtl.min.css.map
│   │   │       │
│   │   │       └───js
│   │   │           └───bootstrap5
│   │   │                   bootstrap.js
│   │   │                   bootstrap.js.map
│   │   │                   bootstrap.min.js
│   │   │                   bootstrap.min.js.map
│   │   │
│   │   └───public
│   │       │   class-nh_public.php
│   │       │
│   │       ├───assets
│   │       │   ├───fonts
│   │       │   ├───gifs
│   │       │   ├───images
│   │       │   ├───js
│   │       │   │   │   acquisition-front.js
│   │       │   │   │   appointment-front.js
│   │       │   │   │   authentication.js
│   │       │   │   │   bidding-front.js
│   │       │   │   │   blog-front.js
│   │       │   │   │   investment-front.js
│   │       │   │   │   landing-main.js
│   │       │   │   │   main.js
│   │       │   │   │   notification-front.js
│   │       │   │   │   opportunity-front.js
│   │       │   │   │   search-front.js
│   │       │   │   │   service-front.js
│   │       │   │   │
│   │       │   │   ├───helpers
│   │       │   │   │       Validator.js
│   │       │   │   │
│   │       │   │   ├───inc
│   │       │   │   │       Functions.js
│   │       │   │   │       UiCtrl.js
│   │       │   │   │
│   │       │   │   └───modules
│   │       │   │           Acquisition.js
│   │       │   │           Appointment.js
│   │       │   │           Auth.js
│   │       │   │           Bidding.js
│   │       │   │           Blog.js
│   │       │   │           Investment.js
│   │       │   │           Nh.js
│   │       │   │           Notification.js
│   │       │   │           Opportunity.js
│   │       │   │           Search.js
│   │       │   │           Service.js
│   │       │   │
│   │       │   └───sass
│   │       │       │   theme.scss
│   │       │       │
│   │       │       ├───base
│   │       │       │   │   _animations.scss
│   │       │       │   │   _badges.scss
│   │       │       │   │   _buttons.scss
│   │       │       │   │   _colors.scss
│   │       │       │   │   _forms.scss
│   │       │       │   │   _mixins.scss
│   │       │       │   │   _spacing.scss
│   │       │       │   │   _typography.scss
│   │       │       │   │   _variables.scss
│   │       │       │   │
│   │       │       │   ├───elements
│   │       │       │   │       __bs-accordion.scss
│   │       │       │   │
│   │       │       │   └───forms
│   │       │       │           _fields.scss
│   │       │       │           _forgot_password.scss
│   │       │       │           _login.scss
│   │       │       │           _registration.scss
│   │       │       │           _verify_email.scss
│   │       │       │
│   │       │       ├───components
│   │       │       │   │   footer.scss
│   │       │       │   │   _components.scss
│   │       │       │   │
│   │       │       │   ├───cards
│   │       │       │   │       _card.scss
│   │       │       │   │       _faq-help-card.scss
│   │       │       │   │       _my-opportunities-card.scss
│   │       │       │   │
│   │       │       │   ├───header
│   │       │       │   │       header-dashboard.scss
│   │       │       │   │       _header-dashboard-global.scss
│   │       │       │   │
│   │       │       │   ├───industries
│   │       │       │   │       _industries.scss
│   │       │       │   │
│   │       │       │   ├───loader
│   │       │       │   │       _loader.scss
│   │       │       │   │
│   │       │       │   ├───modals
│   │       │       │   │       _modals.scss
│   │       │       │   │
│   │       │       │   ├───notifications
│   │       │       │   │       _notifications.scss
│   │       │       │   │
│   │       │       │   ├───registration
│   │       │       │   │       _registration.scss
│   │       │       │   │
│   │       │       │   └───search
│   │       │       │           _search.scss
│   │       │       │
│   │       │       ├───notices
│   │       │       │       notices.scss
│   │       │       │       _forms.scss
│   │       │       │       _global.scss
│   │       │       │
│   │       │       └───pages
│   │       │           ├───dashboard
│   │       │           │   │   archive-faq.scss
│   │       │           │   │   blogs.scss
│   │       │           │   │   faq-taxonomy.scss
│   │       │           │   │   home-dashboard.scss
│   │       │           │   │   my-account.scss
│   │       │           │   │   my-notifications.scss
│   │       │           │   │   my-opportunities.scss
│   │       │           │   │   single-faq.scss
│   │       │           │   │   single-opportunity.scss
│   │       │           │   │
│   │       │           │   └───submenus
│   │       │           │           submenus.scss
│   │       │           │           _main-nav.scss
│   │       │           │           _sub-nav.scss
│   │       │           │
│   │       │           └───landing
│   │       │                   about.scss
│   │       │                   contact-us.scss
│   │       │                   forgot-password.scss
│   │       │                   home.scss
│   │       │                   industry.scss
│   │       │                   login.scss
│   │       │                   register.scss
│   │       │                   service.scss
│   │       │                   services.scss
│   │       │                   user-type.scss
│   │       │                   verification.scss
│   │       │                   _landing-theme.scss
│   │       │
│   │       ├───css
│   │       │   │   theme.css
│   │       │   │   theme.min.css
│   │       │   │   theme.min.css.map
│   │       │   │
│   │       │   ├───components
│   │       │   │   │   footer.css
│   │       │   │   │   footer.min.css
│   │       │   │   │   footer.min.css.map
│   │       │   │   │
│   │       │   │   └───header
│   │       │   │           header-dashboard.css
│   │       │   │           header-dashboard.min.css
│   │       │   │           header-dashboard.min.css.map
│   │       │   │
│   │       │   ├───notices
│   │       │   │       notices.css
│   │       │   │       notices.min.css
│   │       │   │       notices.min.css.map
│   │       │   │
│   │       │   └───pages
│   │       │       ├───dashboard
│   │       │       │   │   archive-faq.css
│   │       │       │   │   archive-faq.min.css
│   │       │       │   │   archive-faq.min.css.map
│   │       │       │   │   blogs.css
│   │       │       │   │   blogs.min.css
│   │       │       │   │   blogs.min.css.map
│   │       │       │   │   faq-taxonomy.css
│   │       │       │   │   faq-taxonomy.min.css
│   │       │       │   │   faq-taxonomy.min.css.map
│   │       │       │   │   home-dashboard.css
│   │       │       │   │   home-dashboard.min.css
│   │       │       │   │   home-dashboard.min.css.map
│   │       │       │   │   home.css
│   │       │       │   │   home.min.css
│   │       │       │   │   home.min.css.map
│   │       │       │   │   my-account.css
│   │       │       │   │   my-account.min.css
│   │       │       │   │   my-account.min.css.map
│   │       │       │   │   my-notifications.css
│   │       │       │   │   my-notifications.min.css
│   │       │       │   │   my-notifications.min.css.map
│   │       │       │   │   my-opportunities.css
│   │       │       │   │   my-opportunities.min.css
│   │       │       │   │   my-opportunities.min.css.map
│   │       │       │   │   single-faq.css
│   │       │       │   │   single-faq.min.css
│   │       │       │   │   single-faq.min.css.map
│   │       │       │   │   single-opportunity.css
│   │       │       │   │   single-opportunity.min.css
│   │       │       │   │   single-opportunity.min.css.map
│   │       │       │   │
│   │       │       │   └───submenus
│   │       │       │           submenus.css
│   │       │       │           submenus.min.css
│   │       │       │           submenus.min.css.map
│   │       │       │
│   │       │       └───landing
│   │       │               about.css
│   │       │               about.min.css
│   │       │               about.min.css.map
│   │       │               contact-us.css
│   │       │               contact-us.min.css
│   │       │               contact-us.min.css.map
│   │       │               forgot-password.css
│   │       │               forgot-password.min.css
│   │       │               forgot-password.min.css.map
│   │       │               home.css
│   │       │               home.min.css
│   │       │               home.min.css.map
│   │       │               industry.css
│   │       │               industry.min.css
│   │       │               industry.min.css.map
│   │       │               login.css
│   │       │               login.min.css
│   │       │               login.min.css.map
│   │       │               register.css
│   │       │               register.min.css
│   │       │               register.min.css.map
│   │       │               service.css
│   │       │               service.min.css
│   │       │               service.min.css.map
│   │       │               services.css
│   │       │               services.min.css
│   │       │               services.min.css.map
│   │       │               user-type.css
│   │       │               user-type.min.css
│   │       │               user-type.min.css.map
│   │       │               verification.css
│   │       │               verification.min.css
│   │       │               verification.min.css.map
│   │       │
│   │       ├───img
│   │       ├───js
│   │       │       acquisition-front.js
│   │       │       acquisition-front.min.js
│   │       │       acquisition-front.min.js.map
│   │       │       appointment-front.js
│   │       │       appointment-front.min.js
│   │       │       appointment-front.min.js.map
│   │       │       authentication.js
│   │       │       authentication.min.js
│   │       │       authentication.min.js.map
│   │       │       bidding-front.js
│   │       │       bidding-front.min.js
│   │       │       bidding-front.min.js.map
│   │       │       blog-front.js
│   │       │       blog-front.min.js
│   │       │       blog-front.min.js.map
│   │       │       investment-front.js
│   │       │       investment-front.min.js
│   │       │       investment-front.min.js.map
│   │       │       landing-main.js
│   │       │       landing-main.min.js
│   │       │       landing-main.min.js.map
│   │       │       main.js
│   │       │       main.min.js
│   │       │       main.min.js.map
│   │       │       notification-front.js
│   │       │       notification-front.min.js
│   │       │       notification-front.min.js.map
│   │       │       opportunity-front.js
│   │       │       opportunity-front.min.js
│   │       │       opportunity-front.min.js.map
│   │       │       search-ajax.js
│   │       │       search-ajax.min.js
│   │       │       search-ajax.min.js.map
│   │       │       search-front.js
│   │       │       search-front.min.js
│   │       │       search-front.min.js.map
│   │       │       service-front.js
│   │       │       service-front.min.js
│   │       │       service-front.min.js.map
│   │       │
│   │       ├───modules
│   │       │       class-nh_appointment.php
│   │       │       class-nh_auth.php
│   │       │       class-nh_blog.php
│   │       │       class-nh_faq.php
│   │       │       class-nh_notification.php
│   │       │       class-nh_opportunity.php
│   │       │       class-nh_opportunity_acquisition.php
│   │       │       class-nh_opportunity_bid.php
│   │       │       class-nh_opportunity_investments.php
│   │       │       class-nh_profile.php
│   │       │       class-nh_profile_widget.php
│   │       │       class-nh_search.php
│   │       │       class-nh_service.php
│   │       │
│   │       ├───vendors
│   │       │   ├───css
│   │       │   │   ├───bbc-icons
│   │       │   │   │   │   demo.html
│   │       │   │   │   │   Read Me.txt
│   │       │   │   │   │   selection.json
│   │       │   │   │   │   style.css
│   │       │   │   │   │   style.scss
│   │       │   │   │   │   variables.scss
│   │       │   │   │   │
│   │       │   │   │   ├───demo-files
│   │       │   │   │   │       demo.css
│   │       │   │   │   │       demo.js
│   │       │   │   │   │
│   │       │   │   │   └───fonts
│   │       │   │   │           B2BCapitalIcons.eot
│   │       │   │   │           B2BCapitalIcons.svg
│   │       │   │   │           B2BCapitalIcons.ttf
│   │       │   │   │           B2BCapitalIcons.woff
│   │       │   │   │
│   │       │   │   ├───bootstrap5
│   │       │   │   │       bootstrap.css
│   │       │   │   │       bootstrap.css.map
│   │       │   │   │       bootstrap.min.css
│   │       │   │   │       bootstrap.min.css.map
│   │       │   │   │       bootstrap.rtl.css
│   │       │   │   │       bootstrap.rtl.css.map
│   │       │   │   │       bootstrap.rtl.min.css
│   │       │   │   │       bootstrap.rtl.min.css.map
│   │       │   │   │
│   │       │   │   ├───fontawesome
│   │       │   │   │
│   │       │   │   ├───intl-tel-input-18.1.6
│   │       │   │   │   ├───css
│   │       │   │   │   │       demo.css
│   │       │   │   │   │       intlTelInput.css
│   │       │   │   │   │       intlTelInput.min.css
│   │       │   │   │   │
│   │       │   │   │   └───img
│   │       │   │   │           flags.png
│   │       │   │   │           flags@2x.png
│   │       │   │   │
│   │       │   │   └───lottiefiles
│   │       │   │       │   animation_404.lottie
│   │       │   │       │   animation_lkowpjb8.json
│   │       │   │       │   copy.json
│   │       │   │       │   diit-ctg-icon.json
│   │       │   │       │   done-animation.json
│   │       │   │       │   done.json
│   │       │   │       │   handshake-agreement.lottie
│   │       │   │       │   hexagon2-1.json
│   │       │   │       │   impossible-hexagon.json
│   │       │   │       │   line-animation.json
│   │       │   │       │   loading-animation-blue.json
│   │       │   │       │   loading-animation.json
│   │       │   │       │   loading-line.json
│   │       │   │       │   money-investment.json
│   │       │   │       │   money-investment.lottie
│   │       │   │       │   scroll-down-arrow-white.json
│   │       │   │       │   scroll-down-arrows-white.json
│   │       │   │       │   show-and-hide.json
│   │       │   │       │   user.json
│   │       │   │       │   verifyed-verified-sign.json
│   │       │   │       │   wave-2.json
│   │       │   │       │   wick-line.json
│   │       │   │       │
│   │       │   │       └───arrow-right-white.lottie
│   │       │   │           │   manifest.json
│   │       │   │           │
│   │       │   │           └───animations
│   │       │   │                   12345.json
│   │       │   │
│   │       │   └───js
│   │       │       │   popper.min.js
│   │       │       │
│   │       │       ├───bootstrap5
│   │       │       │       bootstrap.js
│   │       │       │       bootstrap.js.map
│   │       │       │       bootstrap.min.js
│   │       │       │       bootstrap.min.js.map
│   │       │       │
│   │       │       └───fontawesome
│   │       │               all.min.js
│   │       │
│   │       └───video
│   │               index.php
│   │               investor.mp4
│   │               owner.mp4
│   │
│   └───Views
│       │   archive-faq.php
│       │   archive-service.php
│       │   archive.php
│       │   blogs.php
│       │   none-search.php
│       │   none-service.php
│       │   none.php
│       │   page.php
│       │   search-ajax.php
│       │   search.php
│       │   single-faq.php
│       │   single-opportunity.php
│       │   single-post.php
│       │   single-service.php
│       │   single-taxonomy-faq-category.php
│       │   single-taxonomy-service-category.php
│       │   single-taxonomy.php
│       │   single.php
│       │
│       ├───blogs
│       │       blogs-empty.php
│       │       blogs-item.php
│       │       blogs-list.php
│       │
│       ├───email-template
│       │   ├───account-authentication
│       │   │       body.php
│       │   │
│       │   ├───account-verification
│       │   │       body.php
│       │   │
│       │   ├───default
│       │   │       body.php
│       │   │       footer.php
│       │   │       header.php
│       │   │
│       │   ├───forgot-password
│       │   │       body.php
│       │   │
│       │   ├───opportunity-acquisition
│       │   │       body.php
│       │   │
│       │   ├───opportunity-approve
│       │   │       body.php
│       │   │
│       │   ├───opportunity-bidding
│       │   │       body.php
│       │   │
│       │   ├───opportunity-cancel
│       │   │       body.php
│       │   │
│       │   ├───opportunity-content-verified
│       │   │       body.php
│       │   │
│       │   ├───opportunity-hold
│       │   │       body.php
│       │   │
│       │   ├───opportunity-investment
│       │   │       body.php
│       │   │
│       │   ├───opportunity-new
│       │   │       body.php
│       │   │
│       │   ├───opportunity-published
│       │   │       body.php
│       │   │
│       │   ├───opportunity-seo-verified
│       │   │       body.php
│       │   │
│       │   └───opportunity-translated
│       │           body.php
│       │
│       ├───footers
│       │       dashboard.php
│       │       default.php
│       │       my-account.php
│       │
│       ├───headers
│       │       dashboard.php
│       │       default.php
│       │       landing.php
│       │       my-account.php
│       │
│       ├───js-templates
│       │   │   horizontal-scroll.php
│       │   │
│       │   └───modals
│       │           auth-verif.php
│       │           default.php
│       │           opportunity-response.php
│       │
│       ├───opportunities
│       │       opportunities-empty.php
│       │       opportunities-list.php
│       │       opportunity-item.php
│       │
│       └───template-parts
│           │   login-slider-part.php
│           │   opportunities-ajax.php
│           │   related-opportunities-slider.php
│           │   useful-links.php
│           │
│           ├───cards
│           │       faq-help-card.php
│           │       my-opportunities-card.php
│           │       opportunity-card-horizontal.php
│           │       opportunity-card-vertical.php
│           │
│           ├───dashboard-submenus
│           │       articles-sub-nav.php
│           │       main-nav.php
│           │       myaccount-sub-nav.php
│           │       opportunities-sub-nav.php
│           │
│           └───notifications
│                   notification-ajax.php
│                   notification-empty.php
│                   notification-list-ajax.php
│                   notification.php
│
├───inc
│       custom-functions.php
│       template-tags.php
│       tgm-plugin-activation.php
│
├───languages
│       ninja.pot
│
└───templates
        template-page-about.php
        template-page-authentication.php
        template-page-change-password.php
        template-page-choose-type.php
        template-page-contact-us.php
        template-page-create-opportunity-step2.php
        template-page-create-opportunity.php
        template-page-dashboard.php
        template-page-forgot-password.php
        template-page-home.php
        template-page-industry.php
        template-page-investor.php
        template-page-login.php
        template-page-my-fav-articles.php
        template-page-my-fav-opportunities.php
        template-page-my-ignored-articles.php
        template-page-my-ignored-opportunities.php
        template-page-my-notifications.php
        template-page-my-opportunities.php
        template-page-my-widgets.php
        template-page-myaccount.php
        template-page-opportunity-provider.php
        template-page-registration.php
        template-page-reset-password.php
        template-page-verification.php
```

### Requirements

`nh` requires the following dependencies:

- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)

### Quick Start

### Setup

To start using all the tools that come with `NinjaHub-pro`  you need to install the necessary Node.js and Composer dependencies :

```sh
$ composer install
$ npm install
```

### Available CLI commands

`nh` comes packed with CLI commands tailored for WordPress theme development :

- `npm run start` : Start watching all files [SASS, JS, PHP] and compile them all.
- `npm run publicStyles` : Compile the sass files included in the public path.
- `npm run publicStylesRtl` : Convert the css files to rtl version.
- `npm run publicScripts` : Compile all scripts included in the public path.
- `npm run publicImages` : Minify all images included in the public path and convert them to webp extension.
- `npm run adminStyles` : Compile the sass files included in the admin path.
- `npm run adminStylesRtl` : Convert the css files to rtl version.
- `npm run adminScripts` : Compile all scripts included in the admin path.
- `npm run adminImages` : Minify all images included in the admin path and convert them to webp extension.
- `npm run translate` : Crawl the php files searching for strings added to _() function to be added to the .pot file to
  make it ready to be translated.
- `npm run all` : Compile all files [SASS, JS, PHP] for just one time - Production purpose.
- `npm run bundle` : generates a .zip archive for distribution, excluding development and system files.

Now you're ready.

Good luck!
