
<?php
/**
* Chosen Test Block Callback
*/
function _library_pack_tests_chosen() {
  $block = array();

  // Attach the chosen javascript library
  // $block['#attached']['libraries_load'][] = array('jquery.chosen');
  $block['#attached']['libraries_load'][] = array('jquery.chosen', 'minified');

   // Add some inline javascript to the block.
  $block['#attached']['css']= array(
    "#chosen {width:250px;}" =>
   array('type' => 'inline')
  );


   // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
       $('#chosen').chosen({disable_search: true} );
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

 $block['title'] = array(
      '#markup' => '<h2>Jquery Chosen Library Test</h2>',
  );
  $block['select'] = array(
       '#type' => 'select',
       '#title' => t('Select'),
       '#attributes' => array(
          'id' => 'chosen'
        ),
       '#options' => array(
          0 => t('No'),
         1 => t('Yes'),
         2 => t('Maybe'),
       ),
       '#default_value' => 0,

   );
   return $block;
}
