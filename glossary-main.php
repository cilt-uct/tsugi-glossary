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

$debug = 0;
$menu = false; // We are not using a menu
$glossaryDAO = new GlossaryDAO($PDOX, $CFG->dbprefix);

$domain_id = isset($_GET['domain_id']) ? $_GET['domain_id'] : 0;
$languages = $glossaryDAO ->getAllLanguages();
$word = "";
$domains = $glossaryDAO->getDomain($domain_id);
$all_terms = $glossaryDAO->getAllTerms();

$main_view = "default";

$displayList = [];
foreach ($domains as $domain) {
   $obj = $domain;
   $obj['terms'] = $glossaryDAO->getTermsForDomain($domain['id'], 6);
   array_push($displayList, $obj);
}
$context = [
   'instructor' => $USER->instructor,
   'styles' => [addSession('static/css/app.min.css'), addSession('static/css/custom.css')],
   'scripts' => [],
   'debug' => $debug,
   'custom_debug' => $LAUNCH->ltiRawParameter('custom_debug', false),
   'tool_debug' => $tool['debug'],
   'post_url' => addSession('actions/process.php'),
   'viewAllTerms'=> addSession('templates/glossary-body-all.html'),
   'domains' => $domains,
   'displayList' => $displayList,
   'languages' => $languages,
   'all_terms' => $all_terms,
];

$OUTPUT->header();

Template::view('templates/header.html', $context);

$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);

if ($debug) {
   echo '<pre>';
   echo '</pre>';
}

Template::view('templates/glossary-body-'. $main_view .'.html', $context);

$OUTPUT->footerStart();

Template::view('templates/glossary-footer-'. $main_view .'.html', $context);

$OUTPUT->footerEnd();
?>

