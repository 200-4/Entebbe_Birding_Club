<?php
/** Copy to config.php and set values from cPanel's PostgreSQL Database Wizard. */
return [
  'db' => [
    'host' => 'localhost',
    'port' => '5432',
    'name' => 'cpanel_account_birding',
    'user' => 'cpanel_account_birduser',
    'password' => 'REPLACE_WITH_DATABASE_PASSWORD',
  ],
  // Set a unique random string of 32+ characters. Used only to create the first admin.
  'setup_key' => 'REPLACE_WITH_A_RANDOM_SECRET_OF_AT_LEAST_32_CHARACTERS',
];
