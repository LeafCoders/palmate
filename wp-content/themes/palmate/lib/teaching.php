<?php

/**
 * Teaching Theme post type
 */
function register_cpt_teaching_theme() {
  // Register the post type
  $labels = array( 
    'name' => _x( 'Undervisningsteman', 'theme' ),
    'singular_name' => _x( 'Undervisningstema', 'theme' ),
    'add_new' => _x( 'Skapa nytt', 'theme' ),
    'add_new_item' => _x( 'Skapa nytt undervisningstema', 'theme' ),
    'edit_item' => _x( 'Redigera undervisningstema', 'theme' ),
    'new_item' => _x( 'Nytt undervisningstema', 'theme' ),
    'view_item' => _x( 'Visa undervisningstema', 'theme' ),
    'search_items' => _x( 'Sök undervisningstema', 'theme' ),
    'not_found' => _x( 'Hittade inga undervisningsteman', 'theme' ),
    'not_found_in_trash' => _x( 'Hittade inga undervisningsteman i papperskorgen', 'theme' ),
    'parent_item_colon' => _x( 'Förälder:', 'theme' ),
    'menu_name' => _x( 'Teman', 'theme' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'Ett undervisningstema används för att koppla samman flera undervisningar som predikningar eller bibelstudier.',
    'supports' => array( 'title', 'editor', 'thumbnail' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => 'edit.php?post_type=teaching',
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => 'teaching_theme',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'undervisningsteman', 'with_front' => true, 'pages' => true ),
    'menu_icon' => admin_url('/images/media-button-image.gif'),
    'capability_type' => 'teaching_theme'
  );
  register_post_type( 'teaching_theme', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_teaching_theme' );
  $wp_roles->add_cap( 'administrator', 'edit_teaching_themes' );
  $wp_roles->add_cap( 'administrator', 'edit_others_teaching_themes' );
  $wp_roles->add_cap( 'administrator', 'delete_teaching_theme' );
  $wp_roles->add_cap( 'administrator', 'publish_teaching_themes' );
} 
add_action('init', 'register_cpt_teaching_theme');

/**
 * Teaching post type
 */
function register_cpt_teaching() {
  // Register the post type
  $labels = array( 
    'name' => _x( 'Undervisningar', 'teaching' ),
    'singular_name' => _x( 'Undervisning', 'teaching' ),
    'add_new' => _x( 'Skapa ny', 'teaching' ),
    'add_new_item' => _x( 'Skapa ny undervisning', 'teaching' ),
    'edit_item' => _x( 'Redigera undervisning', 'teaching' ),
    'new_item' => _x( 'Ny undervisning', 'teaching' ),
    'view_item' => _x( 'Visa undervisning', 'teaching' ),
    'search_items' => _x( 'Sök undervisning', 'teaching' ),
    'not_found' => _x( 'Hittade ingen undervisning', 'teaching' ),
    'not_found_in_trash' => _x( 'Hittade ingen undervisning i papperskorgen', 'teaching' ),
    'parent_item_colon' => _x( 'Förälder:', 'teaching' ),
    'menu_name' => _x( 'Undervisning', 'teaching' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'En undervisning innehåller text, talare, samtalsunderlag och ljudfil. En undervisning kan kopplas till ett undervisningstema.',
    'supports' => array( 'title' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => 'teaching',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'undervisningar', 'with_front' => true, 'pages' => true ),
    'menu_icon' => admin_url('/images/media-button-image.gif'),
    'capability_type' => 'teaching'
  );
  register_post_type( 'teaching', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_teaching' );
  $wp_roles->add_cap( 'administrator', 'edit_teachings' );
  $wp_roles->add_cap( 'administrator', 'edit_others_teachings' );
  $wp_roles->add_cap( 'administrator', 'delete_teaching' );
  $wp_roles->add_cap( 'administrator', 'publish_teachings' );
} 
add_action('init', 'register_cpt_teaching');


add_action( 'add_meta_boxes', 'teaching_theme_add_metabox' );
function teaching_theme_add_metabox() {
  add_meta_box('teachings_metabox', __( 'Undervisningar i detta tema', 'teaching_metabox' ),
    'teaching_theme_metabox', 'teaching_theme', 'side' );
}
function teaching_theme_metabox( $post ) {
  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'teaching_theme_metabox' );

  $themeID = $post->ID;
  $args = array(
    'post_type' => 'teaching',
    'posts_per_page' => 10,
    'caller_get_posts'=> 1,
    'meta_key' => 'theme_connection',
    'meta_value' => $themeID
    
  );
  $news_query = null;
  $news_query = new WP_Query($args);
  while ($news_query->have_posts()) {
    $news_query->the_post();
    echo '<p>' . edit_post_link(get_the_title()) . '</p>';
  }
  wp_reset_query();

/*
  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $value = get_post_meta( $post->ID, '_my_meta_value_key', true );
  echo '<label for="myplugin_new_field">';
       _e("Description for this field", 'myplugin_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="'.esc_attr($value).'" size="25" />';
*/
}

function palmate_get_teaching_theme() {
  $theme = '';
  $theme_object = get_field('theme_connection');
 
  if ($theme_object) { 
    // Override current $post
    $post = $theme_object;
    setup_postdata( $post );
    $theme['title'] = $post->post_title;
    $theme['slug'] = $post->post_name;
//    print_r( $theme_object );
    wp_reset_postdata();
  }
  return $theme;
}

function palmate_get_the_teaching_content() {
  $slug = the_slug('','', false);
  $text = get_field('text');
  $extra_text = get_field('extra_text');
  $theme = palmate_get_teaching_theme();
  $date = DateTime::createFromFormat('Ymd', get_field('teaching_date'));

  $content   = '<div class="row-fluid">';
  $content  .= '  <div class="span8">';


  $content  .= '    <article class="hentry">';
  $content  .= '      <div class="contentBox marginRight">';
//  $content  .= '        <div class="teachingBanner"><p>Predikning</p></div>';
  $content  .= '        <header class="clearfix" style="border-bottom: 1px solid #ddd;">';
  $content  .= '          <img class="teachingImage" style="float: left; margin-right: 10px; max-height: 100px;" src="/assets/img/teaching.png">';
//  $content  .= '          <div class="teachingDate teachingMeta" style="float: right; margin-top: 10px; padding-right: 10px; text-align: right;">' . $date->format('Y-m-d') . '</div>';

  $content  .= '          <div class="acal-date" style="float: right;"><div>25<p>okt<br>2013</p></div></div>';

  $content  .= '          <div style="margin-top: -10px; margin-left: 10px;">';
//  $content  .= '            <div class="teachingDate teachingMeta" style="text-align: right; padding-right: 10px;">' . $date->format('Y-m-d') . '</div>';
  $content  .= '            <a href="/undervisningar/' . $slug . '"><h2 class="entry-title">' . the_title('', '', false) . '</h2></a>';
  $content  .= '            <div class="teachingMeta">' . get_field('author') . '</div>';
  if ($theme != '') {
    $content  .= '            <div class="teachingMeta">Tema: <a href="/undervisningsteman/' . $theme['slug'] . '">' . $theme['title'] . '</a></div>';
  }
  $content  .= '            <div class="teachingMeta">Innehåller ljud och samtalsfrågor</div>';
  $content  .= '          </div>';
  $content  .= '        </header>';
  $content  .= '        <div onclick="expandNextElem(this);" class="acal-date" style="float: right;"><div><p><br>läs<br>hela</p><i class="icon-chevron-down"></i></div></div>';
  $content  .= '        <div class="paddingBoth" style="max-height: 120px;">'; // border-bottom: 2px dashed #ddd;
//  $content  .= '                  <audio controls>';
//  $content  .= '                    <source src="horse.ogg" type="audio/ogg">';
//  $content  .= '                    <source src="horse.mp3" type="audio/mpeg">';
//  $content  .= '                    Your browser does not support the audio element.';
//  $content  .= '                  </audio>';
//  $content  .= '                  <br>';
  $content  .= '          <div>' . $text . '</div>';
  $content  .= '          <h3>Samtalsfrågor</h3>';
  $content  .=            $extra_text;
//  $content  .= '          <div style="position: absolute; bottom: -20px; right: 0; width: 50px; background-color: rgba(200,200,200,0.8); height: 50px; text-align: center; color: #fff; border-radius: 30px 0 0 0; font-size: 14px; line-height: 16px;"><p style="padding-top: 10px;">visa<br>hela</p></div>';
//  $content  .= '          <div style="position: absolute; bottom: -10px; height: 20px; width: 70px; right: 0px; background-color: #fff; text-align: center; color: #ddd; font-size: 14px; line-height: 20px;">visa hela</div>';
  $content  .= '        </div>';
  $content  .= '      </div>';
  $content  .= '    </article>';
  $content  .= '  </div>';
  $content  .= '</div>';

  return $content;
}










/**
 * Get image for the active news post
 */
 /*
function palmate_get_the_news_image() {
  $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');
  if (is_array($img)) {
    return $img[0];
  }
  return '/assets/img/news-empty.png';
}
*/

/**
* Get content for the active news post
 */
/*
function palmate_get_the_news_content( $only_excerpt = false ) {
  $hideHref = $only_excerpt ? ' hideHref' : '';

  $content  = '<div class="media' . $hideHref . '" style="margin-bottom: 10px;">';
  $content .= '  <a class="pull-left" href="/nyheter/' . the_slug('','', false) . '">';
  $content .= '    <img class="media-object" style="margin-bottom: 1px; width: 140px; min-width: 140px; max-width: 140px;"';
  $content .= '         alt="Nyhet" src="' . palmate_get_the_news_image() . '"></img>';
  $content .= '  </a>';
  $content .= '  <div class="media-body">';
  $content .= '    <a href="/nyheter/' . the_slug('','', false) . '">';
  $content .= '      <h3 class="media-heading">' . the_title('', '', false) . '</h3>';
  $content .= '    </a>';
  $content .= '    <p class="newsMeta">' . palmate_get_the_news_meta() . '</p>';
  if ($only_excerpt) {
    $content .= '  <a href="/nyheter/' . the_slug('','', false) . '">' . wpautop(apply_filters('the_excerpt', get_the_excerpt())) . '</a>';
  } else {
    $content .= '      ' . wpautop(apply_filters('the_content', get_the_content()));
  }
  $content .= '  </div>';
  $content .= '</div>';
  $content .= '<p class="dividerHor"></p>';
  return $content;
}
*/

/**
 * News shortcode [News]
 */
 /*
function palmate_news_shortcode() {
  $args = array(
    'post_type' => 'news',
    'newsgroup' => 'front-news',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'caller_get_posts'=> 1
  );
  $news_query = null;
  $news_query = new WP_Query($args);

  $content = "";
  while ($news_query->have_posts()) {
    $news_query->the_post();
    $content .= palmate_get_the_news_content(true);
  }
  wp_reset_query();
  return $content . '<a href="/nyheter">Visa alla nyheter</a>';
}

add_shortcode( 'News', 'palmate_news_shortcode' );
*/