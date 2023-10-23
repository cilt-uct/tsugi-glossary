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
            <label for="word">Languages list</label>
               <select name="languages" placeholder="--Select--">  &nbsp; &nbsp;
                  <option> --Select--</option>
                  <option>
                     <!-- <option>
                        {% foreach ($languages as $x => $val) { %} 
                           <option>{{$val['name'] }}</option>
                        {% } %}  -->

                     <?php
                     foreach ($languages as $arr => $value): ?>
                     <option>
                        <?= $value['name']; ?>
                     </option>
                  <?php endforeach; ?>
                  </option>
                  </option>
               </select> <br>
                  </br>
            <input type="text" name="search" placeholder="Search Vula Glossary" value="<?php if (isset($_GET['searchWord()']))
               echo $_GET['searchWord']; ?> ">
            <button type="submit" class="btn btn-primary" id="search-btn">
               Search
            </button>
         </form>
         <div class="row">
            <div class="found-result col-xs-12 p-small" style="display:none"></div>
         </div>
         <div class="row keys hidden-sm hidden-xs">
            <div class="col-xs-12">
               <ul class="list-inline" id="show_alphabets">
               <?php
                echo '<button>0-9</button>';
                  // Array of alphabets
                  $alphabets = range('A', 'Z');

                  // Loop through the alphabets and create buttons
                  foreach ($alphabets as $alphabet) {
                     echo '<button type="button" onclick="searchWords()">'. $alphabet . '</button>';
                  }
               ?>
   
                  <li class="key">
                     <a class="A">A
                        <?php
                        foreach ($domainData as $row) {
                           $word = $row['term'];
                           if (substr($word, 0, 1) == "A") {
                              echo "<li>" . $row['term'] . "</li>";
                           }
                        }
                        ?>
                     </a>
                  </li>

                  <li class="key">
                     <a class="B">B
                        <?php
                        foreach ($domainData as $row) {
                           $word = $row['term'];
                           if (substr($word, 0, 1) == "B") {
                              echo $row['concepttext'];
                              $row['definitiontext'];
                           }
                        }
                        ?>
                     </a>
                  </li>


                  <div id="result"></div>
                  <script>
                     // Function to handle search button click event
                     function searchWord() {
                        const word = document.getElementById("word").value;
                        const resultDiv = document.getElementById("result");

                        if (!word) {
                           alert("Please enter a word.");
                           return;
                        }

                        // Replace the following line with your backend code to fetch word meanings
                        const meaning = "Sample meaning for " + word;
                        resultDiv.innerText = meaning;
                     }
                     // Add event listener to search button
                     document.getElementById("search-btn").addEventListener("click", searchWord);
                  </script>
            </div>
      </section>