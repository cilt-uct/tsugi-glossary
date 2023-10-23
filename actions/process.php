<?php
require_once "../../config.php";
require_once("../dao/MigrateDAO.php");

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
                $result['success'] = $glossaryDAO->addGlossaryTerm($_POST['domain_id'], $USER->id, $_POST['term'], $_POST['description']) ? 1 : 0;
            case 'updateGlossaryTerm':
                $result['success'] = $glossaryDAO->updateGlossaryTerm($_POST['term_id'], $USER->id, $_POST['term'], $_POST['description']) ? 1 : 0;
            case 'removeGlossaryTerm':
                $result['success'] = $glossaryDAO->removeGlossaryTerm($_POST['term_id'], $USER->id) ? 1 : 0;
                break;
        }
        $result['msg'] = $result['success'] ? 'Updated' : 'Error Updating';
    }
}


echo json_encode($result);
exit;