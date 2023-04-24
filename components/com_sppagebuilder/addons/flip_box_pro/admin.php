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

SpAddonsConfig::addonConfig([
    'type' => 'content',
    'addon_name' => 'flip_box_pro',
    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO'),
    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_DESC'),
    'category' => 'Content',
    'icon' => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M27 3a3 3 0 00-3-3H8a3 3 0 00-3 3v10.188a1 1 0 102 0V3a1 1 0 011-1h16a1 1 0 011 1v26a1 1 0 01-1 1H8a1 1 0 01-1-1v-6.906a1 1 0 10-2 0V29a3 3 0 003 3h16a3 3 0 003-3V3z" fill="currentColor"/><path d="M18.332 21.539c.039 0 .079-.002.117-.006C26.428 20.835 32 17.32 32 12.987c0-1.338-.217-2.348-1.33-3.556a1.334 1.334 0 00-1.963 1.805c.548.595.626.908.626 1.75 0 2.758-4.882 5.345-11.116 5.89a1.334 1.334 0 00.115 2.663zM13.021 21.475a1.335 1.335 0 00.144-2.66c-6.28-.69-10.498-3.4-10.498-5.495 0-1.05.182-1.377.758-2.255a1.335 1.335 0 00-2.229-1.464C.452 10.736 0 11.551 0 13.32c0 3.9 5.415 7.325 12.873 8.147.05.005.099.008.148.008z" fill="currentColor"/><path d="M16.217 19.955l2.83-3.77a1 1 0 011.79.459l.94 6.6a1 1 0 01-1.59.94l-3.77-2.83a1 1 0 01-.2-1.399z" fill="currentColor"/></svg>',
    'inline' => [
        'buttons' => [
            'flip_box_general_options' => [
                'action' => 'dropdown',
                'icon' => 'pencil',
                'tooltip' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO'),
                'fieldset' => [
                    'tab_groups' => [
                        'front' => [
                            'fields' => [
                                [
                                    // title
                                    'front_add_title' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_TITLE'),
                                        'std' => 0,
                                        'group' => [
                                            'front_title_option',
                                            'front_title',
                                            'front_title_text_color',
                                            'front_title_typography'
                                        ]
                                    ],

                                    'front_title_option' => [
                                        'type' => 'buttons',
                                        'std' => 'title',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Title',
                                                'value' => 'title'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Typography',
                                                'value' => 'typography'
                                            ],
                                        ],
                                        'depends' => [
                                            ['front_add_title', '=', 1],
                                        ],
                                    ],

                                    'front_title' => [
                                        'type'  => 'text',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
                                        'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
                                        'depends' => [
                                            ['front_title_option', '=', 'title'],
                                            ['front_add_title', '=', 1],
                                        ],
                                    ],

                                    'front_title_text_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'depends' => [
                                            ['front_title_option', '=', 'color'],
                                            ['front_add_title', '=', 1],
                                        ],
                                    ],

                                    'front_title_typography' => [
                                        'type'     => 'typography',
                                        'depends' => [
                                            ['front_title_option', '=', 'typography'],
                                            ['front_add_title', '=', 1],
                                        ],
                                    ],

                                    // paragraph
                                    'front_add_paragraph' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_PARAGRAPH'),
                                        'std' => 0,
                                        'group' => [
                                            'front_paragraph_option',
                                            'front_paragraph',
                                            'front_paragraph_text_color',
                                            'front_paragraph_typography'
                                        ]
                                    ],

                                    'front_paragraph_option' => [
                                        'type' => 'buttons',
                                        'std' => 'title',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Title',
                                                'value' => 'title'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Typography',
                                                'value' => 'typography'
                                            ],
                                        ],
                                        'depends' => [
                                            ['front_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    'front_paragraph' => [
                                        'type'  => 'textarea',
                                        'title' => 'Paragraph',
                                        'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
                                        'depends' => [
                                            ['front_paragraph_option', '=', 'title'],
                                            ['front_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    'front_paragraph_text_color' => [
                                        'type'   => 'color',
                                        'title'  => 'Paragraph Color',
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'depends' => [
                                            ['front_paragraph_option', '=', 'color'],
                                            ['front_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    'front_paragraph_typography' => [
                                        'type'     => 'typography',
                                        'depends' => [
                                            ['front_paragraph_option', '=', 'typography'],
                                            ['front_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    // icon
                                    'front_add_icon' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_ICON'),
                                        'std' => 0,
                                        'group' => [
                                            'front_icon_option',
                                            'front_icon',
                                            'front_icon_size',
                                            'front_global_background_type',
                                            'front_flip_box_icon_color',
                                            'front_flip_box_icon_gradient',
                                            'front_flip_box__margin',
                                            'front_flip_box__padding',
                                        ]
                                    ],

                                    'front_icon_option' => [
                                        'type' => 'buttons',
                                        'std' => 'icon',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Icon',
                                                'value' => 'icon'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Space',
                                                'value' => 'space'
                                            ],
                                        ],
                                        'depends' => [
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],

                                    'front_icon' => [
                                        'type'      => 'icon',
                                        'title'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON_NAME'),
                                        'std'       => 'fas fa-cogs',
                                        'depends' => [
                                            ['front_icon_option', '=', 'icon'],
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],

                                    'front_icon_size' => [
                                        'type'       => 'slider',
                                        'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON_SIZE'),
                                        'std'        => ['xl' => 36],
                                        'max'        => 400,
                                        'responsive' => true,
                                        'depends' => [
                                            ['front_icon_option', '=', 'icon'],
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],

                                    'front_global_background_type' => [
                                        'type' => 'buttons',
                                        'std' => 'none',
                                        'values' => [
                                            [
                                                'label' => 'None',
                                                'value' => 'none'
                                            ],
                                            [
                                                'label' => 'Solid',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Gradient',
                                                'value' => 'gradient'
                                            ],
                                        ],
                                        'depends' => [
                                            ['front_icon_option', '=', 'color'],
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],
                                    'front_flip_box_icon_color' => [
                                        'type'   => 'color',
                                        'title'  => 'Icon Color',
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'depends' => [
                                            ['front_global_background_type', '!=', 'none'],
                                            ['front_global_background_type', '!=', 'gradient'],
                                            ['front_icon_option', '=', 'color'],
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],
                                    'front_flip_box_icon_gradient' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
                                        'std' => [
                                            "color" => "#00c6fb",
                                            "color2" => "#005bea",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['front_global_background_type', '=', 'gradient'],
                                            ['front_icon_option', '=', 'color'],
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],

                                    'front_flip_box__margin' => [
                                        'type' => 'margin',
                                        'title' => 'Margin',
                                        'responsive' => true,
                                        'std' => '',
                                        'depends' => [
                                            ['front_icon_option', '=', 'space'],
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],

                                    'front_flip_box__padding' => [
                                        'type' => 'padding',
                                        'title' => 'Padding',
                                        'responsive' => true,
                                        'std' => '',
                                        'depends' => [
                                            ['front_icon_option', '=', 'space'],
                                            ['front_add_icon', '=', 1],
                                        ],
                                    ],

                                    // button
                                    'front_add_button' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_BUTTON'),
                                        'std' => 0,
                                        'group' => [
                                            'front_button_outer_option',
                                            'front_button_option',
                                            'front_button_type',
                                            'front_appearance',
                                            'front_shape',
                                            'front_block',
                                            'front_button_size',
                                            'front_flip_box_icon',
                                            'front_flip_box_button_icon_position',
                                            'front_button_color_option',
                                            'front_flip_box_button_bg_color',
                                            'front_flip_box_button_bg_gradient',
                                            'front_flip_box_button_color',
                                            'front_flip_box_button_bg_color_hover',
                                            'front_flip_box_button_gradient_bg_hover',
                                            'front_flip_box_button_color_hover',
                                            'front_button_text',
                                            'front_flip_box_button_typography',
                                            'front_flip_box_button_link',
                                            'front_button_padding',
                                            'front_button_margin',
                                        ],
                                        'depends' => [
                                            ['flip_behavior', '=', 'click']
                                        ],
                                    ],

                                    'front_button_outer_option' => [
                                        'type' => 'buttons',
                                        'std' => 'button',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Button',
                                                'value' => 'button'
                                            ],
                                            [
                                                'label' => 'Typography',
                                                'value' => 'typography'
                                            ],
                                            [
                                                'label' => 'Link',
                                                'value' => 'link'
                                            ],
                                        ],
                                        'tabs' => true,
                                        'depends' => [
                                            ['front_add_button', '=', 1],
                                        ],
                                    ],

                                    'front_button_option' => [
                                        'type' => 'buttons',
                                        'std' => 'style',
                                        // 'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Style',
                                                'value' => 'style'
                                            ],
                                            [
                                                'label' => 'Icon',
                                                'value' => 'icon'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color',
                                                'depends' => [
                                                    ['front_button_type', '!=', 'default'],
                                                    ['front_button_type', '!=', 'primary'],
                                                    ['front_button_type', '!=', 'secondary'],
                                                    ['front_button_type', '!=', 'success'],
                                                    ['front_button_type', '!=', 'info'],
                                                    ['front_button_type', '!=', 'warning'],
                                                    ['front_button_type', '!=', 'danger'],
                                                    ['front_button_type', '!=', 'dark'],
                                                ],
                                            ],
                                        ],
                                        'tabs' => true,
                                        'depends' => [
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'front_button_type' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE_DESC'),
                                        'values' => [
                                            'default'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
                                            'primary'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
                                            'secondary' => Text::_('COM_SPPAGEBUILDER_GLOBAL_SECONDARY'),
                                            'success'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
                                            'info'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
                                            'warning'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
                                            'danger'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
                                            'dark'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_DARK'),
                                            'link'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
                                            'custom'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
                                        ],
                                        'inline' => true,
                                        'depends' => [
                                            ['front_button_option', '=', 'style'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                        'std'    => 'custom',
                                    ],

                                    'front_appearance' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
                                        'values' => [
                                            ''         => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
                                            'gradient' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_GRADIENT'),
                                            'outline'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
                                            // '3d' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_3D'), // will be removed
                                        ],
                                        'std'     => '',
                                        'depends' => [
                                            ['front_button_type', '!=', 'link'],
                                            ['front_button_option', '=', 'style'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                        'inline' => true,
                                    ],

                                    'front_shape' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
                                        'values' => [
                                            'rounded' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
                                            'square'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
                                            'round'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
                                        ],
                                        'std'   => 'rounded',
                                        'depends' => [
                                            ['front_button_type', '!=', 'link'],
                                            ['front_button_option', '=', 'style'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                        'inline' => true,
                                    ],

                                    'front_block' => [
                                        'type'   => 'radio',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK_DESC'),
                                        'values' => [
                                            ''               => Text::_('JNO'),
                                            'sppb-btn-block' => Text::_('JYES'),
                                        ],
                                        'depends' => [
                                            ['front_button_type', '!=', 'link'],
                                            ['front_button_option', '=', 'style'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'front_button_size' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DESC'),
                                        'values' => [
                                            ''       => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DEFAULT'),
                                            'lg'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_LARGE'),
                                            'xlg'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_XLARGE'),
                                            'sm'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_SMALL'),
                                            'xs'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_EXTRA_SAMLL'),
                                            'custom' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
                                        ],
                                        'inline' => true,
                                        'depends' => [
                                            ['front_button_option', '=', 'style'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'front_button_padding' => [
                                        'type'    => 'padding',
                                        'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                        'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
                                        'depends' => [
                                            ['front_button_option', '=', 'style'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                            ['front_button_size', '=', 'custom'],
                                        ],
                                        'responsive' => true,
                                    ],

                                    'front_button_margin' => [
                                        'type'    => 'margin',
                                        'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                        'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_DESC'),
                                        'depends' => [
                                            ['front_button_option', '=', 'style'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                        'responsive' => true,
                                    ],

                                    'front_flip_box_icon' => [
                                        'type'  => 'icon',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
                                        'depends' => [
                                            ['front_button_option', '=', 'icon'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                    ],
                                    'front_flip_box_button_icon_position' => [
                                        'type'       => 'margin',
                                        'type'   => 'radio',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
                                        'values' => [
                                            'left'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                            'right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                                        ],
                                        'std' => 'left',
                                        'depends' => [
                                            ['front_button_option', '=', 'icon'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],

                                    ],

                                    'front_button_color_option' => [
                                        'type' => 'buttons',
                                        'std' => 'general',
                                        'style' => 'line',
                                        'values' => [
                                            [
                                                'label' => 'General',
                                                'value' => 'general'
                                            ],
                                            [
                                                'label' => 'Hover',
                                                'value' => 'hover'
                                            ],
                                        ],
                                        'depends' => [
                                            ['front_button_option', '=', 'color'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                        'tabs' => true,
                                    ],

                                    'front_flip_box_button_bg_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_BUTTON_BG_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std'     => '#3366FF',
                                        'depends' => [
                                            ['front_button_option', '=', 'color'],
                                            ['front_button_color_option', '=', 'general'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                            ['front_button_outer_option', '=', 'button'],
                                            ['front_button_type', '!=', 'link'],
                                            ['front_appearance', '!=', 'gradient'],
                                        ],
                                    ],

                                    'front_flip_box_button_bg_gradient' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_frontGROUND_COLOR'),
                                        'std' => [
                                            "color"  => "#3366FF",
                                            "color2" => "#0037DD",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['front_button_option', '=', 'color'],
                                            ['front_button_color_option', '=', 'general'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                            ['front_button_outer_option', '=', 'button'],
                                            ['front_button_type', '!=', 'link'],
                                            ['front_appearance', '=', 'gradient'],
                                        ],
                                    ],

                                    'front_flip_box_button_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std' => '#FFFFFF',
                                        'depends' => [
                                            ['front_button_option', '=', 'color'],
                                            ['front_button_color_option', '=', 'general'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'front_flip_box_button_bg_color_hover' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_BUTTON_BG_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std'     => '#0037DD',
                                        'depends' => [
                                            ['front_button_option', '=', 'color'],
                                            ['front_button_color_option', '=', 'hover'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                            ['front_button_type', '!=', 'link'],
                                            ['front_appearance', '!=', 'gradient'],
                                        ],
                                    ],

                                    'front_flip_box_button_gradient_bg_hover' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_frontGROUND_COLOR'),
                                        'std' => [
                                            "color"  => "#0037DD",
                                            "color2" => "#3366FF",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['front_button_option', '=', 'color'],
                                            ['front_button_color_option', '=', 'hover'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                            ['front_button_type', '!=', 'link'],
                                            ['front_appearance', '=', 'gradient'],
                                        ],
                                    ],

                                    'front_flip_box_button_color_hover' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std' => '#FFFFFF',
                                        'depends' => [
                                            ['front_button_option', '=', 'color'],
                                            ['front_button_color_option', '=', 'hover'],
                                            ['front_add_button', '=', 1],
                                            ['front_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'front_button_text' => [
                                        'type' => 'text',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT'),
                                        'std'  => 'Button',
                                        'depends' => [
                                            ['front_button_outer_option', '=', 'typography'],
                                            ['front_add_button', '=', 1],
                                        ],
                                    ],

                                    'front_flip_box_button_typography' => [
                                        'type' => 'typography',
                                        'depends' => [
                                            ['front_button_outer_option', '=', 'typography'],
                                            ['front_add_button', '=', 1],
                                        ],
                                    ],

                                    'front_flip_box_button_link' => [
                                        'type' => 'link',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_LINK_OPTION'),
                                        'desc' => 'Link',
                                        'depends' => [
                                            ['front_button_outer_option', '=', 'link'],
                                            ['front_add_button', '=', 1],
                                        ],
                                    ],
                                ],
                            ],
                        ],

                        'back' => [
                            'fields' => [
                                [
                                    // title
                                    'back_add_title' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_TITLE'),
                                        'std' => 0,
                                        'group' => [
                                            'back_title_option',
                                            'back_title',
                                            'back_title_text_color',
                                            'back_title_typography'
                                        ]
                                    ],

                                    'back_title_option' => [
                                        'type' => 'buttons',
                                        'std' => 'title',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Title',
                                                'value' => 'title'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Typography',
                                                'value' => 'typography'
                                            ],
                                        ],
                                        'depends' => [
                                            ['back_add_title', '=', 1],
                                        ],
                                    ],

                                    'back_title' => [
                                        'type'  => 'text',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
                                        'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
                                        'depends' => [
                                            ['back_title_option', '=', 'title'],
                                            ['back_add_title', '=', 1],
                                        ],
                                    ],

                                    'back_title_text_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'depends' => [
                                            ['back_title_option', '=', 'color'],
                                            ['back_add_title', '=', 1],
                                        ],
                                    ],

                                    'back_title_typography' => [
                                        'type'     => 'typography',
                                        'depends' => [
                                            ['back_title_option', '=', 'typography'],
                                            ['back_add_title', '=', 1],
                                        ],
                                    ],

                                    // paragraph
                                    'back_add_paragraph' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_PARAGRAPH'),
                                        'std' => 0,
                                        'group' => [
                                            'back_paragraph_option',
                                            'back_paragraph',
                                            'back_paragraph_text_color',
                                            'back_paragraph_typography'
                                        ]
                                    ],

                                    'back_paragraph_option' => [
                                        'type' => 'buttons',
                                        'std' => 'title',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Title',
                                                'value' => 'title'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Typography',
                                                'value' => 'typography'
                                            ],
                                        ],
                                        'depends' => [
                                            ['back_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    'back_paragraph' => [
                                        'type'  => 'textarea',
                                        'title' => 'Paragraph',
                                        'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
                                        'depends' => [
                                            ['back_paragraph_option', '=', 'title'],
                                            ['back_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    'back_paragraph_text_color' => [
                                        'type'   => 'color',
                                        'title'  => 'Paragraph Color',
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'depends' => [
                                            ['back_paragraph_option', '=', 'color'],
                                            ['back_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    'back_paragraph_typography' => [
                                        'type'     => 'typography',
                                        'depends' => [
                                            ['back_paragraph_option', '=', 'typography'],
                                            ['back_add_paragraph', '=', 1],
                                        ],
                                    ],

                                    // icon
                                    'back_add_icon' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_ICON'),
                                        'std' => 0,
                                        'group' => [
                                            'back_icon_option',
                                            'back_icon',
                                            'back_icon_size',
                                            'back_global_background_type',
                                            'back_flip_box_icon_color',
                                            'back_flip_box_icon_gradient',
                                            'back_flip_box__margin',
                                            'back_flip_box__padding',
                                        ]
                                    ],

                                    'back_icon_option' => [
                                        'type' => 'buttons',
                                        'std' => 'icon',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Icon',
                                                'value' => 'icon'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Space',
                                                'value' => 'space'
                                            ],
                                        ],
                                        'depends' => [
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],

                                    'back_icon' => [
                                        'type'      => 'icon',
                                        'title'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON_NAME'),
                                        'std'       => 'fas fa-cogs',
                                        'depends' => [
                                            ['back_icon_option', '=', 'icon'],
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],

                                    'back_icon_size' => [
                                        'type'       => 'slider',
                                        'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON_SIZE'),
                                        'std'        => ['xl' => 36],
                                        'max'        => 400,
                                        'responsive' => true,
                                        'depends' => [
                                            ['back_icon_option', '=', 'icon'],
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],

                                    'back_global_background_type' => [
                                        'type' => 'buttons',
                                        'std' => 'none',
                                        'values' => [
                                            [
                                                'label' => 'None',
                                                'value' => 'none'
                                            ],
                                            [
                                                'label' => 'Solid',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Gradient',
                                                'value' => 'gradient'
                                            ],
                                        ],
                                        'depends' => [
                                            ['back_icon_option', '=', 'color'],
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],
                                    'back_flip_box_icon_color' => [
                                        'type'   => 'color',
                                        'title'  => 'Icon Color',
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'depends' => [
                                            ['back_global_background_type', '!=', 'none'],
                                            ['back_global_background_type', '!=', 'gradient'],
                                            ['back_icon_option', '=', 'color'],
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],
                                    'back_flip_box_icon_gradient' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
                                        'std' => [
                                            "color" => "#00c6fb",
                                            "color2" => "#005bea",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['back_global_background_type', '=', 'gradient'],
                                            ['back_icon_option', '=', 'color'],
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],

                                    'back_flip_box__margin' => [
                                        'type' => 'margin',
                                        'title' => 'Margin',
                                        'responsive' => true,
                                        'std' => '',
                                        'depends' => [
                                            ['back_icon_option', '=', 'space'],
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],

                                    'back_flip_box__padding' => [
                                        'type' => 'padding',
                                        'title' => 'Padding',
                                        'responsive' => true,
                                        'std' => '',
                                        'depends' => [
                                            ['back_icon_option', '=', 'space'],
                                            ['back_add_icon', '=', 1],
                                        ],
                                    ],

                                    // button
                                    'back_add_button' => [
                                        'type' => 'checkbox',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_ADD_BUTTON'),
                                        'std' => 0,
                                        'group' => [
                                            'back_button_outer_option',
                                            'back_button_option',
                                            'back_button_type',
                                            'back_appearance',
                                            'back_shape',
                                            'back_block',
                                            'back_button_size',
                                            'back_flip_box_icon',
                                            'back_flip_box_button_icon_position',
                                            'back_button_color_option',
                                            'back_flip_box_button_bg_color',
                                            'back_flip_box_button_bg_gradient',
                                            'back_flip_box_button_color',
                                            'back_flip_box_button_bg_color_hover',
                                            'back_flip_box_button_gradient_bg_hover',
                                            'back_flip_box_button_color_hover',
                                            'back_button_text',
                                            'back_flip_box_button_typography',
                                            'back_flip_box_button_link',
                                            'back_button_padding',
                                            'back_button_margin',
                                        ]
                                    ],

                                    'back_button_outer_option' => [
                                        'type' => 'buttons',
                                        'std' => 'button',
                                        'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Button',
                                                'value' => 'button'
                                            ],
                                            [
                                                'label' => 'Typography',
                                                'value' => 'typography'
                                            ],
                                            [
                                                'label' => 'Link',
                                                'value' => 'link'
                                            ],
                                        ],
                                        'tabs' => true,
                                        'depends' => [
                                            ['back_add_button', '=', 1],
                                        ],
                                    ],

                                    'back_button_option' => [
                                        'type' => 'buttons',
                                        'std' => 'style',
                                        // 'style' => 'neomorphic',
                                        'values' => [
                                            [
                                                'label' => 'Style',
                                                'value' => 'style'
                                            ],
                                            [
                                                'label' => 'Icon',
                                                'value' => 'icon'
                                            ],
                                            [
                                                'label' => 'Color',
                                                'value' => 'color',
                                                'depends' => [
                                                    ['back_button_type', '!=', 'default'],
                                                    ['back_button_type', '!=', 'primary'],
                                                    ['back_button_type', '!=', 'secondary'],
                                                    ['back_button_type', '!=', 'success'],
                                                    ['back_button_type', '!=', 'info'],
                                                    ['back_button_type', '!=', 'warning'],
                                                    ['back_button_type', '!=', 'danger'],
                                                    ['back_button_type', '!=', 'dark'],
                                                ],
                                            ],
                                        ],
                                        'tabs' => true,
                                        'depends' => [
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'back_button_type' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE_DESC'),
                                        'values' => [
                                            'default'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
                                            'primary'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
                                            'secondary' => Text::_('COM_SPPAGEBUILDER_GLOBAL_SECONDARY'),
                                            'success'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
                                            'info'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
                                            'warning'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
                                            'danger'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
                                            'dark'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_DARK'),
                                            'link'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
                                            'custom'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
                                        ],
                                        'inline' => true,
                                        'depends' => [
                                            ['back_button_option', '=', 'style'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                        'std'    => 'custom',
                                    ],

                                    'back_appearance' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
                                        'values' => [
                                            ''         => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
                                            'gradient' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_GRADIENT'),
                                            'outline'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
                                            // '3d' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_3D'), // will be removed
                                        ],
                                        'std'     => '',
                                        'depends' => [
                                            ['back_button_type', '!=', 'link'],
                                            ['back_button_option', '=', 'style'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                        'inline' => true,
                                    ],

                                    'back_shape' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
                                        'values' => [
                                            'rounded' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
                                            'square'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
                                            'round'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
                                        ],
                                        'std'   => 'rounded',
                                        'depends' => [
                                            ['back_button_type', '!=', 'link'],
                                            ['back_button_option', '=', 'style'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                        'inline' => true,
                                    ],

                                    'back_block' => [
                                        'type'   => 'radio',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK_DESC'),
                                        'values' => [
                                            ''               => Text::_('JNO'),
                                            'sppb-btn-block' => Text::_('JYES'),
                                        ],
                                        'depends' => [
                                            ['back_button_type', '!=', 'link'],
                                            ['back_button_option', '=', 'style'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'back_button_size' => [
                                        'type'   => 'select',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DESC'),
                                        'values' => [
                                            ''       => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DEFAULT'),
                                            'lg'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_LARGE'),
                                            'xlg'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_XLARGE'),
                                            'sm'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_SMALL'),
                                            'xs'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_EXTRA_SAMLL'),
                                            'custom' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
                                        ],
                                        'inline' => true,
                                        'depends' => [
                                            ['back_button_option', '=', 'style'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'back_button_padding' => [
                                        'type'    => 'padding',
                                        'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                        'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
                                        'depends' => [
                                            ['back_button_option', '=', 'style'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                            ['back_button_size', '=', 'custom'],
                                        ],
                                        'responsive' => true,
                                    ],

                                    'back_button_margin' => [
                                        'type'    => 'margin',
                                        'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                        'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_DESC'),
                                        'depends' => [
                                            ['back_button_option', '=', 'style'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                        'responsive' => true,
                                    ],

                                    'back_flip_box_icon' => [
                                        'type'  => 'icon',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
                                        'depends' => [
                                            ['back_button_option', '=', 'icon'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                    ],
                                    'back_flip_box_button_icon_position' => [
                                        'type'       => 'margin',
                                        'type'   => 'radio',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
                                        'values' => [
                                            'left'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                            'right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                                        ],
                                        'std' => 'left',
                                        'depends' => [
                                            ['back_button_option', '=', 'icon'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],

                                    ],

                                    'back_button_color_option' => [
                                        'type' => 'buttons',
                                        'std' => 'general',
                                        'style' => 'line',
                                        'values' => [
                                            [
                                                'label' => 'General',
                                                'value' => 'general'
                                            ],
                                            [
                                                'label' => 'Hover',
                                                'value' => 'hover'
                                            ],
                                        ],
                                        'depends' => [
                                            ['back_button_option', '=', 'color'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                        'tabs' => true,
                                    ],

                                    'back_flip_box_button_bg_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_BUTTON_BG_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std'     => '#3366FF',
                                        'depends' => [
                                            ['back_button_option', '=', 'color'],
                                            ['back_button_color_option', '=', 'general'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                            ['back_button_outer_option', '=', 'button'],
                                            ['back_button_type', '!=', 'link'],
                                            ['back_appearance', '!=', 'gradient'],
                                        ],
                                    ],

                                    'back_flip_box_button_bg_gradient' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                        'std' => [
                                            "color"  => "#3366FF",
                                            "color2" => "#0037DD",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['back_button_option', '=', 'color'],
                                            ['back_button_color_option', '=', 'general'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                            ['back_button_outer_option', '=', 'button'],
                                            ['back_button_type', '!=', 'link'],
                                            ['back_appearance', '=', 'gradient'],
                                        ],
                                    ],

                                    'back_flip_box_button_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std' => '#FFFFFF',
                                        'depends' => [
                                            ['back_button_option', '=', 'color'],
                                            ['back_button_color_option', '=', 'general'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'back_flip_box_button_bg_color_hover' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_BUTTON_BG_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std'     => '#0037DD',
                                        'depends' => [
                                            ['back_button_option', '=', 'color'],
                                            ['back_button_color_option', '=', 'hover'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                            ['back_button_type', '!=', 'link'],
                                            ['back_appearance', '!=', 'gradient'],
                                        ],
                                    ],

                                    'back_flip_box_button_gradient_bg_hover' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                        'std' => [
                                            "color"  => "#0037DD",
                                            "color2" => "#3366FF",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['back_button_option', '=', 'color'],
                                            ['back_button_color_option', '=', 'hover'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                            ['back_button_type', '!=', 'link'],
                                            ['back_appearance', '=', 'gradient'],
                                        ],
                                    ],

                                    'back_flip_box_button_color_hover' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR'),
                                        'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                                        'std' => '#FFFFFF',
                                        'depends' => [
                                            ['back_button_option', '=', 'color'],
                                            ['back_button_color_option', '=', 'hover'],
                                            ['back_add_button', '=', 1],
                                            ['back_button_outer_option', '=', 'button'],
                                        ],
                                    ],

                                    'back_button_text' => [
                                        'type' => 'text',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT'),
                                        'std'  => 'Button',
                                        'depends' => [
                                            ['back_button_outer_option', '=', 'typography'],
                                            ['back_add_button', '=', 1],
                                        ],
                                    ],

                                    'back_flip_box_button_typography' => [
                                        'type' => 'typography',
                                        'depends' => [
                                            ['back_button_outer_option', '=', 'typography'],
                                            ['back_add_button', '=', 1],
                                        ],
                                    ],

                                    'back_flip_box_button_link' => [
                                        'type' => 'link',
                                        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_LINK_OPTION'),
                                        'desc' => 'Link',
                                        'depends' => [
                                            ['back_button_outer_option', '=', 'link'],
                                            ['back_add_button', '=', 1],
                                        ],
                                    ],

                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'flip_box_bg_options' => [
                'action' => 'dropdown',
                'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_BG'),
                'type' => 'placeholder',
                'tooltip'     => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_BG'),
                'placeholder' => [
                    'type' => 'HTMLElement',
                    'element' => 'div',
                    'selector' => '.builder-color-picker',
                    'attribute' => [
                        'type' => 'style',
                        'property' => 'background',
                    ],
                    'display_field' => 'front_bgcolor',
                ],
                'fieldset' => [
                    'tab_groups' => [
                        'front' => [
                            'fields' => [
                                [
                                    'front_bg_type' => [
                                        'type' => 'buttons',
                                        'style' => 'neomorphic',
                                        'std' => 'image',
                                        'values' => [
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Image',
                                                'value' => 'image'
                                            ],
                                        ],
                                        'group' => [
                                            'front_bg_inner_type',
                                            'front_bg_color',
                                            'front_bg_gradient',
                                            'front_bgimg',
                                            'front_flip_box_radius'
                                        ],
                                    ],

                                    'front_bg_inner_type' => [
                                        'type' => 'buttons',
                                        'std' => 'none',
                                        'values' => [
                                            [
                                                'label' => 'None',
                                                'value' => 'none'
                                            ],
                                            [
                                                'label' => 'Solid',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Gradient',
                                                'value' => 'gradient'
                                            ],
                                        ],
                                        'depends' => [
                                            ['front_bg_type', '=', 'color'],
                                        ],
                                    ],
                                    'front_bg_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                                        'depends' => [
                                            ['front_bg_type', '=', 'color'],
                                            ['front_bg_inner_type', '=', 'color'],
                                        ],
                                    ],
                                    'front_bg_gradient' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
                                        'std' => [
                                            "color" => "#00c6fb",
                                            "color2" => "#005bea",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['front_bg_type', '=', 'color'],
                                            ['front_bg_inner_type', '=', 'gradient'],
                                        ],
                                    ],

                                    'front_flip_box_radius' => [
                                        'type' => 'advancedslider',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RADIUS'),
                                        'std' => 0,
                                    ],

                                    'front_bgimg' => [
                                        'type' => 'media',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_IMAGE'),
                                        'std' => ['src' => 'https://sppagebuilder.com/addons/flipbox/flipbox-bg-1.jpg'],
                                        'depends' => [
                                            ['front_bg_type', '=', 'image'],
                                        ],
                                    ],
                                ]
                            ]

                        ],

                        'back' => [
                            'fields' => [
                                [
                                    'back_bg_type' => [
                                        'type' => 'buttons',
                                        'style' => 'neomorphic',
                                        'std' => 'image',
                                        'values' => [
                                            [
                                                'label' => 'Color',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Image',
                                                'value' => 'image'
                                            ],
                                        ],
                                        'group' => [
                                            'back_bg_inner_type',
                                            'back_bg_color',
                                            'back_bg_gradient',
                                            'back_bgimg',
                                            'back_flip_box_radius'
                                        ],
                                    ],

                                    'back_bg_inner_type' => [
                                        'type' => 'buttons',
                                        'std' => 'none',
                                        'values' => [
                                            [
                                                'label' => 'None',
                                                'value' => 'none'
                                            ],
                                            [
                                                'label' => 'Solid',
                                                'value' => 'color'
                                            ],
                                            [
                                                'label' => 'Gradient',
                                                'value' => 'gradient'
                                            ],
                                        ],
                                        'depends' => [
                                            ['back_bg_type', '=', 'color'],
                                        ],
                                    ],
                                    'back_bg_color' => [
                                        'type'   => 'color',
                                        'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                                        'depends' => [
                                            ['back_bg_type', '=', 'color'],
                                            ['back_bg_inner_type', '=', 'color'],
                                        ],
                                    ],
                                    'back_bg_gradient' => [
                                        'type' => 'gradient',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
                                        'std' => [
                                            "color" => "#00c6fb",
                                            "color2" => "#005bea",
                                            "deg" => "45",
                                            "type" => "linear"
                                        ],
                                        'depends' => [
                                            ['back_bg_type', '=', 'color'],
                                            ['back_bg_inner_type', '=', 'gradient'],
                                        ],
                                    ],

                                    'back_flip_box_radius' => [
                                        'type' => 'advancedslider',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RADIUS'),
                                        'std' => 0,
                                    ],

                                    'back_bgimg' => [
                                        'type' => 'media',
                                        'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_IMAGE'),
                                        'std' => ['src' => 'https://sppagebuilder.com/addons/flipbox/flipbox-bg-1.jpg'],
                                        'depends' => [
                                            ['back_bg_type', '=', 'image'],
                                        ],
                                    ],
                                ]
                            ]
                        ],
                    ],
                ],
            ],

            'flip_box_functionality' => [
                'action' => 'dropdown',
                'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_FUNCTIONALITY'),
                'icon' => 'addon::flip_box',
                'tooltip' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIP_BOX_PRO_FUNCTIONALITY'),
                'fieldset' => [
                    'basic' => [
                        'flip_behavior' => [
                            'type' => 'select',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_FLIP_BHAVE'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_FLIP_BHAVE_DESC'),
                            'values' => [
                                'hover' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_FLIP_BHAVE_HOVER'),
                                'click' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_FLIP_BHAVE_CLICK'),
                            ],
                            'std' => 'hover',
                            'inline' => true,
                        ],

                        'flip_style' => [
                            'type' => 'select',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_STYLE'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_STYLE_DESC'),
                            'values' => [
                                'rotate_style' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_ROTATE_STYLE'),
                                'slide_style' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_SLIDE_STYLE'),
                                'fade_style' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_FADE_STYLE'),
                                'threeD_style' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_3D_STYLE'),
                            ],
                            'std' => 'flat_style',
                            'inline' => true,
                        ],

                        'rotate' => [
                            'type' => 'select',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_ROTATE'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_ROTATE_DESC'),
                            'values' => [
                                'flip_top' => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FROM_TOP'),
                                'flip_bottom' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BOTTOM'),
                                'flip_left' => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FROM_LEFT'),
                                'flip_right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                            ],
                            'std' => 'flip_right',
                            'inline' => true,
                            'depends' => [['flip_style', '!=', 'fade_style']],
                        ],

                        'height' => [
                            'type' => 'slider',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_HEIGHT'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FLIPBOX_HEIGHT_DESC'),
                            'std' => '',
                            'responsive' => true,
                            'max' => 1000,
                        ],

                    ],
                ],
            ],

            'flip_box_alignment_separator' => [
                'action' => 'separator',
            ],

            'flip_box_alignment_options' => [
                'action' => 'dropdown',
                'type' => 'placeholder',
                'style' => 'inline',
                'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALIGNMENT'),
                'showCaret' => true,
                'placeholder' => [
                    'type' => 'list',
                    'options' => [
                        'left' => ['icon' => 'textAlignLeft'],
                        'center' => ['icon' => 'textAlignCenter'],
                        'right' => ['icon' => 'textAlignRight'],
                    ],
                    'display_field' => 'text_align',
                ],
                'default' => [
                    'md' => 'left',
                    'sm' => 'center',
                    'xs' => 'right',
                ],
                'fieldset' => [
                    'basic' => [
                        'text_align' => [
                            'type' => 'alignment',
                            'inline' => true,
                            'responsive' => true,
                            'available_options' => ['left', 'center', 'right'],
                            'std' => [
                                'xxl' => '',
                                'xl' => 'left',
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

    'attr' => [],
]);
