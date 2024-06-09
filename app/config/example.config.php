<?php
/* 
    ******************************************
    ANMIK
    Copyright © 2023 Codaff Project

    By :
        Ahmad Afif
        ahmadafif.codaff@gmail.com
        https://github.com/ahmadafif-codaff/anmik

    This program is free software
    You can redistribute it and/or modify
    ******************************************
*/

error_reporting(0);

// time, default indonesia WIB
date_default_timezone_set("Asia/Bangkok");

// Webserver directory location
define('BASEURL', '/anmik');

define('PATHURL_FULL', $_REQUEST['url']);
define('PATHURL_EXPL', explode('/',PATHURL_FULL));
define('PATHURL_ST', PATHURL_EXPL[0]);
define('PATHURL_ND', PATHURL_EXPL[1]);

define('VERSION', file_get_contents('http://'.$_SERVER["HTTP_HOST"].BASEURL.'/VERSION'));

// Mikrotik API
define('MIKROTIK_HOST', '');
define('MIKROTIK_USER', '');
define('MIKROTIK_PASS', '');

// DB
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', 'anmik');

// Session for login, default 60 minutes
define('SESSION', time()+(1*1*60*60));

define('DATENOW', date('Y-m-d H:i:s'));

define('SHA', 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCymWScQFul1uRRZfxaSHLXvQ4ixwJ+wpa2v4xWI1+iejezXvDxyapMuMvZBpgylguxZtyrXfOjk3ggqsiA1CBBeI6edp6Q6YV77k1jDLQJIvruP7JQLexDJt+tYBXeoAu1eFpMBStmjBvTlmuI4UaZKxyiYP0rVi54qVNqvQgwVolzc5H5qdLEesE1enlFlON4rAUaFPWm1ia9e0SL3VoEP7GF2PcmRQWqJkRVt+UhM8Fo/xsjVsHhupgVs2/why9Qb7Zks5V7ya+c8idqOKVaI3ZjxgtyhMZfDDALmiMkxUKmJMYXGZC0Xh/QuA+I2mBbR5hYMc6zeEN781B+ioBBAgMBAAECggEAIjY0CaJia/AwKE+K+ZhrN1xlus+4cKPBzxv+O/nmte8HgHqtWQOydaPomJgky3vmnYMAvmru4uS63Dca1WLNEv2PBFfgpA23njfV5yVlz2I+Ayl8dNN3MJ3ftwxy5ARwecCmO226FJi+M9fanYvZxDl38Lr3hDesCz0UV5wCV4/J7I3nh+1qV8etHCiq68qfbka7LezA9jpmnaMHW9d8Q7+nJjFBusVggI29L8T4FmMli9VyB+HioMN5cC0h5dPfDEZbQHfQTze6f8v0ypJ6z+/thE5Z/Wlc0Fi9tuoM/G5p')

?>