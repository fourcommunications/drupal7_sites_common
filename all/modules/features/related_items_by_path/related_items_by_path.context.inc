<?php
/**
 * @file
 * related_items_by_taxonomy.context.inc
 */

/**
 * Implements hook_context_default_contexts().
 */
function related_items_by_taxonomy_context_default_contexts() {
  $export = array();

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'related_items_by_taxonomy';
  $context->description = 'Related items by taxonomy terms';
  $context->tag = 'features';
  $context->conditions = array(
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'related_items_by_taxonomy-related_items_by_taxonomy_block' => array(
          'module' => 'related_items_by_taxonomy',
          'delta' => 'related_items_by_taxonomy_block',
          'region' => 'content',
          'weight' => '-20',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('Related Items by taxonomy terms');
  $export['related_items_by_taxonomy'] = $context;

  return $export;
}
