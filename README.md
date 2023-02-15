# Government of Yukon - Recruitment Marketing Drupal

### INTRODUCTION
------------

### REQUIREMENTS
------------
- Lagoon CLI installed and configured.
- Lando installed.

### INSTALLATION
------------

Start the project
- `lando start`

Import the DB
- `lando drush sql-sync @lagoon.main @self`

### CONFIGURATION
-------------
#### Lando Tooling

### Developer Notes
-------------

#### Composer Cache Issue
There are cases when Composer complains about not having access to the cache folder in Lando.

To fix the issue: In `.lagoon/cli.dockerfile` add the following line and run (This is a temporary
solution and should not be committed):

`RUN chmod 777 -R /home/.composer/cache`
