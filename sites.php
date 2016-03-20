<?php

/**
 * We need to know Drupal's root, but if we're in Drush, the DRUPAL_ROOT isn't
 * defined because Drush shuffles the order in which Drupal is bootstrapped.
 *
 * To get around this, we first check if DRUPAL_ROOT is defined and, if not, we
 * check if a Drush command is available.
 *
 * Failing all that, we die with an error message because something's gone
 * askew.
 */
$GLOBALS['greyhead_configuration_drupal_root'] = defined('DRUPAL_ROOT') ? DRUPAL_ROOT : NULL;

if (is_null($GLOBALS['greyhead_configuration_drupal_root']) && function_exists('drush_get_context')) {
  $GLOBALS['greyhead_configuration_drupal_root'] = drush_get_context('DRUSH_SELECTED_DRUPAL_ROOT');
}

/**
 * @file
 * Configuration file for Drupal's multi-site directory aliasing feature.
 *
 * This file allows you to define a set of aliases that map hostnames, ports, and
 * pathnames to configuration directories in the sites directory. These aliases
 * are loaded prior to scanning for directories, and they are exempt from the
 * normal discovery rules. See default.settings.php to view how Drupal discovers
 * the configuration directory when no alias is found.
 *
 * Aliases are useful on development servers, where the domain name may not be
 * the same as the domain of the live server. Since Drupal stores file paths in
 * the database (files, system table, etc.) this will ensure the paths are
 * correct when the site is deployed to a live server.
 *
 * To use this file, copy and rename it such that its path plus filename is
 * 'sites/sites.php'. If you don't need to use multi-site directory aliasing,
 * then you can safely ignore this file, and Drupal will ignore it too.
 *
 * Aliases are defined in an associative array named $sites. The array is
 * written in the format: '<port>.<domain>.<path>' => 'directory'. As an
 * example, to map http://www.drupal.org:8080/mysite/test to the configuration
 * directory sites/example.com, the array should be defined as:
 * @code
 * $sites = array(
 *   '8080.www.drupal.org.mysite.test' => 'example.com',
 * );
 * @endcode
 * The URL, http://www.drupal.org:8080/mysite/test/, could be a symbolic link or
 * an Apache Alias directive that points to the Drupal root containing
 * index.php. An alias could also be created for a subdomain. See the
 * @link http://drupal.org/documentation/install online Drupal installation guide @endlink
 * for more information on setting up domains, subdomains, and subdirectories.
 *
 * The following examples look for a site configuration in sites/example.com:
 * @code
 * URL: http://dev.drupal.org
 * $sites['dev.drupal.org'] = 'example.com';
 *
 * URL: http://localhost/example
 * $sites['localhost.example'] = 'example.com';
 *
 * URL: http://localhost:8080/example
 * $sites['8080.localhost.example'] = 'example.com';
 *
 * URL: http://www.drupal.org:8080/mysite/test/
 * $sites['8080.www.drupal.org.mysite.test'] = 'example.com';
 * @endcode
 *
 * @see default.settings.php
 * @see conf_path()
 * @see http://drupal.org/documentation/install/multi-site
 */

if (!function_exists('greyhead_configuration_get_site_urls')) {
  /**
   * Load the site's URL(s) from the settings.site_urls.info file.
   *
   * We use this to build the list of live site URL mappings to their
   * corresponding multisite directories, rather than having to hand-code URLs in
   * to sites.php. Simples! :)
   *
   * Files are structured in Drupal .info file format, which you can read about
   * here:
   *
   * https://api.drupal.org/api/drupal/includes%21common.inc/function/drupal_parse_info_format/7
   *
   * Note that the live site URL value should be provided as an array, even if
   * there is only one value, but you can specify multiple URLs, e.g.:
   *
   *  live_site_url[] = abc.com
   *  live_site_url[] = example.com
   *  live_site_url[] = foo.bar.baz
   *
   * If those URLs should map to different databases, you need to add multiple
   * keys to the local_databases.php file, e.g.:
   *
   * array(
   * 'wmc' => array(
   * 'wmc.4com.local' => array(
   * 'database' => '4com_wmc',
   * 'username' => 'root',
   * 'password' => 'password',
   * ),
   * 'wmc2.4com.local' => array(
   * 'database' => '4com_wmc2',
   * 'username' => 'root',
   * 'password' => 'password',
   * ),
   * 'wmc.monkey.local' => array(
   * 'database' => '4com_wmc2',
   * 'username' => 'root',
   * 'password' => 'password',
   * ),
   * ),
   * );
   *
   * @param array $multisite_directories An array of multisite directories to
   *                                     scan, e.g.:
   *
   *                                     array('wmc','nhsnwlondon');
   *
   *                                     If not provided or NULL, a list of all
   *                                     available directories, excluding the
   *                                     "all" and "default" directories, will be
   *                                     built.
   *
   * @return array|bool A sites.php-compatible associative array, where the keys
   * are the HTTP_HOST site URL, and the values are the multisite directory names.
   *
   * @see local_databases.php's help text for more information.
   */
  function greyhead_configuration_get_site_urls($multisite_directories = NULL) {
    // First, make sure common.inc has been included.
    if (!function_exists('drupal_parse_info_format')) {
      require_once $GLOBALS['greyhead_configuration_drupal_root'] . '/includes/common.inc';
    }

    // Initialise our results array.
    $sites = array();

    // If no list of directories has been provided,
    if (is_null($multisite_directories)) {
      $multisite_directories = greyhead_configuration_get_sites_directories();
    }

    // If we've been passed crufty data, error.
    if (!is_array($multisite_directories)) {
      return FALSE;
    }

    // Create an array of filenames to check - we look for
    // 'settings.this_site_url.info' first, and then 'settings.site_urls.info'.
    $site_urls_files = array(
      'settings.this_site_url.info',
      'settings.site_urls.info',
    );

    // Loop through each directory name and, if a corresponding .info file is
    // found, get the live site URL.
    foreach ($multisite_directories as $multisite_directory) {
      foreach ($site_urls_files as $site_urls_file) {
        $path_to_check = greyhead_configuration_get_path_to_sites_directory() . $multisite_directory . '/' . $site_urls_file;

        // Does the file exist?
        if (is_readable($path_to_check)) {
          // Get the .info file's contents.
          $settings_site_urls_info_contents = file_get_contents($path_to_check);

          // Parse the info file.
          $settings_site_urls_info_contents_parsed = drupal_parse_info_format($settings_site_urls_info_contents);

          // Copy the URLs into the format
          // $array[www.example.com] = multisitedirectory.
          if (array_key_exists('SETTINGS_SITE_URLS', $settings_site_urls_info_contents_parsed)
            && is_array($settings_site_urls_info_contents_parsed['SETTINGS_SITE_URLS'])) {
            foreach ($settings_site_urls_info_contents_parsed['SETTINGS_SITE_URLS'] as $http_host) {
              if (!empty($http_host)) {
                $sites[$http_host] = $multisite_directory;

                // If the host begins www., also create a non-www version.
                if (substr($http_host, 0, strlen('www.')) == 'www.') {
                  $http_host_no_rubberdubdub = substr($http_host, strlen('www.'));
                  $sites[$http_host_no_rubberdubdub] = $multisite_directory;
                }
              }
            }
          }
        }
      }
    }

    return $sites;
  }
}

if (!function_exists('greyhead_configuration_get_path_to_sites_directory')) {
  /**
   * Get the file system path to the sites directory.
   *
   * @return string A path, including a trailing slash, e.g. /var/www/sites/
   */
  function greyhead_configuration_get_path_to_sites_directory($subpath = 'sites/') {
    return $GLOBALS['greyhead_configuration_drupal_root'] . '/' . $subpath;
  }
}

if (!function_exists('greyhead_configuration_get_sites_directories')) {
  /**
   * @param string $subpath The path to the sites folder relative to Drupal's
   *                        root.
   * @param null   $ignores An array of directories to ignore, e.g.:
   *                        array('all', 'default'). To search all directories,
   *                        provide an empty array; if no value is specified,
   *                        defaults to ignoring the "all" and "default"
   *                        directories.
   *
   * @return array An array of directory names in the /sites/ directory.
   */
  function greyhead_configuration_get_sites_directories($subpath = 'sites/', $ignores = NULL) {
    // If ignores is null, ignore "all" and "default".
    if (is_null($ignores)) {
      $ignores = array(
        'all',
        'default',
      );
    }

    $directories_found = array();

    $path = greyhead_configuration_get_path_to_sites_directory($subpath);

    // Loop through all directories:
    foreach (glob($path . '*', GLOB_ONLYDIR) as $directory) {
      $directory_name_trimmed = substr($directory, strlen($path));

      if (!in_array($directory_name_trimmed, $ignores)) {
        $directories_found[$directory_name_trimmed] = $directory_name_trimmed;
      }
    }

    return $directories_found;
  }
}

if (!(isset($sites) && !is_array($sites))) {
  $sites = array();
}

/**
 * This array is constructed according to a couple of basic rules:
 *
 * - The local environment is the sites/[directory] name with .local on the end,
 *   making up the local development URL; e.g. [http://]greyhead7.local
 *
 * - It is also possible to have dev[elopment], test, rc (release candidate)
 *   and live servers set up on greyheaddev.com, so these are automatically
 *   made available, too
 *
 * - Lastly, you have an entry for the live URL, whatever that may be; we
 *   manually add this after we've automagically generated the other URLs.
 */

// To build this list, we start by getting a listing of the directories in
// ./sites, ignoring "all" and "default:

$live_site_info_files = array();

// Get a list of directories in the sites/ directory.
$directories_found = greyhead_configuration_get_sites_directories();

// Loop through each found directory and create the list of possible hosts:
foreach ($directories_found as $directory_found) {
  // Local development:
  $sites[$directory_found . '.4com.local'] = $directory_found;
  $sites[$directory_found . '.local'] = $directory_found;

  // Cater for multisite directories which are the exact URI, e.g.
  // dev.manbo.drupal.dev.fourplc.com.
  $sites[$directory_found] = $directory_found;

  // Staging hosts and live site candidates:
  $staging_hosts = array(
    '.dev.fourplc.com',
    '.staging.fourplc.com',
    '.co.uk',
    '.com',
  );

  // Staging environment types:
  $staging_environment_types = array(
    'dev.',
    'rc.',
  );

  foreach ($staging_hosts as $staging_host) {
    /**
     * E.g. if $directory_found is 'bijouweddings', this will give us:
     *
     * bijouweddings.dev.fourplc.com
     * bijouweddings.staging.fourplc.com
     * bijouweddings.co.uk
     * bijouweddings.com
     * bijouweddings
     *
     * Or for dev.manbo.drupal.dev.fourplc.com:
     *
     * dev.manbo.drupal.dev.fourplc.com.dev.fourplc.com
     * dev.manbo.drupal.dev.fourplc.com.staging.fourplc.com
     * dev.manbo.drupal.dev.fourplc.com.co.uk
     * dev.manbo.drupal.dev.fourplc.com.com
     * dev.manbo.drupal.dev.fourplc.com
     */
    $sites[$directory_found . $staging_host] = $directory_found;

    foreach ($staging_environment_types as $staging_environment_type) {
      /**
       * This gets a bit long-winded but we will end up with...
       *
       * dev.dev.manbo.drupal.dev.fourplc.com.dev.fourplc.com
       * rc.dev.manbo.drupal.dev.fourplc.com.dev.fourplc.com
       * dev.dev.manbo.drupal.dev.fourplc.com.dev.fourplc.com
       * rc.dev.manbo.drupal.dev.fourplc.com.staging.fourplc.com
       * dev.dev.manbo.drupal.dev.fourplc.com.staging.fourplc.com
       * rc.dev.manbo.drupal.dev.fourplc.com.staging.fourplc.com
       * dev.dev.manbo.drupal.dev.fourplc.com.co.uk
       * rc.dev.manbo.drupal.dev.fourplc.com.co.uk
       * dev.dev.manbo.drupal.dev.fourplc.com.co.uk
       * rc.dev.manbo.drupal.dev.fourplc.com.com
       * dev.dev.manbo.drupal.dev.fourplc.com.com
       * rc.dev.manbo.drupal.dev.fourplc.com.com
       * dev.dev.manbo.drupal.dev.fourplc.com
       * rc.dev.manbo.drupal.dev.fourplc.com
       *
       * Oyee...
       */
      $sites[$staging_environment_type . $directory_found . $staging_host] = $directory_found;
    }
  }
}

// Lastly, we need to look at the $_SERVER['HTTP_HOST'] variable to see if
// we have a domain ending in .dev.fourplc.com or .staging.fourplc.com. If we
// do, we want to get the first part of the domain name and check whether it
// matches any of the directories we found. If it does, map the URI to that
// multisite.

// For example, if $_SERVER['HTTP_HOST'] is wmc.1.dev.fourplc.com, and "wmc"
// matches a directory in /sites/, then we will set
// $sites['wmc.1.dev.fourplc.com'] = 'wmc';
if (array_key_exists('HTTP_HOST', $_SERVER)) {
  if ((substr($_SERVER['HTTP_HOST'], strlen($_SERVER['HTTP_HOST']) - strlen('.dev.fourplc.com')) == '.dev.fourplc.com') ||
    (substr($_SERVER['HTTP_HOST'], strlen($_SERVER['HTTP_HOST']) - strlen('.staging.fourplc.com')) == '.staging.fourplc.com')
  ) {
    // Map the first part of the URI to the multisite.
    $uri_parts = explode('.', $_SERVER['HTTP_HOST']);

    // Does the directory exist? In the example above, it would be the "wmc"
    // directory.
    if (array_key_exists($uri_parts[0], $directories_found)) {
      $sites[$_SERVER['HTTP_HOST']] = $uri_parts[0];
    }
  }
}

// Get an array of live site URLs mapped to their multisite directories.
$sites = greyhead_configuration_get_site_urls($directories_found) + $sites;

/*******************************************************************************
 * Manually added and legacy hosts.
 *
 * e.g.: $sites['example.com'] = 'example';
 *
 * Do you need to add an entry into site-specific-environment-overrides.php,
 * too? :)
 *
 * Note that you don't need to add an entry here if your settings.site_urls.info
 * file contains an entry there; we can now auto-detect the correct multisite
 * directory from that .info file.
 ******************************************************************************/

/*******************************************************************************
 * Do not make changes below this line (unless you really, really want to, of
 * course :).
 ******************************************************************************/


