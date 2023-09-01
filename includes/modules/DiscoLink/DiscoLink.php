<?php

class DISCO_DiscoLink extends ET_Builder_Module
{

	public $slug = 'disco_link';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author' => '',
		'author_uri' => '',
	);

	public function init()
	{
		$this->name = esc_html__('DisCO.link', 'disco-custom-divi-extensions');
	}

	public function get_fields()
	{
		return array(
			'src' => array(
				'label' => et_builder_i18n('Image'),
				'type' => 'upload',
				'option_category' => 'basic_option',
				'upload_button_text' => et_builder_i18n('Upload an image'),
				'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
				'update_text' => esc_attr__('Set As Image', 'et_builder'),
				'hide_metadata' => true,
				'affects' => array(
					'alt',
					'title_text',
				),
				'description' => esc_html__('Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'image',
				'mobile_options' => true,
				'hover' => 'tabs',
			),
			'url' => array(
				'label' => esc_html__('Image Link URL', 'et_builder'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'off',
				'description' => esc_html__('If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.', 'et_builder'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'url',
			),
			'alt' => array(
				'label' => esc_html__('Image ALT text', 'et_builder'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'off',
				'description' => esc_html__('Alternate text for image.', 'et_builder'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'url',
			),
			'content' => array(
				'label' => esc_html__('Content', 'disco-custom-divi-extensions'),
				'type' => 'tiny_mce',
				'option_category' => 'basic_option',
				'description' => esc_html__('Content entered here will appear inside the module.', 'disco-custom-divi-extensions'),
				'toggle_slug' => 'main_content',
			),
		);
	}

	public function render($attrs, $content = null, $render_slug)
	{
		return sprintf(
			'<div class="disco_link">'
			. '  <a href="%1$s">'
			. '    <div class="overlay">'
			. '      <div class="title"><span class="text">%2$s</span></div>'
			. '    </div>'
			. '    <img src="%3$s">'
			. '  </a>'
			. '</div>',
			$this->props['url'],
			$this->props['content'],
			$this->props['src'],
			print_r($this->props, true),
		);
	}
}

new DISCO_DiscoLink;
