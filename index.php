<?php

define('ROOT_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
define('DEFAULT_CONFIG', ROOT_PATH . 'config/config.json');

require ROOT_PATH.'core/YFrameCore.php';


