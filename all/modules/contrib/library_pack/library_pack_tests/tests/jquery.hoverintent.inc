<?php
/**
* qTip2 Test Block Callback
*/
function _library_pack_tests_hoverintent() {
  // Blank array
  $block = array();

  // Attach the qtip javascript library
  // $block['#attached']['libraries_load'][] = array('hammer');
  $block['#attached']['libraries_load'][] = array('jquery.hoverIntent');

   // Add some inline javascript to the block.
  $block['#attached']['css']= array(
    " #hover ul.demo {display:block; width:100%; height:75px; padding:0; margin:0; background:#9cc; list-style-type:none;}
        ul.demo li {background:#fcc; display:block; width:25%; height:50px; padding:0; margin:0; float: left; position:relative; overflow:hidden; cursor:default;  font-size:0.9em; line-height:1.1em;}
        ul.demo li.p2 {background:#ffc;}
        ul.demo li.p3 {background:#cfc;}
        ul.demo li.p4 {background:#ccf;}
        ul.demo li span { display:block; margin:4px; background:#eef; cursor:default;}" =>
   array('type' => 'inline')
  );

  // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    '(function($) {
        $("#demo2 li").hoverIntent(makeTall,makeShort);
   })(jQuery);
  function makeTall(){jQuery(this).animate({"height":75},200);}
  function makeShort(){jQuery(this).animate({"height":50},200);}' =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );

 $block['title'] = array(
      '#markup' => '<h2>jQuery HoverIntent Library Test</h2>',
  );
  // Return a list of the items
  $block['hover'] = array(
      '#type' => 'container',
      '#attributes' => array(
        'id' => 'hover'
      )
  );

  $block['hover']['demo'] = array(
      '#markup' => '<ul class="demo" id="demo2">
            <li class="p1" style="height: 50px;">&nbsp;</li>
            <li class="p2" style="height: 50px;">&nbsp;</li>
            <li class="p3" style="height: 50px;">&nbsp;</li>
            <li class="p4" style="height: 50px;"><span>hoverIntent also ignores over/out events from children</span></li>
        </ul>'
  );


  return $block;
}

