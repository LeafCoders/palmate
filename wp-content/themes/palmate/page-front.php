<?php
/*
Template Name: Framsidan
*/

echo palmate_noticebox_shortcode();

the_post();

echo '<div id="main" role="main">';
the_content();
?>

<?php
echo '</div>';
?>
