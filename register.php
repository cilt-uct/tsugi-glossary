<?php

$REGISTER_LTI2 = array(
    "name" => "Glossary"
    ,"FontAwesome" => "fa-book"
    ,"short_name" => "Glossary"
    ,"description" => "Access meanings and translations in one user-friendly interface, streamlining terminology management."
    ,"messages" => array("launch") // By default, accept launch messages..
    ,"privacy_level" => "public" // anonymous, name_only, public
    ,"license" => "Apache"
    ,"languages" => array(
        "English",
    )
    ,"source_url" => "https://github.com/cilt-uct/tsugi-glossary"
    // For now Tsugi tools delegate this to /lti/store
    ,"placements" => array(
        /*
        "tool_configuration", "user_navigation"
        */
    )
    ,"screen_shots" => array(
        /* no screenshots */
    )
);
