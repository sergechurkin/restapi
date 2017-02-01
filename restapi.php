<?php

require_once './src/ControllerRest.php';
require_once './src/ModelRest.php';

use restapi\ControllerRest;

$params = require('./src/params.php');
(new ControllerRest())->run($params);
