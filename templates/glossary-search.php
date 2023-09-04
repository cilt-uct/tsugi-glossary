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
            <div
              class="globalsite cmp-globalsite-glossarysearchrelatedterms oldviz aem-GridColumn aem-GridColumn--default--12">
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
         <select name="languages" placeholder="--Select--">
            <option> --Select--</option>
            <option>
               <?php
               $query = "select * from languages";
               $results = mysqli_query($connection, $query);
               while ($row = mysqli_fetch_assoc($results)) {
                  ?>
               <option>
                  <?php echo $row['languagename'] ?>
               </option>
               <?php
               }
               ?>
            </option>
         </select> <br>
         <input type="text" name="search" placeholder="Search Vula Glossary"
            value="<?php if (isset($_GET['searchWord()']))
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
            <ul class="list-inline">
               <li class="numkey selected">
                  <a class="0-9 selected">0-9
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (is_numeric(substr($word, 0, 1))) {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="A">A
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "A") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="B">B
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "B") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="C">C
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "C") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="D">D
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "D") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="E">E
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "E") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="F">F
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "B") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="G">G
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "G") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="H">H
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "H") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="I">I
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "I") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="J">J
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "J") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="K">K
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "K") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="L">L
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "L") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="M">M
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "M") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="N">N
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "N") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="O">O
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "O") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="P">P
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "P") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="Q">Q
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "Q") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="R">R
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "R") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="S">S
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "S") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="T">T
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "T") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="U">U
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "U") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="V">V
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "V") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="W">W
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "W") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="X">X
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "X") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="disabled key">
                  <a class="disabled Y">Y
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "Y") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>

               <li class="key">
                  <a class="Z">Z
                     <?php
                     while ($row = mysqli_fetch_assoc($resultN)) {
                        ?>
                        <?php $word = $row['concepttext'];
                        if (substr($word, 0, 1) == "Z") {
                           echo $row['concepttext'];
                           $row['definitiontext'];
                        }
                        ?>
                        <?php
                     } ?>
                  </a>
               </li>
            </ul>
         </div>
      </div>

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