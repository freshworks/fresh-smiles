<?php

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for Smiley */
define('DB_NAME', $_SERVER['APP_DB_NAME']);

/** MySQL database username */
define('DB_USER', $_SERVER['APP_DB_USER']);

/** MySQL database password */
define('DB_PASSWORD', $_SERVER['APP_DB_PASS']);

/** MySQL hostname */
define('DB_HOST', $_SERVER['APP_DB_HOST']);


// ** FreshDesk API Settings ** //
/* Freshdesk URL */
define('FD_URL', $_SERVER['APP_FD_URL']);

/* Freshdesk API User Email or API Key */
define('FD_API_USER', $_SERVER['APP_FD_API_USER']);

/* Freshdesk User Password or Blank if using API Key */
define('FD_API_PASS', $_SERVER['APP_FD_API_PASS']);


// ** Custom Ticket Views **//
/* Closed Ticket View */
define('CLOSED_VIEW', $_SERVER['APP_CLOSED_VIEW']);
