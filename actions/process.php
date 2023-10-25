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
    
    if (isset($_POST['type'])) {
        switch($_POST['type']) {           
            case 'addGlossaryTerm':
                 //$result['success'] = $glossaryDAO->addGlossaryTerm($LINK->id, $USER->id, $_POST['domain_id'], $_POST['term'], $_POST['description']) ? 1 : 0;
                 break;
            case 'updateGlossaryTerm':
                $result['success'] = 'updateGlossaryTerm';
                $result['success'] = $glossaryDAO->updateGlossaryTerm($LINK->id, $USER->id,$_POST['term_id'],$_POST['term'], $_POST['description']) ? 1 : 0;
                break;
            case 'removeGlossaryTerm':
                $result['success'] = 'removeGlossaryTerm';
                //$result['success'] = $glossaryDAO->removeGlossaryTerm($_POST['term_id']);
                break;
        }
        $result['msg'] = $result['success'] ? 'Updated' : 'Error Updating';
    }
}
if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    $matchingWords = getWordsStartingWith($searchTerm, $tableName);

    print_r($matchingWords);
} else {
    echo "Please provide a search term using the 'searchTerm' parameter in the URL.";
}


if (isset($_GET['alphabet'])) {
    $alphabet = $_GET['alphabet'];
    $terms = $glossaryDAO->fetchTermsByAlphabet($alphabet);
    echo json_encode($terms);
    exit;
}


echo json_encode($result);
exit;