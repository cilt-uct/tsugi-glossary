<?php
require_once "../config.php";
include "tool-config_dist.php";
include 'src/Template.php';

use \Tsugi\Core\LTIX;

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$site_id = $LAUNCH->ltiRawParameter('context_id','none');

$menu = false; // We are not using a menu

$context = [
    'instructor' => $USER->instructor,
    'styles'     => [ addSession('static/css/app.min.css'), addSession('static/css/custom.css'), ],
    'scripts'    => [ ],
    'debug'      => $debug,
    'custom_debug' => $LAUNCH->ltiRawParameter('custom_debug', false),
    'tool_debug' => $tool['debug'],
    // Add others
  ];

// Start of the output
$OUTPUT->header();

Template::view('templates/header.html', $context);

$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);

if ($debug) {
    echo '<pre>'; print_r($context); echo '</pre>';
}

Template::view('templates/glossary-body.html', $context);

$OUTPUT->footerStart();

Template::view('templates/glossary-footer.html', $context);

$OUTPUT->footerEnd();

?>
