/**
 * @Filename: main.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
// import '@dotlottie/player-component';

class NhMain
{
    constructor()
    {
        window.KEY    = nhGlobals.domain_key;
        window.ITIOBJ = {};
        this.initialization();
    }

    initialization()
    {
        this.onReady();
        this.onLoad();
    }

    onReady()
    {
        $(document).ready(function (e) {
            // IMPORTANT NOTICE
            if (nhGlobals.environment !== 'development') {
                console.log('%cStop!', 'color: red; font-size: 50px; -webkit-text-stroke: 2px black; font-weight: bold;');
                console.log('%cThis browser feature is intended for developers. If someone told you to copy-paste something here to enable a feature or "hack" someone\'s account, it is a scam and will give them access to your account and personal information.', 'font-size: 18px; font-weight:bold');
            }
        });
    }

    onLoad()
    {
        let that = this;

        $(window).on('load', function () {
            setInterval(function() {
                that.refreshToken()
            }, 60000);
        });

    }

    refreshToken()
    {
        if('undefined' !== typeof grecaptcha){
            grecaptcha.ready(function () {
                grecaptcha.execute(nhGlobals.publicKey).then(function (token) {
                    $('input[name=g-recaptcha-response]').each(function(i, obj) {
                        $(this).val(token)
                    });
                });
            });
        }
    }

}

new NhMain();
