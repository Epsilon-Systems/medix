<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http: //www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http: //www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined ('_JEXEC') or die ('Restricted access');

use Joomla\CMS\Language\Text;

SpAddonsConfig::addonConfig(
    [
        'type'       => 'general',
        'addon_name' => 'navigation',
        'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST'),
        'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_DESC'),
        'category'   => 'Content',
        'icon'       => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 5.5A1.5 1.5 0 014.5 4h23a1.5 1.5 0 010 3h-23A1.5 1.5 0 013 5.5zM3 15.5A1.5 1.5 0 014.5 14h23a1.5 1.5 0 010 3h-23A1.5 1.5 0 013 15.5zM3 25.5A1.5 1.5 0 014.5 24h23a1.5 1.5 0 010 3h-23A1.5 1.5 0 013 25.5z" fill="currentColor"/></svg>',
        'inline'     => [
            'buttons' => [
                'navigation_general_options' => [
                    'action'   => 'dropdown',
                    'icon'     => 'addon::navigation',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST'),
                    'fieldset' => [
                        'tab_groups' => [
                            'navigation' => [
                                'fields' => [
                                    [
                                        'scroll_to'=> [
                                            'type'  => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_ENABLE_SCROLL_TO'),
                                            'std'   => 0
                                        ],
                        
                                        'scroll_to_offset' => [
                                            'type'    => 'slider',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_ENABLE_SCROLL_TO_OFFSET'),
                                            'depends' => [
                                                ['scroll_to', '=', 1],
                                            ],
                                            'max' => 2000,
                                            'min' => -2000,
                                        ],
                        
                                        'sticky_menu' => [
                                            'type'  => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_ENABLE_STICKY'),
                                            'std'   => 0
                                        ],
                        
                                        'type' => [
                                            'type'   => 'radio',
                                            'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_TYPE'),
                                            'values' => [
                                                'nav'  => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_TYPE_NAV'),
                                                'list' => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_TYPE_LIST'),
                                            ],
                                            'std' => 'nav'
                                        ],

                                        'responsive_menu' => [
                                            'type'  => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_BURGER_MENU'),
                                            'std'   => 1
                                        ],
                        
                                        'align' => [
                                            'type'   => 'radio',
                                            'style_property' => true,
                                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALIGNMENT'),
                                            'values' => [
                                                'left'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                                'right'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                                                'center' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
                                            ],
                                            'std' => 'left',
                                        ],
                                        
                                        'advanced_settings' => [
                                            'type'   => 'advancedsettings',
                                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ITEMS'),
                                            'buttonText' => Text::_('COM_SPPAGEBUILDER_ADDON_ITEM_ADD_EDIT'),
                                            'buttonIcon' => 'ul',
                                        ],
                                    ],
                                ],
                            ],

                            'link' => [
                                'fields' => [
                                    [
                                        'link_padding'=> [
                                            'type'       => 'padding',
                                            'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                            'std'        => ['xxl'=> '', 'xl'=> '5px 15px 5px 15px', 'lg'=> '', 'md'=> '', 'sm'=> '', 'xs'=> ''],
                                            'responsive' => true
                                        ],

                                        'link_margin'=> [
                                            'type'       => 'margin',
                                            'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                            'responsive' => true
                                        ],

                                        'link_border_radius' => [
                                            'type'       => 'slider',
                                            'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                            'std'        => 3,
                                            'min'        => 0,
                                            'max'        => 100,
                                            'std'        => ['xl' => 4],
                                            'responsive' => true
                                        ],
                                    ],
                                ],
                            ],

                            'icon' => [
                                'fields' => [
                                    [
                                        'icon_position'=> [
                                            'type'   => 'radio',
                                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_POSITION'),
                                            'values' => [
                                                'left'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                                'right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                                                'top'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TOP'),
                                            ],
                                            'std' => 'left',
                                        ],
                        
                                        'icon_size'=> [
                                            'type'       => 'slider',
                                            'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_SIZE'),
                                            'max'        => 200,
                                            'responsive' => true,
                                        ],
                        
                                        'icon_margin'=> [
                                            'type'       => 'margin',
                                            'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                            'responsive' => true
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                'navigation_add_new_item' => [
                    'action' => 'click',
                    'type' => 'plus',
                    'icon' => 'plusCircle',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ADD_NEW'),
                    'meta' => [
                        'key' => 'sp_link_list_item',
                        'title' => 'Item'
                    ]
                ],

                'navigation_typography_options' => [
                    'action'   => 'dropdown',
                    'icon'     => 'typography',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_TYPOGRAPHY'),
                    'fieldset' => [
                        'basic' => [
                            'link_typography' => [
                                'type'      => 'typography',
                                'fallbacks' => [
                                    'font'           => 'link_font_family',
                                    'size'           => 'link_fontsize',
                                    'line_height'    => 'link_lineheight',
                                    'letter_spacing' => 'link_letterspace',
                                    'uppercase'      => 'link_font_style.uppercase',
                                    'italic'         => 'link_font_style.italic',
                                    'underline'      => 'link_font_style.underline',
                                    'weight'         => 'link_font_style.weight',
                                ],
                            ],
                        ],
                    ],
                ],

                'navigation_color_options' => [
                    'action'  => 'dropdown',
                    'type'    => 'placeholder',
                    'tooltip'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                    'placeholder' => [
                        'type'      => 'HTMLElement',
                        'element'   => 'div',
                        'selector'  => '.builder-color-picker',
                        'attribute' => [
                            'type'     => 'style',
                            'property' => 'background'
                        ],
                        'display_field' => 'link_bg',
                    ],

                    'fieldset' => [
                        'tab_groups' => [
                            'navigation' => [
                                'fields' => [
                                    'normal' => [
                                        'link_color' => [
                                            'type'  => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                                            'std'   => '#3366FF',
                                        ],

                                        'link_bg' => [
                                            'type'  => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                            'std'   => '#F5F5F5',
                                        ],
                                    ],

                                    'hover' => [
                                        'link_color_hover' => [
                                            'type'  => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                                            'std'   => '#FFFFFF',
                                        ],

                                        'link_bg_hover'=> [
                                            'type'  => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                            'std'   => '#3366FF',
                                        ],
                                    ],

                                    'active' => [
                                        'link_color_active'=> [
                                            'type'  => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                                            'std'   => '#FFFFFF',
                                        ],
                        
                                        'link_bg_active'=> [
                                            'type'  => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                            'std'   => '#3366FF',
                                        ],
                                    ],
                                ],
                            ],

                            'burger' => [
                                'fields' => [
                                    'normal' => [
                                        'responsive_bar_color'=> [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                                            'std'     => '#3366FF',
                                            'depends' => [['responsive_menu', '=', 1]],
                                        ],

                                        'responsive_bar_bg'=> [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                            'std'     => '#F5F5F5',
                                            'depends' => [['responsive_menu', '=', 1]],
                                        ],
                                    ],

                                    'active' => [
                                        'responsive_bar_bg_active'=> [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                                            'std'     => '#3366FF',
                                            'depends' => [['responsive_menu', '=', 1]],
                                        ],
                                        
                                        'responsive_bar_color_active'=> [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                            'std'     => '#FFFFFF',
                                            'depends' => [['responsive_menu', '=', 1]],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],      
        
        'attr'       => [
            'general' => [
                'sp_link_list_item'=> [
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ITEMS'),
                    'attr'  => [
                        'title' => [
                            'type'  => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_TITLE'),
                            'std'   => 'Home',
                        ],

                        'url' => [
                            'type'  => 'link',
                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
                            'mediaType' => 'attachment',
                        ],

                        'icon' => [
                            'type'  => 'icon',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_ICON'),
                        ],
                        
                        'active' => [
                            'type'  => 'checkbox',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_LINK_LIST_ENABLE_ACTIVE'),
                            'std'   => 0
                        ],

                        // 'target'=> [
                        //     'type'   => 'select',
                        //     'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB'),
                        //     'values' => [
                        //         ''       => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
                        //         '_blank' => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
                        //     ],
                        // ],

                        'class'=> [
                            'type'  => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
                        ],
                    ]
                ],
            ],
        ],
    ]
);