<?php
/**
 * @package        JoomProject
 * @copyright      2013-2019 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

extract($displayData);

JHtml::_('stylesheet', 'com_joomtestimonials/Chart.min.css');
JHtml::_('script', 'com_joomtestimonials/moment.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'com_joomtestimonials/Chart.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'com_joomtestimonials/Chart.utils.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'com_joomtestimonials/Chart.bundle.min.js', array('version' => 'auto', 'relative' => true));

?>
<canvas id="chart_recent_items"></canvas>
<script>
    var daysRange = numberRange(-29, 1);
    var timeFormat = 'MM/DD';
    var color = Chart.helpers.color;
    var config = {
        type: 'line',
        data: {
            labels: daysRange,
            datasets: [
				<?php foreach($recent as $line): ?>
                {
                    label: '<?php echo $line['title'] ?>',
                    backgroundColor: color(window.chartColors.<?php echo $line['color']?>).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.<?php echo $line['color']?>,
                    fill: false,
                    data: [
						<?php echo implode(',', $line['data']) ?>
                    ]
                },
				<?php endforeach; ?>

            ]
        },
        options: {

            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: timeFormat,
                        // round: 'day'
                        tooltipFormat: 'll'
                    },
                    scaleLabel: {
                        display: true,
                        labelString: '<?php echo JText::_('COM_JOOMTESTIMONIALS_GRAPH_DATE'); ?>'
                    }
                }],
                yAxes: [
                    {
                    ticks: {
                        suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                        beginAtZero: true,   // minimum value will be 0.
                        stepSize: 1,

                    },
                    scaleLabel: {
                        display: true,
                        labelString: '<?php echo JText::_('COM_JOOMTESTIMONIALS_GRAPH_SUBMISSION'); ?>'
                    }
                }]
            },
        }
    };

    window.onload = function () {
        var ctx = document.getElementById('chart_recent_items').getContext('2d');
        window.myLine = new Chart(ctx, config);

    };

</script>


