<?php

/**
 * @package SP Page Builder
 * @author JoomShaper https: //www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http: //www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined('_JEXEC') or die('restricted access');

use Joomla\CMS\Language\Text;

SpAddonsConfig::addonConfig(
    [
        'type' => 'repeatable',
        'addon_name' => 'js_slideshow',
        'category' => 'Slider',
        'title' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER'),
        'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DESC'),
        'icon' => '<svg viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M17.656 10.518a1.138 1.138 0 1 0 0 2.276 1.138 1.138 0 0 0 0-2.276ZM15 11.656a2.656 2.656 0 1 1 5.312 0 2.656 2.656 0 0 1-5.312 0ZM10 27a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm12 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm-6.636-9.909c.885.842 1.854 1.306 2.88 1.345 1.014.038 1.939-.343 2.738-.91 1.563-1.108 2.888-3.095 3.906-5.067l-1.776-.918c-.985 1.906-2.13 3.533-3.287 4.354-.561.398-1.06.56-1.505.543-.433-.017-.96-.207-1.578-.796-1.163-1.106-2.319-1.737-3.458-1.923-1.157-.188-2.186.101-3.042.63-1.648 1.018-2.698 2.941-3.185 4.318l1.886.666c.42-1.19 1.265-2.612 2.35-3.282.511-.316 1.058-.457 1.67-.358.628.102 1.432.477 2.4 1.398Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M9 8h14v11H9V8ZM7 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V8Zm-2.193 2.591A1 1 0 1 0 3.193 9.41L.236 13.444a1.246 1.246 0 0 0 0 1.46l2.703 3.687a1 1 0 1 0 1.613-1.182L2.18 14.174l2.626-3.583ZM16 27a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM27.409 9.193a1 1 0 0 1 1.398.216l2.957 4.035c.315.43.315 1.03 0 1.46l-2.703 3.687a1 1 0 1 1-1.613-1.182l2.371-3.235-2.626-3.583a1 1 0 0 1 .216-1.398Z" fill="currentColor"/></svg>',
        'inline' => [
            'buttons' => [
                'js_slideshow_general_options' => [
                    'action' => 'dropdown',
                    'icon' => 'addon::js_slideshow',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER'),
                    'fieldset' => [
                        'tab_groups' => [
                            'slider items' => [
                                'fields' => [
                                    [
                                        'advanced_settings' => [
                                            'type'   => 'advancedsettings',
                                            'title'  => Text::_('Slider Items'),
                                            'buttonText' => Text::_('COM_SPPAGEBUILDER_ADDON_ITEM_ADD_EDIT'),
                                            'buttonIcon' => 'ul',
                                        ],
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
                'js_slideshow_add_new_item' => [
                    'action' => 'click',
                    'type' => 'plus',
                    'icon' => 'plusCircle',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ADD_NEW'),
                    'meta' => [
                        'key' => 'slideshow_items',
                    ],
                ],
            ],
        ],

        'attr' => [
            'general' => [
                'content_container_option' => [
                    'type'   => 'select',
                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTAINER_OPTION'),
                    'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTAINER_OPTION_DESC'),
                    'values' => [
                        'bootstrap' => Text::_('Bootstrap'),
                        'custom'    => Text::_('Custom'),
                    ],
                    'std' => 'bootstrap',
                ],

                'content_container_width' => [
                    'type'       => 'slider',
                    'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_CONTAINER'),
                    'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_CONTAINER_DESC'),
                    'std'        => ['xl' => 75],
                    'max'        => 100,
                    'responsive' => true,
                    'depends'    => [
                        ['content_container_option', '=', 'custom'],
                    ],
                ],

                'content_vertical_alignment' => [
                    'type'  => 'checkbox',
                    'title' => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_CONTENT_VERTICAL_ALIGNMENT'),
                    'std'   => 1,
                ],

                'slideshow_items' => [
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEMS'),
                    'type'  => 'repeatable',
                    'std'   => [
                        [
                            'slider_img' => [
                                'src' => 'https://sppagebuilder.com/addons/js_slideshow/slideshow-default-bg.jpg',
                            ],
                            'content_alignment'     => 'center',
                            'slideshow_inner_items' => [
                                [
                                    'title_content_title'       => 'THE AMAZING SLIDESHOW ADDON!',
                                    'content_type'              => 'title_content',
                                    'title_heading_selector'    => 'h2',
                                    'content_color'             => '#fff',
                                    'content_animation_type'    => 'slide',
                                    'animation_slide_direction' => 'top',
                                    'animation_duration'        => 800,
                                    'animation_delay'           => 1000,
                                    'animation_slide_from'      => 100,
                                    'animation_timing_function' => 'ease',
                                ],
                                [
                                    'content_text'     => '<br>Want to make your website more attractive? Get a stunning hero <br>section with the Slideshow addon in SP Page Builder Pro. <br>It’s easy, fast, and gorgeous.<br><br>',
                                    'content_type'     => 'text_content',
                                    'content_color'    => '#fff',
                                    'content_fontsize' => [
                                        'xxl' => 20,
                                        'xl' => 20,
                                        'lg' => 20,
                                        'md' => 20,
                                        'sm' => 16,
                                        'xs' => 14,
                                    ],
                                    'content_animation_type'    => 'slide',
                                    'animation_slide_direction' => 'top',
                                    'animation_duration'        => 800,
                                    'animation_delay'           => 1000,
                                    'animation_slide_from'      => 100,
                                    'animation_timing_function' => 'ease',
                                ],
                                [
                                    'btn_content'               => 'LEARN MORE',
                                    'content_type'              => 'btn_content',
                                    'content_color'             => '#fff',
                                    'content_animation_type'    => 'slide',
                                    'animation_slide_direction' => 'top',
                                    'animation_duration'        => 800,
                                    'animation_delay'           => 1000,
                                    'animation_slide_from'      => 100,
                                    'animation_timing_function' => 'ease',
                                ],
                            ],
                        ],
                        [
                            'slider_img' => [
                                'src' => 'https://sppagebuilder.com/addons/js_slideshow/slideshow-default-bg.jpg',
                            ],
                            'content_alignment'     => 'center',
                            'slideshow_inner_items' => [
                                [
                                    'title_content_title'       => 'THE AMAZING SLIDESHOW ADDON!',
                                    'content_type'              => 'title_content',
                                    'title_heading_selector'    => 'h2',
                                    'content_color'             => '#fff',
                                    'content_animation_type'    => 'slide',
                                    'animation_slide_direction' => 'top',
                                    'animation_duration'        => 800,
                                    'animation_delay'           => 1000,
                                    'animation_slide_from'      => 100,
                                    'animation_timing_function' => 'ease',
                                ],
                                [
                                    'content_text'     => '<br>Want to make your website more attractive? Get a stunning hero <br>section with the Slideshow addon in SP Page Builder Pro. <br>It’s easy, fast, and gorgeous.<br><br>',
                                    'content_type'     => 'text_content',
                                    'content_color'    => '#fff',
                                    'content_fontsize' => [
                                        'xxl' => 20,
                                        'xl' => 20,
                                        'lg' => 20,
                                        'md' => 20,
                                        'sm' => 16,
                                        'xs' => 14,
                                    ],
                                    'content_animation_type'    => 'slide',
                                    'animation_slide_direction' => 'top',
                                    'animation_duration'        => 800,
                                    'animation_delay'           => 1000,
                                    'animation_slide_from'      => 100,
                                    'animation_timing_function' => 'ease',
                                ],
                                [
                                    'btn_content'               => 'LEARN MORE',
                                    'content_type'              => 'btn_content',
                                    'content_color'             => '#fff',
                                    'content_animation_type'    => 'slide',
                                    'animation_slide_direction' => 'top',
                                    'animation_duration'        => 800,
                                    'animation_delay'           => 1000,
                                    'animation_slide_from'      => 100,
                                    'animation_timing_function' => 'ease',
                                ],
                            ],
                        ],
                    ],
                    'attr' =>  [
                        //Admin label
                        'title' => [
                            'type'  => 'text',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
                            'std'   => 'Item number 1',
                        ],
                        'slider_bg_options' => [
                            'type'   => 'buttons',
                            'std'    => 'bg_image',
                            'values' => [
                                [
                                    'label' => 'Image Background',
                                    'value' => 'bg_image'
                                ],
                                [
                                    'label' => 'Video Background',
                                    'value' => 'bg_video'
                                ],
                            ],
                            'tabs' => true,
                        ],
                        //Slider image
                        'slider_img' => [
                            'type'  => 'media',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_BACKGROUND_IMAGE'),
                            'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_BACKGROUND_IMAGE_DESC'),
                            'std'   => [
                                'src' => 'https://sppagebuilder.com/addons/js_slideshow/slideshow-default-bg.jpg',
                            ],
                            'depends' => [
                                ['slider_bg_options', '!=', 'bg_video'],
                            ],
                        ],
                        'slider_video' => [
                            'type'    => 'media',
                            'format'  => 'video',
                            'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_BACKGROUND_VIDEO'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_BACKGROUND_VIDEO_DESC'),
                            'depends' => [
                                ['slider_bg_options', '!=', 'bg_image'],
                                ['enable_youtube_vimeo', '!=', 1],
                            ],
                            'std' => [
                                'src' => '',
                            ],
                        ],
                        'enable_youtube_vimeo' => [
                            'type'    => 'checkbox',
                            'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_YTUBE_VIMEO_VIDEO'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_YTUBE_VIMEO_VIDEO_DESC'),
                            'depends' => [
                                ['slider_bg_options', '!=', 'bg_image'],
                            ],
                            'std' => 0,
                        ],
                        'youtube_vimeo_url' => [
                            'type'    => 'text',
                            'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_YTUBE_VIMEO_VIDEO_SRC'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_YTUBE_VIMEO_VIDEO_SRC_DESC'),
                            'depends' => [
                                ['slider_bg_options', '!=', 'bg_image'],
                                ['enable_youtube_vimeo', '!=', 0],
                            ],
                        ],
                        'video_volume_btn' => [
                            'type'    => 'checkbox',
                            'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_VOLUME_ICON'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_VOLUME_ICON_DESC'),
                            'depends' => [
                                ['slider_bg_options', '!=', 'bg_image'],
                            ],
                            'std' => 0,
                        ],
                        'slider_overlay_options' => [
                            'type'   => 'buttons',
                            'std'    => 'color_overlay',
                            'values' => [
                                [
                                    'label' => 'Color Overlay',
                                    'value' => 'color_overlay'
                                ],
                                [
                                    'label' => 'Gradient Overlay',
                                    'value' => 'gradient_overaly'
                                ],
                            ],
                            'tabs' => true,
                        ],
                        'slider_bg_overlay' => [
                            'type'    => 'color',
                            'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_OVERLAY'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_OVERLAY_DESC'),
                            'depends' => [
                                ['slider_overlay_options', '=', 'color_overlay'],
                            ],
                        ],
                        'slider_bg_gradient_overlay' => [
                            'type' => 'gradient',
                            'std'  => [
                                "color"  => "#00ad75",
                                "color2" => "#8700fc",
                                "deg"    => "45",
                                "type"   => "linear"
                            ],
                            'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_GD_OVERLAY'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_GD_OVERLAY_DESC'),
                            'depends' => [
                                ['slider_overlay_options', '=', 'gradient_overaly'],
                            ],
                        ],
                        //Slider Inner Item
                        'slideshow_inner_items' => [
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTENTS'),
                            'type'  => 'repeatable',
                            'attr'  => [
                                //Admin label
                                'title' => [
                                    'type'  => 'text',
                                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
                                    'std'   => 'The Amazing Slideshow Addon!',
                                ],

                                //Add content to tabs
                                'content_tabs' => [
                                    'type'   => 'buttons',
                                    'std'    => 'content_type',
                                    'values' => [
                                        [
                                            'label' => 'Content',
                                            'value' => 'content_type'
                                        ],
                                        [
                                            'label' => 'Animation',
                                            'value' => 'content_animation'
                                        ],
                                        [
                                            'label' => 'Style',
                                            'value' => 'content_style'
                                        ],
                                    ],
                                    'tabs' => true,
                                ],
                                //Content Type
                                'content_type_separator' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTENT_TYPE_OPTION'),
                                    'depends' => [
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],
                                'content_type' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_CONTENT_TYPE'),
                                    'values' => [
                                        'title_content' => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
                                        'text_content'  => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_CONTENT_TEXT'),
                                        'image_content' => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE'),
                                        'btn_content'   => Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON'),
                                        'icon_content'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON_NAME'),
                                    ],
                                    'std'     => 'title_content',
                                    'depends' => [
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],
                                //Title Content
                                'title_content_title' => [
                                    'type'    => 'textarea',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_TITLE_CONTENT'),
                                    'std'     => 'The Amazing Slideshow Addon!',
                                    'depends' => [
                                        ['content_type', '=', 'title_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],
                                'title_heading_selector' => [
                                    'type'    => 'select',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
                                    'depends' => [
                                        ['content_type', '=', 'title_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                    'values' => [
                                        'h1'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
                                        'h2'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
                                        'h3'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
                                        'h4'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
                                        'h5'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
                                        'h6'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
                                        'div'  => 'div',
                                        'p'    => 'p',
                                        'span' => 'span',
                                    ],
                                    'std'     => 'h2',
                                    'depends' => [
                                        ['title_content_title', '!=', ''],
                                        ['content_type', '=', 'title_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],
                                //Text Content
                                'content_text' => [
                                    'type'    => 'editor',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TEXT_CONTENT'),
                                    'std'     => 'Lorem ipsum dolor sit amet, ne eam iusto sapientem persecuti, id noster volumus nec.',
                                    'depends' => [
                                        ['content_type', '=', 'text_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],
                                //Image Content
                                'image_content' => [
                                    'type'    => 'media',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMAGE_CONTENT'),
                                    'depends' => [
                                        ['content_type', '=', 'image_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                    'std' => [
                                        'src' => '',
                                    ]
                                ],

                                //Icon Content
                                'icon_content' => [
                                    'type'    => 'icon',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_ICON_CONTENT'),
                                    'std'     => 'fa-cogs',
                                    'depends' => [
                                        ['content_type', '=', 'icon_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],

                                //Button Content
                                'btn_content' => [
                                    'type'    => 'text',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_BTN_CONTENT'),
                                    'std'     => 'Button Text',
                                    'depends' => [
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],
                                //Button Content
                                'content_class' => [
                                    'type'    => 'text',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CUSTOME_CLASS'),
                                    'depends' => [
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                ],

                                'button_url' => [
                                    'type'         => 'media',
                                    'format'       => 'attachment',
                                    'title'        => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL'),
                                    'desc'         => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL_DESC'),
                                    'placeholder'  => 'http://',
                                    'hide_preview' => true,
                                    'depends'      => [
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                    'std' => '#'
                                ],

                                'button_target' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB'),
                                    'desc'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB_DESC'),
                                    'values' => [
                                        'same'   => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
                                        '_blank' => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
                                    ],
                                    'depends' => [
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                    'std' => 'same',
                                ],

                                'button_icon' => [
                                    'type'    => 'icon',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_DESC'),
                                    'depends' => [
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ]
                                ],

                                'button_icon_position' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
                                    'values' => [
                                        'left'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                        'right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                                    ],
                                    'depends' => [
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                    'std' => 'left'
                                ],

                                'button_icon_margin' => [
                                    'type'    => 'margin',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_ICON_MARGIN'),
                                    'depends' => [
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_type'],
                                    ],
                                    'responsive' => true,
                                    'std'        => ''
                                ],

                                //Animation options
                                'animation_separator' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTENT_ANIMATION_OPTION'),
                                    'depends' => [
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                ],
                                'content_animation_type' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTENT_TYPE'),
                                    'values' => [
                                        'slide'        => 'Slide',
                                        'rotate'       => 'Rotate',
                                        'text-animate' => 'Text Animate',
                                        'zoom'         => 'Zoom',
                                    ],
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'std' => 'slide'
                                ],

                                //Animation type slide options
                                'animation_slide_direction' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_SLIDE_DIRECTION'),
                                    'values' => [
                                        'top'    => 'Top',
                                        'right'  => 'Right',
                                        'bottom' => 'Bottom',
                                        'left'   => 'Left',
                                    ],
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_animation_type', '!=', 'rotate'],
                                        ['content_animation_type', '!=', 'zoom'],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'std' => 'bottom'
                                ],

                                'animation_duration' => [
                                    'type'    => 'number',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ANIMATION_DURATION'),
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'std' => 800,
                                ],

                                'animation_delay' => [
                                    'type'    => 'number',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ANIMATION_DELAY'),
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'std' => 1000,
                                ],

                                'animation_slide_from' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_SLIDE_FROM'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_SLIDE_FROM_DESC'),
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_animation_type', '=', 'slide'],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'min' => -100,
                                    'max' => 100,
                                    'std' => '100',
                                ],

                                //animation type rotate options
                                'animation_rotate_from' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_ROTATE_FROM'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_ROTATE_FROM_DESC'),
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_animation_type', '=', 'rotate'],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'max' => 360,
                                    'std' => '360',
                                ],

                                'animation_rotate_to' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_ROTATE_TO'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_ROTATE_TO_DESC'),
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_animation_type', '=', 'rotate'],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'max' => 360,
                                    'std' => '0',
                                ],

                                'animation_timing_function' => [
                                    'type'    => 'select',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_TIMINIG_FUNCTION'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_TIMINIG_FUNCTION_DESC'),
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_animation_type', '!=', 'width'],
                                        ['content_animation_type', '!=', 'zoom'],
                                        ['content_tabs', '=', 'content_animation'],
                                    ],
                                    'values' => [
                                        'ease'         => 'Ease',
                                        'ease-in'      => 'Ease In',
                                        'ease-out'     => 'Ease Out',
                                        'ease-in-out'  => 'Ease In Out',
                                        'linear'       => 'Linear',
                                        'cubic-bezier' => 'Cubic Bezier',
                                    ],
                                    'std' => 'ease',
                                ],

                                'animation_cubic_bezier_value' => [
                                    'type'    => 'text',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_CUBIC_BEZIER'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_ANIMATION_CUBIC_BEZIER_DESC'),
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_animation_type', '!=', 'width'],
                                        ['content_animation_type', '!=', 'zoom'],
                                        ['content_tabs', '=', 'content_animation'],
                                        ['animation_timing_function', '=', 'cubic-bezier'],
                                    ],
                                    'std' => '0,0.46,0,0.63',
                                ],

                                //Styleing options
                                'content_separator' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_CONTENT_STYLE_OPTION'),
                                    'depends' => [
                                        ['content_type', '!=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],
                                'content_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_COLOR'),
                                    'std'     => '#fff',
                                    'depends' => [
                                        ['content_type', '!=', 'image_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],

                                'content_background' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_style'],
                                        ['content_type', '!=', 'btn_content'],
                                    ],
                                ],

                                'content_typography' => [
                                    'type'      => 'typography',
                                    'fallbacks' => [
                                        'font'           => 'content_font_family',
                                        'size'           => 'content_fontsize',
                                        'line_height'    => 'content_lineheight',
                                        'letter_spacing' => 'content_letterspacing',
                                        'custom_letter_spacing' => 'custom_letterspacing',
                                        'uppercase'      => 'content_font_style.uppercase',
                                        'italic'         => 'content_font_style.italic',
                                        'underline'      => 'content_font_style.underline',
                                        'weight'         => 'content_font_style.weight',
                                    ],
                                    'depends' => [
                                        ['content_type', '!=', 'image_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],

                                

                                //Image style options
                                'image_content_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_IMG_WIDTH'),
                                    'depends' => [
                                        ['content_type', '=', 'image_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                    'max'        => 2000,
                                    'responsive' => true,
                                    'std'        => ['xl' => 400, 'sm' => ''],
                                ],
                                'image_content_height' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ITEM_IMG_HEIGHT'),
                                    'depends' => [
                                        ['content_type', '=', 'image_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                    'max'        => 2000,
                                    'responsive' => true,
                                    'std'        => ['xl' => 385, 'sm' => ''],
                                ],
                                //End image style
                                //Start Button Style
                                'button_background_options' => [
                                    'type'   => 'buttons',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_BTN_BG_OPTIONS'),
                                    'std'    => 'color_bg',
                                    'values' => [
                                        [
                                            'label' => 'Color Background',
                                            'value' => 'color_bg'
                                        ],
                                        [
                                            'label' => 'Gradient Background',
                                            'value' => 'color_gradient'
                                        ],
                                    ],
                                    'tabs'    => true,
                                    'depends' => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ]
                                ],

                                'button_background_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                    'std'     => '#444444',
                                    'depends' => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                        ['button_background_options', '=', 'color_bg'],
                                    ]
                                ],

                                'button_background_gradient' => [
                                    'type'  => 'gradient',
                                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
                                    'std'   => [
                                        "color"  => "#B4EC51",
                                        "color2" => "#429321",
                                        "deg"    => "45",
                                        "type"   => "linear"
                                    ],
                                    'depends' => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                        ['button_background_options', '=', 'color_gradient'],
                                    ]
                                ], //End Button Style

                                'content_border' => [
                                    'type'    => 'margin',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                                    'std'     => '',
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],
                                'content_border_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],
                                'content_border_radius' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                    'std'     => '',
                                    'depends' => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],
                                'content_margin' => [
                                    'type'       => 'margin',
                                    'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                    'std'        => '',
                                    'responsive' => true,
                                    'depends'    => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],
                                'content_padding' => [
                                    'type'       => 'padding',
                                    'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                    'std'        => '',
                                    'responsive' => true,
                                    'depends'    => [
                                        ['content_type', '!=', ''],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],
                                //Box or text shadow
                                'content_text_shadow' => [
                                    'type'   => 'boxshadow',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_SHADOW'),
                                    'config' => [
                                        'spread' => false
                                    ],
                                    'depends' => [
                                        ['content_type', '!=', 'image_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                    'std' => '0 0 0 #ffffff',
                                ],
                                'btn_box_shadow' => [
                                    'type'    => 'boxshadow',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BOXSHADOW'),
                                    'depends' => [
                                        ['content_type', '!=', 'text_content'],
                                        ['content_type', '!=', 'icon_content'],
                                        ['content_type', '!=', 'title_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                    'std' => '0 0 0 0 #ffffff',
                                ],
                                //Button hover
                                'btn_hover_separator' => [
                                    'type'       => 'separator',
                                    'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_HOVER_STYLE_OPTIONS'),
                                    'std'        => '',
                                    'responsive' => true,
                                    'depends'    => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ],
                                ],
                                'button_hover_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_HOVER'),
                                    'std'     => '#fff',
                                    'depends' => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ]
                                ],
                                'button_background_color_hover' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR_HOVER'),
                                    'std'     => '#222',
                                    'depends' => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                        ['button_background_options', '=', 'color_bg'],
                                    ]
                                ],
                                'button_background_gradient_hover' => [
                                    'type'  => 'gradient',
                                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
                                    'std'   => [
                                        "color"  => "#429321",
                                        "color2" => "#B4EC51",
                                        "deg"    => "45",
                                        "type"   => "linear"
                                    ],
                                    'depends' => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                        ['button_background_options', '=', 'color_gradient'],
                                    ]
                                ],
                                'button_hover_border_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_BTN_HOVER_BORDER_COLOR'),
                                    'std'     => '#fff',
                                    'depends' => [
                                        ['btn_content', '!=', ''],
                                        ['content_type', '=', 'btn_content'],
                                        ['content_tabs', '=', 'content_style'],
                                    ]
                                ],
                            ], //End Inner Item attr[array]
                        ], //End Inner Item
                        //Start common content options
                        'item_content_separator' => [
                            'type'  => 'separator',
                            'title' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTENT_GLOBAL_OPTIONS'),
                        ],
                        'image_in_column' => [
                            'type'  => 'checkbox',
                            'title' => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMAGE_IN_COLUMN'),
                            'desc'  => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMAGE_IN_COLUMN_DESC'),
                            'std'   => 0,
                        ],
                        'image_column_width' => [
                            'type'    => 'select',
                            'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMAGE_COLUMN_WIDTH'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMAGE_COLUMN_WIDTH_DESC'),
                            'depends' => [
                                ['image_in_column', '!=', 0],
                            ],
                            'values' => [
                                1  => 1,
                                2  => 2,
                                3  => 3,
                                4  => 4,
                                5  => 5,
                                6  => 6,
                                7  => 7,
                                8  => 8,
                                9  => 9,
                                10 => 10,
                                11 => 11,
                                12 => 12,
                            ],
                            'std'        => ['xl' => 6],
                            'responsive' => true,
                        ],
                        'image_column_reverse' => [
                            'type'    => 'checkbox',
                            'title'   => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMAGE_COLUMN_REVERSE'),
                            'desc'    => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMAGE_COLUMN_REVERSE_DESC'),
                            'std'     => 0,
                            'depends' => [
                                ['image_in_column', '!=', 0],
                            ],
                        ],

                        'image_content_alignment' => [
                            'type'   => 'select',
                            'title'  => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_IMG_CONTENT_ALIGNMENT'),
                            'values' => [
                                'left'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                'center' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
                                'right'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                            ],
                            'std'     => 'left',
                            'depends' => [
                                ['image_in_column', '!=', 0],
                            ],
                        ],

                        'content_alignment' => [
                            'type'   => 'select',
                            'title'  => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_CONTENT_ALIGNMENT'),
                            'values' => [
                                'left'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                                'center' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
                                'right'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                            ],
                            'std' => 'center',
                        ],

                        'icon_display_block' => [
                            'type'  => 'checkbox',
                            'title' => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_ICON_DISPLAY_BLOCK'),
                            'desc'  => Text::_('COM_SPPAGEBUILDER_JS_SLIDER_ICON_DISPLAY_BLOCK_DESC'),
                            'std'   => 0,
                        ],
                    ],
                ], //End slider items

                'slideshow_separator' => [
                    'type'  => 'separator',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_GLOBAL_SETTINGS'),
                ],
                //Slider options
                'slider_settings' => [
                    'type'   => 'buttons',
                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SETTINGS'),
                    'std'    => 'slider_global',
                    'values' => [
                        [
                            'label' => 'Slider Global Settings',
                            'value' => 'slider_global'
                        ],
                        [
                            'label' => 'Slider Controllers Settings',
                            'value' => 'slider_controller'
                        ],
                    ],
                    'tabs' => true,
                ],

                                //Global options
                                'separator_global' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_GLOBAL_OPT'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'height' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_HEIGHT'),
                                    'values' => [
                                        'full'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_WIN_HEIGHT'),
                                        'custom' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CUS_HEIGHT'),
                                    ],
                                    'std'     => 'full',
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'custom_height' => [
                                    'type'       => 'slider',
                                    'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
                                    'max'        => 4000,
                                    'std'        => ['xl' => 900, 'lg' => 900, 'md' => 900, 'sm' => 600, 'xs' => 350],
                                    'responsive' => true,
                                    'depends'    => [
                                        ['height', '!=', 'full'],
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'slider_animation' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ANIMATION'),
                                    'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ANIMATION_DESC'),
                                    'values' => [
                                        'slide'  => 'Slide',
                                        'stack'  => 'Stack',
                                        'clip'   => 'Clip',
                                        'bubble' => 'Bubble',
                                        'fade'   => 'Fade',
                                        '3D'     => '3D',
                                    ],
                                    'std'     => 'slide',
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'slide_vertically' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_VERTICALLY'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_VERTICALLY_DESC'),
                                    'std'     => 0,
                                    'depends' => [
                                        ['slider_animation', '=', 'stack'],
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'three_d_rotate' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_3D_ROTATE'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_3D_ROTATE_DESC'),
                                    'max'     => 90,
                                    'min'     => -90,
                                    'std'     => 15,
                                    'depends' => [
                                        ['slider_animation', '=', '3D'],
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'autoplay' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_AUTOPLAY'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_AUTOPLAY_DESC'),
                                    'std'     => 0,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],
                                'pause_on_hover' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_PAUSE'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_PAUSE_DESC'),
                                    'std'     => 0,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['autoplay', '=', 1],
                                    ]
                                ],

                                'interval' => [
                                    'type'    => 'number',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_INTERVAL'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_INTERVAL_DESC'),
                                    'std'     => 5,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'speed' => [
                                    'type'    => 'number',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SPEED'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SPEED_DESC'),
                                    'std'     => 800,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'timer' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_TIMER'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_TIMER_DESC'),
                                    'std'     => 1,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'timer_bg_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TIMER_BG_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['timer', '=', 1],
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'timer_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TIMER_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['timer', '=', 1],
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                'timer_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TIMER_WIDTH'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TIMER_WIDTH_DESC'),
                                    'depends' => [
                                        ['timer', '=', 1],
                                        ['slider_settings', '=', 'slider_global'],
                                    ],
                                    'min'        => 1,
                                    'max'        => 100,
                                    'responsive' => true,
                                    'step'       => .1,
                                    'std'        => ['md' => ''],
                                ],
                                'timer_top_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TIMER_TOP_GAP'),
                                    'depends' => [
                                        ['timer', '=', 1],
                                        ['slider_settings', '=', 'slider_global'],
                                    ],
                                    'min'        => 0,
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['md' => ''],
                                ],
                                'timer_left_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TIMER_LEFT_GAP'),
                                    'depends' => [
                                        ['timer', '=', 1],
                                        ['slider_settings', '=', 'slider_global'],
                                    ],
                                    'min'        => 0,
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['md' => ''],
                                ],

                                'slide_counter' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_NUMBER'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_NUMBER_DESC'),
                                    'std'     => 0,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],
                                'slide_counter_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_NUMBER_COLOR'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['slide_counter', '=', 1],
                                    ]
                                ],
                                'slide_counter_fontsize' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_NUMBER_FONTSIZE'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['slide_counter', '=', 1],
                                    ],
                                    'min'        => 5,
                                    'max'        => 100,
                                    'responsive' => true,
                                    'std'        => ['xl' => 22],
                                ],
                                'slide_counter_fontfamily' => [
                                    'type'    => 'fonts',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_NUMBER_FONTFAMILY'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['slide_counter', '=', 1],
                                    ]
                                ],
                                'slide_counter_bg_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_NUMBER_BG'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['slide_counter', '=', 1],
                                    ]
                                ],
                                'slide_counter_padding' => [
                                    'type'    => 'padding',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_NUMBER_PADDING'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['slide_counter', '=', 1],
                                    ],
                                    'responsive' => true,
                                    'std'        => '0px 0px 0px 0px',
                                ],
                                'slide_counter_gap_bottom' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_NUMBER_GAP_BOTTOM'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['slide_counter', '=', 1],
                                    ],
                                    'min'        => 0,
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 20],
                                ],
                                'slide_counter_gap_left' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_NUMBER_GAP_LEFT'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                        ['slide_counter', '=', 1],
                                    ],
                                    'min'        => 0,
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 20],
                                ],

                                'class' => [
                                    'type'    => 'text',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
                                    'std'     => '',
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_global'],
                                    ]
                                ],

                                //Controllers
                                'separator_controllers' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLER_OPT'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],
                                'controllers' => [
                                    'type'   => 'buttons',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS'),
                                    'std'    => 'dot',
                                    'values' => [
                                        [
                                            'label' => 'Bullet/Line Controllers',
                                            'value' => 'dot'
                                        ],
                                        [
                                            'label' => 'Arrow Controllers',
                                            'value' => 'arrow'
                                        ],
                                    ],
                                    'tabs'    => true,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'dot_controllers' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_CONTROLLERS'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_CONTROLLERS_DESC'),
                                    'std'     => 1,
                                    'depends' => [
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'dot_controllers_style' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_STYLE'),
                                    'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_STYLE_DESC'),
                                    'values' => [
                                        'dot'        => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_STYLE_DOT'),
                                        'line'       => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_STYLE_LINE'),
                                        'with_image' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_IMAGE_WITH'),
                                        'with_text'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_WITH_TEXT'),
                                    ],
                                    'std'     => 'dot',
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'line_indecator' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_LINE_INDECATOR'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_LINE_INDECATOR_DESC'),
                                    'std'     => 1,
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '=', 'line'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'dot_controllers_position' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_POSITION'),
                                    'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_POSITION_DESC'),
                                    'values' => [
                                        'bottom_center'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_BOTTOM_CENTER'),
                                        'bottom_left'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_BOTTOM_LEFT'),
                                        'bottom_right'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_BOTTOM_RIGHT'),
                                        'vertical_left'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_VERTI_LEFT'),
                                        'vertical_right' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_VERTI_RIGHT'),
                                    ],
                                    'std'     => 'bottom_center',
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'dot_controllers_bottom_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_POSITION_FROM_BOTTOM'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers_position', '!=', 'vertical_left'],
                                        ['dot_controllers_position', '!=', 'vertical_right'],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],
                                'dot_controllers_left_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_POSITION_FROM_LEFT'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers_position', '!=', 'bottom_center'],
                                        ['dot_controllers_position', '!=', 'bottom_right'],
                                        ['dot_controllers_position', '!=', 'vertical_right'],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],
                                'dot_controllers_right_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_POSITION_FROM_RIGHT'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers_position', '!=', 'bottom_center'],
                                        ['dot_controllers_position', '!=', 'bottom_left'],
                                        ['dot_controllers_position', '!=', 'vertical_left'],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],

                                'dot_controller_style_option' => [
                                    'type'   => 'buttons',
                                    'std'    => 'dot_normal',
                                    'values' => [
                                        [
                                            'label' => 'Bullet/Line Normal Style',
                                            'value' => 'dot_normal'
                                        ],
                                        [
                                            'label' => 'Bullet/Line Active Style',
                                            'value' => 'dot_active'
                                        ],
                                    ],
                                    'tabs'    => true,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '=', 'dot'],
                                    ]
                                ],
                                'dot_ctlr_style_separator' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_STYLE_OPTION'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ]
                                ],

                                'dot_ctlr_height' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ],
                                    'max' => 100,
                                    'std' => 18,
                                ],

                                'dot_ctlr_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ],
                                    'max' => 100,
                                    'std' => 18,
                                ],
                                'dot_ctlr_bg' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ]
                                ],

                                'dot_ctlr_border_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                                    'std'     => '',
                                    'max'     => 20,
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ]
                                ],

                                'dot_ctlr_border_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ]
                                ],

                                'dot_ctlr_border_radius' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS_DESC'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ],
                                    'max' => 100,
                                    'std' => 18,
                                ],

                                'dot_ctlr_margin' => [
                                    'type'    => 'margin',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                                    'std'     => '',
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_normal'],
                                    ]
                                ],
                                //dot/live hover
                                'dot_ctlr_style_separator_hov' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_STYLE_OPTION_HOV'),
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_active'],
                                    ]
                                ],
                                'dot_ctlr_center_bg' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_CENTER_BACKGROUND'),
                                    'std'     => '',
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '!=', 'with_image'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_active'],
                                    ]
                                ],
                                'dot_ctlr_hover_height' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_ACTIVE_HEIGHT'),
                                    'std'     => '',
                                    'max'     => 100,
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_active'],
                                    ]
                                ],

                                'dot_ctlr_hover_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_ACTIVE_WIDTH'),
                                    'std'     => '',
                                    'max'     => 100,
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_active'],
                                    ]
                                ],

                                'dot_ctlr_hover_border_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_DOT_ACTIVE_BORDER_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['dot_controllers', '!=', 0],
                                        ['dot_controllers_style', '!=', 'with_text'],
                                        ['controllers', '!=', 'arrow'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controller_style_option', '=', 'dot_active'],
                                    ]
                                ],
                                //Text thumbnail style
                                'text_thumb_ctlr_wrap_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TEXT_THUMB_WIDTH'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TEXT_THUMB_WIDTH_DESC'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                    ],
                                    'max'        => 100,
                                    'responsive' => true,
                                ],
                                'text_thumb_ctlr_wrap_bg' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TEXT_THUMB_BG'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                    ],
                                ],
                                'text_thumb_ctlr_wrap_padding' => [
                                    'type'    => 'padding',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TEXT_THUMB_PADDING'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                    ],
                                    'responsive' => true,
                                ],
                                'text_thumb_ctlr_individual_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TEXT_THUMB_ITEM_WIDTH'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TEXT_THUMB_ITEM_WIDTH_DESC'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                    ],
                                    'max'        => 500,
                                    'responsive' => true,
                                ],

                                'text_thumb_cont_style' => [
                                    'type'   => 'buttons',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_TEXT_THUMB_CON_STYLE'),
                                    'std'    => 'thumb_number',
                                    'values' => [
                                        [
                                            'label' => 'Number Text',
                                            'value' => 'thumb_number'
                                        ],
                                        [
                                            'label' => 'Title Text',
                                            'value' => 'thumb_title'
                                        ],
                                        [
                                            'label' => 'Subtitle Text',
                                            'value' => 'thumb_subtitle'
                                        ],
                                    ],
                                    'tabs'    => true,
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                    ]
                                ],
                                //Text thumb number style
                                'text_thumb_number_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_number'],
                                    ],
                                ],
                                'text_thumb_number_font_size' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_number'],
                                    ],
                                    'max'        => 100,
                                    'responsive' => true,
                                ],
                                'text_thumb_number_font_family' => [
                                    'type'    => 'fonts',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_number'],
                                    ],
                                    'selector' => [
                                        'type' => 'font',
                                        'font' => '{{ VALUE }}',
                                        'css'  => '.sp-slider-text-thumb-number { font-family: "{{ VALUE }}"; }'
                                    ],
                                ],
                                'text_thumb_number_font_weight' => [
                                    'type'    => 'select',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_WEIGHT'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_number'],
                                    ],
                                    'values' => [
                                        100 => 100,
                                        200 => 200,
                                        300 => 300,
                                        400 => 400,
                                        500 => 500,
                                        600 => 600,
                                        700 => 700,
                                        800 => 800,
                                        900 => 900,
                                    ],
                                ],
                                //Text thumb title style
                                'text_thumb_title_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_title'],
                                    ],
                                ],
                                'text_thumb_title_font_size' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_title'],
                                    ],
                                    'max'        => 100,
                                    'responsive' => true,
                                ],
                                'text_thumb_title_lineheight' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINE_HEIGHT'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_title'],
                                    ],
                                    'max'        => 100,
                                    'responsive' => true,
                                ],
                                'text_thumb_title_font_family' => [
                                    'type'    => 'fonts',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_title'],
                                    ],
                                    'selector' => [
                                        'type' => 'font',
                                        'font' => '{{ VALUE }}',
                                        'css'  => '.sp-slider-dot-indecator-text.sp-dot-text-key-1 { font-family: "{{ VALUE }}"; }'
                                    ],
                                ],
                                'text_thumb_title_font_weight' => [
                                    'type'    => 'select',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_WEIGHT'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_title'],
                                    ],
                                    'values' => [
                                        100 => 100,
                                        200 => 200,
                                        300 => 300,
                                        400 => 400,
                                        500 => 500,
                                        600 => 600,
                                        700 => 700,
                                        800 => 800,
                                        900 => 900,
                                    ],
                                ],
                                //Text thumb subtitle style
                                'text_thumb_subtitle_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_subtitle'],
                                    ],
                                ],
                                'text_thumb_subtitle_font_size' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_subtitle'],
                                    ],
                                    'max'        => 100,
                                    'responsive' => true,
                                ],
                                'text_thumb_subtitle_font_family' => [
                                    'type'    => 'fonts',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_subtitle'],
                                    ],
                                    'selector' => [
                                        'type' => 'font',
                                        'font' => '{{ VALUE }}',
                                        'css'  => '.sp-slider-dot-indecator-text.sp-dot-text-key-2 { font-family: "{{ VALUE }}"; }'
                                    ],
                                ],
                                'text_thumb_subtitle_font_weight' => [
                                    'type'    => 'select',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_WEIGHT'),
                                    'depends' => [
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['dot_controllers', '!=', 0],
                                        ['controllers', '!=', 'arrow'],
                                        ['dot_controllers_style', '=', 'with_text'],
                                        ['text_thumb_cont_style', '=', 'thumb_subtitle'],
                                    ],
                                    'values' => [
                                        100 => 100,
                                        200 => 200,
                                        300 => 300,
                                        400 => 400,
                                        500 => 500,
                                        600 => 600,
                                        700 => 700,
                                        800 => 800,
                                        900 => 900,
                                    ],
                                ],

                                //Arrow controllers
                                'arrow_controllers' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_ARROWS'),
                                    'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_SHOW_ARROWS_DESC'),
                                    'std'     => 1,
                                    'depends' => [
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'arrow_on_hover' => [
                                    'type'    => 'checkbox',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_ON_HOVER'),
                                    'std'     => 0,
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'arrow_controllers_style' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_STYLE'),
                                    'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_STYLE_DESC'),
                                    'values' => [
                                        'spread' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_STYLE_SPREAD'),
                                        'along'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_STYLE_ALONG_WITH'),
                                    ],
                                    'std'     => 'spread',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'arrow_controllers_content' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_CONTENT'),
                                    'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_CONTENT_DESC'),
                                    'values' => [
                                        'text_only'      => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_CONTENT_TEXT'),
                                        'icon_only'      => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_CONTENT_ICON'),
                                        'long_arrow'     => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_LONG_ARROW'),
                                        'icon_with_text' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROWS_CONTENT_ICON_TEXT'),
                                    ],
                                    'std'     => 'icon_only',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'arrow_controllers_position' => [
                                    'type'   => 'select',
                                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_POSITION'),
                                    'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_POSITION_DESC'),
                                    'values' => [
                                        'bottom_center' => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_BOTTOM_CENTER'),
                                        'bottom_left'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_BOTTOM_LEFT'),
                                        'bottom_right'  => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_CONTROLLERS_BOTTOM_RIGHT'),
                                    ],
                                    'std'     => 'bottom_center',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_controllers_style', '!=', 'spread'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],
                                'arrow_controllers_bottom_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_POSITION_FROM_BOTTOM'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_controllers_style', '!=', 'spread'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['arrow_controllers_position', '!=', ''],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],
                                'arrow_controllers_left_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_POSITION_FROM_LEFT'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_controllers_style', '!=', 'spread'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['arrow_controllers_position', '=', 'bottom_left'],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],
                                'arrow_controllers_right_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_POSITION_FROM_RIGHT'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_controllers_style', '!=', 'spread'],
                                        ['slider_settings', '=', 'slider_controller'],
                                        ['arrow_controllers_position', '=', 'bottom_right'],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],
                                'arrow_spread_controllers_left_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_POSITION_FROM_LEFT'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_controllers_style', '=', 'spread'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],
                                'arrow_spread_controllers_right_gap' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_POSITION_FROM_RIGHT'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_controllers_style', '=', 'spread'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                    'max'        => 2500,
                                    'responsive' => true,
                                    'std'        => ['xl' => 50],
                                ],

                                'arrow_style' => [
                                    'type'   => 'buttons',
                                    'std'    => 'arrow_normal',
                                    'values' => [
                                        [
                                            'label' => 'Normal Arrow Style',
                                            'value' => 'arrow_normal'
                                        ],
                                        [
                                            'label' => 'Hover Arrow Style',
                                            'value' => 'arrow_hover'
                                        ],
                                    ],
                                    'tabs'    => true,
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                //Arrow style
                                'separator_arrow' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'arrow_ctlr_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                    'max'        => 300,
                                    'responsive' => true,
                                    'std'        => ['xxl' => '', 'xl' => '', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
                                ],

                                'arrow_ctlr_height' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                    'max'        => 300,
                                    'responsive' => true,
                                    'std'        => ['xxl' => '', 'xl' => '', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
                                ],

                                'arrow_ctlr_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'arrow_ctlr_font_size' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                    'max'        => 100,
                                    'responsive' => true,
                                    'std'        => ['xxl' => '', 'xl' => '', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
                                ],

                                'arrow_ctlr_background' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'arrow_ctlr_border_width' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                                    'std'     => '',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'arrow_ctlr_border_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
                                    'std'     => '',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'arrow_ctlr_border_radius' => [
                                    'type'    => 'slider',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_hover'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                    'std' => '50',
                                    'max' => 300,
                                ],

                                //Arrow hover
                                'separator_arrow_hover' => [
                                    'type'    => 'separator',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_JS_SLIDER_ARROW_HOVER'),
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['controllers', '!=', 'dot'],
                                        ['arrow_style', '!=', 'arrow_normal'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ],
                                ],

                                'arrow_ctlr_hover_background' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR_HOVER'),
                                    'std'     => '',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_normal'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'arrow_ctlr_hover_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR_HOVER'),
                                    'std'     => '',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_normal'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],

                                'arrow_ctlr_hover_border_color' => [
                                    'type'    => 'color',
                                    'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR_HOVER'),
                                    'std'     => '',
                                    'depends' => [
                                        ['arrow_controllers', '!=', 0],
                                        ['arrow_style', '!=', 'arrow_normal'],
                                        ['controllers', '!=', 'dot'],
                                        ['slider_settings', '=', 'slider_controller'],
                                    ]
                                ],
            ],
        ],
    ]
);
