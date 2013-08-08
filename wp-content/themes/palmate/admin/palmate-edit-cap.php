<?php

/**
 * palmate_edit_cap_filter()
 *
 * Filter on the current_user_can() function.
 * This function is used to explicitly allow authors to edit contributors and other
 * authors posts if they are published or pending.
 *
 * @param array $allcaps All the capabilities of the user
 * @param array $cap     [0] Required capability
 * @param array $args    [0] Requested capability
 *                       [1] User ID
 *                       [2] Associated object ID
 */
function palmate_edit_cap_filter( $allcaps, $cap, $args ) {
  if ( in_array('edit_others_pages', $cap) ) :
    $post_objects = get_field('palmate_edit_page_cap', 'user_' . $args[1]);
    if ( $post_objects ) :
      $has_post_id = false;
      foreach ( $post_objects as $post_object) :
        if ($post_object->ID == $args[2]) :
          $has_post_id = true;
        endif;
      endforeach;
      if ($has_post_id == false) :
        foreach ( $cap as $c ) :
          $allcaps[$c] = false;
        endforeach;
      endif;
    endif;
  endif;

  return $allcaps;
}
add_filter( 'user_has_cap', 'palmate_edit_cap_filter', 10, 3 );


function register_palmate_edit_cap() {
  if (function_exists("register_field_group")) {
    register_field_group(array (
      'id' => '51ed1149046ce',
      'title' => 'Skrivrättigheter',
      'fields' => array (
        0 => array (
          'key' => 'field_505c78f06ef89',
          'label' => 'Sidor',
          'name' => 'palmate_edit_page_cap',
          'type' => 'post_object',
          'order_no' => 0,
          'instructions' => 'Markera de sidor som användaren ska få redigera',
          'required' => 0,
          'conditional_logic' => array (
            'status' => 0,
            'rules' => array (
              0 => array (
                'field' => 'null',
                'operator' => '==',
              ),
            ),
            'allorany' => 'all',
          ),
          'post_type' => array ( 0 => 'page' ),
          'taxonomy' => array ( 0 => 'all' ),
          'allow_null' => 0,
          'multiple' => 1,
        ),
      ),
      'location' => array (
        'rules' => array (
          0 => array (
            'param' => 'ef_user',
            'operator' => '==',
            'value' => 'all',
            'order_no' => 0,
          ),
          1 => array (
            'param' => 'user_type',
            'operator' => '==',
            'value' => 'administrator',
            'order_no' => 1,
          ),
        ),
        'allorany' => 'all',
      ),
      'options' => array (
        'position' => 'normal',
        'layout' => 'default',
        'hide_on_screen' => array (),
      ),
      'menu_order' => 0,
    ));
  }
}
add_action( 'init', 'register_palmate_edit_cap' );

?>