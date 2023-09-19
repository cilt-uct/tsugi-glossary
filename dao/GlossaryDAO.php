<?php
namespace Glossary\DAO;

class GlossaryDAO {
        
    private $PDOX;
    private $p;

    public function __construct($PDOX, $p) {
        $this->PDOX = $PDOX;
    }
   
    // getAllDomains
    // returns glossary_domains
    function getAllDomain($domain_id = 0, $limit = 0, $offset = 0) {   

        $arr = array();
        $query = "SELECT `def`.`id`,`domain`.`name` as `domain_name`,`def`.`term`,`def`.`definition` 
                    FROM `{$this->p}glossary_definition` `def` 
                    LEFT JOIN `{$this->p}glossary_domains` `domain` on `domain`.`id` = `def`.`domain_id`";           

        if ($domain_id > 0) {
            $query .= "WHERE `domain_id`=:domain_id";
            $arr = array(':domain_id' => $domain_id);
        }

        return $this->PDOX->allRowsDie($query, $arr);
     }

    function getDomain($domain_id = 0, $limit = 0, $offset = 0) {   

        $arr = array();
        $query = "SELECT `def`.`id`,`domain`.`name` as `domain_name`,`def`.`term`,`def`.`definition` 
                    FROM `{$this->p}glossary_definition` `def` 
                    LEFT JOIN `{$this->p}glossary_domains` `domain` on `domain`.`id` = `def`.`domain_id`
                    LIMIT 9";

        if ($domain_id > 0) {
            $query .= "WHERE `domain_id`=:domain_id";
            $arr = array(':domain_id' => $domain_id);
        }
        // if limit > 0 add to query
        // same for offset
        return $this->PDOX->allRowsDie($query, $arr);
     }
     
     function searchWord($word) {
        global $conn;

        // const word = document.getElementById("word").value;
        // const resultDiv = document.getElementById("result");

        $query = $this->PDOX->rowDie("SELECT concepttext, definitiontext, domainid FROM {$this->p}conceptdefinitions WHERE domainid = :domain;",
        array(':domainid' => $word));
        
        if ($word == "") {
           echo("Please enter a word.");
           return;
        }else{
          // Replace the following line with your backend code to fetch word meanings
         $meaning = "Sample meaning for " + $word;
         return $meaning;
        }
    
     }


}              
    ?>