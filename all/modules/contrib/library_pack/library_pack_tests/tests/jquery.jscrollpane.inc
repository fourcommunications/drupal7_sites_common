
<?php
/**
* jScrollpane Test Block Callback
*/
function _library_pack_tests_jscrollpane() {
  $block = array();

  // Attach the qtip javascript library
  // $block['#attached']['libraries_load'][] = array('jquery.jscrollpane');
  $block['#attached']['libraries_load'][] = array('jquery.jscrollpane', 'minified');

   // Add some inline javascript to the block.
  $block['#attached']['css']= array(
    "#jscrollpane {width:400px; height:50px;}" =>
   array('type' => 'inline')
  );


   // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
       $('#jscrollpane').jScrollPane();
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

 $block['title'] = array(
      '#markup' => '<h2>jScrollPane Library Test</h2>',
  );

  $block['container'] = array(
    '#type' => 'container',
    '#attributes' => array(
      'id' => 'jscrollpane'
    )
  );

  $block['container']['test'] = array(
    '#markup' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare ante in nibh consequat vestibulum. Duis tempus vel odio eget varius. Nunc et diam pellentesque, vestibulum dui vitae, bibendum tellus. Vestibulum leo dolor, sodales nec eros vitae, rhoncus auctor nulla. Praesent ultrices est quis ipsum faucibus, et pharetra nisi pellentesque. Nulla lacinia ipsum sed arcu lacinia, ut condimentum nibh auctor. Fusce quis ante quis magna euismod varius id nec tortor. Praesent fringilla pellentesque ligula, a sagittis sem molestie vitae.</p>'
  );
   return $block;
}
