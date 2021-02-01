<?php 

/**
 * Unregister Block Patterns from WordPress core
 */
function palmate_remove_default_block_patterns() {
  // TODO: This one should work but doesn't.  remove_theme_support( 'core-block-patterns' );

  unregister_block_pattern_category( 'buttons' );
  unregister_block_pattern_category( 'columns' );
  unregister_block_pattern_category( 'gallery' );
  unregister_block_pattern_category( 'header' );
  unregister_block_pattern_category( 'text' );
  
  $core_block_patterns = array(
    'core/text-two-columns',
    'core/two-buttons',
    'core/two-images',
    'core/text-two-columns-with-images',
    'core/text-three-columns-buttons',
    'core/large-header',
    'core/large-header-button',
    'core/three-buttons',
    'core/heading-paragraph',
    'core/quote',
  );
  foreach ( $core_block_patterns as $core_block_pattern ) {
    unregister_block_pattern( $core_block_pattern );
  }
}
add_action( 'init', 'palmate_remove_default_block_patterns' );


/**
 * Register Block Pattern Category
 */
if ( function_exists( 'register_block_pattern_category' ) ) {
  register_block_pattern_category(
    'palmate',
    array( 'label' => __( 'Palmate', 'palmate' ) )
  );
}


/**
 * Register Block Patterns
 */
if ( function_exists( 'register_block_pattern' ) ) {
  register_block_pattern(
    'palmate/two-col-image',
    array(
      'title'         => __( 'Two column image', 'two-column-image' ),
      'categories'    => array( 'palmate' ),
      'viewportWidth' => 1440,
      'content'       => 
        '<!-- wp:columns -->' .
        '<div class="wp-block-columns"><!-- wp:column -->' .
        '<div class="wp-block-column"><!-- wp:image -->' .
        '<figure class="wp-block-image"><img alt=""/></figure>' .
        '<!-- /wp:image --></div>' .
        '<!-- /wp:column -->' .
        '<!-- wp:column {"width":"200px"} -->' .
        '<div class="wp-block-column" style="flex-basis:200px"><!-- wp:image -->' .
        '<figure class="wp-block-image"><img alt=""/></figure>' .
        '<!-- /wp:image --></div>' .
        '<!-- /wp:column --></div>' .
        '<!-- /wp:columns -->'
    )
  );
}
