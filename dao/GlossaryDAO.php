<?php
namespace Glossary\DAO;

define("OTHER", 9999);

class GlossaryDAO {
        

    private $PDOX;
    private $p;

    public function __construct($PDOX, $p) {
        $this->PDOX = $PDOX;
    }
   
    function getAccountingConcepts($domain){   
        $conn = mysqli_connect("localhost", "root", "", "glossary");

        if (!$conn) {
            die("Connection error");
        }
        $query = $this->PDOX->rowDie("SELECT concepttext, domainid FROM {$this->p}conceptdefinitions WHERE domainid = :domain;",
        array(':domainid' => $domain));
        //$results = mysqli_query($conn, $query);
           
        $arr = array();
        return $this->PDOX->allRowsDie($query, $arr);

        // while ($row = mysqli_fetch_assoc($results)) {
        //     echo $row['concepttext'] ;
        // }
     }



}              
    ?>