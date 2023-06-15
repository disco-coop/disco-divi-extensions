<?php

class DISCO_Title extends ET_Builder_Module {

	public $slug       = 'disco_hello_world';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => '',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__( 'Title', 'disco-custom-divi-extensions' );
	                $this->fullwidth        = true;
	}

	public function get_fields() {
		return array(
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
		return sprintf( '<div class="dots02"><img src="">%1$s</img></div>', $this->props['content'] );
	}
}

new DISCO_Title;
