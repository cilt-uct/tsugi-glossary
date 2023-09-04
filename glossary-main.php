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

function getFilteredArray($params, $data) {
  $filtredArray = [];
  foreach($params as $key => $value) {
      foreach($data as $index => $item) {
          if(array_key_exists($key, $item) && in_array($value, $params)) {
              if($item[$key] == $value ){
                  $filtredArray[$index] = $item;
              } else {
                  continue;
              }
          }
      }
  }
  return $filtredArray;
}

$debug =1 ;
$menu = false; // We are not using a menu
$concepttext = "" ;
$glossaryDAO = new GlossaryDAO($PDOX, $CFG->dbprefix);

//$accountingDef = $glossaryDAO->getAccountingConcepts($domain);

// foreach ($accountingDef as $v) {
//   $start = getFilteredArray(array('concepttext'), $accountingDef);
//   $end = array();
// }

$context = [
   'instructor' => $USER->instructor,
   'styles' => [addSession('static/css/app.min.css'), addSession('static/css/custom.css'),
   ],
   'scripts' => [],
   'debug' => $debug,
   'custom_debug' => $LAUNCH->ltiRawParameter('custom_debug', false),
   'tool_debug' => $tool['debug'],
   'search_url' => addSession('templates/glossary-search.php'),
   //'accountingDef' => $accountingDef,
   // Add others
];

// Start of the output
$OUTPUT->header();

Template::view('templates/header.html', $context);

$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);

// if ($debug) {
//    echo '<pre>';
//    print_r($context);
//    echo '</pre>';
// }

Template::view('templates/glossary-body.html', $context);

$OUTPUT->footerStart();

//Template::view('templates/glossary-footer.html', $context);

$OUTPUT->footerEnd();

?>

