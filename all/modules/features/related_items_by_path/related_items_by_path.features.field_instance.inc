<?php
/**
 * @file
 * related_items_by_taxonomy.features.field_instance.inc
 */

/**
 * Implements hook_field_default_field_instances().
 */
function related_items_by_taxonomy_field_default_field_instances() {
  $field_instances = array();

  // Exported field_instance: 'node-article-field_related_items_by_taxonomy_manual'.
  $field_instances['node-article-field_related_items_by_taxonomy_manual'] = array(
    'bundle' => 'article',
    'default_value' => NULL,
    'default_value_function' => '',
    'deleted' => 0,
    'description' => 'Choose related pages to display at the bottom of this page in the "We think you\'d like..." section. If you choose fewer than the maximum number of related pages, the remainder will be automagically selected based on having similar taxonomy terms. If you choose more than the maximum, a random selection will be chosen and refreshed every hour per page.',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 11,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'node',
    'field_name' => 'field_related_items_by_taxonomy_manual',
    'label' => 'Related Items',
    'required' => 0,
    'settings' => array(
      'behaviors' => array(
        'prepopulate' => array(
          'status' => 0,
        ),
      ),
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'entityreference',
      'settings' => array(
        'match_operator' => 'CONTAINS',
        'path' => '',
        'size' => 60,
      ),
      'type' => 'entityreference_autocomplete',
      'weight' => 9,
    ),
  );

  // Exported field_instance: 'node-page-field_related_items_by_taxonomy_manual'.
  $field_instances['node-page-field_related_items_by_taxonomy_manual'] = array(
    'bundle' => 'page',
    'default_value' => NULL,
    'default_value_function' => '',
    'deleted' => 0,
    'description' => 'Choose related pages to display at the bottom of this page in the "We think you\'d like..." section. If you choose fewer than the maximum number of related pages, the remainder will be automagically selected based on having similar taxonomy terms. If you choose more than the maximum, a random selection will be chosen and refreshed every hour per page.',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 10,
      ),
      'node_tab_about-the-venue' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'node_tab_case-studies' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'node_tab_ceremonies' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'node_tab_gallery' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'node_tab_guest-services' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'node_tab_history' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'node_tab_receptions' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'node',
    'field_name' => 'field_related_items_by_taxonomy_manual',
    'label' => 'Related Items',
    'required' => 0,
    'settings' => array(
      'behaviors' => array(
        'prepopulate' => array(
          'status' => 0,
        ),
      ),
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'entityreference',
      'settings' => array(
        'match_operator' => 'CONTAINS',
        'path' => '',
        'size' => 60,
      ),
      'type' => 'entityreference_autocomplete',
      'weight' => 10,
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Choose related pages to display at the bottom of this page in the "We think you\'d like..." section. If you choose fewer than the maximum number of related pages, the remainder will be automagically selected based on having similar taxonomy terms. If you choose more than the maximum, a random selection will be chosen and refreshed every hour per page.' );
  t('Related Items');

  return $field_instances;
}
