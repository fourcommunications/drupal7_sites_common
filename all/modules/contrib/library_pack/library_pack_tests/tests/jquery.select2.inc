<?php
/**
* Chosen Test Block Callback
*/
function _library_pack_tests_select2() {
  $block = array();

  // Attach the select2 javascript library
  // $block['#attached']['libraries_load'][] = array('select2');
  $block['#attached']['libraries_load'][] = array('select2', 'minified');

   // Add some inline javascript to the block.
  $block['#attached']['css']= array(
    "#select2, #s2id_select2 {width:250px;}" =>
   array('type' => 'inline')
  );


   // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
       $('#select2').select2();
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

 $block['title'] = array(
      '#markup' => '<h2>jQuery Select2 Library Test</h2>',
  );

  $block['select'] = array(
       '#type' => 'select',
       '#title' => t('Select'),
       '#attributes' => array(
          'id' => 'select2'
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
