<?php
function rosette_server() {
  $rosette_option = get_option('rosette_option');
  return $rosette_option[url] . '/' . $rosette_option[version] . '/';
}
?>