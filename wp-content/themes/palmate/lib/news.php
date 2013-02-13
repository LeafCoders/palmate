<?php

/**
 * News post type
 */
function register_cpt_news() {
  // Register the post type
  $labels = array( 
    'name' => _x( 'Nyheter', 'news' ),
    'singular_name' => _x( 'Nyhet', 'news' ),
    'add_new' => _x( 'Skapa ny', 'news' ),
    'add_new_item' => _x( 'Skapa ny nyhet', 'news' ),
    'edit_item' => _x( 'Redigera nyhet', 'news' ),
    'new_item' => _x( 'Ny nyhet', 'news' ),
    'view_item' => _x( 'Visa nyhet', 'news' ),
    'search_items' => _x( 'Sök nyhet', 'news' ),
    'not_found' => _x( 'Hittade inga nyheter', 'news' ),
    'not_found_in_trash' => _x( 'Hittade inga nyheter i papperskorgen', 'news' ),
    'parent_item_colon' => _x( 'Förälder:', 'news' ),
    'menu_name' => _x( 'Nyheter', 'news' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'En nyhet visas på framsidan. Nyheten som är överst i denna listan visas överst på framsidan.',
    'supports' => array( 'title', 'editor', 'thumbnail' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => 'news',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'nyheter', 'with_front' => true, 'pages' => true ),
    'menu_icon' => admin_url('/images/media-button-image.gif'),
    'capability_type' => 'news'
  );
  register_post_type( 'news', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_news' );
  $wp_roles->add_cap( 'administrator', 'edit_newss' );
  $wp_roles->add_cap( 'administrator', 'delete_news' );
  $wp_roles->add_cap( 'administrator', 'publish_newss' );
} 
add_action('init', 'register_cpt_news');

function register_newsgroup_taxonomies() {
  $labels = array( 
    'name' => _x( 'Grupp', 'newsgroup' ),
    'singular_name' => _x( 'Grupp', 'newsgroup' ),
    'search_items' =>  _x( 'Sök grupp', 'newsgroup' ),
    'all_items' => _x( 'Alla grupper', 'newsgroup' ),
    'parent_item' => _x( 'Förälder till gruppen', 'newsgroup' ),
    'parent_item_colon' => _x( 'Förälder:', 'newsgroup' ),
    'edit_item' => _x( 'Redigera grupp', 'newsgroup' ),
    'update_item' => _x( 'Uppdatera grupp', 'newsgroup' ),
    'add_new_item' => _x( 'Lägg till grupp', 'newsgroup' ),
    'new_item_name' => _x( 'Ny grupp', 'newsgroup' ),
    'menu_name' => _x( 'Grupper', 'newsgroup' ),
  );

  register_taxonomy('newsgroup', 'news', array(
    'hierarchical' => true,
    'labels' => $labels,
    'rewrite' => array( 'slug' => 'gruppnyheter', 'with_front' => false )
  ));

  // Setup a news group that indicate that the news should be visible on front page
  if (!term_exists('front-news', 'newsgroup')) {
    wp_insert_term('Visa på framidan', 'newsgroup',
      array(
        'description'=> 'Nyheten visas på framsidan ifall denna markeras',
        'slug' => 'front-news',
        'parent'=> null
      )
    );
  }    
}
add_action( 'init', 'register_newsgroup_taxonomies', 0 );

/**
 * Get all news for a specific group
 */
function palmate_get_news_by_group( $groupslug ) {
  $args = array(
    'post_type'=> 'news',
    'newsgroup' => $groupslug,
    'order' => 'asc'
  );
  return new WP_Query($args);
}

/**
 * Get content for news of a specific news group
 */
function palmate_get_newsgroup_contents( $group, $items = 4 ) {
  $args = array(
    'post_type' => 'news',
    'post_status' => 'publish',
    'newsgroup' => $group,
    'posts_per_page' => $items,
    'caller_get_posts'=> 1
  );
  $news_query = null;
  $news_query = new WP_Query($args);

  $text = '';
  while ($news_query->have_posts()) {
    $news_query->the_post();
    $text .= palmate_get_the_news_content_small();
  }
  wp_reset_query();
  $text .= '<a href="/gruppnyheter/' . $group . '">Visa alla nyheter för gruppen</a>';
  return $text;
}

/**
 * Get content for the active news post
 */
function palmate_get_the_news_content($addHref = true) {
  $content = '<div class="row-fluid hideHref">';
  global $more; 
  if ($addHref) {
    $more = 0; // Turn on more function for posts
    $content .= '<a href="/nyheter/' . the_slug('','', false) . '">';
  } else {
    $more = 1; // Turn off more function for posts
  }
  $offset = ' offset4';
  $imgUrl = palmate_get_the_news_image();
  if (!empty($imgUrl)) {
    $content .= '<div class="span4 paddingRight"><img class="newsImg" src="' . $imgUrl . '"></img></div>';
    $offset = '';
  }

  $content .= '<div class="span8' . $offset . '"><h3>' . the_title('', '', false) . '</h3>';
  $content .= '<p class="newsMeta">' . palmate_get_the_news_meta() . '</p>';
  $content .= '<p>' . wpautop(apply_filters('the_content', get_the_content('&hellip;'))) . '</p>';
  if ($addHref) {
    $content .= '</a>';
  }
  $content .= '</div></div><p class="dividerHor"></p>';
  return $content;
}

/**
 * Get content for the active news post in a small style
 */
function palmate_get_the_news_content_small() {
  $content = '<div class="row-fluid hideHref"><div class="span12"><a href="/nyheter/' . the_slug('','', false) . '">';
  $imgUrl = palmate_get_the_news_image();
  if (!empty($imgUrl)) {
    $content .= '<img style="max-height: 100px;" src="' . $imgUrl . '"></img>';
  }
  $content .= '<h3>' . the_title( '', '', false ) . '</h3>';
  $content .= '<p class="newsMeta" style="line-height: 5px; font-size: 10px; color: #999;">' . palmate_get_the_news_meta() . '</p>';
  $content .= '<p>' . wpautop(apply_filters('the_excerpt', get_the_excerpt())) . '</p>';
  $content .= '</a></div></div><p class="dividerHor"></p>';
  return $content;
}

/**
 * Get image for the active news post
 */
function palmate_get_the_news_image() {
  return wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium')[0];
}

/**
 * Get meta data for the active news post
 */
function palmate_get_the_news_meta() {
  $meta = get_the_date('Y-m-d');
  $categories = get_the_terms(get_the_ID(), 'newsgroup');
  if ($categories) {
    foreach ($categories as $category) {
      if (strcmp($category->slug, 'front-news') != 0) {
        $meta .= ' | ' . $category->name;
      }
    }
  }
  return $meta;
}

/**
 * News shortcode [News]
 */
function palmate_news_shortcode($atts) {
  $args = array(
    'post_type' => 'news',
    'newsgroup' => 'front-news',
    'post_status' => 'publish',
    'posts_per_page' => 8,
    'caller_get_posts'=> 1
  );
  $news_query = null;
  $news_query = new WP_Query($args);

  $counter = 0;
  $full = '';
  $left = '';
  $right = '';

  while ($news_query->have_posts()) {
    $news_query->the_post();

    if ($counter < 2) {
      $full .= palmate_get_the_news_content();
    } else {
      $imgUrl = palmate_get_the_news_image();
      $small = '<a href="/nyheter/' . the_slug('','', false) . '">';
      if (!empty($imgUrl)) {
//TODO:        $small .= '<img style="max-height: 100px;" src="' . $imgUrl . '"></img>';
      }
      $small .= '<h3>' . the_title( '', '', false ) . '</h3>';
      $small .= '<p class="newsMeta" style="line-height: 5px; font-size: 10px; color: #999;">' . palmate_get_the_news_meta() . '</p>';
      $small .= '<p>' . wpautop(apply_filters('the_excerpt', get_the_excerpt())) . '</p></a>';
      $small .= '<p class="dividerHor"></p>';
      if ($counter % 2) {
        $right .= $small;
      } else {
        $left .= $small;
      }
    }
    $counter += 1;
  }

  wp_reset_query();

  if (empty($left)) {
    return $full . '<a href="/nyheter">Visa alla nyheter</a>';
  } else {
    $full .= '<div class="row-fluid hidden-phone hideHref">';
    $full .= '<div class="span6 paddingRight">' . $left . '</div>';
    $full .= '<div class="span6 paddingLeft">' . $right . '</div>';
    $full .= '</div>' . '<a href="/nyheter">Visa alla nyheter</a>';
    return $full;
  }
}
add_shortcode( 'News', 'palmate_news_shortcode' );
