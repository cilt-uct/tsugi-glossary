<?php
require_once "../config.php";
include "tool-config_dist.php";
include 'src/Template.php';
require_once "dao/GlossaryDAO.php";

use \Tsugi\Core\LTIX;
use \Glossary\DAO\GlossaryDAO;
//use \Glossary\templates\glossary_footer;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$debug = 1;
$menu = false; // We are not using a menu
$glossaryDAO = new GlossaryDAO($PDOX, $CFG->dbprefix);

$domain_id = isset($_GET['domain_id']) ? $_GET['domain_id'] : 0;
$languages = $glossaryDAO ->getAllLanguages();
$word = "";
$searchTerm = $glossaryDAO ->searchWord($word);
$domains = $glossaryDAO->getDomain($domain_id);
// foreach ($domains as $domain) {
//    $obj = $domain;
//    $obj['courses'] = $glossaryDAO->getDomain($domain_id);;
//    array_push($domains, $obj);
// }

$displayList = [];
foreach ($domains as $domain) {
   $obj = $domain;
   $obj['terms'] = $glossaryDAO->getTermsForDomain($domain['id'], 6);
   array_push($displayList, $obj);
}

// foreach ($domain as $dn) {
//    echo ($dn);
// }

$context = [
   'instructor' => $USER->instructor,
   'styles' => [addSession('static/css/app.min.css'), addSession('static/css/custom.css')],
   'scripts' => [],
   'debug' => $debug,
   'custom_debug' => $LAUNCH->ltiRawParameter('custom_debug', false),
   'tool_debug' => $tool['debug'],
   'search_url' => addSession('actions/glossary-search.php'),
   'post_url' => addSession('actions/process.php'),
   'domains' => $domains,
   'displayList' => $displayList,
   //'selectedDomain' => $selectedDomain
];

// Start of the output
$OUTPUT->header();

Template::view('templates/header.html', $context);

$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);

if ($debug) {
   // echo '<pre>';
   // // print_r($displayList);
   // echo '</pre>';
}

Template::view('templates/glossary-body.html', $context);

$OUTPUT->footerStart();

Template::view('templates/glossary-footer.html', $context);

$OUTPUT->footerEnd();
?>

