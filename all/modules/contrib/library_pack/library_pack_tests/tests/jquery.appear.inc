<?php
/**
* Placeholder Test Block Callback
*/
function _library_pack_tests_appear() {
  // Blank array
  $block = array();

  // Attach the placeholder javascript library
  // $block['#attached']['libraries_load'][] = array('jquery.placeholder');
  $block['#attached']['libraries_load'][] = array('jquery.appear');

  $block['#attached']['css']= array(
    "
    #appear {
      position:relative;
      height:40px;
    }
    #appear.appeared span {
      position: absolute;
      top: 0px;
      left: 0px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: red;


      -webkit-animation: move 3s ease infinite;
    }

    @-webkit-keyframes move {
      50% {
        -webkit-transform: translate(100px, 0px);
      }

    }




    " =>
   array('type' => 'inline')
  );

  // Add some inline javascript to the block.
  $block['#attached']['js']= array(
    "(function($) {

      jQuery('#appear').appear();
        jQuery(document.body).on('appear','#appear', function(event, all_appeared_elements) {
          jQuery(this).addClass('appeared');
    });
    jQuery(document.body).on('disappear','#appear', function(event, all_appeared_elements) {
          jQuery(this).removeClass('appeared');
    });
   })(jQuery);" =>
   array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
  );


  $block['title'] = array(
    '#markup' => '<h2>jQuery Appear Library Test</h2>',
  );

  $block['appear'] = array(
    '#type' => 'container',
    '#attributes' => array(
      'id' => 'appear',
    )
  );

  $block['appear']['appeared'] = array(
    '#markup' => '<span></span>'
  );

  return $block;
}
