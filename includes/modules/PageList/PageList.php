<?php

class DISCO_PageList extends ET_Builder_Module
{

	public $slug = 'page_list';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author' => '',
		'author_uri' => '',
	);

	public function init()
	{
		$this->name = esc_html__('DisCO.PageList', 'disco-custom-divi-extensions');
	}

	public function get_fields()
	{
		return array(
			'parent' => array(
				'label' => et_builder_i18n('Parent Page'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('The Id for the page whose children you want to show', 'et_builder'),
				'toggle_slug' => 'main_content',
			),
			'columns' => array(
				'label' => et_builder_i18n('Number of columns'),
				'type' => 'range',
				'range_settings' => array(
					'min' => 1,
					'max' => 4,
					'step' => 1,
				),
				'option_category' => 'basic_option',
				'description' => esc_html__('Number of columns', 'et_builder'),
				'toggle_slug' => 'main_content',
			),
			'cnt' => array(
				'label' => et_builder_i18n('Number of links'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('Maximum number of links to show', 'et_builder'),
				'toggle_slug' => 'main_content',
			),
			'show_excerpt' => array(
				'label' => et_builder_i18n('Show excerpt'),
				'type' => 'yes_no_button',
				'options' => array(
					'no' => esc_html('No', 'et_builder'),
					'yes' => esc_html('Yes', 'et_builder'),
				), 'option_category' => 'basic_option',
				'description' => esc_html__('Show page excerpt', 'et_builder'),
				'toggle_slug' => 'main_content',
			),
		);
	}

	public function render($attrs, $content = null, $render_slug)
	{
		$cols = $this->props['columns'];
		$pages = get_pages(array(
			'parent' => $this->props['parent'],
			'sort_column' => 'menu_order,post_title',
			'sort_order' => 'asc',
			'number' => $this->props['cnt'],
		));
		$ret = sprintf("<div class=\"et_pb_row_%scol\">", $cols);
		foreach ($pages as $page) {
			$excerpt = '';
			if ($this->props['show_excerpt']) {
				$excerpt = get_the_excerpt($page->ID);
			}
			$ret .=
				sprintf('<div class="et_pb_column et_pb_column_1_%s">', $cols)
				. sprintf(
					'<div class="page_list">'
					. '  <a href="%1$s">'
					. '    <div class="overlay">'
					. '      <div class="title"><span class="text">%2$s</span></div>'
					. '    </div>'
					. '    <img src="%3$s">'
					. '  </a>'
					. '<div class="excerpt">%4$s</div>'
					. '</div>',
					get_page_link($page->ID),
					$page->post_title,
					get_the_post_thumbnail_url($page->ID),
					$excerpt,
				)
				. '</div>';
		}
		$ret .= '</div>';
		return $ret;
	}
}

new DISCO_PageList;
