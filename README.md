# Glossary [LTI] (tsugi-glossary)
Used on Sakai to organize and manage glossaries for various projects and sites that require precise terminology.

## Installation
Install through the "Tsugi - Glossary" interface and run "Update Database" to create the appropriate database tables.

## Process
The UI of the glossary tool interacts with the database entries stored in the `glossary_site` table. When a user enters a term in
the search bar, the tool retrieves the meaning of the term and also provides translations in various languages if available.

## Custom LTI Parameters
The UI and functionality can change custom parameters that can be set for the tool:
1. `dev=true` : Sets the tool into development mode, which shows the 'coming soon' page except if the site id is configured in the configuration file.

## Configuration
Create a local configuration file and then update it to your settings:
```
cp tool-config_dist.php tool-config.php
```
