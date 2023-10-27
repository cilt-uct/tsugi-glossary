<?php
require_once "../../config.php";
include "../tool-config_dist.php";
require_once("../dao/GlossaryDAO.php");


use \Tsugi\Core\LTIX;
use \Glossary\DAO\GlossaryDAO;

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$site_id = $LAUNCH->ltiRawParameter('context_id','none');

$glossaryDAO = new GlossaryDAO($PDOX, $CFG->dbprefix);

$result = ['success' => 0, 'msg' => 'requires POST'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['type'])) {
        switch($_GET['type']) {
            case 'workflow':
                $result = $GlossaryDAO->getTerms();

                $result = [
                        'success' => $result ? 1 : 0, 
                        'terms' => $result ? json_decode($result) : [
                    ]];
                break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result['msg'] = $_POST;
    $domain_id = isset($_POST['term_faculty_id']) ? $_POST['term_faculty_id'] : '';
    $domain = isset($_POST['term_faculty']) ? $_POST['term_faculty'] : '';
    $term_id = isset($_POST['inp_term_id']) ? $_POST['inp_term_id'] : '';
    $term = isset($_POST['term_name']) ? $_POST['term_name'] : '';
    $definition = isset($_POST['term_definition']) ? $_POST['term_definition'] : '';
    $form_action = $_POST['inp_term_type'];
    
    if ($form_action) {
        switch($form_action) {           
            case 'addGlossaryTerm':
                $result['success'] = $glossaryDAO->addGlossaryTerm($LINK->id, $USER->id, $domain_id, $term, $definition) ? 1 : 0;
                break;
            case 'updateGlossaryTerm':
                $result['success'] = $glossaryDAO->updateGlossaryTerm($LINK->id, $USER->id, $term_id, $term, $definition) ? 1 : 0;
                break;
            case 'deleteGlossaryTerm':
                $result['success'] = $glossaryDAO->removeGlossaryTerm($LINK->id, $USER->id, $term_id);
                break;
        }
        $result['msg'] = $result['success'] ? 'Updated' : 'Error Updating';
    }

    // if (isset($_POST['alphabet'])) {
    //     $alphabet = isset($_POST['alphabet']);
    //     $result = $glossaryDAO->fetchTermsByAlphabet($alphabet);
        
    //     $result = [
    //         'success' => $result ? 1 : 0, 
    //         'terms' => $result ? json_decode($result) : []
    //     ];
    // }
}

if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    $matchingWords = getWordsStartingWith($searchTerm, $tableName);

    print_r($matchingWords);
} else {
    echo "Please provide a search term using the 'searchTerm' parameter in the URL.";
}


echo json_encode($result);
exit;