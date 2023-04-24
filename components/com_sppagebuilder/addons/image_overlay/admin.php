<?php
/**
 * @package SP Page Builder
 * @author JoomShaper https: //www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2023 JoomShaper
 * @license http: //www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined ('_JEXEC') or die ('Restricted access');

use Joomla\CMS\Language\Text;

SpAddonsConfig::addonConfig(
	[
		'type'       => 'content',
		'addon_name' => 'image_overlay',
		'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY'),
		'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_DESC'),
		'category'   => 'Media',
		'icon'       => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M31.288 10.71l-9.718 5.9a5 5 0 01-5.8-.436l-3.622-3.024a3 3 0 00-3.583-.196l-6.781 4.503-1.106-1.666 6.78-4.503a5 5 0 015.971.327l3.623 3.024a3 3 0 003.48.262L30.25 9l1.038 1.71z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M27 21c0 .552-.41 1-.917 1H5.917C5.41 22 5 21.552 5 21s.41-1 .917-1h20.166c.507 0 .917.448.917 1zM16 26a1 1 0 01-1 1H6a1 1 0 110-2h9a1 1 0 011 1z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M28 2H4a2 2 0 00-2 2v24a2 2 0 002 2h24a2 2 0 002-2V4a2 2 0 00-2-2zM4 0a4 4 0 00-4 4v24a4 4 0 004 4h24a4 4 0 004-4V4a4 4 0 00-4-4H4z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M19.077 6a2.077 2.077 0 100 4.154 2.077 2.077 0 000-4.154zM15 8.077a4.077 4.077 0 118.154 0 4.077 4.077 0 01-8.154 0z" fill="currentColor"/></svg>',
		'inline'     => [
			'buttons' => [
				'image_overlay_general_options' => [
					'action'   => 'dropdown',
					'icon'     => 'addon::image_overlay',
					'tooltip'  => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY'),
					'fieldset' => [
						'tab_groups' => [
							'image' => [
								'fields' => [
									[
										'image'=> [
											'type'       => 'media',
											'std'        => ['src' => 'https://sppagebuilder.com/addons/image/image1.jpg',]
										],
						
										'image_height' => [
											'type'        => 'slider',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
											'responsive'  => true,
											'max'         => 1200,
											'std'         => ['xl'=> 300],
										],

										'background_image_animation'=> [
											'type'   => 'select',
											'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ANIMATION'),
											'values' => [
												'slide-top'    => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_BG_ANIMATION_SLIDE_TOP'),
												'slide-right'  => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_BG_ANIMATION_SLIDE_RIGHT'),
												'slide-bottom' => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_BG_ANIMATION_SLIDE_BOTTOM'),
												'slide-left'   => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_BG_ANIMATION_SLIDE_LEFT'),
												'zoom-in'      => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_BG_ANIMATION_SLIDE_ZOOMIN'),
												'zoom-out'     => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_BG_ANIMATION_SLIDE_ZOOMOUT'),
											],
											'std'     => 'slide-left',
											'inline'  => true,
										],
						
										'image_in_lightbox' => [
											'type'    => 'checkbox',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_IMG_IN_LIGHTBOX'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_IMG_IN_LIGHTBOX_DESC'),
											'std'     => 0,
										],
						
										'lightbox_icon_bg' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_LIGHTBOX_BG'),
											'depends' => [
												['image_in_lightbox', '!=', 0],
											],
											'std' => '',
										],
									]
								],
							],

							'title' => [
								'fields' => [
									'title' => [
										'title'=> [
											'type'  => 'text',
											'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
											'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
											'std'   => 'Image Overlay'
										],
						
										'heading_selector'=> [
											'type'   => 'headings',
											'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
											'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
											'std'     => 'h4',
										],

										'title_icon' => [
											'type'    => 'icon',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON'),
										],
						
										'title_margin'=> [
											'type'        => 'margin',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
											'responsive'  => true,
											'max'         => 400,
										],
									],

									'color' => [
										'title_text_color'=> [
											'type'    => 'color',
											'inline'  => true,
										],
									],

									'typography' => [
										'title_typography' => [
											'type'      => 'typography',
											'fallbacks' => [
												'font'           => 'title_font_family',
												'size'           => 'title_fontsize',
												'line_height'    => 'title_lineheight',
												'letter_spacing' => 'title_letterspace',
												'uppercase'      => 'title_font_style.uppercase',
												'italic'         => 'title_font_style.italic',
												'underline'      => 'title_font_style.underline',
												'weight'         => 'title_font_style.weight',
											],
										],
									],

									'link' => [
										'title_link'=> [
											'type'        => 'link',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
											'mediaType' => 'attachment',
										],
										// title_link_new_window
									]
								],
							],

							'subtitle' => [
								'fields' => [
									'subtitle' => [
										'sub_title' => [
											'type'  => 'text',
											'title' => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_SUBTITLE'),
											'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_SUBTITLE_DESC'),
											'std'   => 'Subtitle of the Image Overlay addon',
										],
						
										'subtitle_heading_selector' => [
											'type'   => 'headings',
											'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
											'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
											'std'     => 'div',
										],
						
										'sub_title_icon' => [
											'type'    => 'icon',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON'),
										],
						
										'sub_title_margin'=> [
											'type'        => 'margin',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
											'responsive'  => true,
										],
									],

									'color' => [
										'sub_title_text_color'=> [
											'type'    => 'color',
											'inline'  => true,
										],
									],

									'typography' => [
										'sub_title_typography' => [
											'type'      => 'typography',
											'fallbacks' => [
												'font'           => 'sub_title_font_family',
												'size'           => 'sub_title_fontsize',
												'letter_spacing' => 'sub_title_letterspace',
												'uppercase'      => 'sub_title_font_style.uppercase',
												'italic'         => 'sub_title_font_style.italic',
												'underline'      => 'sub_title_font_style.underline',
												'weight'         => 'sub_title_font_style.weight',
											],
										],
									],
								],
							],

							'content' => [
								'fields' => [
									[
										'title_subtitle_position'=> [
											'type'   => 'select',
											'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_POSITION'),
											'values' => [
												'top-left'      => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_TOP_LEFT'),
												'top-center'    => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_TOP_CENTER'),
												'top-right'     => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_TOP_RIGHT'),
												'center-left'   => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_CENTER_LEFT'),
												'center-center' => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_CENTER_CENTER'),
												'center-right'  => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_CENTER_RIGHT'),
												'bottom-left'   => Text::_('COM_SPPAGEBUILDER_ADDON_BOTTOM_LEFT'),
												'bottom-center' => Text::_('COM_SPPAGEBUILDER_ADDON_BOTTOM_CENTER'),
												'bottom-right'  => Text::_('COM_SPPAGEBUILDER_ADDON_BOTTOM_RIGHT'),
											],
											'std'     => 'bottom-left',
											'inline'  => true,
										],
						
										'show_content_on_hover' => [
											'type'  => 'checkbox',
											'title' => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_SHOW_CONTENT'),
											'std'   => 0
										],
						
										'content_padding'=> [
											'type'       => 'padding',
											'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
											'responsive' => true,
										],
									],
								],
							],
						],
					],
				],

				'image_overlay_color_options' => [
					'action'      => 'dropdown',
					'type'        => 'placeholder',
					'tooltip'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
					'placeholder' => [
                        'type'      => 'HTMLElement',
                        'element'   => 'div',
                        'selector'  => '.builder-color-picker',
                        'attribute' => [
                            'type'     => 'style',
                            'property' => 'background'
                        ],
                        'display_field' => 'overlay_color',
                    ],
					'fieldset' => [
						'tab_groups' => [
							'normal' => [
								'fields' => [
									[
										'overlay_type'=> [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_OVERLAY_CHOOSE'),
											'std'    => 'gradient',
											'values' => [
												'none'     => 'None',
												'color'    => 'Color',
												'gradient' => 'Gradient'
											],
										],
						
										'overlay_color'=> [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'depends' => [
												['overlay_type', '!=', 'none'],
												['overlay_type', '!=', 'gradient'],
											],
											'std' => 'rgba(0, 91, 234, 0.5)'
										],
						
										'overlay_gradient'=> [
											'type'  => 'gradient',
											'std'   => [
												"color"  => "rgba(127, 0, 255, 0.8)",
												"color2" => "rgba(225, 0, 255, 0.7)",
												"deg"    => "45",
												"type"   => "linear"
											],
											'depends'=> [['overlay_type', '=', 'gradient']]
										],
									],
								],
							],

							'hover' => [
								'fields' => [
									[
										'overlay_hover_type'=> [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_OVERLAY_OVERLAY_CHOOSE'),
											'values' => [
												'none'     => 'None',
												'color'    => 'Color',
												'gradient' => 'Gradient'
											],
											'std'     => 'none',
										],
						
										'overlay_hover_color'=> [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'depends' => [
												['overlay_hover_type', '!=', 'none'],
												['overlay_hover_type', '!=', 'gradient'],
											],
										],
						
										'overlay_hover_gradient'=> [
											'type'  => 'gradient',
											'std'   => [
												"color"  => "rgba(127, 0, 255, 0.8)",
												"color2" => "rgba(225, 0, 255, 0.7)",
												"deg"    => "45",
												"type"   => "linear"
											],
											'depends'=> [['overlay_hover_type', '=', 'gradient']]
										],
									],
								],
							],
						],
					],
				],

				'image_overlay_button_options' => [
					'action'   => 'dropdown',
					'icon'     => 'button',
					'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON'),
					'fieldset' => [
						'tab_groups' => [
							'basic' => [
								'fields' => [
									'button' => [
										'text' => [
											'type'  => 'text',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LABEL'),
											'inline' => true,
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
											'std'   => 'custom',
											'inline' => true,
										],
							
										'appearance' => [
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
											'depends' => [['type', '!=', 'link']]
										],
							
										'shape' => [
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
											'depends' => [['type', '!=', 'link']]
										],
	
										'link_padding_bottom' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_PADDING_BOTTOM'),
											'max'     => 100,
											'std'     => '',
											'depends' => [['type', '=', 'link']]
										],
									],
	
									'options' => [
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
											'std'   => '',
										],
							
										'button_padding' => [
											'type'    => 'padding',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
											'responsive' => true,
											'depends' => [['size', '=', 'custom']]
										],
							
										'block' => [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
											'values' => [
												''               => Text::_('JNO'),
												'sppb-btn-block' => Text::_('JYES'),
											],
											'std'     => '',
											'depends' => [['type', '!=', 'link']]
										],

										'button_margin' => [
											'type'        => 'margin',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
											'responsive' => true,
											'std'        => ['xxl' => '', 'xl' => '10px 0px 0px 0px', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
										],
									],
								],
							],
	
							'icon' => [
								'fields' => [
									[
										'button_icon' => [
											'type'  => 'icon',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
											'desc'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_DESC'),
										],
							
										'button_icon_position' => [
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
										],
									],
								],
							],
	
							'link' => [
								'fields' => [
									[
										'url' => [
											'type'  => 'link',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
											'mediaType' => 'attachment',
										],
									],
								],
							],
	
							'color' => [
								'fields' => [
									'normal' => [
										'color' => [
											'type' => 'color',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'std' => '#FFFFFF',
											'depends' => [['type', '=', 'custom']],
										],
							
										'background_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std'     => '#3366FF',
											'depends' => [
												['appearance', '!=', 'gradient'],
												['type', '=', 'custom'],
											],
										],
							
										'background_gradient' => [
											'type' => 'gradient',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std' => [
												"color"  => "#3366FF",
												"color2" => "#0037DD",
												"deg" => "45",
												"type" => "linear"
											],
											'depends' => [
												['appearance', '=', 'gradient'],
												['type', '=', 'custom'],
											],
										],
							
										// link button
										'link_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'depends' => [['type', '=', 'link']]
										],
							
										'link_border_width' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
											'max'     => 30,
											'depends' => [['type', '=', 'link']]
										],
							
										'link_border_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
											'std'     => '',
											'depends' => [['type', '=', 'link']]
										],
									],
	
									'hover' => [
										'color_hover' => [
											'type' => 'color',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'std' => '#FFFFFF',
											'depends' => [
												['type', '=', 'custom'],
											],
										],
							
										'background_color_hover' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std'     => '#0037DD',
											'depends' => [
												['appearance', '!=', 'gradient'],
												['type', '=', 'custom'],
											],
										],
							
										'background_gradient_hover' => [
											'type' => 'gradient',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std' => [
												"color"  => "#0037DD",
												"color2" => "#3366FF",
												"deg" => "45",
												"type" => "linear"
											],
											'depends' => [
												['appearance', '=', 'gradient'],
												['type', '=', 'custom']
											],
										],
										
										'link_hover_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'std'     => '',
											'depends' => [['type', '=', 'link']]
										],
	
										'link_border_hover_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
											'std'     => '',
											'depends' => [['type', '=', 'link']]
										],
									],
								],
							],
						],
					],
				],
			],
		],
		
		'attr' => [],
    ]
);
