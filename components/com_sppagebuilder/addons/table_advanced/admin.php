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
		'type'       => 'repeatable',
		'addon_name' => 'table_advanced',
		'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED'),
		'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DESC'),
		'category'   => 'Content',
		'icon'       => '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.27 4.27A4.333 4.333 0 014.332 3h23.334A4.333 4.333 0 0132 7.333v17.334A4.333 4.333 0 0127.667 29H4.333A4.333 4.333 0 010 24.667V7.333C0 6.184.457 5.082 1.27 4.27zM2 13.666v5.666h13v-5.666H2zm15 0v5.666h13v-5.666H17zm13-2V7.333A2.333 2.333 0 0027.667 5H4.333A2.333 2.333 0 002 7.333v4.334h28zm0 9.666H17V27L27.667 27A2.333 2.333 0 0030 24.667v-3.334zM15 27v-5.666H2v3.334A2.333 2.333 0 004.333 27H15z" fill="currentColor"/></svg>',
		'inline' => [
			'buttons' => [
				'table_advanced_general_options' => [
					'action' => 'dropdown',
                    'icon' => 'addon::table_advanced',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED'),
                    'fieldset' => [
						'tab_groups' => [
							'table contents' => [
								'fields' => [
									[
									'turn_off_heading' => [
										'type'    => 'checkbox',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TURNOFF_HEADER'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TURNOFF_HEADER_DESC'),
										'std' => 0
									],

									'sp_table_advanced_item' => [
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_HEAD'),
										'depends' => [
											['turn_off_heading', '=', 0],
										],
										'std' => [
											[
												'content' => 'First Name',
											],
											[
												'content' => 'Last Name',
											],
											[
												'content' => 'Countries',
											],
											[
												'content' => 'Capitals',
											],
										],
										'attr' => [
											'title' => [
												'type'  => 'text',
												'title' => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
												'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
												'std'   => 'Column Header <th>'
											],
											'head_col_span' => [
												'type'  => 'number',
												'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DATA_COL_SPAN'),
												'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DATA_COL_SPAN_DESC'),
											],
											'content' => [
												'type'  => 'builder',
												'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TH_CONTENT'),
												'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TH_CONTENT_DESC'),
												'std'   => 'First Name'
											],
										],
					
									],

									'table_advanced_item' => [
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_ROW'),
										'std' => [
											[
												'table_advanced_item' => [
													[
														'content' => 'Ronald',
													],
													[
														'content' => 'Curiel',
													],
													[
														'content' => 'USA',
													],
													[
														'content' => 'Washington, D.C.',
													],
												]
											],
											[
												'table_advanced_item' => [
													[
														'content' => 'Roger',
													],
													[
														'content' => 'Morison',
													],
													[
														'content' => 'Sweden',
													],
													[
														'content' => 'Stockholm',
													],
												]
											],
											[
												'table_advanced_item' => [
													[
														'content' => 'Luca',
													],
													[
														'content' => 'Jane',
													],
													[
														'content' => 'Russia',
													],
													[
														'content' => 'Moscow',
													],
												]
											],
											[
												'table_advanced_item' => [
													[
														'content' => 'Marry',
													],
													[
														'content' => 'Chan',
													],
													[
														'content' => 'China',
													],
													[
														'content' => 'Beijing',
													],
												]
											],
										],
										'attr' => [
											'title' => [
												'type'  => 'text',
												'title' => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
												'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
												'std'   => 'Row Admin Label'
											],
					
											'table_advanced_item' => [
												'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DATA'),
												'type'  => 'repeatable',
												'attr'  => [
													'title' => [
														'type'  => 'text',
														'title' => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
														'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
														'std'   => 'Column Data <td>'
													],
													'row_span' => [
														'type'  => 'number',
														'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DATA_ROW_SPAN'),
														'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DATA_ROW_SPAN_DESC'),
													],
													'col_span' => [
														'type'  => 'number',
														'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DATA_COL_SPAN'),
														'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_DATA_COL_SPAN_DESC'),
													],
													'content' => [
														'type'  => 'builder',
														'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TD_CONTENT'),
														'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TD_CONTENT_DESC'),
														'std'   => 'Jhon'
													],
													'td_inner_bg' => [
														'type'  => 'color',
														'title' => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TD_INNER_BG'),
														'desc'  => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TD_INNER_BG_DESC'),
														'std'   => ''
													],
												],
					
											],
										],
					
									],

									'table_searchable' => [
										'type'    => 'checkbox',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SEARCHABLE'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SEARCHABLE_DESC'),
										'std' => 0,
									],
									'search_column_limit' => [
										'type'    => 'text',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SEARCH_LIMIT'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SEARCH_LIMIT_DESC'),
										'depends' => [
											['table_searchable', '!=', 0],
										],
										'std' => '1,2,3'
									],
									'table_sortable' => [
										'type'    => 'checkbox',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SORTABLE'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SORTABLE_DESC'),
										'depends' => [
											['turn_off_heading', '=', 0],
										],
										'std' => 0,
									],
									'table_pagination' => [
										'type'    => 'checkbox',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI_DESC'),
										'std' => 0,
									],
									'pagination_item' => [
										'type'    => 'number',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI_NUMBER'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI_NUMBER_DESC'),
										'depends' => [
											['table_pagination', '=', 1],
										],
										'std' => 10,
									],
									'total_entries' => [
										'type'    => 'checkbox',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TOTAL_ENTRY'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TOTAL_ENTRY_DESC'),
										'depends' => [
											['table_pagination', '=', 1],
										],
										'std' => 0,
									],
									'total_entries_position' => [
										'type'    => 'checkbox',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TOTAL_ENTRY_POSITION'),
										'depends' => [
											['table_pagination', '=', 1],
											['total_entries', '=', 1],
										],
										'std' => 0,
									],
									'pagination_position' => [
										'type'    => 'select',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI_POSITION'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI_POSITION_DESC'),
										'depends' => [
											['table_pagination', '=', 1],
											['total_entries', '=', 0],
										],
										'values' => [
											'left-pagi'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
											'center-pagi' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
											'right-pagi'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
										],
										'std' => 'left-pagi',
									],
									'turn_off_responsive' => [
										'type'    => 'checkbox',
										'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TURNOFF_RESPONSIVE'),
										'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TURNOFF_RESPONSIVE_DESC'),
										'std' => 0,
									],
								],
							],
							],
							'table styles' => [
								'fields' => [
									[
										'table_text_alignment' => [
											'type'    => 'alignment',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TEXT_ALIGN'),
											'available_options' => ['left', 'center', 'right'],
											'std' => 'left',
										],
										'header_separator' => [
											'type'    => 'separator',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_HEADER_SEPARATOR'),
											'depends' => [
												['turn_off_heading', '=', 0],
											],
										],
										'first_tr_separator' => [
											'type'    => 'separator',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_FIRST_TR_SEPARATOR'),
											'depends' => [
												['turn_off_heading', '=', 1],
											],
										],
										'header_bg_options' => [
											'type'    => 'buttons',
											'std'     => 'color_bg',
											'depends' => [
											],
											'values' => [
												[
													'label' => 'Color BG',
													'value' => 'color_bg'
												],
												[
													'label' => 'Gradient BG',
													'value' => 'gradient_bg'
												],
											],
											'tabs' => true,
										],
										'header_bg_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'depends' => [
												['header_bg_options', '=', 'color_bg'],
											],
											'std' => '#6c7ae0',
										],
										'header_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
											'depends' => [
											],
											'std' => '#fff',
										],
						
										'header_gradient_bg' => [
											'type' => 'gradient',
											'std'  => [
												"color"  => "#00ad75",
												"color2" => "#8700fc",
												"deg"    => "45",
												"type"   => "linear"
											],
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
											'depends' => [
												['header_bg_options', '=', 'gradient_bg'],
											],
										],
						
										'header_padding' => [
											'type'    => 'padding',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
											'depends' => [											],
											'responsive' => true,
										],
										'header_border' => [
											'type'    => 'margin',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH_DESC'),
											'depends' => [											],
										],
										'header_border_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
											'depends' => [											],
										],

										'tr_td_separator' => [
											'type'    => 'separator',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TD_SEPARATOR'),
											'depends' => [
												],
										],

										'fields' => [
											'Row Style' => [
													'tr_bg_color' => [
														'type'    => 'color',
														'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
														'depends' => [
														],
													],
													'tr_second_bg_color' => [
														'type'    => 'color',
														'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TR_SEC_BG'),
														'depends' => [
														],
													],
													'tr_hover_bg_color' => [
														'type'    => 'color',
														'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR_HOVER'),
														'depends' => [
														],
													],
											],

											'Data Style' => [
												'td_bg_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
													'depends' => [
													],
												],
												'td_second_bg_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_TD_SEC_BG'),
													'depends' => [
													],
												],
												'td_padding' => [
													'type'    => 'padding',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
													'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
													'depends' => [
													],
													'responsive' => true,
												],
												'td_border' => [
													'type'    => 'margin',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
													'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH_DESC'),
													'depends' => [
													],
												],
												'td_border_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
													'depends' => [
													],
												],
											],
										],

										'sort_separator' => [
											'type'    => 'separator',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SORT_SEPARATOR'),
											'depends' => [
												['turn_off_heading', '=', 0],
												['table_sortable', '=', 1],
											],
										],
										'sort_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SORT_COLOR'),
											'depends' => [
												['turn_off_heading', '=', 0],
												['table_sortable', '=', 1],
											],
										],
										'sort_margin_right' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SORT_MARGIN_RIGHT'),
											'depends' => [
												['turn_off_heading', '=', 0],
												['table_sortable', '=', 1],
											],
											'min' => '0',
											'max' => '200',
										],

										'pagination_separator' => [
											'type'    => 'separator',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI_SEPARATOR'),
											'depends' => [
												['table_pagination', '=', 1],											],
										],

										'fields1' => [
											'depends' => [
												['table_pagination', '=', 1],
											],
											'Normal' => [
												'pagi_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_bg_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_font_family' => [
													'type'    => 'fonts',
													'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FONT_FAMILY'),
													'depends' => [
														['table_pagination', '=', 1],
													],
													'selector' => [
														'type' => 'font',
														'font' => '{{ VALUE }}',
														'css'  => '.sppb-page-link { font-family: "{{ VALUE }}"; }'
													]
												],
												'pagi_border_width' => [
													'type'    => 'margin',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
													'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH_DESC'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_border_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_border_radius' => [
													'type'    => 'slider',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
													'depends' => [
														['table_pagination', '=', 1],
													],
													'min' => 0,
													'max' => 200,
												],
												'pagi_margin' => [
													'type'    => 'slider',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
													'desc'    => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_PAGI_MARGIN_DESC'),
													'depends' => [
														['table_pagination', '=', 1],
													],
													'min' => 0,
													'max' => 50,
												],
												'pagi_padding' => [
													'type'    => 'padding',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
													'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
													'depends' => [
														['table_pagination', '=', 1],
													]
												],
											],

											'Hover' => [
												'pagi_hover_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_hover_bg_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_hover_border_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
											],

											'Active' => [
												'pagi_active_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_active_bg_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
												'pagi_active_border_color' => [
													'type'    => 'color',
													'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
													'depends' => [
														['table_pagination', '=', 1],
													],
												],
											],
										],

										'total_entries_separator' => [
											'type'    => 'separator',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_ENTRY_SEPARATOR'),
											'depends' => [
												['total_entries', '=', 1],
												['table_pagination', '=', 1],
											],
										],
										'total_entries_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'depends' => [
												['total_entries', '=', 1],
												['table_pagination', '=', 1],
											],
										],
										'total_entries_fontsize' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
											'std'     => '',
											'depends' => [
												['total_entries', '=', 1],
												['table_pagination', '=', 1],
											],
											'max' => 400,
										],
										'total_entries_font_family' => [
											'type'    => 'fonts',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_FONT_FAMILY'),
											'depends' => [
												['total_entries', '=', 1],
												['table_pagination', '=', 1],
											],
											'selector' => [
												'type' => 'font',
												'font' => '{{ VALUE }}',
												'css'  => '.sppb-table-total-reg { font-family: "{{ VALUE }}"; }'
											]
										],
										'total_entries_font_style' => [
											'type'    => 'fontstyle',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE'),
											'depends' => [
												['total_entries', '=', 1],
												['table_pagination', '=', 1],
											],
										],
										'search_separator' => [
											'type'    => 'separator',
											'title'   => Text::_('COM_SPPAGEBUILDER_ADDON_TABLE_ADVANCED_SEARCH_SEPARATOR'),
											'depends' => [
												['table_searchable', '=', 1]
											],
										],
										'search_bg_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
											'depends' => [
												['table_searchable', '=', 1]
											],
										],
										'search_text_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_COLOR'),
											'depends' => [
												['table_searchable', '=', 1]
											],
										],
										'search_border' => [
											'type'    => 'margin',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
											'desc'    => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH_DESC'),
											'depends' => [
												['table_searchable', '=', 1]
											],
										],
										'search_border_color' => [
											'type'    => 'color',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR'),
											'depends' => [
												['table_searchable', '=', 1]
											],
										],
										'search_padding' => [
											'type'    => 'padding',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
											'depends' => [
												['table_searchable', '=', 1]
											],
										],
										'search_margin_bottom' => [
											'type'    => 'slider',
											'title'   => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_BOTTOM'),
											'depends' => [
												['table_searchable', '=', 1]
											],
											'min' => 0,
											'max' => 100,
										],
									]
								]
							],
						],
					],
				],

				'table_advanced_add_new_item' => [
                    'action' => 'click',
                    'type' => 'plus',
                    'icon' => 'plusCircle',
                    'tooltip' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ADD_NEW'),
                    'meta' => [
                        'key' => 'table_advanced_item',
                    ],
                ],
			],
		],
		
		
		'attr'       => [
			'general' => [
				
			],
		],
	]
);
