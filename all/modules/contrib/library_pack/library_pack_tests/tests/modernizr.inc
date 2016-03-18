<?php
/**
* qTip2 Test Block Callback
*/
function _library_pack_tests_modernizr() {
  // Blank array
  $block = array();
  $block['#attached']['libraries_load'][] = array('modernizr');

 $block['title'] = array(
      '#markup' => '<h2>Modernizr Library Test</h2>',
  );

  return $block;

}
