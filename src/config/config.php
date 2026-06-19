<?php
/** Cookies Config */
define('SESSION_NAME', 'GWTLDADOSLOCOS');   // Define the session cookie name
define('SESSION_HHTPONLY', true);           // Prevents JavaScript access to session cookie
define('SESSION_SECURE', false);            // Only send cookie over HTTPS
define('SESSION_SAMETIME', 'Strict');       // Protects against CSRF
define('SESSIONSTRICT_MODE', true);         // Rejects invalid session IDs
define('SESSION_TIME', 3600);               // Session expire time
define('SESSION_STRICT', 0);                // Define if the session is strict, be careful with mobile devices
