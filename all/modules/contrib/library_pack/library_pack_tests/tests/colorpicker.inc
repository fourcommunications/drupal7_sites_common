<?php
/**
* Chosen Test Block Callback
*/
function _library_pack_tests_colorpicker() {
  $block = array();

  // Attach the colorpicker javascript library
  $block['#attached']['libraries_load'][] = array('colorpicker');

   // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
       $('#colorpicker').ColorPicker({
        onChange: function(hsb, hex, rgb, el) {
              console.log(hex);
    $('#colorpicker').val(hex);
  },

       });
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

 $block['title'] = array(
      '#markup' => '<h2>Colorpicker Library Test</h2>',
  );
   // Return a list of the items
  $block['colorpicker'] = array(
      '#type' => 'textfield',
      '#attributes' => array(
        'id' => 'colorpicker'
      )
  );
   return $block;
}
