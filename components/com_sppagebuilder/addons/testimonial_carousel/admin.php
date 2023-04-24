<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http: //www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http: //www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

SpAddonsConfig::addonConfig(
    [
        'type' => 'repeatable',
        'addon_name' => 'testimonial_carousel',
        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CAROUSEL'),
        'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CAROUSEL_DESC'),
        'category' => 'Slider',
        'icon' => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><circle opacity=".5" cx="10.5" cy="30.5" r="1.5" fill="currentColor"/><circle opacity=".5" cx="22.5" cy="30.5" r="1.5" fill="currentColor"/><circle cx="16.5" cy="30.5" r="1.5" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M22 2H10v21h12V2zM10 0a2 2 0 00-2 2v21a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H10z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M6 4a1 1 0 00-1-1H1a1 1 0 000 2h3v15H1a1 1 0 100 2h4a1 1 0 001-1V4zm20 17a1 1 0 001 1h4a1 1 0 100-2h-3V5h3a1 1 0 100-2h-4a.996.996 0 00-1 1v17z" fill="currentColor"/><path d="M13 7.496c0 .381.309.69.69.69h.779v.297c0 .527-.364.975-.858 1.097-.148.037-.273.157-.273.31v.848c0 .152.124.277.275.26a2.538 2.538 0 002.256-2.515V5.69a.69.69 0 00-.69-.69h-1.49a.69.69 0 00-.689.69v1.806zM16.6 7.496c0 .381.309.69.69.69h.779v.297c0 .527-.364.975-.858 1.097-.148.037-.273.157-.273.31v.848c0 .152.124.277.275.26a2.538 2.538 0 002.256-2.515V5.69a.69.69 0 00-.69-.69h-1.49a.69.69 0 00-.689.69v1.806z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M12 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1zM13 19a1 1 0 011-1h4a1 1 0 110 2h-4a1 1 0 01-1-1z" fill="currentColor"/></svg>',
        'inline' => [
            'buttons' => [
                'team_carousel_general_options' => [
                    'action' => 'dropdown',
                    'icon' => 'addon::testimonial_carousel',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CAROUSEL'),
                    'fieldset' => [
                        'tab_groups' => [
                            'carousel' => [
                                'fields' => [
                                    'items' => [
                                        'carousel_item_number' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_NUMBER'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_NUMBER_DESC'),
                                            'min' => 1,
                                            'max' => 15,
                                            'responsive' => true,
                                        ],

                                        'carousel_margin' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_MARGIN'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_MARGIN_DESC'),
                                            'std' => 15,
                                        ],

                                        'advanced_settings' => [
                                            'type' => 'advancedsettings',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ITEMS'),
                                            'buttonText' => Text::_('COM_SPPAGEBUILDER_ADDON_ITEM_ADD_EDIT'),
                                            'buttonIcon' => 'ul',
                                        ],
                                    ],

                                    'animation' => [
                                        'carousel_autoplay' => [
                                            'type' => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_AUTOPLAY'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_AUTOPLAY_DESC'),
                                            'std' => 0,
                                        ],

                                        'carousel_interval' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_INTERVAL'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CAROUSEL_INTERVAL_DESC'),
                                            'std' => 4500,
                                            'depends' => [['carousel_autoplay', '=', 1]],
                                        ],

                                        'carousel_speed' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SPEED'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SPEED_DESC'),
                                            'std' => 1500,
                                        ],

                                        'carousel_bullet' => [
                                            'type' => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_CONTROLLERS'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_CONTROLLERS_DESC'),
                                            'std' => 1,
                                        ],

                                        'carousel_arrow' => [
                                            'type' => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_ARROWS'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_ARROWS_DESC'),
                                            'std' => 1,
                                        ],
                                    ],
                                ],
                            ],

                            // 'quote' => [
                            //     'fields' => [
                            //         [

                            //         ],
                            //     ],
                            // ],

                            // 'ratings' => [
                            //     'fields' => [
                            //         [

                            //         ],
                            //     ],
                            // ],

                            'items' => [
                                'fields' => [
                                    'options' => [
                                        'label_content_options' => [
                                            'type' => 'header',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CONTENT'),
                                            'group' => [
                                                'content_padding',
                                                'content_border_radius',
                                            ],
                                            'depends' => [['testimonial_carousel_layout', '!=', 'testi_layout3']],
                                        ],

                                        'content_padding' => [
                                            'type' => 'padding',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                            'responsive' => true,
                                            'depends' => [['testimonial_carousel_layout', '!=', 'testi_layout3']],
                                        ],

                                        'content_border_radius' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                            'min' => 0,
                                            'max' => 300,
                                            'depends' => [['testimonial_carousel_layout', '!=', 'testi_layout3']],
                                        ],

                                        'label_message_options' => [
                                            'type' => 'header',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_MESSAGE'),
                                            'group' => [
                                                'message_margin_top',
                                                'message_margin_bottom',
                                                'message_padding',
                                                'message_border_radius',
                                            ],
                                        ],

                                        'message_margin_top' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_TOP'),
                                            'responsive' => true,
                                            'min' => 0,
                                            'max' => 300,
                                        ],

                                        'message_margin_bottom' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_BOTTOM'),
                                            'responsive' => true,
                                            'std' => ['xl' => 40],
                                            'min' => 0,
                                            'max' => 300,
                                        ],

                                        'message_padding' => [
                                            'type' => 'padding',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                            'placeholder' => '10',
                                            'responsive' => true,
                                            'std' => ['xxl' => '', 'xl' => '30px 30px 30px 30px', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
                                            'depends' => [['testimonial_carousel_layout', '=', 'testi_layout3']],
                                        ],

                                        'message_border_radius' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                            'min' => 0,
                                            'max' => 300,
                                            'depends' => [['testimonial_carousel_layout', '=', 'testi_layout3']],
                                        ],

                                        'name_margin' => [
                                            'type' => 'margin',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_NAME_MARGIN'),
                                            'responsive' => true,
                                            'std' => ['xxl' => '', 'xl' => '10px 0px 0px 0px', 'lg' => '', 'md' => '',  'sm' => '', 'xs' => ''],
                                        ],
                                    ],

                                    'avatar' => [
                                        'avatar_layout' => [
                                            'type' => 'thumbnail',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_AVATAR_STYLE'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_AVATAR_STYLE_DESC'),
                                            'columns' => 2,
                                            'values' => [
                                                'avatar_layout1' => ['svg' => '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 76"><path opacity="0.1" d="M0 0h146v76H0V0z" fill="currentColor"/><path d="M26.205 52.328c7.58 0 13.726-6.136 13.726-13.705 0-7.57-6.145-13.705-13.726-13.705-7.58 0-13.726 6.136-13.726 13.705s6.145 13.705 13.726 13.705z" fill="currentColor"/><path opacity="0.6" d="M93.086 29.902H49.17a3 3 0 00-3 3v1.475a3 3 0 003 3h43.915a3 3 0 003-3v-1.475a3 3 0 00-3-3z" fill="currentColor"/><path opacity="0.3" d="M132.021 43.607h-84.35a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h84.35a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5z" fill="currentColor"/></svg>'],
                                                'avatar_layout2' => ['svg' => '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 76"><path opacity="0.1" d="M0 0h146v76H0V0z" fill="currentColor"/><path d="M120.205 52.328c7.581 0 13.726-6.136 13.726-13.705 0-7.57-6.145-13.705-13.726-13.705-7.581 0-13.726 6.136-13.726 13.705s6.145 13.705 13.726 13.705z" fill="currentColor"/><path opacity="0.6" d="M96.394 29.918H52.479a3 3 0 00-3 3v1.475a3 3 0 003 3h43.915a3 3 0 003-3v-1.475a3 3 0 00-3-3z" fill="currentColor"/><path opacity="0.3" d="M98.329 43.918h-84.35a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h84.35a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5z" fill="currentColor"/></svg>'],
                                                'avatar_layout3' => ['svg' => '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 76"><path opacity="0.1" d="M0 0h146v76H0V0z" fill="currentColor"/><path d="M26.205 39.869c7.58 0 13.726-6.136 13.726-13.705 0-7.57-6.145-13.705-13.726-13.705-7.58 0-13.726 6.136-13.726 13.705s6.145 13.705 13.726 13.705z" fill="currentColor"/><path opacity="0.6" d="M59.394 46.098H15.479a3 3 0 00-3 3v1.475a3 3 0 003 3h43.915a3 3 0 003-3v-1.475a3 3 0 00-3-3z" fill="currentColor"/><path opacity="0.3" d="M98.329 59.803h-84.35a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h84.35a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5z" fill="currentColor"/></svg>'],
                                                'avatar_layout4' => ['svg' => '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 76"><path opacity="0.1" d="M0 0h146v76H0V0z" fill="currentColor"/><path d="M26.205 63.869c7.58 0 13.726-6.136 13.726-13.705 0-7.57-6.145-13.705-13.726-13.705-7.58 0-13.726 6.136-13.726 13.705s6.145 13.705 13.726 13.705z" fill="currentColor"/><path opacity="0.6" d="M59.394 13.098H15.479a3 3 0 00-3 3v1.475a3 3 0 003 3h43.915a3 3 0 003-3v-1.475a3 3 0 00-3-3z" fill="currentColor"/><path opacity="0.3" d="M98.329 26.459h-84.35a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h84.35a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5z" fill="currentColor"/></svg>'],
                                            ],
                                            'std' => 'avatar_layout3',
                                            'class' => 'builder-mb-0',
                                            'depends' => [['testimonial_carousel_layout', '!=', 'testi_layout3']],
                                        ],

                                        'avatar_height' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
                                            'std' => ['xl' => 60],
                                            'responsive' => true,
                                            'min' => 1,
                                            'max' => 200,
                                        ],

                                        'avatar_width' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
                                            'std' => ['xl' => 60],
                                            'responsive' => true,
                                            'min' => 1,
                                            'max' => 200,
                                        ],

                                        'avatar_border_radius' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS_DESC'),
                                            'std' => 100,
                                            'min' => 0,
                                            'max' => 1000,
                                        ],

                                        'avatar_gap' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                            'std' => ['xl' => 15],
                                            'min' => 0,
                                            'max' => 200,
                                            'responsive' => true,
                                            'depends' => [['testimonial_carousel_layout', '!=', 'testi_layout3']],
                                        ],
                                    ],

                                    'quote' => [
                                        'show_quote_icon' => [
                                            'type' => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_QUOTE'),
                                            'std' => 1,
                                        ],

                                        'quote_icon_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                                            'std' => '#dbdbdb',
                                            'depends' => [['show_quote_icon', '=', 1]],
                                        ],

                                        'quote_icon_size' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_SIZE'),
                                            'std' => ['xl' => 50],
                                            'min' => 10,
                                            'max' => 200,
                                            'responsive' => true,
                                            'depends' => [['show_quote_icon', '=', 1]],
                                        ],

                                        'quote_icon_gap' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                            'std' => ['xl' => 20],
                                            'min' => 0,
                                            'max' => 200,
                                            'responsive' => true,
                                            'depends' => [['show_quote_icon', '=', 1]],
                                        ],
                                    ],

                                    'ratings' => [
                                        'rating_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                                            'std' => '#ffb527',
                                        ],

                                        'rating_size' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_SIZE'),
                                            'std' => ['xl' => 18],
                                            'min' => 0,
                                            'max' => 200,
                                            'responsive' => true,
                                        ],

                                        'rating_gap' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                            'std' => ['xl' => 20],
                                            'min' => 0,
                                            'max' => 200,
                                            'responsive' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                'testimonial_add_new_item' => [
                    'action' => 'click',
                    'type' => 'plus',
                    'icon' => 'plusCircle',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ADD_NEW'),
                    'meta' => [
                        'key' => 'sp_testimonial_carousel_item',
                        'title' => "Testimonial Carousel Item",
                        'client_name' => 'Edward Morinho',
                        'client_desgination' => 'Full Stack Devloper',
                        'client_message' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                        'show_rating' => 1,
                        'client_rating' => 4.5,
                        'testimonial_carousel_img' => 'https://sppagebuilder.com/addons/testimonial_carousel/testimonial-person-1.png',
                    ]
                ],

                'testimonial_carousel_layout_options' => [
                    'action' => 'dropdown',
                    'icon' => 'layoutsDuo',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LAYOUTS'),
                    'fieldset' => [
                        [
                            'testimonial_carousel_layout' => [
                                'type' => 'thumbnail',
                                'columns' => 3,
                                'class' => 'builder-mb-n3',
                                'values' => [
                                    'testi_layout1' => ['svg' => '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 152"><path opacity="0.1" d="M0 0h146v152H0V0z" fill="currentColor"/><path opacity="0.4" d="M125.782 52.328H20.218a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h105.564a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5zM125.782 62.295H20.218a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h105.564a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5zM95.833 72.262H20.218a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h75.615a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5z" fill="currentColor"/><path d="M29.949 132.065c6.202 0 11.23-5.021 11.23-11.213 0-6.193-5.028-11.213-11.23-11.213-6.203 0-11.231 5.02-11.231 11.213 0 6.192 5.028 11.213 11.23 11.213z" fill="currentColor"/><path opacity="0.6" d="M78.11 114.623H50.42a3 3 0 00-3 3v.23a3 3 0 003 3H78.11a3 3 0 003-3v-.23a3 3 0 00-3-3z" fill="currentColor"/><path opacity="0.3" d="M96.088 124.59H48.665a1.246 1.246 0 000 2.492h47.423a1.246 1.246 0 000-2.492z" fill="currentColor"/><path opacity="0.15" d="M27.209 39.87h-5.491a3 3 0 01-3-3v-5.695c0-3.201.678-5.729 2.034-7.58 1.356-1.851 3.68-3.486 6.974-4.905l2.483 4.62c-2.025.934-3.425 1.864-4.2 2.79-.775.925-1.206 2.02-1.294 3.282h2.494a3 3 0 013 3v4.486a3 3 0 01-3 3v.002zm13.259 0h-5.491a3 3 0 01-3-3v-5.695c0-3.201.678-5.729 2.034-7.58 1.356-1.851 3.68-3.486 6.974-4.905l2.483 4.62c-2.025.934-3.425 1.864-4.2 2.79-.775.925-1.206 2.02-1.294 3.282h2.494a3 3 0 013 3v4.486a3 3 0 01-3 3v.002z" fill="currentColor"/><path d="M27.988 92.237c0 .1-.072.195-.145.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zm12.478 0c0 .1-.072.195-.145.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zm12.48 0c0 .1-.073.195-.146.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zm12.478 0c0 .1-.072.195-.145.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zM74.967 94.222l1.705-1.652-2.35-.346-1.054-2.125-1.053 2.125-2.35.346 1.704 1.652-.407 2.342 2.106-1.107 2.1 1.107-.4-2.342zm2.936-1.986c0 .1-.072.194-.145.266l-2.022 1.97.48 2.78.005.111c0 .15-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.781-2.029-1.97c-.067-.072-.139-.166-.139-.266 0-.168.173-.235.312-.257l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.257z" fill="currentColor"/></svg>'],
                                    'testi_layout2' => ['svg' => '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 152"><path opacity="0.1" d="M0 0h146v152H0V0z" fill="currentColor"/><path opacity="0.4" d="M125.782 72.262H20.218a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h105.564a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5zM125.782 82.228H20.218a1.5 1.5 0 00-1.5 1.5v.739a1.5 1.5 0 001.5 1.5h105.564a1.5 1.5 0 001.5-1.5v-.739a1.5 1.5 0 00-1.5-1.5zM95.833 92.195H20.218a1.5 1.5 0 00-1.5 1.5v.738a1.5 1.5 0 001.5 1.5h75.615a1.5 1.5 0 001.5-1.5v-.738a1.5 1.5 0 00-1.5-1.5z" fill="currentColor"/><path d="M29.949 42.36c6.202 0 11.23-5.02 11.23-11.213s-5.028-11.213-11.23-11.213c-6.203 0-11.231 5.02-11.231 11.213 0 6.192 5.028 11.213 11.23 11.213z" fill="currentColor"/><path opacity="0.6" d="M78.11 24.918H50.42a3 3 0 00-3 3v.23a3 3 0 003 3H78.11a3 3 0 003-3v-.23a3 3 0 00-3-3z" fill="currentColor"/><path opacity="0.3" d="M96.088 34.885H48.665a1.246 1.246 0 100 2.492h47.423a1.246 1.246 0 100-2.492z" fill="currentColor"/><path opacity="0.15" d="M27.209 108.395h-5.491a3 3 0 00-3 3v5.695c0 3.201.678 5.728 2.034 7.579 1.356 1.852 3.68 3.487 6.974 4.906l2.483-4.62c-2.025-.934-3.425-1.865-4.2-2.79-.775-.926-1.206-2.02-1.294-3.283h2.494a3 3 0 003-3v-4.486a3 3 0 00-3-3v-.001zm13.259 0h-5.491a3 3 0 00-3 3v5.695c0 3.201.678 5.728 2.034 7.579 1.356 1.852 3.68 3.487 6.974 4.906l2.483-4.62c-2.025-.934-3.425-1.865-4.2-2.79-.775-.926-1.206-2.02-1.294-3.283h2.494a3 3 0 003-3v-4.486a3 3 0 00-3-3v-.001z" fill="currentColor"/><path d="M27.988 53.614c0 .1-.072.195-.145.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zm12.478 0c0 .1-.072.195-.145.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zm12.48 0c0 .1-.073.195-.146.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zm12.478 0c0 .1-.072.195-.145.267l-2.022 1.97.48 2.78.005.111c0 .145-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256zM74.967 55.598l1.705-1.652-2.35-.345-1.054-2.125-1.053 2.125-2.35.345 1.704 1.652-.407 2.342 2.106-1.107 2.1 1.107-.4-2.342zm2.936-1.986c0 .1-.072.195-.145.267l-2.022 1.97.48 2.78.005.111c0 .15-.067.278-.228.278a.454.454 0 01-.223-.067l-2.5-1.313-2.502 1.313a.47.47 0 01-.223.067c-.162 0-.234-.133-.234-.278l.011-.11.48-2.782-2.029-1.969c-.067-.072-.139-.167-.139-.267 0-.167.173-.234.312-.256l2.797-.406 1.253-2.53c.05-.107.145-.229.273-.229.128 0 .223.122.273.228l1.253 2.531 2.797.406c.134.022.312.09.312.256z" fill="currentColor"/></svg>'],
                                    'testi_layout3' => ['svg' => '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 153"><path opacity="0.1" d="M146 0H0v152.239h146V0z" fill="currentColor"/><path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M134.513 12.479a4 4 0 014 4v63.128a4 4 0 01-4 4H76.491l-4.115 5.157-4.126-5.157H11.487a4 4 0 01-4-4V16.478a4 4 0 014-4h123.026z" fill="currentColor"/><path d="M124.534 47.418H21.466a1.5 1.5 0 00-1.5 1.5v.744a1.5 1.5 0 001.5 1.5h103.068a1.5 1.5 0 001.5-1.5v-.744a1.5 1.5 0 00-1.5-1.5z" fill="#fff"/><path opacity="0.7" d="M124.534 57.4H21.466a1.5 1.5 0 00-1.5 1.5v.744a1.5 1.5 0 001.5 1.5h103.068a1.5 1.5 0 001.5-1.5V58.9a1.5 1.5 0 00-1.5-1.5z" fill="#fff"/><path opacity="0.5" d="M94.585 67.383h-73.12a1.5 1.5 0 00-1.5 1.5v.743a1.5 1.5 0 001.5 1.5h73.12a1.5 1.5 0 001.5-1.5v-.743a1.5 1.5 0 00-1.5-1.5z" fill="#fff"/><path d="M73.624 119.796c6.202 0 11.23-5.029 11.23-11.231 0-6.203-5.028-11.231-11.23-11.231-6.203 0-11.23 5.028-11.23 11.231 0 6.202 5.027 11.231 11.23 11.231z" fill="currentColor"/><path opacity="0.6" d="M86.846 126.035H60.402a3 3 0 00-3 3v.239a3 3 0 003 3h26.444a3 3 0 003-3v-.239a3 3 0 00-3-3z" fill="currentColor"/><path opacity="0.3" d="M97.333 136.018H49.914a1.247 1.247 0 100 2.495h47.42a1.247 1.247 0 100-2.495z" fill="currentColor"/></svg>'],
                                ],
                                'std' => 'testi_layout3',
                            ],
                        ],
                    ],
                ],

                'testimonial_carousel_typography_options' => [
                    'action' => 'dropdown',
                    'icon' => 'typography',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TYPOGRAPHY'),
                    'fieldset' => [
                        'tab_groups' => [
                            'message' => [
                                'fields' => [
                                    [
                                        'message_typography' => [
                                            'type' => 'typography',
                                            'fallbacks' => [
                                                'font' => 'message_font_family',
                                                'size' => 'message_fontsize',
                                                'line_height' => 'message_lineheight',
                                                'letter_spacing' => 'message_letterspace',
                                                'uppercase' => 'message_font_style.uppercase',
                                                'italic' => 'message_font_style.italic',
                                                'underline' => 'message_font_style.underline',
                                                'weight' => 'message_font_style.weight',
                                            ],
                                        ],
                                    ],
                                ],
                            ],

                            'name' => [
                                'fields' => [
                                    [
                                        'name_typography' => [
                                            'type' => 'typography',
                                            'fallbacks' => [
                                                'font' => 'name_font_family',
                                                'size' => 'name_fontsize',
                                                'line_height' => 'name_lineheight',
                                                'letter_spacing' => 'name_letterspace',
                                                'uppercase' => 'name_font_style.uppercase',
                                                'italic' => 'name_font_style.italic',
                                                'underline' => 'name_font_style.underline',
                                                'weight' => 'name_font_style.weight',
                                            ],
                                        ],
                                    ],
                                ],
                            ],

                            'designation' => [
                                'fields' => [
                                    [
                                        'title_typography' => [
                                            'type' => 'typography',
                                            'fallbacks' => [
                                                'font' => 'designation_font_family',
                                                'size' => 'designation_fontsize',
                                                'line_height' => 'designation_lineheight',
                                                'letter_spacing' => 'designation_letterspace',
                                                'uppercase' => 'designation_font_style.uppercase',
                                                'italic' => 'designation_font_style.italic',
                                                'underline' => 'designation_font_style.underline',
                                                'weight' => 'designation_font_style.weight',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                'testimonial_carousel_color_options' => [
                    'action' => 'dropdown',
                    'type' => 'placeholder',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                    'placeholder' => [
                        'type' => 'HTMLElement',
                        'element' => 'div',
                        'selector' => '.builder-color-picker',
                        'attribute' => [
                            'type' => 'style',
                            'property' => 'background',
                        ],
                        'display_field' => 'content_background',
                    ],
                    'fieldset' => [
                        [
                            'message_text_color' => [
                                'type' => 'color',
                                'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                                'std' => '#888d92',
                            ],

                            'content_background' => [
                                'type' => 'color',
                                'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                'depends' => [['testimonial_carousel_layout', '!=', 'testi_layout3']],
                            ],

                            'message_background' => [
                                'type' => 'color',
                                'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                'std' => '#F8F8F8',
                                'depends' => [['testimonial_carousel_layout', '=', 'testi_layout3']],
                            ],

                            'name_text_color' => [
                                'type' => 'color',
                                'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_NAME'),
                                'std' => '#6d7175',
                            ],

                            'designation_text_color' => [
                                'type' => 'color',
                                'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_DESIGNATION'),
                                'std' => '#888d92',
                            ],
                        ],
                    ],
                ],

                'testimonial_carousel_alignment_separator' => [
                    'action' => 'separator',
                ],

                'testimonial_carousel_alignment_options' => [
                    'action' => 'dropdown',
                    'type' => 'placeholder',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALIGNMENT'),
                    'style' => 'inline',
                    'showCaret' => true,
                    'placeholder' => [
                        'type' => 'list',
                        'options' => [
                            'left' => ['icon' => 'textAlignLeft'],
                            'center' => ['icon' => 'textAlignCenter'],
                            'right' => ['icon' => 'textAlignRight'],
                        ],
                        'display_field' => 'content_alignment',
                    ],
                    'fieldset' => [
                        'basic' => [
                            'content_alignment' => [
                                'type' => 'alignment',
                                'inline' => true,
                                'responsive' => true,
                                'available_options' => ['left', 'center', 'right'],
                                'std' => [
                                    'xxl' => '',
                                    'xl' => 'center',
                                    'lg' => '',
                                    'md' => '',
                                    'sm' => '',
                                    'xs' => '',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],

        'attr' => [
            'general' => [
                'sp_testimonial_carousel_item' => [
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEMS'),
                    'std' => [
                        [
                            'client_name' => 'Edward Morinho',
                            'client_desgination' => 'Full Stack Devloper',
                            'client_message' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                            'show_rating' => 1,
                            'client_rating' => 4.5,
                            'testimonial_carousel_img' => 'https://sppagebuilder.com/addons/testimonial_carousel/testimonial-person-1.png',
                        ],
                        [
                            'client_name' => 'Edward Morinho',
                            'client_desgination' => 'Full Stack Devloper',
                            'client_message' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                            'show_rating' => 1,
                            'client_rating' => 4.5,
                            'testimonial_carousel_img' => 'https://sppagebuilder.com/addons/testimonial_carousel/testimonial-person-2.png',
                        ],
                        [
                            'client_name' => 'Edward Morinho',
                            'client_desgination' => 'Full Stack Devloper',
                            'client_message' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                            'show_rating' => 1,
                            'client_rating' => 4.5,
                            'testimonial_carousel_img' => 'https://sppagebuilder.com/addons/testimonial_carousel/testimonial-person-3.png',
                        ],
                        [
                            'client_name' => 'Edward Morinho',
                            'client_desgination' => 'Full Stack Devloper',
                            'client_message' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                            'show_rating' => 1,
                            'client_rating' => 4.5,
                            'testimonial_carousel_img' => 'https://sppagebuilder.com/addons/testimonial_carousel/testimonial-person-1.png',
                        ],
                        [
                            'client_name' => 'Edward Morinho',
                            'client_desgination' => 'Full Stack Devloper',
                            'client_message' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                            'show_rating' => 1,
                            'client_rating' => 4.5,
                            'testimonial_carousel_img' => 'https://sppagebuilder.com/addons/testimonial_carousel/testimonial-person-2.png',
                        ],
                        [
                            'client_name' => 'Edward Morinho',
                            'client_desgination' => 'Full Stack Devloper',
                            'client_message' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                            'show_rating' => 1,
                            'client_rating' => 4.5,
                            'testimonial_carousel_img' => 'https://sppagebuilder.com/addons/testimonial_carousel/testimonial-person-3.png',
                        ],
                    ],
                    'attr' => [
                        'title' => [
                            'type' => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADMIN_LABEL'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADMIN_LABEL_DESC'),
                            'std' => 'Carousel Item Tittle',
                        ],
                        'client_name' => [
                            'type' => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_NAME'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_NAME_DESC'),
                            'std' => 'Edward Morinho',
                        ],
                        'client_desgination' => [
                            'type' => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_CLIENT_DESIGNATION'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_CLIENT_DESIGNATION_DESC'),
                            'std' => 'Full Stack Devloper',
                        ],
                        'client_message' => [
                            'type' => 'textarea',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CAROUSEL_MESSAGE'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CAROUSEL_MESSAGE_DESC'),
                            'std' => 'Testimonial carousel is modern and stylish addon for SP Page Builder . Instantly raise your website appearance with this stylish new addon.',
                        ],
                        'show_rating' => [
                            'type' => 'checkbox',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_RATING_ENABLE'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_RATING_ENABLE_DESC'),
                            'std' => 1,
                        ],
                        'client_rating' => [
                            'type' => 'slider',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_RATING'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_CLIENT_RATING_DESC'),
                            'depends' => [
                                ['show_rating', '!=', 0],
                            ],
                            'std' => 4.5,
                            'min' => 1,
                            'max' => 5,
                            'step' => .5,
                        ],
                        'testimonial_carousel_img' => [
                            'type' => 'media',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CLIENT_IMAGE'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CLIENT_IMAGE_DESC'),
                            'std' => [
                                'src' => 'https://sppagebuilder.com/addons/image_carousel/image-carousel-default.jpg',
                            ],
                        ],
                    ],
                ],

                // bullets
                'toggle_bullet_controllers' => [
                    'type' => 'header',
                    'style' => 'toggle',
                    'uuid' => 'toggle_bullet_controllers',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_BULLETS'),
                    'group' => [
                        'bullet_position_verti',
                        'bullet_position_hori',
                        'bullet_height',
                        'bullet_width',
                        'bullet_border_width',
                        'bullet_border_radius',
                        'bullet_style',
                        'bullet_background',
                        'bullet_border_color',
                        'bullet_active_background',
                    ],
                    'depends' => [['carousel_bullet', '=', 1]],
                ],

                'bullet_position_verti' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_VERTICAL_POSITION'),
                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_VERTICAL_POSITION_DESC'),
                    'min' => -100,
                    'max' => 100,
                    'responsive' => true,
                ],

                'bullet_position_hori' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_HORI_POSITION'),
                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_HORI_POSITION_DESC'),
                    'min' => -2000,
                    'max' => 2000,
                    'responsive' => true,
                ],

                'bullet_height' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
                    'max' => 100,
                    'min' => 0,
                    'std' => 12,
                ],

                'bullet_width' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
                    'max' => 100,
                    'min' => 0,
                    'std' => 12,
                ],

                'bullet_border_width' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                    'max' => 20,
                ],

                'bullet_border_radius' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                    'desc' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS_DESC'),
                    'max' => 100,
                ],

                'bullet_style' => [
                    'type' => 'buttons',
                    'values' => [
                        ['label' => 'Normal', 'value' => 'normal'],
                        ['label' => 'Active', 'value' => 'active'],
                    ],
                    'std' => 'normal',
                ],

                'bullet_background' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                    'std' => '#dbdbdb',
                    'depends' => [['bullet_style', '=', 'normal']],
                ],

                'bullet_border_color' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                    'depends' => [['bullet_style', '=', 'normal']],
                ],

                'bullet_active_background' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                    'std' => '#373bff',
                    'depends' => [['bullet_style', '=', 'active']],
                ],
                // active border color is required

                // arrows
                'toggle_arrow_controllers' => [
                    'type' => 'header',
                    'style' => 'toggle',
                    'uuid' => 'toggle_arrow_controllers',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ARROWS'),
                    'group' => [
                        'arrow_position_verti',
                        'arrow_position_hori',
                        'arrow_icon',
                        'arrow_height',
                        'arrow_width',
                        'arrow_font_size',
                        'arrow_border_width',
                        'arrow_border_radius',
                        'arrow_style',
                        'arrow_color',
                        'arrow_background',
                        'arrow_border_color',
                        'arrow_hover_color',
                        'arrow_hover_background',
                        'arrow_hover_border_color',
                    ],
                    'depends' => [['carousel_arrow', '=', 1]],
                ],

                'arrow_position_verti' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_VERTICAL_POSITION'),
                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_VERTICAL_POSITION_DESC'),
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                    ],
                    'min' => -100,
                    'max' => 100,
                    'responsive' => true,
                ],

                'arrow_position_hori' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_HORI_POSITION'),
                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_CONTROLLER_HORI_POSITION_DESC'),
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                    ],
                    'min' => -200,
                    'max' => 200,
                    'responsive' => true,
                ],

                'arrow_icon' => [
                    'type' => 'select',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_ARROWS_ICON'),
                    'values' => [
                        'angle' => 'Angle',
                        'long_arrow' => 'Long Arrow',
                    ],
                    'std' => 'long_arrow',
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                    ],
                ],

                'arrow_style' => [
                    'type' => 'buttons',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TESTIMONIAL_PRO_ARROWS_STYLE'),
                    'std' => 'normal_arrow',
                    'values' => [
                        [
                            'label' => 'Normal Arrow',
                            'value' => 'normal_arrow',
                        ],
                        [
                            'label' => 'Hover Arrow',
                            'value' => 'hover_arrow',
                        ],
                    ],
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                    ],
                ],

                'arrow_height' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
                    'std' => '',
                    'max' => 200,
                    'min' => 10,
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                    'std' => 50,
                ],

                'arrow_width' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
                    'std' => '',
                    'max' => 200,
                    'min' => 10,
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                    'std' => 52,
                ],

                'arrow_background' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                    'std' => '#373bff',
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                ],

                'arrow_color' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                    'std' => '#fff',
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                ],

                'arrow_font_size' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
                    'min' => 0,
                    'max' => 100,
                    'std' => 24,
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                ],

                'arrow_border_width' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                    'min' => 0,
                    'max' => 20,
                ],

                'arrow_border_color' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                    'std' => '#373bff',
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                ],

                'arrow_border_radius' => [
                    'type' => 'slider',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                    'desc' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS_DESC'),
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'normal_arrow'],
                    ],
                    'max' => 1000,
                    'min' => 0,
                    'std' => '0',
                ],

                //Arrow hover
                'arrow_hover_background' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR_HOVER'),
                    'std' => '',
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'hover_arrow'],
                    ],
                ],

                'arrow_hover_color' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR_HOVER'),
                    'std' => '',
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'hover_arrow'],
                    ],
                ],

                'arrow_hover_border_color' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR_HOVER'),
                    'std' => '',
                    'depends' => [
                        ['carousel_arrow', '=', 1],
                        ['carousel_navigation', '=', 'arrow_controller'],
                        ['arrow_style', '=', 'hover_arrow'],
                    ],
                ],
            ],
        ],
    ]
);
