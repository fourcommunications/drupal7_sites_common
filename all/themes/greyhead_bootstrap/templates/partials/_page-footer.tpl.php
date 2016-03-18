<?php
/**
 * @file: page footer partial.
 */
?>

<?php if ($just_above_footer = render($page['justabovefooter'])): ?>
  <div class="just-above-footer-wrapper">
    <footer class="just-above-footer container">
      <?php print $just_above_footer ?>
    </footer>
  </div>
<?php endif ?>
<?php if (($footer = render($page['footer'])) || isset($logo)): ?>
  <div class="footer-wrapper">
    <footer class="footer container">
      <?php print $footer ?>
      <?php if (isset($logo) && !empty($logo)): ?>
        <a class="logo navbar-btn pull-right" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" class="logo" alt="<?php print t('Home'); ?>"/>
        </a>
      <?php endif ?>
    </footer>
  </div>
<?php endif ?>
