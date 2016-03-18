<?php
/**
* Placeholder Test Block Callback
*/
function _library_pack_tests_placeholder() {
  // Blank array
  $block = array();

  // Attach the placeholder javascript library
  // $block['#attached']['libraries_load'][] = array('jquery.placeholder');
  $block['#attached']['libraries_load'][] = array('jquery.placeholder','minified');

  // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
      $('#placeholder').placeholder();
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );


 $block['title'] = array(
      '#markup' => '<h2>jQuery Placeholder Library Test</h2>',
  );

  $block['placeholder'] = array(
    '#type' => 'textfield',
    '#attributes' => array(
      'id' => 'placeholder',
      'placeholder' => 'This is the placeholder text'
    )
  );


  return $block;
}
