<?php

/**
 * @file
 * template.php
 */

/**
 * Implements hook_form_alter().
 *
 * @param array $form
 * @param array $form_state
 * @param null  $form_id
 */
function greyhead_bootstrap_subtheme_form_alter(array &$form, array &$form_state = array(), $form_id = NULL) {
  if ($form_id) {
    switch ($form_id) {
      // Adjust the search form's submit button with a custom theme function
      // which we use to change the button to a search icon.
      case 'search_form':
        // Implement a theme wrapper to add a submit button containing a search
        // icon directly after the input element.
        $form['basic']['keys']['#theme_wrappers'] = array('greyhead_bootstrap_subtheme_search_form_wrapper');
        break;
      case 'search_block_form':
        $form['search_block_form']['#theme_wrappers'] = array('greyhead_bootstrap_subtheme_search_form_wrapper');
        break;

      // Rewrite the topics filter on news pages to place the label inline.
      case 'views_exposed_form':
        // Are we showing the news listing form? These are the views form IDs.
        $views_forms_we_want_to_finagle = array(
          'views-exposed-form-news-page-news-home',
          'views-exposed-form-news-news-by-date',
        );

        if (in_array($form['#id'], $views_forms_we_want_to_finagle)) {
          // The form contains a drop-down select at $form['topics'], and the
          // options array is in ['#options']['All']. We want to change the
          // _value_ of the 'All' topics to read t('Topics').
          $form['topics']['#options']['All'] = t('Topics');
        }
        break;
    }
  }
}

/**
 * Theme function implementation for MYTHEME_search_form_wrapper.
 *
 * @param $variables
 *
 * @return string
 */
function greyhead_bootstrap_subtheme_search_form_wrapper($variables) {
  $output = '<div class="input-group">';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<button type="submit" class="btn btn-default">';
// We can be sure that the font icons exist in CDN.
//  if (theme_get_setting('bootstrap_cdn')) {
  $output .= _bootstrap_icon('search');
//  }
//  else {
  $output .= ' <span class="hidden">' . t('Search') . '</span>';
//  }
  $output .= '</button>';
  $output .= '</span>';
  $output .= '</div>';
  return $output;
}

/**
 * Bootstrap theme wrapper function for the primary menu links.
 *
 * Modified to include the menu name for themeing.
 *
 * @param array $variables
 *
 * @return string
 */
function greyhead_bootstrap_menu_tree__primary(&$variables) {
//  return '<ul class="menu nav navbar-nav primary">' . $variables['tree'] . '</ul>';
}

/**
 * Implements hook_preprocess_image_style().
 *
 * Add in our img-responsive class to all images.
 *
 * @param $variables
 */
function greyhead_bootstrap_preprocess_image_style(&$variables) {
//  $variables['attributes']['class'][] = 'img-responsive';
}

/**
 * Implements hook_preprocess_node().
 *
 * Add the correct date format to the submitted.
 *
 * @param $variables
 */
function greyhead_bootstrap_preprocess_node(&$variables) {
//  $variables['submitted'] = format_date($variables['revision_timestamp'], 'date_only');

  /**
   * Add template suggestions for the node templating system: this adds template
   * suggestions such as:
   *
   * node--landing-page--teaser.tpl.php
   * node--landing-page--full.tpl.php
   */
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];
}

/**
 * Implements hook_preprocess_page().
 *
 * @param $variables
 */
function greyhead_bootstrap_preprocess_page(&$variables) {
  // In this theme, we have made the sidebars 4 columns wide, so we need to
  // adjust the number of centre columns. Note that we have no sidebars on the
  // homepage, so add in a check to make sure we fix the homepage to 12.
  if (drupal_is_front_page()) {
    $variables['content_column_class'] = ' class="col-sm-12"';
  }
  else {
    if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
      $variables['content_column_class'] = ' class="col-sm-4"';
    }
    elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
      $variables['content_column_class'] = ' class="col-sm-8"';
    }
    else {
      $variables['content_column_class'] = ' class="col-sm-12"';
    }
  }

  /**
   * Preprocess the breadcrumbs. Ordinarily, these are built in
   * theme_process_page(), but we are using the Menu HTML module on sites such
   * as the NHS NW London, and that results in escaped HTML such as this
   * appearing in the breadcrumbs:
   *
   * <li><a href="/yourhealth">Your &lt;br /&gt;health</a></li>
   *
   * ... which looks a bit pants, really :)
   */
  if (!isset($variables['breadcrumb'])) {
    $variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => greyhead_bootstrap_drupal_get_breadcrumb()));
  }
}

/**
 * Implements hook_preprocess_html().
 *
 * @param $variables
 */
function greyhead_bootstrap_preprocess_html(&$variables) {
  // Add a meta-tag to tell IE 8 not to panic when rendering pages.
  // Code from https://api.drupal.org/comment/18004#comment-18004
  // <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,IE=8">
  $meta_ie_render_engine = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'content' => 'IE=edge,chrome=1,IE=8',
      'http-equiv' => 'X-UA-Compatible',
    ),
  );

  // Add header meta tag for IE to head
  drupal_add_html_head($meta_ie_render_engine, 'meta_ie_render_engine');

  // Workaround to prevent console.logs from throwing IE errors of DOOOM.
  $js = 'if (!window.console) console = {log: function() {}};';
  drupal_add_js($js, array('type' => 'inline', 'scope' => 'header', 'weight' => -1000));
}

///**
// * Implements hook_menu_breadcrumb_alter.
// *
// * Remove any HTML in the menu link titles which has been set by the menu_html
// * contrib module.
// *
// * @param $variables
// */
//function greyhead_bootstrap_menu_breadcrumb_alter(&$active_trail, $item) {
//  foreach ($active_trail as &$active_trail_item) {
//    $active_trail_item['title'] = strip_tags($active_trail_item['title']);
//  }
//}

/**
 * Gets the breadcrumb trail for the current page.
 *
 * This function uses a custom implementation of menu_get_active_breadcrumb()
 * which removes rather than escapes any HTML in the link title.
 *
 * @return array|null
 */
function greyhead_bootstrap_drupal_get_breadcrumb() {
  $breadcrumb = greyhead_bootstrap_drupal_set_breadcrumb();

  if (!isset($breadcrumb)) {
    $breadcrumb = greyhead_bootstrap_menu_get_active_breadcrumb();
  }

  // Make the function hook_alteraboo, as a
  // hook_greyhead_bootstrap_breadcrumb(). In an ideal world, the
  // menu_trail_by_path module would provide alter hooks and we wouldn't have
  // to do this, but it doesn't, so we do. Sad face.
  drupal_alter('greyhead_bootstrap_breadcrumb', $breadcrumb);

  return $breadcrumb;
}

/**
 * Sets the breadcrumb trail for the current page.
 *
 * This is a separate implementation of drupal_set_breadcrumb() which we use
 * to make sure we rebuild a breadcrumb which doesn't contain any HTML.
 *
 * @param $breadcrumb
 *   Array of links, starting with "home" and proceeding up to but not including
 *   the current page.
 *
 * @return null
 */
function greyhead_bootstrap_drupal_set_breadcrumb($breadcrumb = NULL) {
  $stored_breadcrumb = &drupal_static(__FUNCTION__);

  if (isset($breadcrumb)) {
    $stored_breadcrumb = $breadcrumb;
  }
  return $stored_breadcrumb;
}

/**
 * Gets the breadcrumb for the current page, as determined by the active trail.
 *
 * This is a custom implementation of menu_get_active_breadcrumb()
 * which removes rather than escapes any HTML in the link title.
 *
 * @return array
 */
function greyhead_bootstrap_menu_get_active_breadcrumb() {
  $breadcrumb = array();

  // No breadcrumb for the front page.
  if (drupal_is_front_page()) {
    return $breadcrumb;
  }

  $item = menu_get_item();
  if (!empty($item['access'])) {
    $active_trail = menu_get_active_trail();

    // Allow modules to alter the breadcrumb, if possible, as that is much
    // faster than rebuilding an entirely new active trail.
    drupal_alter('menu_breadcrumb', $active_trail, $item);

    // Don't show a link to the current page in the breadcrumb trail.
    $end = end($active_trail);
    if ($item['href'] == $end['href']) {
      array_pop($active_trail);
    }

    // Remove the tab root (parent) if the current path links to its parent.
    // Normally, the tab root link is included in the breadcrumb, as soon as we
    // are on a local task or any other child link. However, if we are on a
    // default local task (e.g., node/%/view), then we do not want the tab root
    // link (e.g., node/%) to appear, as it would be identical to the current
    // page. Since this behavior also needs to work recursively (i.e., on
    // default local tasks of default local tasks), and since the last non-task
    // link in the trail is used as page title (see menu_get_active_title()),
    // this condition cannot be cleanly integrated into menu_get_active_trail().
    // menu_get_active_trail() already skips all links that link to their parent
    // (commonly MENU_DEFAULT_LOCAL_TASK). In order to also hide the parent link
    // itself, we always remove the last link in the trail, if the current
    // router item links to its parent.
    if (($item['type'] & MENU_LINKS_TO_PARENT) == MENU_LINKS_TO_PARENT) {
      array_pop($active_trail);
    }

    foreach ($active_trail as $parent) {
      $breadcrumb[] = l(strip_tags($parent['title']), $parent['href'], $parent['localized_options']);
    }
  }
  return $breadcrumb;
}
