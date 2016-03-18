<?php
/**
* qTip2 Test Block Callback
*/
function _library_pack_tests_qtip2() {
  // Blank array
  $block = array();

  // Attach the qtip javascript library
  // $block['#attached']['libraries_load'][] = array('jquery.qtip2');
  $block['#attached']['libraries_load'][] = array('jquery.qtip2','minified');

  // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {
       $('[data-tooltip]').each(function() {
         $(this).qtip({
           content: {
             text: $(this).data('tooltip')
           },
           position: {
             my: 'bottom left',
             at: 'top left',
             target: $(this)
           }
         });
     });
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

  // Generate test content
  $tests = array();

  $tests[] = array(
    'data' => 'This is a list item with a tooltip attached',
    'class' => array('qtip-test'),
    'data-tooltip' => array(
      'This is a tooltip for the first list item'
    )
  );
  $tests[] = array(
    'data' => 'This is another list item with a different tooltip attached',
    'class' => array('qtip-test'),
    'data-tooltip' => array(
        'This is a tooltip for the second list item'
    )
  );

  // Return a list of the items
  $block['title'] = array(
      '#markup' => '<h2>Qtip2 Library Test</h2>',
  );
  $block['test'] = array(
      '#theme' => 'item_list',
      '#items' => $tests
  );
  return $block;
}
