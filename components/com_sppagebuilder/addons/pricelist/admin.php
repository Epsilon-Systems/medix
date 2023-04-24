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
		'addon_name' => 'pricelist',
		'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST'),
		'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST_DESC'),
		'category'   => 'Content',
		'icon'       => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M5.379 6.36c-.53-.304-1.094-.535-1.652-.775a3.674 3.674 0 01-.907-.527c-.538-.445-.435-1.168.196-1.454.178-.08.365-.107.555-.119a4.088 4.088 0 012.087.428c.33.165.438.113.55-.242.117-.376.214-.758.323-1.137.073-.254-.017-.422-.248-.529a5.168 5.168 0 00-1.317-.408c-.597-.095-.597-.098-.6-.72-.003-.876-.003-.876-.851-.876-.123 0-.246-.003-.368 0-.396.012-.463.084-.475.498-.005.185 0 .37-.002.558-.003.549-.006.54-.514.731C.93 2.251.17 3.118.09 4.506c-.073 1.23.547 2.059 1.52 2.663.6.373 1.264.593 1.9.885.249.113.486.243.692.422.611.524.5 1.394-.226 1.723-.387.177-.798.22-1.219.165A5.302 5.302 0 01.898 9.79c-.343-.185-.444-.136-.561.249-.1.332-.19.668-.279 1.003-.12.451-.075.558.34.769.53.266 1.097.402 1.674.497.453.075.466.096.472.582.003.22.003.442.006.662.002.277.13.44.407.445.312.006.628.006.94-.003.257-.006.388-.15.388-.42 0-.3.014-.604.003-.904-.014-.307.114-.463.399-.544a3.144 3.144 0 001.643-1.093c1.194-1.503.74-3.704-.951-4.672z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M32 5c0 .552-.428 1-.956 1H10.956C10.428 6 10 5.552 10 5s.428-1 .957-1h20.087c.528 0 .956.448.956 1zM21 10a1 1 0 01-1 1h-9a1 1 0 110-2h9a1 1 0 011 1z" fill="currentColor"/><path d="M5.379 24.36c-.53-.304-1.094-.535-1.652-.775a3.675 3.675 0 01-.907-.527c-.538-.445-.435-1.168.196-1.454.178-.08.365-.107.555-.119a4.088 4.088 0 012.087.428c.33.165.438.113.55-.242.117-.376.214-.758.323-1.137.073-.254-.017-.422-.248-.529a5.166 5.166 0 00-1.317-.408c-.597-.095-.597-.098-.6-.72-.003-.876-.003-.876-.851-.876-.123 0-.246-.003-.368 0-.396.012-.463.084-.475.498-.005.185 0 .37-.002.558-.003.549-.006.54-.514.731C.93 20.251.17 21.118.09 22.506c-.073 1.23.547 2.059 1.52 2.663.6.373 1.264.593 1.9.885.249.113.486.243.692.422.611.524.5 1.394-.226 1.724-.387.176-.798.22-1.219.164a5.302 5.302 0 01-1.858-.575c-.343-.185-.444-.136-.561.249-.1.332-.19.668-.279 1.003-.12.451-.075.558.34.769.53.266 1.097.402 1.674.497.453.076.466.096.472.582.003.22.003.442.006.662.002.277.13.44.407.445.312.006.628.006.94-.003.257-.006.388-.15.388-.42 0-.3.014-.604.003-.904-.014-.307.114-.463.399-.544a3.144 3.144 0 001.643-1.093c1.194-1.503.74-3.704-.951-4.672z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M32 23c0 .552-.428 1-.956 1H10.956c-.528 0-.956-.448-.956-1s.428-1 .957-1h20.087c.528 0 .956.448.956 1zM21 28a1 1 0 01-1 1h-9a1 1 0 110-2h9a1 1 0 011 1z" fill="currentColor"/></svg>',
		'inline'     => [
			'contenteditable' => true,
			'buttons'         => [
				'pricelist_general_settings' => [
					'action'   => 'dropdown',
					'icon'     => 'addon::pricelist',
					'tooltip'  => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST'),
					'fieldset' => [
						'tab_groups' => [
							'title' => [
								'fields' => [
									[
										'title'=> [
											'type'  => 'textarea',
											'std'   => 'Grilled Peach & Summer Berries'
										],

										'title_margin_top'=> [
											'type'        => 'slider',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_TOP'),
											'max'         => 400,
											'responsive'  => true
										],
						
										'title_margin_bottom'=> [
											'type'        => 'slider',
											'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_BOTTOM'),
											'max'         => 400,
											'responsive'  => true
										],
									],
								],
							],

							'content' => [
								'fields' => [
									[
										'text'=> [
											'type'  => 'editor',
											'std'   => 'Mixed greens, fresh pulled mozzarella, garden basil, Hawaiian sea salt,extra virgin olive oil'
										],
									],
								],
							],

							'media' => [
								'fields' => [
									[
										'add_number_or_image'=> [
											'type'  => 'checkbox',
											'title' => Text::_('COM_SPPAGEBUILDER_PRICELIST_MEDIA'),
											'std'   => 1,
										],
						
										'number_or_image_left'=> [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_MEDIA_TYPE'),
											'values' => [
												'image'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_LEFT_IMAGE'),
												'number' => Text::_('COM_SPPAGEBUILDER_PRICELIST_LEFT_NUMBER'),
											],
											'std'     => 'image',
											'depends' => [['add_number_or_image', '!=', 0]],
										],
			
										'image'=> [
											'type'       => 'media',
											'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST_IMG'),
											'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST_IMG_DESC'),
											'show_input' => true,
											'std' => [
												'src' => 'http://demo.joomshaper.com/2015/cuisine/images/frying-pank.jpg',
											],
											'depends'    => [
												['number_or_image_left', '!=', 'number'],
												['add_number_or_image', '!=', 0]
											],
										],
						
										'number_text'=> [
											'type'    => 'text',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST_NUMBER'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST_NUMBER_DESC'),
											'std'     => '01',
											'inline'  => true,
											'depends' => [
												['number_or_image_left', '!=', 'image'],
												['add_number_or_image', '!=', 0]
											],
										],
									],
								],
							],

							'price' => [
								'fields' => [
									[
										'price'=> [
											'type'        => 'text',
											'title'       => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE'),
											'desc'        => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_DESC'),
											'placeholder' => '$20.00',
											'std'         => '$20.00',
											'inline' 	  => true,
										],
			
										'price_position'=> [
											'type'   => 'select',
											'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_POSITION'),
											'desc'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_POSITION_DESC'),
											'values' => [
												'with-title'     => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_WITH_TITLE'),
												'right-to-title' => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_RIGHT_TITLE'),
												'content-bottom' => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_CONTENT_BOTTOM'),
											],
											'std' => 'right-to-title',
											'inline' => true,
										],
			
										// rename to decimal alignment
										'zero_position'=> [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_ZERO_POSITION'),
											'desc'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_ZERO_POSITION_DESC'),
											'values' => [
												'top'      => Text::_('COM_SPPAGEBUILDER_PRICELIST_POSITION_TOP'),
												'baseline' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BOTTOM'),
											],
											'std'     => 'baseline',
										],
			
										// add separator
										'discount_price_separator'=> [
											'type'	=> 'separator',
										],
			
										'discount_price'=> [
											'type'        => 'text',
											'title'       => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_DISCOUNT'),
											'desc'        => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE_DISCOUNT_DESC'),
											'placeholder' => '$15.00',
											'inline'	  => true,
										],
						
										'discount_price_position'=> [
											'type'   => 'radio',
											'title'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_DIS_PRICE_POSITION'),
											'values' => [
												'top'      => Text::_('COM_SPPAGEBUILDER_PRICELIST_POSITION_TOP'),
												'baseline' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BOTTOM'),
											],
											'std'     => 'baseline',
										],
									],
								],
							],
						],
					],
				],

				'pricelist_typography_separator' => [
					'action' => 'separator'
				],
	
				'pricelist_typography_options' => [
					'action'   => 'dropdown',
					'icon'     => 'typography',
					'tooltip'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_TYPOGRAPHY'),
					'fieldset' => [
						'tab_groups' => [
							'title' => [
								'fields' => [
									[
										'title_typography' => [
											'type'     => 'typography',
											'fallbacks'   => [
												'font'           => 'font_family',
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
								],
							],

							'content' => [
								'fields' => [
									[
										'content_typography' => [
											'type'     => 'typography',
											'fallbacks'   => [
												'font'           => 'text_font_family',
												'size'           => 'text_fontsize',
												'line_height'    => 'text_lineheight',
												'weight'         => 'text_fontweight',
											],
										],
									],
								],
							],

							'number' => [
								'fields' => [
									[
										'number_typography' => [
											'type'     => 'typography',
											'fallbacks'   => [
												'font'           => 'number_font_family',
												'size'           => 'number_fontsize',
												'italic'         => 'number_fontstyle',
												'weight'         => 'number_fontweight',
											],
										],
									],
								],
							],

							'price' => [
								'fields' => [
									[
										'price_typography' => [
											'type'     => 'typography',
											'fallbacks'   => [
												'font'           => 'price_font_family',
												'size'           => 'price_fontsize',
												'weight'         => 'price_fontweight',
											],
										],
									],
								],
							],
						],
					],
				],

				'pricelist_color_options' => [
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
						'display_field' => 'title_text_color',
					],
					'fieldset' => [
						[
							'title_text_color' => [
								'type'   => 'color',
								'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_TITLE'),
							],

							'global_text_color' => [
								'type'   => 'color',
								'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_CONTENT'),
							],

							'price_color' => [
								'type'   => 'color',
								'title'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE'),
							],

							'discount_price_color' => [
								'type'   => 'color',
								'title'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_DISCOUNT'),
							],

							'number_color_separator' => [
								'type'	=> 'separator',
								'depends' => [
									['number_or_image_left', '!=', 'image'],
									['add_number_or_image', '!=', 0]
								],
							],

							'number_color' => [
								'type'    => 'color',
								'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST_NUMBER'),
								'depends' => [
									['number_or_image_left', '!=', 'image'],
									['add_number_or_image', '!=', 0]
								],
							],
			
							'number_bg_color' => [
								'type'    => 'color',
								'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_PRICELIST_NUMBER_BACKGROUND'),
								'depends' => [
									['number_or_image_left', '!=', 'image'],
									['add_number_or_image', '!=', 0]
								],
							],
						],
					],
				],

				'pricelist_alignment_separator' => [
					'action'	=> 'separator',
					'depends'    => [['price_position', '=', 'content-bottom']],
				],

				'pricelist_alignment_options' => [
					'action'      => 'dropdown',
					'type'        => 'placeholder',
					'style'       => 'inline',
					'showCaret'   => true,
					'tooltip'  	=> Text::_('COM_SPPAGEBUILDER_GLOBAL_ALIGNMENT'),
					'depends'    => [['price_position', '=', 'content-bottom']],
					'placeholder' => [
						'type'    => 'list',
						'options' => [
							'left'    => ['icon' => 'textAlignLeft'],
							'center'  => ['icon' => 'textAlignCenter'],
							'right'   => ['icon' => 'textAlignRight'],
						],
						'display_field' => 'content_position'
					],
					'fieldset' => [
						'basic' => [
							'content_position' => [
								'type'        => 'alignment',
								'available_options' => ['left', 'center', 'right'],
								'inline'      => true,
								'responsive'  => true,
							],
						],
					],
				],
			],
		],
		
		'attr'       => [
			'general' => [
				// price
				'toggle_price'=> [
					'type'  => 'header',
					'style'	=> 'toggle',
					'uuid'	=> 'toggle_price',
					'title' => Text::_('COM_SPPAGEBUILDER_PRICELIST_PRICE'),
					'group'	=> [
						'price_top_gap',
						'price_bottom_gap',
					],
					'depends' => [
						['price_position', '!=', 'with-title'],
						['price_position', '!=', 'right-to-title'],
                    ],
				],
				
				'price_top_gap'=> [
					'type'        => 'slider',
					'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_TOP'),
                ],

				'price_bottom_gap'=> [
					'type'        => 'slider',
					'title'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_BOTTOM'),
                ],

				// divider
				'toggle_divider'=> [
					'type'  => 'header',
					'style'	=> 'toggle',
					'uuid'	=> 'toggle_divider',
					'title' => Text::_('COM_SPPAGEBUILDER_PRICELIST_DIVIDER'),
					'group'	=> [
						'add_line',
						'line_style',
						'line_size',
						'line_color',
						'line_position',
						'line_top_gap',
						'line_bottom_gap',
					],
					'depends' => [
						['price_position', '!=', 'with-title'],
                    ],
				],

				'add_line'=> [
					'type'    => 'checkbox',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_DESC'),
					'std'     => 1,
					'depends' => [
						['price_position', '!=', 'content-bottom'],
                    ],
                ],

				'line_style'=> [
					'type'   => 'select',
					'title'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_STYLE'),
					'desc'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_STYLE_DESC'),
					'values' => [
						'solid'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_LINE_SOLID'),
						'dotted' => Text::_('COM_SPPAGEBUILDER_PRICELIST_LINE_DOTTED'),
						'dashed' => Text::_('COM_SPPAGEBUILDER_PRICELIST_LINE_DASHED'),
						'double' => Text::_('COM_SPPAGEBUILDER_PRICELIST_LINE_DOUBLE'),
                    ],
					'std'     => 'dotted',
					'inline'	=> true,
					'depends' => [
						['add_line', '!=', 0]
                    ],
                ],

				'line_size'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_SIZE'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_SIZE_DESC'),
					'max'     => 20,
					'depends' => [
						['add_line', '!=', 0]
                    ],
                ],

				'line_color'=> [
					'type'    => 'color',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_COLOR'),
					'depends' => [
						['add_line', '!=', 0]
                    ],
                ],

				'line_position'=> [
					'type'   => 'select',
					'title'  => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_POSITION'),
					'desc'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_POSITION_DESC'),
					'values' => [
						'center'       => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_POSITION_CENTER'),
						'flex-end'     => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_POSITION_BOTTOM'),
						'title-bottom' => Text::_('COM_SPPAGEBUILDER_PRICELIST_ADD_LINE_POSITION_TITLE_BOTTOM'),
                    ],
					'inline'	=> true,
					'std'     => 'center',
					'depends' => [
						['price_position', '!=', 'content-bottom'],
						['add_line', '!=', 0]
                    ],
                ],

				'line_top_gap' => [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_TOP'),
					'std'     => 0,
					'max'     => 100,
					'depends' => [
						['line_position', '!=', 'center'],
						['line_position', '!=', 'flex-end'],
						['price_position', '!=', 'content-bottom'],
						['add_line', '!=', 0]
                    ],
                ],

				'line_bottom_gap'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_BOTTOM'),
					'std'     => 0,
					'max'     => 100,
					'depends' => [
						['line_position', '!=', 'center'],
						['line_position', '!=', 'flex-end'],
						['price_position', '!=', 'content-bottom'],
						['add_line', '!=', 0]
                    ],
                ],

				// media
				'toggle_media'=> [
					'type'  => 'header',
					'style'	=> 'toggle',
					'uuid'	=> 'toggle_media',
					'title' => Text::_('COM_SPPAGEBUILDER_PRICELIST_MEDIA'),
					'group'	=> [
						'number_top_padding',
						'number_bottom_padding',
						'image_width',
						'image_gutter',
						'image_border_radius',
						'separator_image_tag',
						'image_tag',
						'image_tag_text',
						'image_tag_bg',
						'image_tag_radius',
						'image_tag_top_margin',
						'image_tag_left_margin',
					],
				],

				'number_top_padding'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_TOP'),
					'max'     => 200,
					'std'     => '',
					'depends' => [
						['label_media', '=', 1],
						['number_or_image_left', '!=', 'image'],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'number_bottom_padding'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_BOTTOM'),
					'max'     => 200,
					'std'     => '',
					'depends' => [
						['label_media', '=', 1],
						['number_or_image_left', '!=', 'image'],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'image_width'=> [
					'type'       => 'slider',
					'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
					'responsive' => true,
					'std'        => 15,
					'max'        => 100,
					'depends'    => [
						['label_media', '=', 1],
						['number_or_image_left', '!=', ''],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'image_gutter'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_GAP'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_GUTTER_DESC'),
					'depends' => [
						['label_media', '=', 1],
						['number_or_image_left', '!=', ''],
						['add_number_or_image', '!=', 0]
                    ],
					'max'        => 100,
					'responsive' => true,
					'std'        => 15,
                ],

				'image_border_radius'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_BORDER_RADIUS_DESC'),
					'std'     => '',
					'max'     => 100,
					'depends' => [
						['label_media', '=', 1],
						['number_or_image_left', '!=', ''],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'separator_image_tag'=> [
					'type'    => 'separator',
					'depends' => [
						['label_media', '=', 1],
						['number_or_image_left', '!=', 'number'],
						['add_number_or_image', '!=', 0]
                    ],
				],

				'image_tag'=> [
					'type'    => 'checkbox',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_DESC'),
					'std'     => 0,
					'depends' => [
						['label_media', '=', 1],
						['number_or_image_left', '!=', 'number'],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'image_tag_text'=> [
					'type'        => 'text',
					'title'       => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_TEXT'),
					'desc'        => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_TEXT_DESC'),
					'placeholder' => 'HOT',
					'std'         => 'HOT',
					'inline'	  => true,
					'depends'     => [
						['label_media', '=', 1],
						['image_tag', '!=', 0],
						['number_or_image_left', '!=', 'number'],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'image_tag_bg'=> [
					'type'    => 'color',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_BG'),
					'std'     => '#FA0606',
					'depends' => [
						['label_media', '=', 1],
						['image_tag', '!=', 0],
						['number_or_image_left', '!=', 'number'],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'image_tag_radius'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_RADIUS'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_RADIUS_DESC'),
					'max'     => 100,
					'depends' => [
						['label_media', '=', 1],
						['image_tag', '!=', 0],
						['number_or_image_left', '!=', 'number'],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'image_tag_top_margin'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_TOP_MARGIN'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_TOP_MARGIN_DESC'),
					'std'     => 0,
					'max'     => 500,
					'depends' => [
						['label_media', '=', 1],
						['image_tag', '!=', 0],
						['number_or_image_left', '!=', 'number'],
						['add_number_or_image', '!=', 0]
                    ],
                ],

				'image_tag_left_margin'=> [
					'type'    => 'slider',
					'title'   => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_LEFT_MARGIN'),
					'desc'    => Text::_('COM_SPPAGEBUILDER_PRICELIST_IMAGE_TAG_LEFT_MARGIN_DESC'),
					'std'     => 0,
					'max'     => 500,
					'depends' => [
						['label_media', '=', 1],
						['image_tag', '!=', 0],
						['number_or_image_left', '!=', 'number'],
						['add_number_or_image', '!=', 0]
                    ],
                ],
            ],
        ],
    ]
);
