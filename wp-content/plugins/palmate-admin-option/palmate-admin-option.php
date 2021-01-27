<?php
/*
Plugin Name: palmate-admin-option
Plugin URI: http://github.com/LeafCoders/palmate
Description: Option page for Palmate
Version: 0.1
*/

class PalmateAdminOption {

  function __construct() {
    add_action( 'admin_init', array( $this, 'action_register_settings') );
    add_action( 'admin_menu', array( $this, 'action_add_option_menu' ) );
  }

  function action_register_settings() {
    register_setting(
      'palmate_option_group',
      'rosette_option',
      array( $this, 'rosette_option_validate'));
      
    add_settings_section(
      'rosette_section_id',
      __('Rosette server connection', 'palmate'),
      null,
      'rosette_section');
  
    add_settings_field(
      'rosette_option_url',
      __('URL', 'palmate'),
      array( $this, 'rosette_option_url'),
      'rosette_section',
      'rosette_section_id');
  
    add_settings_field(
      'rosette_option_version',
      __('Version', 'palmate'),
      array( $this, 'rosette_option_version'),
      'rosette_section',
      'rosette_section_id');
  }
    
  function action_add_option_menu() {
    if ( !function_exists('current_user_can') || !current_user_can('manage_options') ) {
      return;
    }

    if ( function_exists('add_options_page') ) {
      // Apply languages
      load_plugin_textdomain('palmate', false, basename( dirname( __FILE__ ) ) . "/langs" );

      // Add option menu and page
      global $palmate_option_page;
      $palmate_option_page = add_options_page(__('Palmate Settings','palmate'), __('Palmate','palmate'), 'manage_options', 'palmate_admin_option', array( $this, 'option_page' ) );
      add_action( 'load-' . $palmate_option_page, array( $this, 'help_tabs' ) );
    }
  }
    
  function option_page() {
    $rosette_option = get_option('rosette_option');

    ?>
      <div class="wrap">
        <?php screen_icon("options-general"); ?>
        <h2><?php echo esc_html(__( 'Palmate Settings', 'palmate' )); ?></h2>
        <form action="options.php" method="post">
          <?php settings_fields('palmate_option_group'); ?>
          <?php do_settings_sections('rosette_section'); ?>
          <p class="submit">
            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
          </p>
        </form>
      </div> 
    <?php 
  }

  function rosette_option_url() {
    $rosette_option = get_option('rosette_option');
    
    ?>
      <input id="url" name="rosette_option[url]" type="text" class="regular-text" value="<?php echo $rosette_option['url']; ?>" />
    <?php
  }
    
  function rosette_option_version() {
    $rosette_option = get_option('rosette_option');
    
    ?>
      <input id="version" name="rosette_option[version]" type="text" class="regular-text" value="<?php echo $rosette_option['version']; ?>" />
    <?php
  }
    
  function rosette_option_validate($input) {
    $rosette_option = get_option('rosette_option');

    // Url
    if (esc_url($input['url']) == $input['url']) {
      $rosette_option['url'] = rtrim($input['url'], '/ ');
    } else {
      add_settings_error('rosette_option', 'settings_updated', __('Invalid URL!', 'palmate'));
    }

    // Version
    if (!empty($input['version'])) {
      $rosette_option['version'] = $input['version'];
    } else {
      add_settings_error('rosette_option', 'settings_updated', __('Invalid version!', 'palmate'));
    }
  
    return $rosette_option;
  }

  function help_tabs() {
    global $palmate_option_page, $current_screen;
    if ($current_screen->id != $palmate_option_page) {
      return;
    }

    $current_screen->add_help_tab( array(
      'id'      => 'palmate_admin_option_help',
      'title'   => __('Instructions', 'palmate'),
      'content' => '<p>' . __('Contact the LeafCoders team at ', 'palmate') . '<a href="http://github.com/LeafCoders">http://github.com/LeafCoders</a>.</p>'
    ) );
  }
}

$option = new PalmateAdminOption();

?>