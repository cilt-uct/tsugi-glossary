<?php

// To allow this to be called directly or from admin/upgrade.php
if ( !isset($PDOX) ) {
    require_once "../config.php";
    $CURRENT_FILE = __FILE__;
    require $CFG->dirroot."/admin/migrate-setup.php";
}

// The SQL to uninstall this tool
$DATABASE_UNINSTALL = array(
    "drop table if exists {$CFG->dbprefix}glossary_site",
     "drop table if exists {$CFG->dbprefix}glossary_user",
    "drop table if exists {$CFG->dbprefix}glossary_domain",
    "drop table if exists {$CFG->dbprefix}glossary_term",
    "drop table if exists {$CFG->dbprefix}glossary_term_translation",
    "drop table if exists {$CFG->dbprefix}glossary_language",
    "drop table if exists {$CFG->dbprefix}glossary_term_translation_text",
    "drop table if exists {$CFG->dbprefix}glossary_term_translation_feedback",
    "drop table if exists {$CFG->dbprefix}glossary_term_translation_status",
    "drop table if exists {$CFG->dbprefix}glossary_term_translation_feedback_item"
);

// The SQL to create the tables if they don't exist
$DATABASE_INSTALL = array(
array(  
    "{$CFG->dbprefix}glossary_site",
    "CREATE TABLE `{$CFG->dbprefix}glossary_site` (
        `link_id` int NOT NULL DEFAULT '0',
        `user_id` int NOT NULL DEFAULT '0',

        // Add more fields later

        // Set primary key later

        // Set constraint later

        UNIQUE KEY `link_id` (`link_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3"
),  
array( "{$CFG->dbprefix}glossary_user",
"CREATE TABLE `{$CFG->dbprefix}glossary_user` (
    `link_id` int(11) NOT NULL,
    
    // Add more fields later

    // Set primary key later

    // Set constraint later

  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;"
),
  // Add other tables later
);

// Database upgrade
$DATABASE_UPGRADE = function($oldversion) {
    global $CFG, $PDOX;

    // This is a place to make sure added fields are present
    // if you add a field to a table, put it in here and it will be auto-added
    $add_some_fields = array(
        array('glossary_site', 'is_admin', 'TINYINT(1) NOT NULL DEFAULT 0'),

        array('glossary_site', 'link_id', 'int(11) NOT NULL'),
        array('glossary_site', 'site_id', 'VARCHAR(99) NOT NULL'),
        array('glossary_site', 'title', 'VARCHAR(99) DEFAULT NULL'),
        // will add more fields later

        // drop report
        array('migration_site', 'report', 'DROP')
    );

    foreach ( $add_some_fields as $add_field ) {
        if (count($add_field) != 3 ) {
            echo("Badly formatted add_field");
            var_dump($add_field);
            continue;
        }
        $table = $add_field[0];
        $column = $add_field[1];
        $type = $add_field[2];
        $sql = false;
        if ( $PDOX->columnExists($column, $CFG->dbprefix.$table ) ) {
            if ( $type == 'DROP' ) {
                $sql= "ALTER TABLE {$CFG->dbprefix}$table DROP COLUMN $column";
            } else {
                // continue;
                $sql= "ALTER TABLE {$CFG->dbprefix}$table MODIFY $column $type";
            }
        } else {
            if ( $type == 'DROP' ) continue;
            $sql= "ALTER TABLE {$CFG->dbprefix}$table ADD $column $type";
        }
        echo("Upgrading: ".$sql."<br/>\n");
        error_log("Upgrading: ".$sql);
        $q = $PDOX->queryReturnError($sql);
    }

    return 202210211000;
}; // Don't forget the semicolon on anonymous functions :)
