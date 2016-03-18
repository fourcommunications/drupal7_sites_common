<?php
/**
* Chosen Test Block Callback
*/
function _library_pack_tests_timeago() {
  $block = array();

  // Attach the timeago javascript library
  $block['#attached']['libraries_load'][] = array('jquery.timeago');

   // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
       $('#timeago').html('November 5th, 1955 is ' + jQuery.timeago('1955-11-05') );
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

 $block['title'] = array(
      '#markup' => '<h2>jQuery Timeago Library Test</h2>',
  );

  $block['timeago'] = array(
     '#type' => 'container',
     '#attributes' => array(
        'id' => 'timeago'
      )
   );
   return $block;
}
