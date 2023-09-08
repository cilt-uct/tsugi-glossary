<?php
require_once "../config.php";
include "tool-config_dist.php";
include 'src/Template.php';
require_once "dao/GlossaryDAO.php";

use \Tsugi\Core\LTIX;
use \Glossary\DAO\GlossaryDAO;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$debug = 1;
$menu = false; // We are not using a menu
$glossaryDAO = new GlossaryDAO($PDOX, $CFG->dbprefix);

// get all the domains
// for each domain
$displayDomains = $glossaryDAO->getDomain();

$context = [
   'instructor' => $USER->instructor,
   'styles' => [addSession('static/css/app.min.css'), addSession('static/css/custom.css')],
   'scripts' => [],
   'debug' => $debug,
   'custom_debug' => $LAUNCH->ltiRawParameter('custom_debug', false),
   'tool_debug' => $tool['debug'],
   'search_url' => addSession('templates/glossary-search.php'),
   'displayDomains' => $displayDomains
];

// Start of the output
$OUTPUT->header();

Template::view('templates/header.html', $context);

$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);

if ($debug) {
   echo '<pre>';
   print_r($context);
   echo '</pre>';
}

Template::view('templates/glossary-body.html', $context);

$OUTPUT->footerStart();

Template::view('templates/glossary-footer.html', $context);

$OUTPUT->footerEnd();
?>

