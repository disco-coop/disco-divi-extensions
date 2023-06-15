<?php

class DISCO_LinkImage extends ET_Builder_Module {

	public $slug       = 'disco_link_image';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => '',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__( 'Hello World', 'disco-custom-divi-extensions' );
	}

	public function get_fields() {
		return array(
            'src'                 => array(
                'label'              => et_builder_i18n( 'Image' ),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => et_builder_i18n( 'Upload an image' ),
                'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
                'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
                'hide_metadata'      => true,
                'affects'            => array(
                    'alt',
                    'title_text',
                ),
                'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
                'toggle_slug'        => 'main_content',
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ),
            'url'                 => array(
                'label'           => esc_html__( 'Image Link URL', 'et_builder' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'depends_show_if' => 'off',
                'description'     => esc_html__( 'If you would like your image to be a link, input your destination URL here. No l
ink will be created if this field is left blank.', 'et_builder' ),
                'toggle_slug'     => 'link',
                'dynamic_content' => 'url',
            ),
			'content' => array(
				'label'           => esc_html__( 'Content', 'disco-custom-divi-extensions' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'disco-custom-divi-extensions' ),
				'toggle_slug'     => 'main_content',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf( '<h1>%1$s</h1>', $this->props['content'] );
	}
}

new DISCO_LinkImage;
