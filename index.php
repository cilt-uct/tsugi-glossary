<?php
require_once('../config.php');
include 'tool-config_dist.php';

use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;

$LAUNCH = LTIX::requireData();

$is_dev = $LAUNCH->ltiRawParameter('custom_dev', false);
// Add others later

$site_id = $LAUNCH->ltiRawParameter('context_id','none');

if ($is_dev == FALSE) {
    $is_dev = in_array($site_id, $tool['dev']);
}

// Add more later ...

if ( $USER->instructor ) {
  header( 'Location: '.addSession('glossary-home.php') ) ;
}
