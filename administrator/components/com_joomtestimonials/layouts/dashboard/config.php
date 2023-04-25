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
		'icon' => 'fas fa-list',
		'title' => 'COM_JOOMTESTIMONIALS_LIST_CONFIG',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#list'
	],
	[
		'icon' => 'fas fa-eye',
		'title' => 'COM_JOOMTESTIMONIALS_TEMPLATE_CONFIG',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#template'
	],
	[
		'icon' => 'fas fa-magic',
		'title' => 'COM_JOOMTESTIMONIALS_ANIMATION_CONFIG',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#animation'
	],
	[
		'icon' => 'fas fa-cut',
		'title' => 'COM_JOOMTESTIMONIALS_TEXTLIMITER_CONFIG',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#textlimiter'
	],
	[
		'icon' => 'fas fa-list-alt',
		'title' => 'COM_JOOMTESTIMONIALS_FIELDS_CONFIG',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#fields'
	],
	[
		'icon' => 'fas fa-paper-plane',
		'title' => 'COM_JOOMTESTIMONIALS_SUBMISSION_CONFIG',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#edit'
	],
	[
		'icon' => 'fas fa-envelope',
		'title' => 'COM_JOOMTESTIMONIALS_EMAIL_CONFIG',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#email'
	],
	[
		'icon' => 'fas fa-lock',
		'title' => 'JCONFIG_PERMISSIONS_LABEL',
		'url' => 'index.php?option=com_config&view=component&component=com_joomtestimonials#permissions'
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
                        'url'   => $link['url']
                    ]
                ) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
