<?php
/**
 * @file: related-items-by-taxonomy--items.tpl.php
 *
 *      Theming function for the Related Items By Path module.
 *
 *      Copy this file into your theme directory if you would like to override
 *      its output.
 *
 *      The following variable is available:
 *
 *        related_items: an item list chunk of HTML rendered by
 *          theme_related_items_by_taxonomy_item.
 */
?>

<div class="related-items-list">
  <?php foreach ($related_items as $row => $related_item): ?>
  <div class="related-item-number-<?php print $row ?> col-md-3">
    <?php print theme('related_items_by_taxonomy_item', $related_item) ?>
  </div>
  <?php endforeach ?>
</div>
