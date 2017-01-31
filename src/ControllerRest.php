<?php

namespace restapi;

use restapi\ModelRest;
 
class ControllerRest {
/*
 * sergechurkin/restapi
*/
    public function run($params) {
        $model = new ModelRest();
        $header = getallheaders();
        parse_str(file_get_contents('php://input'), $requestData);
        $getParam = basename($_SERVER['REQUEST_URI']);
        if (substr($getParam, 0, 1) == '?') {
            $getParam = substr($getParam, 1);
        }    
        parse_str($getParam, $arrGetParam);
        if ($params['supportMethods']) {
            $method = strtolower($_SERVER['REQUEST_METHOD']);
        } else {
            $method = strtolower($arrGetParam['method']);
        }    
        if ($header['OAuth-Token'] !== $params['token']) {
            $model->putError(203, 'Задан недопустимый токен', strtoupper($method), $params);
            die;
        }
        if (isset($arrGetParam['table'])) {
            $table = $arrGetParam['table'];
        } else {
            $table = '';
        }
        if (isset($arrGetParam['condition'])) {
            $condition = $arrGetParam['condition'];
        } else {
            $condition = '';
        }
        /*
         * Допустимые методы:
         * GET    - получение 
         * POST   - добавление
         * PUT    - изменение
         * DELETE - удаление
         * HEAD и TRACE  - прроверка связи
         */
        if(method_exists($model, $method)) {
            $model->$method ($params, $table, $condition, $requestData);
        } else {
            $model->putError(405, 'Задан недопустимый метод', strtoupper($method), $params);
        }                               
    }
}
