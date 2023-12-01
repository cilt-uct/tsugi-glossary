<?php
// To allow this to be called directly or from admin/upgrade.php
if (!isset($PDOX)) {
    require_once "../config.php";
    $CURRENT_FILE = __FILE__;
    require $CFG->dirroot . "/admin/migrate-setup.php";
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
        "CREATE TABLE IF NOT EXISTS `{$CFG->dbprefix}glossary_site` (
            `link_id` int NOT NULL,
            `site_id` varchar(99) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `settings` text COLLATE utf8mb4_general_ci NOT NULL,
            PRIMARY KEY (`link_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ),
    array(
        "{$CFG->dbprefix}glossary_user",
        "CREATE TABLE IF NOT EXISTS `{$CFG->dbprefix}glossary_user` (
         `user_id` int NOT NULL,
        `settings` text COLLATE utf8mb4_general_ci,
         PRIMARY KEY (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3"
    ),
    array(
        "{$CFG->dbprefix}glossary_domain",
        "CREATE TABLE IF NOT EXISTS `{$CFG->dbprefix}glossary_domain` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int NOT NULL DEFAULT '0',
            `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `modified_by` int DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ),
    array(
        "{$CFG->dbprefix}glossary_language",
        "CREATE TABLE IF NOT EXISTS `glossary_language` (
            `id` int NOT NULL AUTO_INCREMENT,
            `language` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;"
    ),
    array(
        "{$CFG->dbprefix}glossary_term",
        "CREATE TABLE IF NOT EXISTS`glossary_term` (
            `id` int NOT NULL AUTO_INCREMENT,
            `domain_id` int NOT NULL,
            `term` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
            `description` text COLLATE utf8mb4_general_ci NOT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            `deleted` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int NOT NULL DEFAULT '0',
            `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `modified_by` int DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `fk_glossary_term_to_domain_idx` (`domain_id`),
            CONSTRAINT `fk_glossary_term_to_domain` FOREIGN KEY (`domain_id`) REFERENCES `glossary_domain` (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=2044 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ), 
     array(
        "{$CFG->dbprefix}glossary_term_translation",
        "CREATE TABLE IF NOT EXISTS `{$CFG->dbprefix}`glossary_term_translation` (
            `id` int NOT NULL AUTO_INCREMENT,
            `term_id` int NOT NULL,
            `language_id` int NOT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            `deleted` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int NOT NULL DEFAULT '0',
            `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `modified_by` int DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_language_id` (`language_id`),
            KEY `idx_term_id` (`term_id`),
            CONSTRAINT `fk_glossary_term_translation_to_term` FOREIGN KEY (`term_id`) REFERENCES `glossary_term` (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=21904 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ),
  
    array(
        "{$CFG->dbprefix}glossary_term_translation_feedback",
        "CREATE TABLE IF NOT EXISTS `{$CFG->dbprefix}glossary_term_translation_feedback` (
            `id` int NOT NULL AUTO_INCREMENT,
            `translation_id` int NOT NULL,
            `status` int NOT NULL DEFAULT '1',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int NOT NULL DEFAULT '0',
            `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `modified_by` int DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `fk_glossary_term_translation_feedback_to_term_idx` (`translation_id`),
            KEY `idx_status` (`status`),
            CONSTRAINT `fk_glossary_term_translation_feedback_to_term` FOREIGN KEY (`translation_id`) REFERENCES `glossary_term_translation` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ),
    // Add other tables later
    array(
        "{$CFG->dbprefix}glossary_term_translation_feedback_item",
        "CREATE TABLE IF NOT EXISTS `{$CFG->dbprefix}glossary_term_translation_feedback_item` (
            `id` int NOT NULL AUTO_INCREMENT,
            `feedback_id` int NOT NULL,
            `content` text COLLATE utf8mb4_general_ci NOT NULL,
            `deleted` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int NOT NULL DEFAULT '0',
            `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `modified_by` int DEFAULT NULL,
            PRIMARY KEY (`id`,`feedback_id`),
            KEY `fk_glossary_term_translation_feedback_item_glossary_term_tr_idx` (`feedback_id`),
            CONSTRAINT `fk_glossary_term_translation_feedback_item_glossary_term_tran1` FOREIGN KEY (`feedback_id`) REFERENCES `glossary_term_translation_feedback` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ),
    array(
        "{$CFG->dbprefix}glossary_term",
        "CREATE TABLE `{$CFG->dbprefix}glossary_term_translation_text` (
            `id` int NOT NULL AUTO_INCREMENT,
            `translation_id` int NOT NULL,
            `term` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
            `description` text COLLATE utf8mb4_general_ci NOT NULL,
            `version` int NOT NULL DEFAULT '1',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int NOT NULL DEFAULT '0',
            `language_id` int NOT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_translation_id` (`translation_id`),
            KEY `foreign_key_1` (`language_id`),
            CONSTRAINT `fk_glossary_term_translation_text_glossary_term_translation1` FOREIGN KEY (`translation_id`) REFERENCES `glossary_term_translation` (`id`),
            CONSTRAINT `foreign_key_1` FOREIGN KEY (`language_id`) REFERENCES `glossary_term_translation` (`language_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
            CONSTRAINT `foreign_key_2` FOREIGN KEY (`translation_id`) REFERENCES `glossary_term_translation` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
          ) ENGINE=InnoDB AUTO_INCREMENT=21904 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ),
    array(
        "{$CFG->dbprefix}glossary_term_translation",
        "CREATE TABLE IF NOT EXISTS `{$CFG->dbprefix}glossary_translation_status` (
            `id` int NOT NULL,
            `status` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
            KEY `fk_glossary_translation_status_glossary_term_translation_fe_idx` (`id`),
            CONSTRAINT `fk_glossary_translation_status_glossary_term_translation_feed` FOREIGN KEY (`id`) REFERENCES `glossary_term_translation_feedback` (`status`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    ),
    
);

// Database upgrade
$DATABASE_UPGRADE = function ($oldversion) {
    global $CFG, $PDOX;

    // This is a place to make sure added fields are present
    // if you add a field to a table, put it in here and it will be auto-added
    $add_some_fields = array(
        // array('glossary_site', 'is_admin', 'TINYINT(1) NOT NULL DEFAULT 0'),

        // array('glossary_site', 'link_id', 'int(11) NOT NULL'),
        // array('glossary_site', 'site_id', 'VARCHAR(99) NOT NULL'),
        // array('glossary_site', 'title', 'VARCHAR(99) DEFAULT NULL'),
        // // will add more fields later

        // // drop report
        // array('migration_site', 'report', 'DROP')
    );

    foreach ($add_some_fields as $add_field) {
        if (count($add_field) != 3) {
            echo ("Badly formatted add_field");
            var_dump($add_field);
            continue;
        }
        $table = $add_field[0];
        $column = $add_field[1];
        $type = $add_field[2];
        $sql = false;
        if ($PDOX->columnExists($column, $CFG->dbprefix . $table)) {
            if ($type == 'DROP') {
                $sql = "ALTER TABLE {$CFG->dbprefix}$table DROP COLUMN $column";
            } else {
                // continue;
                $sql = "ALTER TABLE {$CFG->dbprefix}$table MODIFY $column $type";
            }
        } else {
            if ($type == 'DROP')
                continue;
            $sql = "ALTER TABLE {$CFG->dbprefix}$table ADD $column $type";
        }
        echo ("Upgrading: " . $sql . "<br/>\n");
        error_log("Upgrading: " . $sql);
        $q = $PDOX->queryReturnError($sql);
    }

    return 202210211000;
}; // Don't forget the semicolon on anonymous functions :)

?>