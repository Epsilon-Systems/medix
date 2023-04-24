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
		'type'       => 'content',
		'addon_name' => 'modal',
		'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL'),
		'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_DESC'),
		'category'   => 'General',
		'icon'       => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.294 24.88l4.722 4.752c.73.49 1.663.49 2.394 0l4.721-4.752h5.616c1.138 0 2.253-1.021 2.253-2.48V4.528C29.916 3.008 28.759 2 27.641 2H4.252C3.115 2 2 3.021 2 4.48V22.4c0 1.459 1.115 2.48 2.252 2.48h6.042zM32 4.48V22.4c0 2.464-1.914 4.48-4.253 4.48h-4.784l-4.252 4.28a4.135 4.135 0 01-4.997 0l-4.252-4.28h-5.21C1.914 26.88 0 24.864 0 22.4V4.48C0 2.016 1.914 0 4.252 0h23.39C29.98 0 31.893 2.016 32 4.48z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M27 10.5a1.5 1.5 0 01-1.5 1.5h-19a1.5 1.5 0 010-3h19a1.5 1.5 0 011.5 1.5zM23 16.5a1.5 1.5 0 01-1.5 1.5h-11a1.5 1.5 0 010-3h11a1.5 1.5 0 011.5 1.5z" fill="currentColor"/></svg>',
		'inline'     => [
			'buttons' => [
				'modal_general_options' => [
					'action'   => 'dropdown',
					'icon'     => 'addon::modal',
					'tooltip'  => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL'),
					'fieldset' => [
						'tab_groups' => [
							'handle' => [
								'fields' => [
									[
										'modal_selector' => [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR'),
											'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_DESC'),
											'values' => [
												'button' => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_BUTTON'),
												'image'  => Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE'),
												'icon'   => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_TYPE_ICON'),
											],
											'std' => 'button',
										],

										'button_text' => [
											'type'    => 'text',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT_DESC'),
											'std'     => 'Button Text',
											'depends' => [['modal_selector', '=', 'button']],
										],

										'selector_image' => [
											'type'    => 'media',
											'depends' => ['modal_selector' => 'image'],
										],

										'selector_icon_name' => [
											'type'    => 'icon',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON'),
											'std'	  => 'fas fa-play-circle',
											'clearable'	=> false,
											'depends' => [['modal_selector', '=', 'icon']]
										],

										'selector_icon_size' => [
											'type'       => 'slider',
											'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON_SIZE'),
											'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_SELECTOR_ICON_SIZE_DESC'),
											'std'        => ['xl' => 36],
											'max'        => 400,
											'responsive' => true,
											'depends'    => [['modal_selector', '=', 'icon']]
										],

										'selector_icon_padding' => [
											'type'        => 'slider',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
											'max'         => 400,
											'responsive'  => true,
											'depends'     => [['modal_selector', '=', 'icon']]
										],

										'selector_icon_border_radius' => [
											'type'        => 'slider',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
											'max'         => 400,
											'responsive'  => true,
											'depends'     => [['modal_selector', '=', 'icon']]
										],

										'show_ripple_effect' => [
											'type'    => 'checkbox',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_RIPPLE_EFFECT'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_RIPPLE_EFFECT_DESC'),
											'std'     => 0,
											'depends' => [['modal_selector', '=', 'icon']]
										],
									],
								],
							],

							'popup' => [
								'fields' => [
									[
										'modal_content_type' => [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_CONTENT_TYPE'),
											'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_CONTENT_TYPE_DESC'),
											'values' => [
												'video' => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_CONTENT_TYPE_VIDEO'),
												'image' => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_CONTENT_TYPE_IMAGE'),
												'text'  => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_CONTENT_TYPE_TEXT'),
											],
											'std' => 'text',
										],

										'modal_content_text' => [
											'type'    => 'editor',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_TEXT'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_TEXT_DESC'),
											'std'     => 'Kevin chicken fatback sirloin ball tip, flank meatloaf t-bone. Meatloaf shankle swine pancetta biltong capicola ham hock meatball. Shoulder bacon andouille ground round pancetta pastrami. Sirloin beef ribs tenderloin rump corned beef filet mignon capicola kielbasa drumstick chuck turducken beef t-bone ribeye. Pork loin ground round t-bone chuck beef ribs swine pastrami cow. Venison tenderloin drumstick, filet mignon salami jowl sausage shank hamburger meatball ribeye kevin tri-tip. Swine kielbasa tenderloin fatback pork shankle andouille, flank frankfurter jerky chicken tri-tip jowl leberkas.&lt;br&gt;&lt;br&gt;Pancetta chicken pork belly beef cow kielbasa fatback sirloin biltong andouille bacon. Sirloin beef tenderloin porchetta, jerky tri-tip andouille sausage landjaeger shank bresaola short ribs tongue meatloaf fatback. Kielbasa pancetta shoulder tri-tip pastrami filet mignon ham corned beef prosciutto doner beef ribs. Doner sausage ham hock, shoulder sirloin pancetta boudin filet mignon chuck. Meatball ham hock beef, filet mignon tri-tip andouille venison ground round chuck turducken drumstick.',
											'depends' => ['modal_content_type' => 'text']
										],

										'modal_content_image' => [
											'type'    => 'media',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_IMAGE'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_IMAGE_DESC'),
											'depends' => ['modal_content_type' => 'image'],
										],

										'modal_content_video_url' => [
											'type'    => 'text',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_VIDEO'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_VIDEO_DESC'),
											'depends' => ['modal_content_type' => 'video']
										],

										'label_popup_options' => [
											'type' => 'header',
											'title' => Text::_('COM_SPPAGEBUILDER_ADDON_MODAL_POPUP'),
											'group' => [
												'modal_popup_width',
												'modal_popup_height',
											],
											'depends' => [
												['modal_content_type', '!=', 'video']
											],
										],

										'modal_popup_width' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
											'std'     => '760',
											'depends' => [
												['modal_content_type', '!=', 'video']
											],
										],

										'modal_popup_height' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
											'std'     => '440',
											'depends' => [
												['modal_content_type', '!=', 'video']
											],
										],
									],
								],
							],
						],
					],
				],

				'modal_color_options' => [
					'action'      => 'dropdown',
					'type'        => 'placeholder',
					'tooltip'     => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
					'default'     => '#3366FF',
					'depends'     => [['modal_selector', '=', 'icon']],
					'placeholder' => [
						'type'      => 'HTMLElement',
						'element'   => 'div',
						'selector'  => '.builder-color-picker',
						'attribute' => [
							'type'     => 'style',
							'property' => 'background'
						],
						'display_field' => 'selector_icon_color',
					],
					'fieldset' => [
						[
							'selector_icon_color' => [
								'type'    => 'color',
								'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
								'std'	  => '#3366FF',
							],

							'selector_icon_background' => [
								'type'    => 'color',
								'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
							],

							'selector_icon_border_width' => [
								'type'        => 'slider',
								'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
								'max'         => 400,
								'responsive'  => true,
							],

							'selector_icon_border_color' => [
								'type'    => 'color',
								'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
							],
						],
					],
				],

				'modal_button_options' => [
					'action'   => 'dropdown',
					'icon'     => 'button',
					'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON'),
					'depends' => [['modal_selector', '=', 'button']],
					'fieldset' => [
						'tab_groups' => [
							'basic' => [
								'fields' => [
									'button' => [
										'button_type' => [
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

										'button_appearance' => [
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
											'depends' => [['button_type', '!=', 'link']]
										],

										'button_shape' => [
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
											'depends' => [['button_type', '!=', 'link']]
										],

										'link_button_padding_bottom' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_PADDING_BOTTOM'),
											'max'     => 100,
											'std'     => '',
											'depends' => [['button_type', '=', 'link']]
										],
									],

									'options' => [
										'button_size' => [
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
											'std' => ['xxl' => '', 'xl' => '8px 22px 10px 22px', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
											'depends' => [['button_size', '=', 'custom']]
										],

										'button_block' => [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
											'values' => [
												''               => Text::_('JNO'),
												'sppb-btn-block' => Text::_('JYES'),
											],
											'std'     => '',
											'depends' => [['button_type', '!=', 'link']]
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
										'button_typography' => [
											'type'     => 'typography',
											'fallbacks' => [
												'font' => 'button_font_family',
												'size' => 'button_fontsize',
												'letter_spacing' => 'button_letterspace',
												'weight' => 'button_font_style.weight',
												'italic' => 'button_font_style.italic',
												'underline' => 'button_font_style.underline',
												'uppercase' => 'button_font_style.uppercase',
											],
										],
									],
								],
							],

							'color' => [
								'fields' => [
									'normal' => [
										'button_color' => [
											'type' => 'color',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'std' => '#FFFFFF',
											'depends' => [['button_type', '=', 'custom']],
										],

										'button_background_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std'     => '#3366FF',
											'depends' => [
												['button_appearance', '!=', 'gradient'],
												['button_type', '=', 'custom'],
											],
										],

										'button_background_gradient' => [
											'type' => 'gradient',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std' => [
												"color"  => "#3366FF",
												"color2" => "#0037DD",
												"deg" => "45",
												"type" => "linear"
											],
											'depends' => [
												['button_appearance', '=', 'gradient'],
												['button_type', '=', 'custom'],
											],
										],

										// link button
										'link_button_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'depends' => [['button_type', '=', 'link']]
										],

										'link_button_border_width' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
											'max'     => 30,
											'depends' => [['button_type', '=', 'link']]
										],

										'link_button_border_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
											'std'     => '',
											'depends' => [['button_type', '=', 'link']]
										],
									],

									'hover' => [
										'button_color_hover' => [
											'type' => 'color',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'std' => '#FFFFFF',
											'depends' => [
												['button_type', '=', 'custom'],
											],
										],

										'button_background_color_hover' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std'     => '#0037DD',
											'depends' => [
												['button_appearance', '!=', 'gradient'],
												['button_type', '=', 'custom'],
											],
										],

										'button_background_gradient_hover' => [
											'type' => 'gradient',
											'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'std' => [
												"color"  => "#0037DD",
												"color2" => "#3366FF",
												"deg" => "45",
												"type" => "linear"
											],
											'depends' => [
												['button_appearance', '=', 'gradient'],
												['button_type', '=', 'custom']
											],
										],

										'link_button_hover_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'std'     => '',
											'depends' => [['button_type', '=', 'link']]
										],

										'link_button_border_hover_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
											'std'     => '',
											'depends' => [['button_type', '=', 'link']]
										],
									],
								],
							],
						],
					],
				],

				'modal_alignment_separator' => [
					'action'	=> 'separator',
				],

				'modal_alignment_options' => [
					'action'      => 'dropdown',
					'type'        => 'placeholder',
					'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALIGNMENT'),
					'style'       => 'inline',
					'showCaret'   => true,
					'placeholder' => [
						'type'    => 'list',
						'options' => [
							'left'    => ['icon' => 'textAlignLeft'],
							'center'  => ['icon' => 'textAlignCenter'],
							'right'   => ['icon' => 'textAlignRight'],
						],
						'display_field' => 'alignment'
					],
					'default' => [
						'md' => 'left',
						'sm' => 'center',
						'xs' => 'right'
					],
					// 'tooltip'  => 'Change the alignment by clicking here.',
					'fieldset' => [
						'basic' => [
							'alignment' => [
								'type'        => 'alignment',
								'inline'      => true,
								'responsive'  => true,
								'std'         => [
									'xxl' => '',
									'xl' => 'left',
									'lg' => '',
									'md' => '',
									'sm' => '',
									'xs' => ''
								]
							]
						]
					]
				],
			],
		],


		'attr' => [],
	]
);
