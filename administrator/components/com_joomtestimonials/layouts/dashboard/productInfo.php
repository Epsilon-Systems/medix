<?php
/**
 * @package        JoomProject
 * @copyright      2013-2020 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$links = [
	[
		'icon' => 'fas fa-pager',
		'title' => 'COM_JOOMTESTIMONIALS_PRODUCT_PAGE',
		'url' => 'https://www.joomboost.com/joomla-components/2-joomtestimonials.html'
	],
	[
		'icon' => 'fas fa-book',
		'title' => 'COM_JOOMTESTIMONIALS_PRODUCT_DOCS',
		'url' => 'https://www.joomboost.com/support/documentation/28-joomtestimonials.html'
	],
	[
		'icon' => 'fas fa-sync-alt',
		'title' => 'COM_JOOMTESTIMONIALS_PRODUCT_CHANGELOG',
		'url' => 'https://www.joomboost.com/components-changelogs/9-joomtestimonials-changelog.html'
	],
	[
		'icon' => 'fas fa-comments',
		'title' => 'COM_JOOMTESTIMONIALS_PRODUCT_FORUM',
		'url' => 'https://www.joomboost.com/support/forums/categories/14-joomtestimonials.html'
	],
	[
		'icon' => 'fas fa-life-ring',
		'title' => 'COM_JOOMTESTIMONIALS_PRODUCT_TICKET',
		'url' => 'https://www.joomboost.com/support/submit-ticket.html'
	],
	[
		'icon' => 'fas fa-road',
		'title' => 'COM_JOOMTESTIMONIALS_PRODUCT_ROADMAP',
		'url' => 'https://trello.com/joomtestimonialsroadmap'
	],
	[
		'icon' => 'fas fa-language',
		'title' => 'COM_JOOMTESTIMONIALS_PRODUCT_TRANSLATE',
		'url' => 'https://translate.joomboost.com/'
	]
];

?>
<div class="form-row">
    <div class="container px-2">
        <div class="row">
            <?php foreach ($links as $link): ?>
                <?php echo JLayoutHelper::render(
                    'dashboard.skeleton.buttonLink',
                    [
                        'title' => $link['title'],
                        'icon'  => $link['icon'],
                        'url'   => $link['url'],
                        'target' => '_blank',
                    ]
                ) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
