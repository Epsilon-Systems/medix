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

SpAddonsConfig::addonConfig([
	'type'       => 'repeatable',
	'addon_name' => 'gallery',
	'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY'),
	'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_DESC'),
	'category'   => 'Media',
	'icon'       => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M25.812 20.723l-7.524 4.568a5.057 5.057 0 01-5.865-.44l-2.127-1.776a3.034 3.034 0 00-3.623-.199L1.57 26.264.451 24.58l5.103-3.388a5.057 5.057 0 016.038.33l2.127 1.776c.996.832 2.41.938 3.52.265l7.523-4.568 1.05 1.73z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M15.678 14.801a1.517 1.517 0 100 3.034 1.517 1.517 0 000-3.034zm-3.54 1.517a3.54 3.54 0 117.08 0 3.54 3.54 0 01-7.08 0z" fill="currentColor"/><path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M8.254 3.042A2.023 2.023 0 005.995 4.65l-.957 4.786-1.984-.396.957-4.787A4.046 4.046 0 018.53 1.038L28.504 3.78a4.046 4.046 0 013.461 4.536L30.16 22.035a3.895 3.895 0 01-3.862 3.387v-2.023c.94 0 1.734-.697 1.856-1.628l1.805-13.72a2.023 2.023 0 00-1.73-2.267L8.254 3.042z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M23.264 10.755H3.034c-.558 0-1.011.453-1.011 1.012v17.195c0 .558.453 1.011 1.011 1.011h20.23c.559 0 1.012-.453 1.012-1.011V11.767c0-.559-.453-1.012-1.012-1.012zM3.034 8.732A3.034 3.034 0 000 11.767v17.195a3.034 3.034 0 003.034 3.034h20.23a3.034 3.034 0 003.034-3.034V11.767a3.034 3.034 0 00-3.034-3.035H3.034z" fill="currentColor"/></svg>',
	'inline'     => [
		'buttons' => [
			'gallery_general_options' => [
				'action'   => 'dropdown',
				'icon'     => 'addon::gallery',
				'tooltip'  => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY'),
				'fieldset' => [
					'tab_groups' => [
						'items' => [
							'fields' => [
								[
									'width' => [
										'type'       => 'slider',
										'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
										'responsive' => true,
										'std'        => ['xl' => 200],
										'max'        => 1000,
									],
						
									'height' => [
										'type'       => 'slider',
										'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
										'responsive' => true,
										'std'        => ['xl' => 200],
										'max'        => 1000,
									],
									
									'item_gap' => [
										'type'       => 'slider',
										'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_GAP'),
										'responsive' => true,
										'std'        => ['xl' => 0],
										'max'        => 80,
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

						'title' => [
							'fields' => [
								'title' => [
									'title' => [
										'type'  => 'text',
										'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
										'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
									],
						
									'heading_selector' => [
										'type'   => 'headings',
										'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
										'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
										'std'   => 'h3',
									],
			
									'title_margin_top' => [
										'type'       => 'slider',
										'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_TOP'),
										'max'        => 400,
										'responsive' => true,
									],
								
									'title_margin_bottom' => [
										'type'       => 'slider',
										'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_BOTTOM'),
										'max'        => 400,
										'responsive' => true,
									],
								],

								'color' => [
									'title_text_color' => [
										'type'   => 'color',
										'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
										'desc'   => Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
										'inline' => true
									],
								],

								'typography' => [
									'title_typography' => [
										'type'     => 'typography',
										'fallbacks'   => [
											'font' => 'title_font_family',
											'size' => 'title_fontsize',
											'line_height' => 'title_lineheight',
											'letter_spacing' => 'title_letterspace',
											'uppercase' => 'title_font_style.uppercase',
											'italic' => 'title_font_style.italic',
											'underline' => 'title_font_style.underline',
											'weight' => 'title_font_style.weight',
										],
									],
								],
							],
						],
					],
				],
			],

			'gallery_add_new_item' => [
				'action' => 'click',
				'type' => 'plus',
				'icon' => 'plusCircle',
				'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ADD_NEW'),
				'meta' => [
					'key' => 'sp_gallery_item',
					'title' => "Gallery Item",
					'thumb' => [
						'src' => 'https://sppagebuilder.com/addons/gallery/gallery1.jpg',
						'height' => '',
						'width'  => ''
					],
					'full' => [
						'src' => 'https://sppagebuilder.com/addons/gallery/gallery1.jpg',
						'height' => '',
						'width'  => ''
					],
				]
			],

			'gallery_alignment_separator' => [
				'action' => 'separator',
			],

			'gallery_alignment_options' => [
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
					'display_field' => 'item_alignment'
				],
				'default' => [
					'md' => 'left',
					'sm' => 'center',
					'xs' => 'right'
				],
				'fieldset' 	=> [
					[
						'item_alignment' => [
							'type'              => 'alignment',
							'inline'            => true,
							'responsive'        => true,
							'available_options' => ['left', 'center', 'right'],
							'std'               => [
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

	'attr' => [
		'general' => [
			'sp_gallery_item' => [
				'title' => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_ITEMS'),
				'attr'  => [
					'title' => [
						'type'  => 'text',
						'title' => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_ITEM_TITLE'),
						'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_ITEM_TITLE_DESC'),
						'std'   => 'Gallery Item 1'
					],

					'thumb' => [
						'type'  => 'media',
						'title' => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_THUMB'),
						'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_THUMB_DESC'),
						'std'   => [
							'src'    => 'https://sppagebuilder.com/addons/gallery/gallery1.jpg',
							'height' => '',
							'width'  => '',
						],
					],

					'full' => [
						'type'  => 'media',
						'title' => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_FULL'),
						'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_GALLERY_FULL_DESC'),
						'std'   => [
							'src'    => 'https://sppagebuilder.com/addons/gallery/gallery1.jpg',
							'height' => '',
							'width'  => '',
						],
					],
				],
			],
		],
	],
]);
