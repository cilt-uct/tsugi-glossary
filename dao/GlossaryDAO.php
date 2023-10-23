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
        $query = "SELECT `term`, 'description` , `domain_id`
                    FROM `{$this->p}glossary_term` ";

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
    function addGlossaryTerm($term_id, $domian_id, $terms, $description) {
        $notifications = $this->PDOX->rowDie("SELECT notification FROM {$this->p}glossary_term where state = 'admin' and domian_id = :domian_id limit 1;", 
                                            array(':id' => $term_id));

        if (gettype($notifications) == "boolean") {
            $notifications = '';
        } else {
            $notifications = $notifications['notification'];
        }

        $result = [];
        foreach ($terms as $site) {

            if (strlen($site) > 3) {
                $output = $this->startMigration($term_id, $domian_id, $terms, $description, $notifications, '', '[]', $terms, '', 0) ? 1 : 0;
                array_push($result, $output);
            }
        }

        return $result;
    }
    
    function updateGlossaryTerm($domain_id, $term_id, $state) {
        $query = "UPDATE {$this->p}glossary_term
        SET modified_at = NOW(), modified_by = :userId, `state` = :state, `active` = 0
        WHERE domain_id = :domainId";

        $arr = array(':id' => $term_id,':domain_id' => $domain_id, ':active' => $state);
        return $this->PDOX->queryDie($query, $arr);
    }
    function insertGlossaryTerm($term_id, $domain_id, $state, $term, $description ) {
        $query = "INSERT 
        INTO {$this->p}glossary_term(id, domain_id, term, description)
        VALUES ('$term_id', '$domain_id', '$term', '$description')";

        $arr = array(':id' => $term_id,':domain_id' => $domain_id, ':active' => $state);
        return $this->PDOX->queryDie($query, $arr);
    }

    function removeGlossaryTerm($term_id, $user_id, $domain_id) {                        
        return $this->PDOX->queryDie("DELETE FROM {$this->p}glossary_term " .
                                "WHERE `term_id` = :id and `domain_id` = domain_id;", 
                                array(':id' => $term_id, ':domain_id' => $domain_id));
    } 

    //  function getWorkflowAndReport($link_id, $site_id) {
    //     $query = "SELECT workflow, 
    //                     ifnull(report_url,'') as report_url,`state`,
    //                     imported_site_id, transfer_site_id
    //                     FROM {$this->p}migration_site where link_id = :linkId and site_id = :siteId;";
    //     $rows = $this->PDOX->rowDie($query, array(':siteId' => $site_id, ':linkId' => $link_id));

    //     return ($rows == 0 ? [] : $rows);
    // } 

}              
    ?>