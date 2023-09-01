<?php

class DISCO_FilterablePostList extends ET_Builder_Module
{

	public $slug = 'filterable_post_list';
	public $vb_support = 'on';
	public $page_no = 1;

	protected $module_credits = array(
		'module_uri' => '',
		'author' => '',
		'author_uri' => '',
	);

	public function init()
	{
		$this->name = esc_html__('DisCO.FilterablePostList', 'disco-custom-divi-extensions');
		
		var_dump('Loading actions');
		add_action('wp_ajax_disco_load_more',[$this,'ajax_load_more']);
		add_action('wp_ajax_nopriv_disco_load_more',[$this,'ajax_load_more']);
	}

	public function get_fields()
	{
		$categories = get_categories(array('hide_empty' => true));
		$categories_names = array();
		foreach($categories as $category){
			array_push($categories_names,$category->name);
		}
		return array(
			'number_of_posts' => array(
				'label' => et_builder_i18n('Number of posts to show'),
				'type' => 'range',
				'range_settings' => array(
					'min' => 1,
					'max' => 20,
					'step' => 1,
				),
				'option_category' => 'basic_option',
				'description' => esc_html__('Number of posts to show. If filtered, also this nymber of posts will be shown. This means that WordPress loads N posts of each category but only shows the filtered posts.', 'et_builder'),
				'toggle_slug' => 'main_content',
			),
			'filter_categories' => array(
				'label' => et_builder_i18n('The categories selected to filter'),
				'type' => 'multiple_checkboxes',
				'options' => $categories_names,
				'option_category' => 'basic_option',
				'description' => esc_html__('Number of posts to show. If filtered, also this nymber of posts will be shown. This means that WordPress loads N posts of each category but only shows the filtered posts.', 'et_builder'),
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
		// Categories filter
		$categories = get_categories();
		$categories_multiple_choice = explode('|',$this->props['filter_categories']);
		$categories_selected = array();
		$categories_selected_slug = array();
		$categories_selected_ids = '';
		$i = 0;
		foreach($categories as $category){
			if($categories_multiple_choice[$i] === 'on'){
				array_push($categories_selected, $category);
				array_push($categories_selected_slug, $category->slug);
				$categories_selected_ids .= ',' . $category->cat_ID;
			}
			$i++;
		}

		// Get latest post to show as default
		$posts = get_posts(array(
			'category' => $categories_selected_ids,
			'numberposts' => $this->props['number_of_posts']
		));
		
		// Get posts for each filtered category
		$posts_by_category = array();
		foreach ($categories_selected as $category) {
			$posts_by_category[$category->slug] = get_posts(array(
				'category' => $category->cat_ID,
				'numberposts' => $this->props['number_of_posts']
			));
		}

		// Print component
		// Print filter buttons
		$ret = '<div class="disco-filter-buttons-wrapper">';
		foreach($categories_selected as $category) {
			$ret .= sprintf('<div class="et_pb_button_module_wrapper et_pb_button_wrapper et_pb_module">'
						.   '  <a class="disco-%1$s-category et_pb_button" onclick="filterPosts(\'%1$s\')">'
						. 	'    %2$s'
						.	'  </a>'
						.	'</div> ',
						$category->slug,     
						$category->name,
					);
		}
		$ret .= '</div>';

		// Print latest posts with pagination
		$ret .= '<div class="disco-latest-list disco-active-list">';
		$ret .= $this->renderPaginationBtn('latest');
		$ret .= $this->renderPosts($posts);
		$ret .= '</div>';

		// Prepare filtered posts
		foreach ($posts_by_category as $category => $posts) {
			$ret .= sprintf('<div class="disco-%s-category-list">', $category);
			// Print latest posts by category
			$ret .= $this->renderPaginationBtn($category);
			$ret .= $this->renderPosts($posts);
			$ret .= '</div>';
		}

		return $ret;
	}

	function renderPosts($posts,bool $show_excerpt = true){
		// var_dump($posts);
		$html = '';
		foreach ($posts as $post) {
			$excerpt = '';
			if ($show_excerpt) {
				$excerpt = get_the_excerpt($post->ID);
			}
			// Create category tags
			$post_categories = get_the_category($post->ID);
			$cat_links = '';
			foreach ($post_categories as $post_cat){
				$cat_links .= sprintf( '<a href="%1$s" rel="tag">%2$s</a>',get_category_link($post_cat),$post_cat->name);
			}
			$html .= sprintf(
					'<article id="post-%1$s" class="et_pb_post">'
					. '  <p class="post-meta categories">'
					. '    %2$s'
					. '  </p>'
					. '  <a href="%4$s" class="entry-featured-image-url">'
					. '    %3$s'
					. '  </a>'
					. '  <h2 class="entry-title">'
					. '     <a href="%4$s">'
					. '       %5$s'
					. '     </a>'
					. '  </h2>'
					. '  <p class="post-meta date">'
					. '     <span class="published">'
					. '       %6$s'
					. '     </span>'
					. '  </p>'
					. '  <div class="post-content">'
					. '    <div class="excerpt">%7$s</div>'
					. '    <div class="et_pb_button_module_wrapper et_pb_button_wrapper et_pb_module">'
					. '      <a  href="%4$s" class="more-link et_pb_button">'
					. '        Continue reading'
					. '      </a>'
					. '    </div> '
					. '  </div>'
					. '</article>',
					$post->ID,
					$cat_links,
					get_the_post_thumbnail($post->ID),
					get_permalink($post->ID),
					$post->post_title,
					get_the_date('F j, Y',$post->ID),
					$excerpt,
			);
		}
		return $html;
	}

	function renderPaginationBtn(string $list = 'latest'){
		// Print pagination button
		$html = sprintf(
				'<div class="et_pb_button_module_wrapper et_pb_button_wrapper et_pb_module">'
			.   '  <a id="disco-%1$s-load-more" class="et_pb_button" data-page="%2$s" data-list="%1$s" onclick="handleLoadMorePosts(event)">'
			. 	'    Previous posts'
			.	'  </a>'
			.	'</div> ',
			$list,
			$this->page_no
		);

		return $html;
	}

	// Create ajax endpoint
	function ajax_load_more(){

		echo 'Yess';
		wp_die();

		// // Check is an AJAX request
		// if(!empty($_SERVER['HTTP_X_REQUESTE_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTE_WITH']) === 'xmlhttprequest') {
		// 	wp_send_json_error(__('Invalid request.', 'text-domain'));
		// 	wp_die('0',400);
		// }

		// // Check nonce
		// if(!check_ajax_referer('loadmore_post_nonce',false)) {
		// 	wp_send_json_error(__('Invalid security token sent.', 'text-domain'));
		// 	wp_die('0',400);
		// }

		// $offset = 10*($_POST['page']);
		// $category = $_POST['category'] ? get_cat_ID($_POST['category']) : '';
		
		// $posts = get_posts(array(
		// 	'offset' => $offset,
		// 	'category' => $category,
		// 	'numberposts' => $this->props['number_of_posts']
		// ));

		// $html = $this->renderPosts($posts);

		// echo json_encode($html);

		// die;
	}

}

new DISCO_FilterablePostList;
