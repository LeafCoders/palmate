<?php
/**
 * User manual admin page
 */
function palmate_usermanual_page() {
  echo '<h1>Användarmanual till Palmate</h1>';
  echo '<div><a href="/assets/Anvandarmanual_Palmate.pdf">Klicka här för att läsa användarmanualen</a></div>';
  echo '<h2>Versionshistorik</h2>';
  echo '<table>';
  echo '<tr><td style="min-width: 100px;">Version 1.1</td><td>Login, logout</td></tr>';
  echo '<tr><td style="min-width: 100px;">Version 1.0</td><td>Login, logout</td></tr>';
  echo '</table>';
}
function palmate_usermanual_menu() {
  add_menu_page('Användarmanual', 'Användarmanual', 'read', 'palmate-user-manual', 'palmate_usermanual_page', '', 3);
}
add_action('admin_menu', 'palmate_usermanual_menu');

?>
