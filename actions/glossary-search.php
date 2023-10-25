<?php
require_once "../../config.php";
include "../tool-config_dist.php";
include '../src/Template.php';
require_once "../dao/GlossaryDAO.php";

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

$domain_id = isset($_GET['domain_id']) ? $_GET['domain_id'] : 0;
$limit = 9;
$domainData = $glossaryDAO->getTermsForDomain($domain_id, $limit);
if (!$domainData) {
   die("Query failed: " . mysqli_error($connection));
}
//$concepts =$glossaryDAO->searchWord($word, $definition, $term);
$languages = $glossaryDAO->getAllLanguages();

?>

<style>
   .row {
      margin-left: -15px;
      margin-right: -15px;
   }

   .key .keys {
      background-color: #e6e6e6;
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 8px;
      padding-bottom: 8px;
      cursor: pointer;
      height: 35px;
      width: 35px;
   }

   .keys .key>a,
   .globalsite.cmp-globalsite-glossarysearch .keys .numkey>a {
      font-size: 17px;
      font-weight: 500;
      line-height: 20px;
      text-align: center;
      color: #0052d6;
      display: block;
      cursor: pointer;
   }

   .key {
      display: flex;
      flex-wrap: wrap;
   }

   .letter {
      width: 33.33%;

   }

   .column {
      list-style: none;
   }

   .a {
      font-weight: bold;
   }
</style>
<!-- <li><span aria-current="page" class="page-numbers current">3</span></li> -->

<section>
   <div class="globalsite cmp-globalsite-glossarysearch oldviz aem-GridColumn aem-GridColumn--default--12">
   </div>
   <div class="globalsite cmp-globalsite-glossarysearchrelatedterms oldviz aem-GridColumn aem-GridColumn--default--12">
      <section class="grid-norm  ">
         <form>
            <!-- simpletexteyebrow Template -->
            <div class="simpletexteyebrow display-flex grid-full no-top hero-mb" style="background-color: #F4F4F4;">
               <div class="hero-content grid-wide no-top-bottom">
                  <div class="simple-rep grid-wide-inner ">
                     <div class="child-cell">
                        <h1 data-en-heading="Glossary" style="color:#002856">Vula Glossary</h1>
                     </div>
                  </div>
               </div>
            </div>
            <label for="word">Languages list</label> &nbsp; &nbsp; &nbsp; &nbsp;
            <select name="languages" id="languageSelect">
               <?php
               foreach ($languages as $arr => $value): ?>
                  <option>
                     <?= $value['language']; ?>
                  </option>
               <?php endforeach; ?>
            </select> <br>
            <div id="termsContainer">
               <!-- Display terms here -->
            </div>
            <input type="text" id="searchBox" name="searchBox" placeholder="Search Vula Glossary" value="">
            <button type="submit" class="btn btn-primary" id="searchButton">
               Search
            </button>
            <div id="searchResults"> </div>
         </form>
         <div class="row">
            <div class="found-result col-xs-12 p-small" style="display:none"></div>
         </div>
         <div class="row keys hidden-sm hidden-xs">
            <div>
               <?php
               echo '<button>0-9</button>';
               // Array of alphabets
               $alphabets = range('A', 'Z');
               foreach ($alphabets as $alphabet) {
                  echo '<button type="button" data-term_id="{{searchTerm}}"  >' . $alphabet . '</button>';
               }
               ?>
            </div>
            &nbsp; <div class="col-xs-12">

               <ul class="key" data-action="alphabet">
                  <?php
                  $termsByLetter = []; 
                  foreach ($domainData as $row) {
                     $word = $row['term'];
                     $firstLetter = strtoupper(substr($word, 0, 1));
                     $termsByLetter[$firstLetter][] = $row['term'];
                  }
                  // Loop through the alphabets from A to Z
                  for ($letter = 'A'; $letter <= 'Z'; $letter++) {
                     $letterTerms = $termsByLetter[$letter] ?? [];
                     if (!empty($letterTerms)) {
                        echo '<li class="letter">';
                        echo '<a class="' . $letter . '">' . $letter . '</a>';
                        echo '<div class="columns">';
                        $numColumns = 3;
                        $columnSize = ceil(count($letterTerms) / $numColumns);
                        $columns = array_chunk($letterTerms, $columnSize);
                        foreach ($columns as $column) {
                           echo '<div class="column">';
                           echo '<ul>'; // Create a nested list for the terms in this column
                           foreach ($column as $term) {
                              echo '<li>' . $term . '</li>';
                           }
                           echo '</ul>';
                           echo '</div>';
                        }
                        echo '</div>';
                        echo '</li>';
                     }
                  }
                  ?>
               </ul>

               <div id="result"></div>
            </div>
      </section>