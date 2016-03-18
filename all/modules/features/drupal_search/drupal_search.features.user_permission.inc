<?php
/**
 * @file
 * drupal_search.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function drupal_search_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'administer search'.
  $permissions['administer search'] = array(
    'name' => 'administer search',
    'roles' => array(
      'super-administrator' => 'super-administrator',
    ),
    'module' => 'search',
  );

  // Exported permission: 'search content'.
  $permissions['search content'] = array(
    'name' => 'search content',
    'roles' => array(
      'anonymous user' => 'anonymous user',
      'authenticated user' => 'authenticated user',
      'super-administrator' => 'super-administrator',
    ),
    'module' => 'search',
  );

  // Exported permission: 'use advanced search'.
  $permissions['use advanced search'] = array(
    'name' => 'use advanced search',
    'roles' => array(
      'anonymous user' => 'anonymous user',
      'authenticated user' => 'authenticated user',
      'super-administrator' => 'super-administrator',
    ),
    'module' => 'search',
  );

  return $permissions;
}
