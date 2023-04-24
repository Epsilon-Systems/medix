<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

SpAddonsConfig::addonConfig(
    [
        'type' => 'repeatable',
        'addon_name' => 'form_builder',
        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER'),
        'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_DESC'),
        'category' => 'Content',
        'icon' => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2 4a4 4 0 014-4h17a4 4 0 014 4v13a1 1 0 11-2 0V4a2 2 0 00-2-2H6a2 2 0 00-2 2v22a2 2 0 002 2h8.5a1 1 0 110 2H6a4 4 0 01-4-4V4z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M21 8a1 1 0 01-1 1H9a1 1 0 110-2h11a1 1 0 011 1zM21 13a1 1 0 01-1 1H9a1 1 0 110-2h11a1 1 0 011 1zM15 18a1 1 0 01-1 1H9a1 1 0 110-2h5a1 1 0 011 1z" fill="currentColor"/><path opacity=".5" d="M29.38 26.843l-1.166-.673a5.272 5.272 0 000-1.921l1.166-.674a.33.33 0 00.15-.383 6.816 6.816 0 00-1.497-2.589.33.33 0 00-.405-.063l-1.166.673a5.166 5.166 0 00-1.664-.96v-1.344a.328.328 0 00-.257-.32 6.881 6.881 0 00-2.989 0 .328.328 0 00-.257.32v1.346a5.328 5.328 0 00-1.664.961l-1.163-.673a.325.325 0 00-.405.063 6.775 6.775 0 00-1.498 2.589.327.327 0 00.15.383l1.167.673a5.276 5.276 0 000 1.922l-1.166.673a.33.33 0 00-.15.383 6.817 6.817 0 001.497 2.59.33.33 0 00.405.063l1.166-.674c.49.422 1.053.747 1.664.96v1.348c0 .153.106.287.257.32a6.88 6.88 0 002.989 0 .328.328 0 00.257-.32v-1.347a5.328 5.328 0 001.664-.96l1.166.672a.325.325 0 00.405-.062 6.776 6.776 0 001.497-2.59.338.338 0 00-.153-.386zm-6.333.556a2.193 2.193 0 01-2.19-2.19c0-1.207.983-2.19 2.19-2.19 1.207 0 2.19.983 2.19 2.19 0 1.207-.983 2.19-2.19 2.19z" fill="currentColor"/></svg>',
        'inline'     => [
            'buttons' => [
                'form_builder_general_options' => [
                    'action'   => 'dropdown',
                    'icon'     => 'addon::form_builder',
                    'tooltip'     => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER'),
                    'fieldset' => [
                        'tab_groups' => [
                            'items' => [
                                'fields' => [
                                    [
                                        'field_gutter' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_STYLE_GUTTER'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_STYLE_GUTTER_DESC'),
                                            'max' => 200,
                                            'responsive' => true,
                                            'std' => ['xl' => 15],
                                        ],
                        
                                        'field_horizontal_space' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_STYLE_HORI_GAP'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_STYLE_HORI_GAP_DESC'),
                                            'max' => 200,
                                            'responsive' => true,
                                        ],

                                        'advanced_settings' => [
                                            'type'   => 'advancedsettings',
                                            'title'  => Text::_('Items'),
                                            'buttonText' => Text::_('COM_SPPAGEBUILDER_ADDON_ITEM_ADD_EDIT'),
                                            'buttonIcon' => 'ul',
                                        ],
                                    ],
                                ],
                            ],

                            'field' => [
                                'fields' => [
                                    [
                                        'input_height' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_INPUT_HEIGHT'),
                                            'max' => 200,
                                            'responsive' => true,
                                        ],
                        
                                        'textarea_height' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_TEXTAREA_HEIGHT'),
                                            'max' => 1000,
                                            'responsive' => true,
                                        ],

                                        'field_border_radius' => [
                                            'type' => 'slider',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_INPUT_BORDER_RADIUS'),
                                            'max' => 200,
                                        ],
                        
                                        'field_padding' => [
                                            'type' => 'padding',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
                                            'responsive' => true,
                                        ],

                                        'label_margin' => [
                                            'type' => 'margin',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_LABEL_MARGIN'),
                                            'responsive' => true,
                                        ],
                                    ],
                                ],
                            ],

                            'messages' => [
                                'fields' => [
                                    [
                                        'required_field_message' => [
                                            'type' => 'text',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_REQUIRED_MESSAGE'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_REQUIRED_MESSAGE_DESC'),
                                            'std' => 'Please fill the required field.',
                                        ],
                        
                                        'success_message' => [
                                            'type' => 'textarea',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_SUCCESS_MESSAGE'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_SUCCESS_MESSAGE_DESC'),
                                            'std' => 'Email successfully sent!',
                                        ],
                        
                                        'failed_message' => [
                                            'type' => 'textarea',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FAILED_MESSAGE'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FAILED_MESSAGE_DESC'),
                                            'std' => 'Email sent failed, fill required field and try again!',
                                        ],
                                    ],
                                ],
                            ],

                            'options' => [
                                'fields' => [
                                    [
                                        'enable_redirect' => [
                                            'type' => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_REDIRECT'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_REDIRECT_DESC'),
                                            'std' => 0,
                                        ],
                        
                                        'redirect_url' => [
                                            'type' => 'text',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_REDIRECT_URL'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_REDIRECT_URL_DESC'),
                                            'inline'    => true,
                                            'depends' => [['enable_redirect', '=', 1]],
                                        ],

                                        'enable_captcha' => [
                                            'type' => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_SHOW_RECAPTCHA'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_SHOW_RECAPTCHA_DESC'),
                                            'std' => 1,
                                        ],

                                        'captcha_type' => [
                                            'type' => 'select',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CAPTCHA_TYPE'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CAPTCHA_TYPE_DESC'),
                                            'values' => [
                                                'default' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CAPTCHA_TYPE_DEFAULT'),
                                                'gcaptcha' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CAPTCHA_TYPE_GCHAPTCHA'),
                                                'igcaptcha' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CAPTCHA_TYPE_INVISIBLE_GCHAPTCHA'),
                                            ],
                                            'std' => 'default',
                                            'inline'    => true,
                                            'depends' => [['enable_captcha', '=', 1]],
                                        ],

                                        'captcha_question' => [
                                            'type' => 'text',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_CAPTCHA_QUESTION'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_CAPTCHA_QUESTION_DESC'),
                                            'std' => '3 + 4 = ?',
                                            'inline'    => true,
                                            'depends' => [
                                                ['enable_captcha', '=', 1],
                                                ['captcha_type', '=', 'default'],
                                            ],
                                        ],

                                        'captcha_answer' => [
                                            'type' => 'text',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_CAPTCHA_ANSWER'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_CAPTCHA_ANSWER_DESC'),
                                            'std' => '7',
                                            'inline'    => true,
                                            'depends' => [
                                                ['enable_captcha', '=', 1],
                                                ['captcha_type', '=', 'default'],
                                            ],
                                        ],

                                        'enable_policy' => [
                                            'type' => 'checkbox',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_POLICY'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_POLICY_DESC'),
                                            'std' => 0,
                                        ],
                        
                                        'policy_text' => [
                                            'type' => 'textarea',
                                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_POLICY_TEXT'),
                                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_POLICY_TEXT_DESC'),
                                            'std' => 'I agree with the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a> and I declare that I have read the information that is required in accordance with <a href="http://eur-lex.europa.eu/legal-content/EN/TXT/?uri=uriserv:OJ.L_.2016.119.01.0001.01.ENG&amp;toc=OJ:L:2016:119:TOC" target="_blank">Article 13 of GDPR.</a>',
                                            'depends' => [['enable_policy', '=', 1]],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                'form_builder_add_new_item' => [
                    'action' => 'click',
                    'type' => 'plus',
                    'icon' => 'plusCircle',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ADD_NEW'),
                    'meta' => [
                        'key' => 'sp_form_builder_item',
                        'title' => 'Form Item',
                        'field_type' => 'text',
                        'field_name' => 'First Name',
                        'field_placeholder' => 'First Name',
                        'field_width' => 'First Name',
                        'field_name' => 'First Name',
                    ]
                ],

                'form_builder_typography_options' => [
                    'type'     => 'icon-text',
                    'icon'     => 'typography',
                    'action'   => 'dropdown',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_TYPOGRAPHY'),
                    'fieldset' => [
                        'tab_groups' => [
                            'field' => [
                                'fields' => [
                                    [
                                        'field_typography' => [
                                            'type'      => 'typography',
                                            'fallbacks' => [
                                                'size'           => 'field_font_size',
                                            ],
                                        ],
                                    ],
                                ],
                            ],

                            'label' => [
                                'fields' => [
                                    [
                                        'label_typography' => [
                                            'type'     => 'typography',
                                            'fallbacks' => [
                                                'size' => 'label_font_size',
                                                'weight' => 'label_font_style.weight',
                                                'italic' => 'label_font_style.italic',
                                                'underline' => 'label_font_style.underline',
                                                'uppercase' => 'label_font_style.uppercase',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                'form_builder_color_options' => [
                    'action'  => 'dropdown',
                    'type'    => 'placeholder',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                    'placeholder' => [
                        'type'      => 'HTMLElement',
                        'element'   => 'div',
                        'selector'  => '.builder-color-picker',
                        'attribute' => [
                            'type'     => 'style',
                            'property' => 'background'
                        ],
                        'display_field' => 'field_bg_color',
                    ],
                    'fieldset' => [
                        'tab_groups' => [
                            'field' => [
                                'fields' => [
                                    'normal' => [
                                        'field_bg_color' => [
                                            'type'   => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                        ],

                                        'field_color' => [
                                            'type'   => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT'),
                                        ],

                                        'field_placeholder_color' => [
                                            'type'   => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_PLACEHOLDER'),
                                        ],

                                        'field_placeholder_separator' => [
                                            'type'  => 'separator'
                                        ],

                                        'field_border_width' => [
                                            'type' => 'margin',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                                        ],

                                        'field_border_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                                        ],
                                    ],

                                    'hover' => [
                                        'field_hover_bg_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND'),
                                        ],
                        
                                        'field_hover_placeholder_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_PLACEHOLDER'),
                                        ],
                        
                                        'field_focus_border_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                                        ],
                                    ],
                                ],
                            ],

                            'others' => [
                                'fields' => [
                                    [
                                        'radio_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RADIO'),
                                        ],

                                        'checkbox_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CHECKBOX'),
                                        ],

                                        'label_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LABEL'),
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                'form_builder_button_options' => [
                    'action'   => 'dropdown',
                    'icon'     => 'button',
                    'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON'),
                    'fieldset' => [
                        'tab_groups' => [
                            'basic' => [
                                'fields' => [
                                    'button' => [
                                        'btn_text' => [
                                            'type'  => 'text',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LABEL'),
                                            'inline' => true,
                                            'std' => 'Send Message',
                                        ],
                            
                                        'btn_type' => [
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
                                            'std'   => 'custom',
                                            'inline' => true,
                                        ],
                            
                                        'btn_appearance' => [
                                            'type'   => 'select',
                                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
                                            'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
                                            'values' => [
                                                ''         => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
                                                'gradient' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_GRADIENT'),
                                                'outline'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
                                            ],
                                            'std'   => '',
                                            'inline' => true,
                                            'depends' => [['btn_type', '!=', 'link']]
                                        ],
                            
                                        'btn_shape' => [
                                            'type'   => 'select',
                                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
                                            'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
                                            'values' => [
                                                'rounded' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
                                                'square'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
                                                'round'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
                                            ],
                                            'std'   => 'square',
                                            'inline' => true,
                                            'depends' => [['btn_type', '!=', 'link']]
                                        ],
    
                                        'link_button_padding_bottom' => [
                                            'type'    => 'slider',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_PADDING_BOTTOM'),
                                            'max'     => 100,
                                            'std'     => '',
                                            'depends' => [['btn_type', '=', 'link']]
                                        ],
                                    ],
    
                                    'options' => [
                                        'btn_size' => [
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
                                            'std'   => '',
                                        ],
                            
                                        'btn_padding' => [
                                            'type'    => 'padding',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                            'responsive' => true,
                                            'std' => ['xxl' =>'', 'xl' =>'8px 22px 10px 22px', 'lg' =>'', 'md' =>'', 'sm' =>'', 'xs' =>''],
                                            'depends' => [['btn_type', '=', 'custom']]
                                        ],
                            
                                        'btn_block' => [
                                            'type'   => 'radio',
                                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
                                            'values' => [
                                                ''               => Text::_('JNO'),
                                                'sppb-btn-block' => Text::_('JYES'),
                                            ],
                                            'std'     => '',
                                            'depends' => [['btn_type', '!=', 'link']]
                                        ],

                                        'btn_position' => [
                                            'type'	=> 'alignment',
                                            'title'	=> Text::_('COM_SPPAGEBUILDER_GLOBAL_POSITION'),
                                        ],
                            
                                        'btn_margin' => [
                                            'type'        => 'margin',
                                            'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                            'responsive'  => true,
                                        ],
                                    ],
                                ],
                            ],
    
                            'icon' => [
                                'fields' => [
                                    [
                                        'btn_icon' => [
                                            'type'  => 'icon',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
                                            'desc'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_DESC'),
                                        ],
                            
                                        'btn_icon_position' => [
                                            'type'   => 'radio',
                                            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
                                            'values' => [
                                                'left'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                                'right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                                            ],
                                            'std' => 'left',
                                        ],
                                    ],
                                ],
                            ],
    
                            'typography' => [
                                'fields' => [
                                    [
                                        'btn_typography' => [
                                            'type'     => 'typography',
                                            'fallbacks' => [
                                                'font' => 'btn_font_family',
                                                'size' => 'btn_fontsize',
                                                'letter_spacing' => 'btn_letterspace',
                                                'weight' => 'btn_font_style.weight',
                                                'italic' => 'btn_font_style.italic',
                                                'underline' => 'btn_font_style.underline',
                                                'uppercase' => 'btn_font_style.uppercase',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
    
                            'color' => [
                                'fields' => [
                                    'normal' => [
                                        'btn_color' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
                                            'std' => '#FFFFFF',
                                            'depends' => [['btn_type', '=', 'custom']],
                                        ],
                            
                                        'btn_background_color' => [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                            'std'     => '#3366FF',
                                            'depends' => [
                                                ['btn_appearance', '!=', 'gradient'],
                                                ['btn_type', '=', 'custom'],
                                            ],
                                        ],
                            
                                        'btn_background_gradient' => [
                                            'type' => 'gradient',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                            'std' => [
                                                "color"  => "#3366FF",
                                                "color2" => "#0037DD",
                                                "deg" => "45",
                                                "type" => "linear"
                                            ],
                                            'depends' => [
                                                ['btn_appearance', '=', 'gradient'],
                                                ['btn_type', '=', 'custom'],
                                            ],
                                        ],
                            
                                        // link button
                                        'link_button_color' => [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
                                            'depends' => [['btn_type', '=', 'link']]
                                        ],
                            
                                        'link_button_border_width' => [
                                            'type'    => 'slider',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                                            'max'     => 30,
                                            'depends' => [['btn_type', '=', 'link']]
                                        ],
                            
                                        'link_button_border_color' => [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                                            'std'     => '',
                                            'depends' => [['btn_type', '=', 'link']]
                                        ],
                                    ],
    
                                    'hover' => [
                                        'btn_color_hover' => [
                                            'type' => 'color',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
                                            'std' => '#FFFFFF',
                                            'depends' => [
                                                ['btn_type', '=', 'custom'],
                                            ],
                                        ],
                            
                                        'btn_background_color_hover' => [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                            'std'     => '#0037DD',
                                            'depends' => [
                                                ['btn_appearance', '!=', 'gradient'],
                                                ['btn_type', '=', 'custom'],
                                            ],
                                        ],
                            
                                        'btn_background_gradient_hover' => [
                                            'type' => 'gradient',
                                            'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                            'std' => [
                                                "color"  => "#0037DD",
                                                "color2" => "#3366FF",
                                                "deg" => "45",
                                                "type" => "linear"
                                            ],
                                            'depends' => [
                                                ['btn_appearance', '=', 'gradient'],
                                                ['btn_type', '=', 'custom']
                                            ],
                                        ],
                                        
                                        'link_button_hover_color' => [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
                                            'std'     => '',
                                            'depends' => [['btn_type', '=', 'link']]
                                        ],
    
                                        'link_button_border_hover_color' => [
                                            'type'    => 'color',
                                            'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                                            'std'     => '',
                                            'depends' => [['btn_type', '=', 'link']]
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        
        'attr' => [
            'general' => [
                'sp_form_builder_item' => [
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_ITEMS'),
                    'std' => [
                        [
                            'title' => 'First Name',
                            'field_name' => 'first-name',
                            'field_placeholder' => 'First Name',
                            'field_type' => 'text',
                            'field_width' => ['xxl' => 50, 'xl' => 50, 'lg' => 50, 'md' => 50, 'sm' => 100, 'xs' => 100],
                        ],
                        [
                            'title' => 'Last Name',
                            'field_name' => 'last-name',
                            'field_placeholder' => 'Last Name',
                            'field_type' => 'text',
                            'field_width' => ['xxl' => 50, 'xl' => 50, 'lg' => 50, 'md' => 50, 'sm' => 100, 'xs' => 100],
                        ],
                        [
                            'title' => 'Email',
                            'field_name' => 'email',
                            'field_placeholder' => 'Email',
                            'field_type' => 'email',
                            'field_is_required' => 1,
                            'field_required_star' => 1,
                            'field_width' => ['xxl' => 50, 'xl' => 50, 'lg' => 50, 'md' => 50, 'sm' => 100, 'xs' => 100],
                        ],
                        [
                            'title' => 'Subject',
                            'field_name' => 'subject',
                            'field_placeholder' => 'Subject',
                            'field_type' => 'text',
                            'field_width' => ['xxl' => 50, 'xl' => 50, 'lg' => 50, 'md' => 50, 'sm' => 100, 'xs' => 100],
                        ],
                        [
                            'title' => 'Message',
                            'field_name' => 'message',
                            'field_placeholder' => 'Message',
                            'field_type' => 'textarea',
                            'field_is_required' => 1,
                            'field_required_star' => 1,
                            'field_width' => ['xxl' => 100, 'xl' => 100, 'lg' => 100, 'md' => 100, 'sm' => 100, 'xs' => 100],
                        ],
                    ],
                    'attr' => [
                        'field_type' => [
                            'type' => 'select',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_TYPE'),
                            'values' => [
                                'text' => 'Text',
                                'email' => 'Email',
                                'tel' => 'Phone',
                                'textarea' => 'Textarea',
                                'radio' => 'Radio',
                                'checkbox' => 'Checkbox',
                                'select' => 'Select',
                                'date' => 'Date',
                                'range' => 'Range',
                                'number' => 'Number',
                            ],
                            'std' => 'text',
                        ],
                        'title' => [
                            'type' => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_LABEL'),
                            'std' => 'Item 1',
                        ],
                        'field_name' => [
                            'type' => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NAME'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NAME_DESC'),
                            'depends' => [
                                ['field_type', '!=', 'checkbox'],
                            ],
                            'std' => 'First Name',
                        ],
                        'field_placeholder' => [
                            'type' => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_PLACEHOLDER'),
                            'depends' => [
                                ['field_type', '!=', 'radio'],
                                ['field_type', '!=', 'checkbox'],
                                ['field_type', '!=', 'date'],
                                ['field_type', '!=', 'range'],
                            ],
                            'std' => 'First Name',
                        ],
                        'field_width' => [
                            'type' => 'slider',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_WIDTH'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_WIDTH_DESC'),
                            'max' => 100,
                            'responsive' => true,
                            'std' => ['xl' => 50],
                        ],
                        'tel_pattern' => [
                            'type' => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_TEL_PATTERN'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_TEL_PATTERN_DESC'),
                            'depends' => [
                                ['field_type', '=', 'tel'],
                            ],
                            'std' => '^\+(?:[0-9]●?){6,14}[0-9]$',
                        ],
                        'range_min' => [
                            'type' => 'number',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RANGE_MIN'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RANGE_MIN_DESC'),
                            'depends' => [
                                ['field_type', '=', 'range'],
                            ],
                        ],
                        'range_max' => [
                            'type' => 'number',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RANGE_MAX'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RANGE_MAX_DESC'),
                            'depends' => [
                                ['field_type', '=', 'range'],
                            ],
                        ],
                        'range_step' => [
                            'type' => 'number',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RANGE_STEP'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RANGE_STEP_DESC'),
                            'depends' => [
                                ['field_type', '=', 'range'],
                            ],
                        ],
                        'number_min' => [
                            'type' => 'number',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NUMBER_MIN'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NUMBER_MIN_DESC'),
                            'depends' => [
                                ['field_type', '=', 'number'],
                            ],
                        ],
                        'number_max' => [
                            'type' => 'number',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NUMBER_MAX'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NUMBER_MAX_DESC'),
                            'depends' => [
                                ['field_type', '=', 'number'],
                            ],
                        ],
                        'number_step' => [
                            'type' => 'number',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NUMBER_STEP'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NUMBER_STEP_DESC'),
                            'depends' => [
                                ['field_type', '=', 'number'],
                            ],
                        ],                        
                        'minimum_character' => [
                            'type' => 'slider',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_MINIMUM_CHARACTERS'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_MINIMUM_CHARACTERS_DESC'),
                            'depends' => [
                                ['field_type', '=', 'textarea']
                            ]
                        ],
                        'maximum_character' => [
                            'type' => 'slider',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_MAXIMUM_CHARACTERS'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_MAXIMUM_CHARACTERS_DESC'),
                            'depends' => [
                                ['field_type', '=', 'textarea']
                            ]
                        ],
                        'sp_form_builder_inner_item_radio' => [
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RADIO_ITEMS'),
                            'type' => 'repeatable',
                            'depends' => [
                                ['field_type', '=', 'radio'],
                            ],
                            'attr' => [
                                //inner item title
                                'title' => [
                                    'type' => 'text',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_RADIO'),
                                    'std' => 'Radio',
                                ],
                                'is_radio_checked' => [
                                    'type' => 'checkbox',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_CHECKED'),
                                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_CHECKED_DESC'),
                                    'std' => 0,
                                ],
                            ],
                        ],
                        'sp_form_builder_inner_item_checkbox' => [
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_CHECKBOX_ITEMS'),
                            'type' => 'repeatable',
                            'depends' => [
                                ['field_type', '=', 'checkbox'],
                            ],
                            'attr' => [
                                //Admin label
                                'title' => [
                                    'type' => 'text',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_CHECKBOX'),
                                    'std' => 'Checkbox',
                                ],
                                'checkbox_field_name' => [
                                    'type' => 'text',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NAME'),
                                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_NAME_DESC'),
                                    'std' => 'checkbox-1',
                                ],
                                'checkbox_is_required' => [
                                    'type' => 'checkbox',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_IS_REQUIRED'),
                                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_IS_REQUIRED_DESC'),
                                    'std' => 0,
                                ],
                                'is_checkbox_checked' => [
                                    'type' => 'checkbox',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_CHECKED'),
                                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_CHECKED_DESC'),
                                    'std' => 0,
                                ],
                            ],
                        ],
                        'sp_form_builder_inner_item_select' => [
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_SELECT_ITEMS'),
                            'type' => 'repeatable',
                            'depends' => [
                                ['field_type', '=', 'select'],
                            ],
                            'attr' => [
                                //inner item title
                                'title' => [
                                    'type' => 'text',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_SELECT'),
                                    'std' => 'Select',
                                ],
                                'is_selected' => [
                                    'type' => 'checkbox',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_SELECT'),
                                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_SELECT_DESC'),
                                    'std' => 0,
                                ],
                            ],
                        ],
                        'is_resize' => [
                            'type' => 'checkbox',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_RESIZE'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_IS_RESIZE_DESC'),
                            'depends' => [
                                ['field_type', '=', 'textarea'],
                            ],
                            'std' => 0,
                        ],
                        'field_is_required' => [
                            'type' => 'checkbox',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_IS_REQUIRED'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_IS_REQUIRED_DESC'),
                            'depends' => [
                                ['field_type', '!=', 'checkbox'],
                            ],
                            'std' => 0,
                        ],
                        'field_required_star' => [
                            'type' => 'checkbox',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_REQUIRED_STAR'),
                            'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FIELD_REQUIRED_STAR_DESC'),
                            'depends' => [
                                ['title', '!=', ''],
                            ],
                            'std' => 1,
                        ],
                    ],
                ],   

                // email template
                'toggle_email_template' => [
                    'type'  => 'header',
                    'style' => 'toggle',
                    'uuid'  => 'toggle_email_template',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_EMAIL_TEMPLATE'),
                    'group' => [
                        'recipient_email',
                        'additional_header',
                        'from',
                        'email_subject',
                        'email_template',
                    ],
                ],

                'recipient_email' => [
                    'type'  => 'text',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_RECIPIENT_EMAIL'),
                    'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_RECIPIENT_EMAIL_DESC'),
                ],

                'additional_header' => [
                    'type'  => 'textarea',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_ADDITIONAL_HEADER'),
                    'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_ADDITIONAL_HEADER_DESC'),
                    'std'   => "Reply-To: {{email}}\nReply-name: {{first-name}} {{last-name}}\nCc: {{email}}",
                ],

                'from' => [
                    'type'  => 'text',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_FORM_EMAIL'),
                    'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_FORM_EMAIL_DESC'),
                    'placeholder' => 'mail@yourhost.com',
                ],

                'email_subject' => [
                    'type'  => 'text',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_SUBJECT'),
                    'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_AJAX_CONTACT_SUBJECT_DESC'),
                    'std'   => '{{subject}} | {{site-name}}',
                ],
                
                'email_template' => [
                    'type'  => 'textarea',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FORM_TEMPLATE'),
                    'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_FORM_BUILDER_FORM_TEMPLATE_DESC'),
                    'std'   => "<p><strong>From:</strong>{{first-name}} {{last-name}}</p>\n<p><strong>Email:</strong>{{email}}</p>\n<p><strong>Subject:</strong>{{subject}}</p>\n<p><strong>Message:</strong>{{message}}</p>",
                ],
            ],
        ],
    ]
);