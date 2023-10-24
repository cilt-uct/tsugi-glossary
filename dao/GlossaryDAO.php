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
                    LEFT JOIN `{$this->p}glossary_domains` `domain` on `domain`.`id` = `def`.`domain_id`";

        if ($domain_id > 0) {
            $query .= "WHERE `domain_id`=:domain_id";
            $arr = array(':domain_id' => $domain_id);
        }
        // if limit > 0 add to query
        if ($limit > 0) {
            $query .= " limit ". $limit;
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
        $query = "SELECT `id`,`name`
                    FROM `{$this->p}glossary_languages`";

        return $this->PDOX->allRowsDie($query);
     }

    function searchWord($word, $description, $term) {
        //global $conn;
        $searchTerm = $_GET['searchTerm'];
        
        $query = "SELECT `term`, 'description` ,
                    FROM `{$this->p}glossary_term` 
                    LIKE ?";
        $stmt = ($query);
        // Bind the parameter (use % for wildcard matching)
        $param = "%" . $searchTerm . "%";
        $stmt->bind_param("s", $param);
        $stmt->execute();

        array(':term' => $word);
        
        if ($word == "") {
           echo("Please enter a word.");
           return;
        }else{
            $query .= "WHERE 'SUBSTRING(term, 1, 3)'  == SUBSTRING($word,1,3) ";
            $arr = array(':description_text' => $description, ':concept_text'=> $term);
            
            return $this->PDOX->allRowsDie($query, $arr);
        }
    
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