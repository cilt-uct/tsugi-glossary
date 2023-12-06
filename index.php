<?php
require_once('../config.php');
include 'tool-config_dist.php';
require_once "dao/GlossaryDAO.php";

use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;
use \Glossary\DAO\GlossaryDAO;


$launch = LTIX::requireData();

$menu = false; // We are not using a menu

$is_dev = $LAUNCH->ltiRawParameter('custom_dev', false);

$site_id = $LAUNCH->ltiRawParameter('context_id', 'none');

if ($USER->instructor) {
  header('Location: ' . addSession('glossary-main.php'));
}