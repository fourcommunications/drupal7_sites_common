<?php if ($above_navigation = render($page['above_navigation'])): ?>
  <header id="above-navigation" role="banner" class="above-navigation">
    <!--    <div class="container">-->
    <div class="row">
      <?php print $above_navigation; ?>
    </div>
    <!--    </div>-->
  </header>
<?php endif; ?>

<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="navbar-header">

    <!-- Header row 1 - site logo and primary menu -->
    <div class="navbar-row-1 clearfix">
      <div class="row">
        <div class="container">
          <div class="navbar-header">
            <div class="site-info">
              <div class="site-name-link-and-slogan">
                <?php if (!empty($site_name)): ?>
                  <h1 class="site-name-link">
                    <a class="name navbar-brand" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><?php print $site_name; ?></a>
                  </h1>
                <?php endif; ?>

                <?php if (!empty($site_slogan)): ?>
                  <p class="lead site-slogan">
                    <a href="<?php print $front_page; ?>"><?php print $site_slogan; ?></a>
                  </p>
                <?php endif; ?>
              </div>
            </div>

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <span class="navbar-toggle-container">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <span class="navbar-toggle-label"><?php print t('Menu') ?></span>
            </span>

            <?php if (!empty($primary_nav) || !empty($page['navigation'])): ?>
              <div class="navbar-container navbar-collapse collapse">
                <nav role="navigation">
                  <?php if ($primary_nav_rendered = render($primary_nav)): ?>
                    <?php print $primary_nav_rendered; ?>
                  <?php endif; ?>

                  <?php if ($navigation = render($page['navigation'])): ?>
                    <?php print $navigation; ?>
                  <?php endif; ?>
                </nav>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Header row 2 - secondary menu, if populated -->
  <!--    @TODO: hide/move on mobile to bottom of page? -->
  <?php if (!empty($secondary_nav) || !empty($page['secondary_navigation'])): ?>
    <div class="navbar-row-2 clearfix">
      <div class="row">
        <div class="container">
          <?php print render($secondary_nav); ?>

          <?php if ($secondary_navigation = render($page['secondary_navigation'])): ?>
            <?php print $secondary_navigation; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

</header>
