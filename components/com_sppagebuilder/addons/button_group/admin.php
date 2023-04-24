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
        'type'       => 'general',
        'addon_name' => 'button_group',
        'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_GROUP'),
        'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_GROUP_DESC'),
        'category'   => 'Content',
        'icon'       => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 13a1 1 0 011-1h10a1 1 0 110 2H11a1 1 0 01-1-1z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M5 7c-1.648 0-3 1.352-3 3v8c0 1.648 1.352 3 3 3h3a1 1 0 110 2H5c-2.752 0-5-2.248-5-5v-8c0-2.752 2.248-5 5-5h22c2.752 0 5 2.248 5 5v8c0 2.752-2.248 5-5 5h-3a1 1 0 110-2h3c1.648 0 3-1.352 3-3v-8c0-1.648-1.352-3-3-3H5z" fill="currentColor"/><path opacity=".5" d="M16 17c-2.75 0-5 2.25-5 5s2.25 5 5 5 5-2.25 5-5-2.25-5-5-5zm2 5.625h-1.375V24c0 .375-.25.625-.625.625s-.625-.25-.625-.625v-1.375H14c-.375 0-.625-.25-.625-.625s.25-.625.625-.625h1.375V20c0-.375.25-.625.625-.625s.625.25.625.625v1.375H18c.375 0 .625.25.625.625s-.25.625-.625.625z" fill="currentColor"/></svg>',
        'inline' => [
            'buttons' => [
                'button_group_general_options' => [
                    'action'    => 'dropdown',
                    'icon'      => 'addon::button_group',
                    'tooltip'   => Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_GROUP'),
                    'fieldset'  => [
                        'content' => [
                            'margin' => [
                                'type'       => 'slider',
                                'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_GAP'),
                                'responsive' => true,
                                'max'        => 100,
                                'std'        => ['xl' => 5],
                            ],

                            'advanced_settings' => [
                                'type'   => 'advancedsettings',
                                'title'  => Text::_('Buttons'),
                                'buttonText' => 'Items',
                                'buttonIcon' => 'ul',
                            ],
                        ],
                    ],
                ],

                'button_add_new_item' => [
                    'action' => 'click',
                    'type' => 'plus',
                    'icon' => 'plusCircle',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ADD_NEW'),
                    'meta' => [
                        'key' => 'sp_button_group_item',
                        'title' => "Button",
                        'size' =>  '',
                        'block' => '',
                        'type' => 'primary'
                    ]
                ],

                'button_alignment_separator' => [
                    'action' => 'separator',
                ],

                'button_alignment_options' => [
                    'action'      => 'dropdown',
                    'type'        => 'placeholder',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALIGNMENT'),
                    'style'       => 'inline',
                    'showCaret'   => true,
                    'placeholder' => [
                        'type'    => 'list',
                        'options' => [
                            'left'   => ['icon' => 'textAlignLeft'],
                            'center' => ['icon' => 'textAlignCenter'],
                            'right'  => ['icon' => 'textAlignRight'],
                        ],
                        'display_field' => 'alignment'
                    ],
                    'default' => [
                        'xl' => 'left',
                    ],
                    'fieldset' => [
                        'basic' => [
                            'alignment' => [
                                'type'              => 'alignment',
                                'inline'            => true,
                                'responsive'        => true,
                                'available_options' => ['left', 'center', 'right'],
                                'std'               => [
                                    'xxl' => '',  'xl' => 'center', 'lg' => '', 'md' => '', 'sm' => '',  'xs' => ''
                                ]
                            ]
                        ]
                    ]
                ],
            ],
        ],
        
        
        'attr'       => [
            'general' => [
                // Repeatable Items
                'sp_button_group_item' => [
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_BUTTONS_ITEM'),
                    'attr'  => [
                        'tab' => [
                            'type'   => 'buttons',
                            'std'    => 'normal',
                            'values' => [
                                ['label' => 'Basic', 'value' => 'basic'],
                                ['label' => 'Icon', 'value' => 'icon'],
                                ['label' => 'Typography', 'value' => 'typography'],
                                ['label' => 'Link', 'value' => 'link'],
                                ['label' => 'Color', 'value' => 'color', 'depends' => [['type', '=', 'custom']]],
                            ],
                            'std'   => 'basic',
                            'tabs'    => true,
                        ],

                        'title' => [
                            'type'  => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                            'desc'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT_DESC'),
                            'inline' => true,
                            'std'   => 'Button',
                            'depends' => [['tab', '=', 'basic']]
                        ],

                        'type' => [
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
                            'std' => 'primary',
                            'depends' => [['tab', '=', 'basic']]
                        ],

                        'appearance' => [
                            'type'   => 'select',
                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
                            'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
                            'values' => [
                                ''         => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
                                'outline'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
                                'gradient' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_GRADIENT'),
                            ],
                            'inline' => true,
                            'std'     => 'flat',
                            'depends' => [
                                ['tab', '=', 'basic'],
                                ['type', '!=', 'link']
                            ]
                        ],

                        'shape' => [
                            'type'   => 'radio',
                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
                            'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
                            'values' => [
                                'rounded' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
                                'square'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
                                'round'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
                            ],
                            'depends' => [['tab', '=', 'basic']]
                        ],

                        'size' => [
                            'type'   => 'select',
                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE'),
                            'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DESC'),
                            'values' => [
                                ''    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DEFAULT'),
                                'lg'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_LARGE'),
                                'xlg' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_XLARGE'),
                                'sm'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_SMALL'),
                                'xs'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_EXTRA_SAMLL'),
                                'custom' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
                            ],
                            'inline' => true,
                            'depends' => [['tab', '=', 'basic']]
                        ],

                        'button_padding' => [
                            'type'    => 'padding',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
                            'responsive' => true,
                            'depends' => [
                                ['tab', '=', 'basic'],
                                ['type', '=', 'custom'],
                                ['size', '=', 'custom']
                            ]
                        ],

                        'block' => [
                            'type'   => 'radio',
                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
                            'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK_DESC'),
                            'values' => [
                                ''               => Text::_('JNO'),
                                'sppb-btn-block' => Text::_('JYES'),
                            ],
                            'depends' => [['tab', '=', 'basic']]
                        ],

                        // icon
                        'icon' => [
                            'type'  => 'icon',
                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
                            'desc'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_DESC'),
                            'depends' => [['tab', '=', 'icon']]
                        ],

                        'icon_position' => [
                            'type'   => 'radio',
                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
                            'values' => [
                                'left'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                'right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                            ],
                            'depends' => [['tab', '=', 'icon']],
                            'std'     => 'left'

                        ],

                        // typography
                        'typography' => [
                            'type'     => 'typography',
                            'fallbacks' => [
                                'font' => 'font_family',
                                'size' => 'fontsize',
                                'letter_spacing' => 'letterspace',
                                'weight' => 'font_style.weight',
                                'italic' => 'font_style.italic',
                                'underline' => 'font_style.underline',
                                'uppercase' => 'font_style.uppercase',
                            ],
                            'depends' => [['tab', '=', 'typography']]
                        ],

                        // link
                        'url' => [
                            'type'         => 'link',
                            'title'        => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL'),
                            'desc'         => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL_DESC'),
                            'mediaType'    => 'attachment',
                            'depends'      => [['tab', '=', 'link']]
                        ],

                        // 'target' => [
                        //     'type'   => 'select',
                        //     'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB'),
                        //     'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB_DESC'),
                        //     'values' => [
                        //         ''       => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
                        //         '_blank' => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
                        //     ],
                        //     'depends' => [
                        //         ['url', '!=', ''],
                        //     ]
                        // ],

                        // 'font_family' => [
                        //     'type'     => 'fonts',
                        //     'title'    => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FONT_FAMILY'),
                        //     'selector' => [
                        //         'type' => 'font',
                        //         'font' => '{{ VALUE }}',
                        //         'css'  => '.sppb-btn { font-family: "{{ VALUE }}"; }'
                        //     ]
                        // ],
                        
                        // 'font_style' => [
                        //     'type'  => 'fontstyle',
                        //     'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_FONT_STYLE'),
                        //     'std'   => ''
                        // ],

                        // 'letterspace' => [
                        //     'type'   => 'select',
                        //     'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_LETTER_SPACING'),
                        //     'values' => [
                        //         '0'    => 'Default',
                        //         '1px'  => '1px',
                        //         '2px'  => '2px',
                        //         '3px'  => '3px',
                        //         '4px'  => '4px',
                        //         '5px'  => '5px',
                        //         '6px'  => '6px',
                        //         '7px'  => '7px',
                        //         '8px'  => '8px',
                        //         '9px'  => '9px',
                        //         '10px' => '10px'
                        //     ],
                        //     'std' => '0'
                        // ],
                        

                        // 'fontsize' => [
                        //     'type'       => 'slider',
                        //     'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
                        //     'std'        => ['md' => 16],
                        //     'responsive' => true,
                        //     'max'        => 400,
                        //     'depends'    => [
                        //         ['type', '=', 'custom'],
                        //     ]
                        // ],

                        'button_status' => [
                            'type'   => 'buttons',
                            'std'    => 'normal',
                            'values' => [
                                ['label' => 'Normal', 'value' => 'normal'],
                                ['label' => 'Hover', 'value' => 'hover'],
                            ],
                            'tabs'    => true,
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'custom'],
                            ]
                        ],

                        'color' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_DESC'),
                            'std'     => '#fff',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'custom'],
                                ['button_status', '=', 'normal'],
                            ],
                        ],

                        'background_color' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                            'std'     => '#444444',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['appearance', '!=', 'gradient'],
                                ['type', '=', 'custom'],
                                ['button_status', '=', 'normal'],
                            ]
                        ],

                        'background_gradient' => [
                            'type'  => 'gradient',
                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                            'std'   => [
                                "color"  => "#3366FF",
                                "color2" => "#0037DD",
                                "deg"    => "45",
                                "type"   => "linear"
                            ],
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['appearance', '=', 'gradient'],
                                ['type', '=', 'custom'],
                                ['button_status', '=', 'normal'],
                            ]
                        ],

                        'color_hover' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
                            'std'     => '#fff',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'custom'],
                                ['button_status', '=', 'hover'],
                            ],
                        ],

                        'background_color_hover' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                            'std'     => '#222',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['appearance', '!=', 'gradient'],
                                ['type', '=', 'custom'],
                                ['button_status', '=', 'hover'],
                            ]
                        ],

                        'background_gradient_hover' => [
                            'type'  => 'gradient',
                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                            'std'   => [
                                "color"  => "#0037DD",
                                "color2" => "#3366FF",
                                "deg"    => "45",
                                "type"   => "linear"
                            ],
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['appearance', '=', 'gradient'],
                                ['type', '=', 'custom'],
                                ['button_status', '=', 'hover'],
                            ]
                        ],

                        //Link Button Style
                        // 'link_button_status' => [
                        //     'type'   => 'buttons',
                        //     'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE'),
                        //     'std'    => 'normal',
                        //     'values' => [
                        //         [
                        //             'label' => 'Normal',
                        //             'value' => 'normal'
                        //         ],
                        //         [
                        //             'label' => 'Hover',
                        //             'value' => 'hover'
                        //         ],
                        //     ],
                        //     'tabs'    => true,
                        //     'depends' => [
                        //         ['type', '=', 'link'],
                        //     ]
                        // ],

                        'link_button_status' => [
                            'type'   => 'buttons',
                            'std'    => 'normal',
                            'values' => [
                                ['label' => 'Normal', 'value' => 'normal'],
                                ['label' => 'Hover', 'value' => 'hover'],
                            ],
                            'tabs'    => true,
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'link'],
                            ],
                        ],

                        'link_button_color' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'link'],
                                ['link_button_status', '=', 'normal'],
                            ]
                        ],

                        'link_button_border_width' => [
                            'type'    => 'slider',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                            'max'     => 30,
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'link'],
                                ['link_button_status', '=', 'normal'],
                            ]
                        ],

                        'link_border_color' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                            'std'     => '',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'link'],
                                ['link_button_status', '=', 'normal'],
                            ]
                        ],

                        'link_button_padding_bottom' => [
                            'type'    => 'slider',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_PADDING_BOTTOM'),
                            'max'     => 100,
                            'std'     => '',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'link'],
                                ['link_button_status', '=', 'normal'],
                            ]
                        ],

                        //Link Hover
                        'link_button_hover_color' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
                            'std'     => '',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'link'],
                                ['link_button_status', '=', 'hover'],
                            ]
                        ],

                        'link_button_border_hover_color' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                            'std'     => '',
                            'depends' => [
                                ['tab', '=', 'color'],
                                ['type', '=', 'link'],
                                ['link_button_status', '=', 'hover'],
                            ]
                        ],
                    ],
                ],
            ],
        ],
    ]
);
