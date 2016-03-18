<?php
/**
 * @file
 * related_items_by_taxonomy.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function related_items_by_taxonomy_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'administer related items'.
  $permissions['administer related items'] = array(
    'name' => 'administer related items',
    'roles' => array(
      'administrator' => 'administrator',
    ),
    'module' => 'related_items_by_taxonomy',
  );

  return $permissions;
}
