<?php

/**
 * Deprecated, functions moved to wc-functions.php, delete file in v6.
 *
 * This empty file is needed to not crash existing bootcommerce-child installations
 * because they have require get_template_directory() . '/woocommerce/woocommerce-functions.php';
 * in their functions.php.
 */
add_action('wp_enqueue_scripts', 'x1team_scripts');
function x1team_scripts() {

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', ( 'https://code.jquery.com/jquery-3.7.1.min.js' ), false, null, true );
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script('create-vendor-product', get_template_directory_uri() . '/woocommerce/js/create-vendor-product.js', array('jquery'), '1.0' );
	wp_enqueue_script('x1team-main', get_template_directory_uri() . '/assets/x1team-main.js', array('jquery'), '1.0' );





}

add_action( 'wp_enqueue_scripts', 'add_data_to_scripts' );
function add_data_to_scripts() {
    $userData = wp_get_current_user();
    $user = $userData->ID ? true : false;

	$data = [];

	if ( $userData->ID ) {
		$data['user'] = [
			'user_id' => $userData->ID,
			'user_nickname'=>$userData->nickname
		];
	} else {

		$data['user'] = false;


	}


    wp_add_inline_script('x1team-main', 'window.x1teamMainData = '.wp_json_encode( $data ), 'before');
}





add_theme_support( 'wc-product-gallery-slider' );
add_filter( 'excerpt_more', 'new_excerpt_more' );
function new_excerpt_more( $more ){
	global $post;

    return '... <a role="button" href="'.get_permalink($post).'" data-bs-toggle="collapse" data-bs-target="#more" aria-expanded="false" aria-controls="collapseExample"><span class="link-primary link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover text-nowrap">Читать далее</span></a>';


	// return '... <a href="'. get_permalink($post) . '">Читать дальше</a>';
}
add_filter( 'excerpt_length', function(){
	return 16;
} );
add_action( 'woocommerce_product_options_advanced', 'rudr_product_field' );
function rudr_product_field(){

	echo '<div class="options_group">';
	woocommerce_wp_text_input(
		array(
			'id'      => 'product_link_video',
			'value'   => get_post_meta( get_the_ID(), 'product_link_video', true ),
			'label'   => 'Сылка видео',
			'desc_tip' => true,
			'description' => 'Вставьте сылку на видео',
		)
	);
	echo '</div>';

}
add_action( 'woocommerce_process_product_meta', 'rudr_save_field' );
function rudr_save_field( $id ){

	$super = isset( $_POST[ 'product_link_video' ] ) ? $_POST[ 'product_link_video' ] : "";
	update_post_meta( $id, 'product_link_video', $super );

}

function custom_login_redirect( $redirect_to, $request, $user ) {
    // Get the current user's role
    if ( isset($_GET['blocklyfile'] ) ) {
		wp_redirect('./blockly/blockly?blocklyfile=' . $_GET['blocklyfile']);
	}


    return $redirect_to;
}
add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 );




add_filter( 'woocommerce_account_menu_items', 'my_account_menu' );
function my_account_menu( $menu_links ){
	$menu_links = array(
		// 'dashboard'          => __( 'Панель управления', 'woocommerce' ),
		'orders'             => __( 'Покупки', 'woocommerce' ),
		'sales' 	=> __( 'Продажи', 'woocommerce' ),
		'ads' 	=> __( 'Объявления', 'woocommerce' ),
		'ads_add' 	=> __( 'Добавить объявление', 'woocommerce' ),
		'sales-orders' 	=> __( 'Заказы покупателей', 'woocommerce' ),
		'edit-account'       => __( 'Анкета', 'woocommerce' ),
		'customer-logout'    => __( 'Выйти', 'woocommerce' ),


		// 'edit-address'       => __( 'Адреса', 'woocommerce' ),
		// 'woo-wallet'         => __( 'Анкета', 'woocommerce' ),
		// 'edit-account'       => __( 'Детали профиля', 'woocommerce' ),


	);
	return $menu_links;
}

add_filter( 'woocommerce_get_endpoint_url', 'my_account_menu_endpoint', 10, 4 );
function my_account_menu_endpoint( $url, $endpoint, $value, $permalink ) {
	if ( $endpoint === 'ads' ) {
		$current_user = wp_get_current_user();
		$user_id =  $current_user->ID;
		$vendor = yith_get_vendor( $user_id, 'user' );
		$url = home_url( "/vendor/".$vendor->term->slug );
	}
	if ( $endpoint === 'ads_add' ) {
		$url = home_url( 'vendor-new-product' );
	}
	return $url;
}
add_action( 'init', 'add_x1team_list_endpoint' );
function add_x1team_list_endpoint() {
	add_rewrite_endpoint( 'sales-orders', EP_PAGES );
}
add_action( 'woocommerce_account_sales-orders_endpoint', 'show_templated_sales_orders' );
function show_templated_sales_orders() {
	require_once dirname( __FILE__ )  . '/myaccount/sales-orders.php';
}






add_filter( 'woocommerce_checkout_fields', 'x1team_del_fields', 25 );
function x1team_del_fields( $fields ) {

	// оставляем эти поля
	// unset( $fields[ 'billing' ][ 'billing_first_name' ] ); // имя
	// unset( $fields[ 'billing' ][ 'billing_last_name' ] ); // фамилия
	// unset( $fields[ 'billing' ][ 'billing_phone' ] ); // телефон
	// unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл

	// // удаляем все эти поля
	unset( $fields[ 'billing' ][ 'billing_company' ] ); // компания
	unset( $fields[ 'billing' ][ 'billing_country' ] ); // страна
	unset( $fields[ 'billing' ][ 'billing_address_1' ] ); // адрес 1
	unset( $fields[ 'billing' ][ 'billing_address_2' ] ); // адрес 2
	unset( $fields[ 'billing' ][ 'billing_city' ] ); // город
	unset( $fields[ 'billing' ][ 'billing_state' ] ); // регион, штат
	unset( $fields[ 'billing' ][ 'billing_postcode' ] ); // почтовый индекс
	unset( $fields[ 'order' ][ 'order_comments' ] ); // заметки к заказу


    // $fields[ 'billing' ] = [];
    // $fields[ 'shipping' ] = [];
    // unset( $fields[ 'billing' ]);
    // unset( $fields[ 'shipping' ]);
    // var_dump($fields);
	return $fields;

}

add_filter( 'woocommerce_checkout_fields', 'x1team_required_fields', 25 );
function x1team_required_fields( $fields ) {

	// print_r( $fields ); exit // если хотите узнать названия полей
	$fields[ 'billing' ][ 'billing_first_name' ][ 'required' ] = false; // необязательно
	$fields[ 'billing' ][ 'billing_last_name' ][ 'required' ] = false; // необязательно
	$fields[ 'billing' ][ 'billing_email' ][ 'required' ] = false; // обязательно

	return $fields;

}


add_action( 'woocommerce_after_shop_loop_item', 'edit_link_after_btn_card', 10 );
function edit_link_after_btn_card() {
	$current_user = wp_get_current_user();
	if( $current_user->exists() ){
		global $product;
		// Авторизован.
		// $user_login =  $current_user->user_login;
		// $user_email =  $current_user->user_email;
		// $user_firstname =  $current_user->user_firstname;
		// $user_lastname =  $current_user->user_lastname;
		// $user_display_name =  $current_user->display_name;
		$user_id =  $current_user->ID;

		$vendor = yith_get_vendor( $product->get_id(), 'product' );
		$vendor_user_id = $vendor->get_owner();

		if ( is_a( $product, 'WC_Product' ) &&  $vendor_user_id == $user_id ) {
			echo '<a href="/edit-product/?edit-id='.$product->get_id().'">Редактировать</a>';
		}
	}
}

// add_action( 'init', 'add_my_account_list_endpoint' );
// function add_my_account_list_endpoint() {
// 	add_rewrite_endpoint( 'online-voice-order', EP_PAGES );
// 	add_rewrite_endpoint( 'instr', EP_PAGES );
// 	add_rewrite_endpoint( 'feedback', EP_PAGES ); //добавил
// 	add_rewrite_endpoint( 'formated', EP_PAGES );
// 	add_rewrite_endpoint( 'test_cli', EP_PAGES );
// 	add_rewrite_endpoint( 'order_ready', EP_PAGES );
// }

// add_action( 'woocommerce_account_online-voice-order_endpoint', 'show_templated_online_voice' );
// function show_templated_online_voice() {
// 	require_once dirname( __FILE__ )  . '/my-account/show_templated_online_voice.php';
// }

// $sss = get_post_meta(113);
// echo '<pre>';
// var_dump( YITH_Vendors() );
// var_dump( YITH_Vendors()->get_vendors() );
// var_dump( YITH_Vendors()->get_role_name() );
// var_dump( YITH_Vendors()->get_user_meta_key() );
// var_dump( YITH_Vendors()->get_user_meta_owner() );
// var_dump( YITH_Vendors()->get_taxonomy_name() );


// $vendor = yith_get_vendor( 'current', 'product' );
// var_dump($vendor);

// $vendor = yith_get_vendor( 'current', 'user' );
// var_dump($vendor);

// $vendor = yith_get_vendor( 'current', 'vendor' );
// var_dump($vendor);


// var_dump( $vendor_id );
// var_dump( YITH_Vendors()->get_taxonomy_name() );
// var_dump(  get_term_by ( 'term_id', $vendor_id, YITH_Vendors()->get_taxonomy_name() ) );
// echo '</pre>';


add_action('wp_ajax_create_vendor_product', 'create_vendor_product');
function create_vendor_product() {
	$user_id = get_current_user_id();

	$product_data = $_POST;



	$product_id = create_product($product_data);
	$arg = array(
		'ID' => $product_id,
		'post_author' => $user_id,
	);
	wp_update_post( $arg );

	$cat_product = $product_data["cat_product"];
	$cat_product_int = array_map(function( $str ) {
		return (int)$str;
	}, $cat_product);

	wp_set_object_terms( $product_id, $cat_product_int, 'product_cat', false );


	var_dump('done');

	wp_die();
}
function create_product($product_data) {
	$product = new WC_Product_Simple();

	$product->set_status( 'pending' );

	$product->set_name( $product_data['title'] );

	$product->set_slug( sanitize_title( $product_data['title'] ) );

	$product->set_regular_price( $product_data['regular_price'] );
	if ( $product_data['sale_price_field'] != '' ) {
		$product->set_sale_price( $product_data['sale_price_field'] );
	}

	$product->set_description( $product_data['content'] );

	$product->set_short_description( $product_data['excerpt'] );
	// you can also add a full product description
	// $product->set_description( 'long description here...' );

	// $product->set_image_id( 90 );

	// let's suppose that our 'Accessories' category has ID = 19
	// $product->set_category_ids( array( 19 ) );
	// you can also use $product->set_tag_ids() for tags, brands etc

	$product->save();

	return $product->get_id();
}



add_action('wp_ajax_update_vendor_product', 'update_vendor_product');
function update_vendor_product() {


	$product_data = $_POST;

	$product_id = update_product($product_data);


	$cat_product = $product_data["productCategory"];
	$cat_product_int = array_map(function( $str ) {
		return (int)$str;
	}, $cat_product);

	wp_set_object_terms( $product_id, $cat_product_int, 'product_cat', false );

	echo get_post_permalink( $product_id );

	wp_die();
}
function update_product( $product_data ) {

	$user_id = get_current_user_id();

	$product = wc_get_product( $product_data['productID'] );

	$product->set_name( trim($product_data['productTitle']) );
	$product->set_description( trim($product_data['productDescription']) );
	$product->set_price( $product_data['productPrice'] );
	$product->set_sale_price( $product_data['productPrice'] );
	$product->set_regular_price( $product_data['productRegularPrice'] );

	$product->save();

	return $product->get_id();
	// $arg = array(
	// 	'ID' => $product_data['productID'],
	// 	'post_author' => $user_id,

	// );
	// wp_update_post( $arg );
}



// Not Use
function categories_single_product_bottom() {
	$taxonomy     = 'product_cat';
	$orderby      = 'name';
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no
	$title        = '';
	$empty        = 0;

	$args = array(
			'taxonomy'     => $taxonomy,
			'orderby'      => $orderby,
			'show_count'   => $show_count,
			'pad_counts'   => $pad_counts,
			'hierarchical' => $hierarchical,
			'title_li'     => $title,
			'hide_empty'   => $empty
	);
	$all_categories = get_categories( $args );

	$html = '';
	foreach ($all_categories as $cat) {
		if($cat->category_parent == 0) {
			$category_id = $cat->term_id;

			$cat_url = get_term_link($cat->slug, $taxonomy);
			$cat_name = $cat->name;
			if ( $cat_name == 'Misc') continue;

			$args2 = array(
					'taxonomy'     => $taxonomy,
					'child_of'     => 0,
					'parent'       => $category_id,
					'orderby'      => $orderby,
					'show_count'   => $show_count,
					'pad_counts'   => $pad_counts,
					'hierarchical' => $hierarchical,
					'title_li'     => $title,
					'hide_empty'   => $empty
			);
			$sub_cats = get_categories( $args2 );
			$html_inner = '';
			if($sub_cats) {
				$isset_sub_class = 'form-list';
				$html_inner = '<a class="d-block" data-bs-toggle="collapse" href="#collapseCatalogItem'.$category_id.'" role="button" aria-controls="collapseCatalogItem'.$category_id.'">
									<input class="form-check-input" type="checkbox" value="" id="'.$category_id.'">
									<label class="form-check-label" for="'.$category_id.'">'.$cat_name.'</label>
									<div class="form-check-arrow"></div>
								</a>
								<div class="collapse" id="collapseCatalogItem'.$category_id.'">
								';
				foreach($sub_cats as $sub_category) {
					$sub_category_id = $sub_category->term_id;
					$sub_cat_name = $sub_category->name;
					$html_inner .= '<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="'.$sub_category_id.'">
										<label class="form-check-label" for="'.$sub_category_id.'">'.$sub_cat_name.'</label>
									</div>';
				}
				$html_inner .= '</div>';
			} else {
				$isset_sub_class = '';
				$html_inner = '<input class="form-check-input" type="checkbox" value="" id="'.$category_id.'">
								<label class="form-check-label" for="'.$category_id.'">'.$cat_name.'</label>';
			}
			$html .= '<div class="form-check border-bottom py-2 '.$isset_sub_class.'"> '.$html_inner.' </div>';
		}
	}
	$wrapper = '<div class="form-check border-bottom py-2">
					<input class="form-check-input" type="checkbox" value="" id="user_announcements">
					<label class="form-check-label" for="user_announcements">Мои объявления</label>
				</div>' . $html;
	echo $wrapper;
}
function filter_single_product_bottom( $type, $categories = [] ) {
	$categories_list = isset($_POST['categories_ids']) ? $_POST['categories_ids'] : $categories;
	if ( !$categories_list ) {
		$categories_list = [ ];
	}

	$data_query = [
		'status'    => 'publish',
		'limit'     => 4,
		'product_category_id' => $categories_list
	];
	$products = wc_get_products( $data_query);

	if ( in_array( 'user_announcements', $categories ) ) {
		unset($data_query['product_category_id']);

		$data_query['author'] = get_current_user_id();

		$products_author = wc_get_products($data_query);
		foreach ($products_author as $key => $product) {
			$products[] = $product;
		}
	}

	ob_start();
	foreach ($products as $_product) {
		$thumbnail_url = get_the_post_thumbnail_url( $_product->get_id() );
		if ( !$thumbnail_url) $thumbnail_url = wc_placeholder_img_src('thumb');
		?>
			<div class="d-flex mb-5">
				<div class="flex-shrink-0"><img class="img-fluid img-flex-card rounded me-3" src="<?= $thumbnail_url ?>" alt=""></div>
					<div class="flex-grow-1 py-0">
						<div class="row">
						<div class="col-xl-7"><a class="d-block fw-bold" href="<?php echo get_post_permalink($_product->get_id()) ?>"><?php echo $_product->get_name() ?></a>
							<p class="fs-6 mb-2">Купить абонемент или билет на занятие</p>
							<?php if( current_user_can('edit_pages') ) { ?>
								<a class="link-success redact" href="ge<?php echo get_edit_post_link($_product->get_id()) ?>">Редактировать</a>
							<?php } ?>
							<div class="mb-3">
							<div class="collapse" id="addDescrCard">
								<div class="card card-body px-0">
								<textarea class="form-control" id="textareaCardDescription" name="" cols="30" rows="2"></textarea>
								</div>
								<button class="btn btn-sm btn-secondary">Добавить </button>
							</div>
							</div>
						</div>
						<div class="col-xl-2">
							<div class="d-flex flex-column justify-content-center align-items-start">

							<h5 class="text-danger text-nowrap m-0"><?php echo $_product->get_price() . ' ' . get_woocommerce_currency_symbol()?></h5>
							<?php if ( $_product->get_regular_price() ) { ?>
								<p class="text-decoration-line-through"><?php echo $_product->get_regular_price() . ' ' . get_woocommerce_currency_symbol() ?></p>
							<?php }?>

							</div>
						</div>
						<div class="col-xl-3">
							<div class="count d-flex flex-md-wrap flex-nowrap">
							<div class="count-content collapse pe-2" id="collapseCartCatalog1" data-bs-delay="{&quot;show&quot;:0,&quot;hide&quot;:150}"><span class="change minus min d-flex justify-content-center align-items-center"><span>-</span></span>
								<input type="text" name="productСount" value="1" disabled=""><span class="change plus d-flex justify-content-center align-items-center"><span>+</span></span>
							</div>
							<div class="btn-block ms-auto" href="#collapseCartCatalog1" data-bs-toggle="collapse">
								<button class="btn btn-primary w-100">
								<svg class="bi bi-basket" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
									<path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"></path>
								</svg><span>В корзину</span>
								</button>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
	$contetn = ob_get_contents();
	ob_end_clean();
	if ( $type == 'front' ) {
		echo  $contetn;
	} else if ( $type == 'ajax' ) {
		echo json_encode($contetn, JSON_UNESCAPED_SLASHES);
		wp_die();
	}
}