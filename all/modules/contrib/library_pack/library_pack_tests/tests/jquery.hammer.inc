<?php
/**
* qTip2 Test Block Callback
*/
function _library_pack_tests_hammer() {
  // Blank array
  $block = array();

  // Attach the qtip javascript library
  // $block['#attached']['libraries_load'][] = array('hammer');
  $block['#attached']['libraries_load'][] = array('hammer');
  $block['#attached']['libraries_load'][] = array('jquery.hammer');



   // Add some inline javascript to the block.
  $block['#attached']['css']= array(
    "#hammer {
      position: relative;
      width:200px;
      height:200px;
      background:#efefef;
    }" =>
   array('type' => 'inline')
  );



  // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
      var hammertime = jQuery('#hammer').hammer().on('tap', function(event) {
          alert('you tapped!');
      });
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );


 $block['title'] = array(
      '#markup' => '<h2>jQuery Hammer Library Test</h2>',
  );
  // Return a list of the items
  $block['hammer'] = array(
      '#type' => 'container',
      '#attributes' => array(
        'id' => 'hammer'
      )
  );
  return $block;
}
