<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function lqh_evp_create_posttype() {
	
	$labels = array(
			'name'               => __( 'Elearning Videos' ),
			'singular_name'      => __( 'Elearning Video' ),
			'add_new'            => __( 'Add Video' ),
			'add_new_item'       => __( 'Add Video' ),
			'edit_item'          => __( 'Edit Video' ),
			'new_item'           => __( 'New Video' ),
			'view_item'          => __( 'View Video' ),
			'search_items'       => __( 'Search Video' ),
			'not_found'          => __( 'No videos found' ),
			'not_found_in_trash' => __( 'No videos in the trash' ),
		);
		$supports = array(
			'title'
		);
		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'elearning-video-lqh', ),
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-format-video',
			'register_meta_box_cb' => 'lqh_evp_add_evideo_metaboxes'
		);
	
	
	register_post_type( 'evideolqh', $args	);
	
	$labels2 = array(
			'name'                       => __( 'E-Video Categories' ),
			'singular_name'              => __( 'E-Video Category' ),
			'menu_name'                  => __( 'E-Video Categories' ),
			'edit_item'                  => __( 'Edit E-Video Category' ),
			'update_item'                => __( 'Update E-Video Category' ),
			'add_new_item'               => __( 'Add New E-Video Category' ),
			'new_item_name'              => __( 'New E-Video Category Name' ),
			'parent_item'                => __( 'Parent E-Video Category' ),
			'parent_item_colon'          => __( 'Parent E-Video Category:' ),
			'all_items'                  => __( 'All E-Video Categories' ),
			'search_items'               => __( 'Search E-Video Categories' ),
			'popular_items'              => __( 'Popular E-Video Categories' ),
			'separate_items_with_commas' => __( 'Separate E-Video categories with commas' ),
			'add_or_remove_items'        => __( 'Add or remove E-Video categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used E-Video categories' ),
			'not_found'                  => __( 'No E-Video categories found.' ),
		);
		$args2 = array(
			'labels'            => $labels2,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'elearning-video-lqh-category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);
		$args2 = apply_filters( 'evideo_post_type_category_args', $args2 );
	
	register_taxonomy( 'evideolqh-categories', 'evideolqh', $args2 );
	
	// Add the Video Link Meta Boxes and show Shortcode
	function lqh_evp_add_evideo_metaboxes() {
		add_meta_box('evideolqh-link', 'Video Links', 'lqh_evp_link', 'evideolqh', 'normal', 'high');
		add_meta_box('evideolqh-subtitle', 'Video Subtitle', 'lqh_evp_sub', 'evideolqh', 'normal', 'high');
		add_meta_box('evideolqh-poster', 'Video Poster', 'lqh_evp_poster', 'evideolqh', 'normal', 'high');
		add_meta_box('evideolqh-time', 'Popup Time', 'lqh_evp_popuptime', 'evideolqh', 'normal', 'high');
		add_meta_box('evideolqh-quizz', 'Quizzes', 'lqh_evp_quizz', 'evideolqh', 'normal', 'high');
		add_meta_box('evideolqh-shortcode', 'Shortcode', 'lqh_evp_shortcode_generate', 'evideolqh', 'side', 'high');
	}
	function lqh_evp_link() {
		global $post;
	
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="evideometa_noncename" id="evideometa_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
		// Get the location data if its already been entered
		$videolink = get_post_meta($post->ID, '_videolink', true);
		// Echo out the field
		echo '<input id="video_link" type="text" name="_videolink" value="' . $videolink  . '" class="widefat" />
		<p><em>Support direct link (.mp4) and Youtube</em></p>
		<p><em>Direct Link example: http://vjs.zencdn.net/v/oceans.mp4</em></p>
		<p><em>Youtube Link example: https://www.youtube.com/watch?v=up5CSxJwpWQ</em></p>
		';

	}
	function lqh_evp_sub(){
	    global $post;
	
		// Get the location data if its already been entered
		$videosub = get_post_meta($post->ID, '_sub', true);
		// Echo out the field
		echo '<input id="sub_link" type="text" name="_sub" value="' . $videosub  . '" class="widefat" />
		<p><em>Subtitle must be in .vtt format</em></p>
		<p><em>Using <b>Upload Subtitle</b> to upload image to Library, click <b>File URL</b> then <b>Insert to Post</b> to update subtitle link field </em></p>
		<input id="upload_sub_button"  type="button" value="Upload Subtitle" />
		<p><em>You can use <a href="http://www.webvtt.org/" target="_blank">webvtt.org</a> to convert SRT to VTT</em></p>
		<p><em>No need for youtube video</p></em>';
	}
	function lqh_evp_poster(){
	    global $post;
		
		// Get the location data if its already been entered
		$videoposter = get_post_meta($post->ID, '_poster', true);
		// Echo out the field
		echo '<input id="poster_link" type="text" name="_poster" value="' . $videoposter  . '" class="widefat" />
		<p><em>Using <b>Upload Image</b> to upload image to Library, click <b>File URL</b> then <b>Insert to Post</b> to update poster link field </em></p>
		<input id="upload_image_button"  type="button" value="Upload Image" />
		<p><em>No need for youtube video</p></em>
		';
	}
	function lqh_evp_popuptime(){
	    global $post;
	
		// Get the location data if its already been entered
		$videopopuptime = get_post_meta($post->ID, '_popuptime', true);
		// Echo out the field
		echo '<input id="popup_time" type="text" name="_popuptime" value="' . $videopopuptime  . '" />
		<p><em>Example: 60 (seconds).</em></p>
		<p><em>If you don\'t provide popup time, the default value is 999999, which means popup won\'t show up for many case. (Still can be show by press Q)</em></p>
		';
	}
	function lqh_evp_quizz(){
	    global $post;
	
		// Get the location data if its already been entered
		$videoquizz = get_post_meta($post->ID, '_quizz', true);
		// Echo out the field
		echo '<p><em>Compose HTML multiple choice quizz (see example below)</em></p>
		<div id="tab-container">
		  <div id="tab-navigator">
		    <span data-tab="text-tab" class="selected-tab">Text</span>
		    <span data-tab="visual-tab">Visual</span>
		  </div>
		  <div id="tab-content">
		    <div id="visual-tab" class="tab previous"></div>
		    <div id="text-tab" class="tab current">
		      <textarea id="quizz" class="wp-editor-area" cols="40" style="height:100%;width:100%;" name="_quizz">'.$videoquizz.'</textarea>
		    </div>
		  </div>
		</div>
		<p><em>Example:</em></p>
		<div>
		<xmp>
        <!-- question one -->
<div class="quizz-question">
    <h4 class="quizz-question-title">1+1 = ?</h4>
    <button class="quizz-choice">0</button>
    <button class="quizz-choice">1</button>
    <button class="quizz-choice" answer="right">2</button>
    <button class="quizz-choice">3</button>
</div>
	<!-- question two -->
<div class="quizz-question">
    <h4 class="quizz-question-title">2+2 = ?</h4>
    <button class="quizz-choice">3</button>
    <button class="quizz-choice" answer="right">4</button>
    <button class="quizz-choice">5</button>
    <button class="quizz-choice">6</button>
</div>			
		</xmp>
		</div>
		';
	}
	function lqh_evp_shortcode_generate(){
	    global $post;
		// Get the location data if its already been entered
		$videosub = get_post_meta($post->ID, '_sub', true);
		// Echo out the field
		echo '<input id="shortcode-generate" class="widefat" type="text" value=\'[lqh-e-video id="' . $post->ID  . '"]\'  readonly/>
		<span id ="copy-shortcode" class="btn" data-clipboard-target="#shortcode-generate">Copy Shortcode</span>
		<p><em>Default width and height is 480px and 270px, add <b>width="your-width" height="your-height"</b> to shortcode to set your own width and height</em></p>
		<p>Example: <b>[lqh-e-video id="' . $post->ID  . '" width="720px" height="405px"]</b></p>
		';
		
	}
	
	// Save the Metabox Data
	function lqh_evp_save_evideo_metas($post_id, $post) {
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( isset($_POST['evideometa_noncename']) && !wp_verify_nonce( $_POST['evideometa_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
		}
	
		// Is the user allowed to edit the post or page?
		if ( !current_user_can( 'edit_post', $post->ID ))
			return $post->ID;
	
		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		if( isset( $_POST['_videolink'] ) && $_POST['_sub'] && $_POST['_poster'] && $_POST['_popuptime'] && $_POST['_quizz']){
			$evideo_meta['_videolink'] = $_POST['_videolink'];
			$evideo_meta['_sub'] = $_POST['_sub'];
			$evideo_meta['_poster'] = $_POST['_poster'];
			$evideo_meta['_popuptime'] = $_POST['_popuptime'];
			$evideo_meta['_quizz'] = $_POST['_quizz'];
			
			// Add values of $events_meta as custom fields
			
			foreach ($evideo_meta as $key => $value) { // Cycle through the $evideo_meta array!
				if( $post->post_type == 'revision' ) return; // Don't store custom data twice
				$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
				if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
					update_post_meta($post->ID, $key, $value);
				} else { // If the custom field doesn't have a value
					add_post_meta($post->ID, $key, $value);
				}
				
			}
		}
		
	}

add_action('save_post', 'lqh_evp_save_evideo_metas', 1, 2); // save the custom fields
}
add_action( 'init', 'lqh_evp_create_posttype' );

?>