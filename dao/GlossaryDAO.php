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
    function getDomain($domain_id = 0, $limit = 0, $offset = 0) {   
        $arr = array();
        $query = "SELECT *
                    FROM `{$this->p}glossary_domain` `domain`";
                    
        if ($domain_id > 0) {
            $query .= "WHERE `domain`.`id`=:domain_id";
            $arr = array(':domain_id' => $domain_id);
        }

        return $this->PDOX->allRowsDie($query, $arr);
     }

    function getTermsForDomain($domain_id = 0, $limit = 0, $offset = 0) {   
        $arr = array();
        $query = "SELECT `def`.`id`, `domain`.`name` as `domain_name`,`def`.`term`,`def`.`description` 
                    FROM `{$this->p}glossary_term` `def` 
                    LEFT JOIN `{$this->p}glossary_domain` `domain` on `domain`.`id` = `def`.`domain_id`";

        if ($domain_id > 0) {
            $query .= "WHERE `domain_id`=:domain_id";
            $arr = array(':domain_id' => $domain_id);
        }
        // same for offset
        return $this->PDOX->allRowsDie($query, $arr);
     }

    function getTerms($id, $domain_id, $term , $description ) {   
        $arr = array();
        $query = "SELECT `id`,`domain_id`,`term`,`description` 
                    FROM `{$this->p}glossary_term`where link_id = :linkId and site_id = :siteId;";
         return $this->PDOX->allRowsDie($query, $arr);
     }
     
    function getAllLanguages() {   
        $query = "SELECT `id`,`language`
                    FROM `{$this->p}glossary_language`";

        return $this->PDOX->allRowsDie($query);
     }
     function getTermsForLanguage($selectedLanguage) {
        $query = "SELECT `term `
                    FROM `{$this->p}glossary_term_translation_text`
                    LEFT JOIN `{$this->p}glossary_term_translation_text`,`glossary_term_translation` on `glossary_term_translation`.`id` = `glossary_term_translation_text`.`translation_id`
                    WHERE `language_id` = ?";
                    
        return $this->PDOX->allRowsDie($query);
    }

    function searchWord( $search_term) {
        global $db;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $search_term = $_POST["#search_term"];
        }
        $query = "SELECT `term` FROM `glossary_term_translation_text` WHERE term LIKE '$search_term%'";
        $result =  $this->PDOX->allRowsDie($query);
    
        if ($result === false) {
            return [];
        }
        // Fetch and display the results
     }
     function fetchTermsByAlphabet($alphabet) {
        global $pdo;
        
        $query = $pdo->prepare("SELECT `term` FROM glossary_term
                                WHERE `term` 
                                LIKE ? ORDER BY `term`");
        $query->execute(["$alphabet%"]);
        
        $terms = $query->fetchAll(PDO::FETCH_COLUMN);
        
        return $terms;
    }
    function addGlossaryTerm($link_id, $user_id, $domain_id, $term, $description) {
        $result = $this->PDOX->rowDie ("INSERT INTO {$this->p}glossary_term (`domain_id`, `term`, `description`)
                                            VALUES ( `:domain_id`, `:term`, `:description`)",
                                            array(':link_id'=>$link_id,':user_id'=>$user_id ,':domain_id' => $domain_id,':term' => $term, ':description' => $description ));
        return $result;
    }
    
    function updateGlossaryTerm( $link_id, $user_id, $term_id, $description, $term) {
        $query = "UPDATE {$this->p}glossary_term
        SET `modified_at` = NOW(), `modified_by` = :user_id, `term` = :term ,`description` = :description
        WHERE link_id = :link_id and term_id = :term_id";

        $arr = array(':link_id'=>$link_id,':user_id'=>$user_id ,':term_id' => $term_id,':description' => $description, ':term' => $term);
        return $this->PDOX->queryDie($query, $arr);
    }
    function insertGlossaryTerm($term_id, $domain_id, $state, $term, $description ) {
        $query = "INSERT 
        INTO {$this->p}glossary_term(id, domain_id, term, description)
        VALUES ('$term_id', '$domain_id', '$term', '$description')";

        $arr = array(':id' => $term_id,':domain_id' => $domain_id, ':active' => $state);
        return $this->PDOX->queryDie($query, $arr);
    }

    function removeGlossaryTerm($domain_id) {                        
        return $this->PDOX->queryDie("DELETE FROM {$this->p}glossary_term " .
                                "WHERE `term_id` = :id and `domain_id` = domain_id;", 
                                array(':domain_id' => $domain_id));
    } 

}              
    ?>