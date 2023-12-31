/**
 * Filename: ProfileWidgets.js
 * Description:
 * User: Ahmed Gamal
 * Date: 7/9/2022
 */

/* globals nhGlobals, KEY */
// import theme 3d party modules
import $        from 'jquery';
import NhUiCtrl from '../inc/UiCtrl';
import Nh       from './Nh';
import UiCtrl   from '../inc/UiCtrl';
import Chart    from 'chart.js/auto';

class NhProfileWidgets extends Nh
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }

    getForexData(formData, $el)
    {
        let that                       = this;
        // Creating an AJAX request for login
        this.ajaxRequests.getForexData = $.ajax({
            url: nhGlobals.ajaxUrl,
            type: 'POST',
            data: {
                action: `${KEY}_get_forex_data_ajax`,
                data: formData,
            },
            beforeSend: function () {
                $el.container.parent().find('input, button').prop('disabled', true);
                UiCtrl.beforeSendPrepare($el.container.parent());
            },
            success: function (res) {
                $('input').prop('disabled', false);

                if (res.success) {
                    that.createChart(res.data.data, res.data.id);
                } else {
                    UiCtrl.notices($el.container.parent(), res.msg);
                }

                $el.container.parent().find('input, button').prop('disabled', false);
                UiCtrl.blockUI($el.container.parent(), false);
            },
            error: function (xhr) {
                let errorMessage = `${xhr.status}: ${xhr.statusText}`;
                if (xhr.statusText !== 'abort') {
                    console.error(errorMessage);
                }
            },
        });
    }

    createChart(data, id)
    {

        const config = {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'USD to EGP Exchange Rate',
                        backgroundColor: '#7bdcb5',
                        borderColor: '#79ca97',
                        data: data.values,
                        fill: true,
                        tension: 0.4
                    },
                ],
            }, options: {
                scales: {
                    x: {
                        grid: {
                            display: false // Hides the grid lines for the x-axis
                        }
                    },
                    y: {
                        grid: {
                            display: false // Hides the grid lines for the y-axis
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        // More legend options
                    }
                },
            },
        };

        // Assuming there is a <canvas> element in your HTML with the id 'myChart'
        const myChart = new Chart($(`canvas[data-id="${id}"]`)[0], config);
        $(`canvas[data-id="${id}"]`).parent().find('.from').html(data.from);
        $(`canvas[data-id="${id}"]`).parent().find('.to').html(data.to);
    }
}

export default NhProfileWidgets;
