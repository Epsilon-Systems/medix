<?php
/**
 * @package        JoomProject
 * @copyright      2013-2019 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$links = [
	[
		'icon' => 'fab fa-facebook',
		'title' => 'Facebook Page',
		'url' => 'https://www.facebook.com/joomboost'
	],
	[
		'icon' => 'fab fa-twitter',
		'title' => 'Twitter Page',
		'url' => 'https://twitter.com/joomboost'
	],
	[
		'icon' => 'fab fa-linkedin',
		'title' => 'LinkedIn Company',
		'url' => 'https://www.linkedin.com/company/joomboost'
	],
	[
		'icon' => 'fab fa-pinterest',
		'title' => 'Pinterest',
		'url' => 'https://www.pinterest.com/joomboost/'
	],
	[
		'icon' => 'fas fa-rss',
		'title' => 'RSS Feed',
		'url' => 'https://feeds.feedburner.com/joomboost-news'
	],
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
