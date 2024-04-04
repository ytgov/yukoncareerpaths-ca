# Yukon Government - PSC Recruitment Marketing - Drupal CMS

Find a career in the Yukon.

## Deployments

UAT: https://yukoncareerpaths.cms-uat.yukon.ca

PROD: https://yukoncareerpaths.ca, https://yukoncareerpaths.com,
https://parcoursprofessionnelyukon.ca, https://parcoursprofessionnelyukon.com

## Development environment

### Required tools

- Lagoon CLI
- Lando
- Node.js and npm

### Installation

1. `lando start`
2. `lando composer install`
3. Edit the `web/sites/default/settings.local.php` file to add settings like those shown
below.
4. Load the database from a SQL dump file: `lando drush sqlc <dump.sql`
5. `cd` to the following directories and run `npm i && npm run compile` in each:
`web/themes/custom/govt_yukon`, `web/themes/custom/govt_yukon_claro`,
`web/themes/custom/govt_yukon_rms`
6. Copy the site media files to the `web/sites/default/files/` directory.
7. `lando drush cr`
8. Visit http://yukoncareerpaths-ca.lndo.site/

Sample `settings.local.php` contents for step #3:
```
<?php
$databases['default']['default'] = array (
  'database' => 'drupal10',
  'username' => 'drupal10',
  'password' => 'drupal10',
  'prefix' => '',
  'host' => 'database',
  'port' => '',
  'isolation_level' => 'READ COMMITTED',
  'driver' => 'mysql',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);
$settings['rebuild_access'] = FALSE;
$settings['hash_salt'] = '...see below...'
$config['matomo.settings']['site_id'] = 4;  // 4 for DEV & UAT, 81 for PROD
```

You can generate a new hash_salt with:
`lando drush php-eval 'echo \Drupal\Component\Utility\Crypt::randomBytesBase64(55)'`