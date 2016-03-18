<?php
/**
* Underscore Test Block Callback
*/
function _library_pack_tests_underscore() {
  $block = array();

  // Attach the underscore javascript library
  // $block['#attached']['libraries_load'][] = array('underscore');
  $block['#attached']['libraries_load'][] = array('underscore', 'minified');


   // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
       $('#underscore').html('Underscore version is: ' + _.VERSION);
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

 $block['title'] = array(
      '#markup' => '<h2>Underscore Library Test</h2>',
  );

  $block['underscore'] = array(
       '#type' => 'container',
       '#attributes' => array(
          'id' => 'underscore'
        )
   );
   return $block;
}
