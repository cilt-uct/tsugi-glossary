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
        $query = "SELECT `id`,`name`
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
            $query .= "WHERE `domain_id`=:domain_id AND `deleted` = 0";
            $arr = array(':domain_id' => $domain_id);
        } else {
            $query .= "WHERE `deleted` = 0";
        }
        return $this->PDOX->allRowsDie($query, $arr);
    }
    
    function getTerms($id, $domain_id, $term , $description ) {   
        $arr = array();
        $query = "SELECT `id`,`domain_id`,`term`,`description` 
                    FROM `{$this->p}glossary_term`where link_id = :linkId and site_id = :siteId;";
         return $this->PDOX->allRowsDie($query, $arr);
    }
       
    function getAllTerms() {
        return $this->PDOX->allRowsDie("SELECT `term`.`id`,`term`.`domain_id`,`term`.`term`,`term`.`description`,`domain`.`name` AS `domain`
                    FROM `{$this->p}glossary_term` AS `term`
                    LEFT JOIN `glossary_domain` AS `domain` ON `term`.`domain_id` = `domain`.`id`
                    WHERE `deleted` = 0 
                    order by `term`.`term` asc");   
    }

    function getAllLanguages() {   
        return $this->PDOX->allRowsDie("SELECT `id`,`language`
                    FROM `{$this->p}glossary_language`");
    }

    function addGlossaryTerm($link_id, $user_id, $domain_id, $term, $description) {
        return $this->PDOX->queryDie ("INSERT INTO {$this->p}glossary_term 
                               (`domain_id`, `term`, `description`, `active`, `deleted`, `created_at`, `created_by`, `modified_at`, `modified_by`)
                                VALUES ( :domain_id, :term, :description, :active, :deleted, NOW(), :userId, NOW(), :userId)",
                                array(':domain_id' => $domain_id, ':term' => $term, ':description' => $description, ':active' => 1, ':deleted' => 0, ':userId' => $user_id, ':userId' => $user_id ));
        
    }
   
    function updateGlossaryTerm($link_id, $user_id, $term_id, $term, $description) {
        return $this->PDOX->queryDie("UPDATE {$this->p}glossary_term
                  SET `modified_at` = NOW(), `modified_by` = :userId, `term` = :termName ,`description` = :termDescription
                  WHERE `id` = :termId",

                array(':userId' => $user_id ,':termId' => $term_id, ':termName' => $term,':termDescription' => $description));
    }

    function removeGlossaryTerm($link_id, $user_id, $term_id) {                        
        return $this->PDOX->queryDie("UPDATE {$this->p}glossary_term
                  SET `deleted` = TRUE, `modified_at` = NOW(), `modified_by` = :userId
                  WHERE `id` = :termId;", 
                  
                array(':userId' => $user_id, ':termId' => $term_id));
    }

}              
    ?>