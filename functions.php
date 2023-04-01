<?php

function twentyfifteenchild_theme_setup()
{

    load_child_theme_textdomain( 'twentyfifteenchild', get_stylesheet_directory() . '/languages' );

    add_action( 'wp_enqueue_scripts', 'twentyfifteenchild_theme_enqueue_styles' );
	function twentyfifteenchild_theme_enqueue_styles() {

	    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

	    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	    wp_enqueue_style( 'child-style',
	        get_stylesheet_directory_uri() . '/style.css',
	        array( $parent_style ),
	        wp_get_theme()->get('Version')
	    );


	    wp_enqueue_style( 'custom', get_stylesheet_directory_uri().'/css/custom.css' );
    	wp_enqueue_script( 'modernizr',  get_stylesheet_directory_uri() . '/js/modernizr.js', array( 'jquery' ), '1.0', true );

    	wp_enqueue_script( 'plugins',  get_stylesheet_directory_uri() . '/js/plugins.js', array( 'jquery' ), '1.0', true );

    	wp_enqueue_script( 'custom',  get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );

		wp_enqueue_script( 'ajax-call',  get_stylesheet_directory_uri() . '/js/ajax-call.js', array( 'jquery' ), '1.0', true );

		wp_localize_script( 'ajax-call', 'ajaxcall', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		));
	}

}
add_action( 'after_setup_theme', 'twentyfifteenchild_theme_setup' );



add_action( 'wp_ajax_nopriv_ajax_get_post_by_month', 'ajax_get_post_by_month' );
add_action( 'wp_ajax_ajax_get_post_by_month', 'ajax_get_post_by_month' );
function ajax_get_post_by_month()
{
    $month = (int) $_POST['month'];

	$args = array(
		'date_query' => array(
			array(
				'month' => $month
			),
		),
	);
	$q = new WP_Query( $args );
	if( $q->have_posts() ) {
		while( $q->have_posts() ) {

			$q->the_post();

			$cat_collection = get_the_category();
			?>
			<li class="ajax-post-call" id="postID<?php echo get_the_ID(); ?>" data-post-id="<?php echo get_the_ID(); ?>">
				<a href="#" class="lists">
					<div class="mask img-holder cover-img">
						<?php the_post_thumbnail(); ?>
					</div>
					<span class="title"><?php the_title(); ?></span>
					<span class="cats"><?php echo $cat_collection[0]->name; ?></span>
				</a>
			</li>
			<?php
		}

	}
	else
	{
		?>
		<li class="not-found">
			<a href="#">
				<span class="title">No Post Found !</span>
			</a>
		</li>
		<?php
	}

    die();
}

//added posts//
add_action( 'wp_ajax_nopriv_ajax_get_all_posts', 'ajax_get_all_posts' );
add_action( 'wp_ajax_ajax_get_all_posts', 'ajax_get_all_posts' );
function ajax_get_all_posts()
{
	$args = array(
        'post_status' => array('publish'),
        //'category_name' => 'Current Trip'
	);
	$query = new WP_Query( $args );

	if ($query->have_posts()) {
		$ajaxposts = array();
		while ($query->have_posts()) {
            $query->the_post();
			$item = array();
			$item['id'] = get_the_ID();
            $item['title'] = get_the_title();
            $item['permalink'] = get_the_permalink();
            //$item['content'] = get_the_content();
            $item['post_date'] = get_the_date();

            $item['latitude'] = get_post_meta($query->post->ID, 'latitude', true);
            $item['longitude'] = get_post_meta($query->post->ID, 'longitude', true);
			array_push($ajaxposts,$item);
		}

		wp_reset_postdata();
		echo json_encode( $ajaxposts );
	}
	else
	{
		echo "[]";
	}

    die();
}



add_action( 'wp_ajax_nopriv_ajax_get_post_by_id', 'ajax_get_post_by_id' );
add_action( 'wp_ajax_ajax_get_post_by_id', 'ajax_get_post_by_id' );
function ajax_get_post_by_id()
{
    $post_id = (int) $_POST['post_id'];

	$args = array( 'p' => $post_id );
	$q = new WP_Query( $args );
	if( $q->have_posts() ) {
		while( $q->have_posts() ) {

			$q->the_post();

			$cat_collection = get_the_category();
			?>
			<div class="scroll-container">
				<div id="bar" class="bar">
					<ul class="padded">
						<!-- <li class="blue">Cat : <?php echo $cat_collection[0]->name; ?></li>
						<li class="address">
							Meta two
						</li> -->
					</ul>
				</div>

        <a class="close" id="close-place" onclick="Mapper.closePost()">
    <span>&times;</span>
</a>

				<h1 class="padded blue"><?php the_title(); ?></h1>
				<div class="featured-mask img-holder cover-img">
					<?php the_post_thumbnail(); ?>
				</div>

        <div class="next-priv">
			<?php $prev_post_id = get_previous_post_id( $post_id );  ?>
            <a href="#" data-previd="<?php echo $prev_post_id; ?>" class="btn btn-default card-link previous_post<?php echo ($prev_post_id != null) ? '':' inactive'; ?>">Previous</a>

			<?php $next_post_id = get_next_post_id( $post_id );  ?>
            <a href="#" data-nextid="<?php echo $next_post_id; ?>" class="btn btn-default card-link float-right next_post<?php echo ($next_post_id != null) ? '':' inactive'; ?>">Next</a>

         </div>

				<div class="content padded">
					<div class="column">
						<?php the_content(); ?>
					</div>
				</div>

				<div class="layout"></div>
			</div>
			<?php
		}

	}
	else
	{
		?>
		<li class="not-found">
			<a href="#">
				<span class="title">No Post Found !</span>
			</a>
		</li>
		<?php
	}

    die();
}



function get_previous_post_id( $post_id ) {
    // Get a global post reference since get_adjacent_post() references it
    global $post;
    // Store the existing post object for later so we don't lose it
    $oldGlobal = $post;
    // Get the post object for the specified post and place it in the global variable
    $post = get_post( $post_id );
    // Get the post object for the previous post
    $previous_post = get_previous_post();
    // Reset our global object
	$post = $oldGlobal;
	if(!empty($previous_post)){
		return $previous_post->ID;
	}
	else{
		return null;
	}
}

function get_next_post_id( $post_id ) {
    // Get a global post reference since get_adjacent_post() references it
    global $post;
    // Store the existing post object for later so we don't lose it
    $oldGlobal = $post;
    // Get the post object for the specified post and place it in the global variable
    $post = get_post( $post_id );
    // Get the post object for the next post
    $next_post = get_next_post();
    // Reset our global object
	$post = $oldGlobal;
	if(!empty($next_post)){
		return $next_post->ID;
	}
	else{
		return null;
	}
}
