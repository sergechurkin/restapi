<?php

namespace restapi;

// use restapi\ControllerRest;

class ModelRest {

    public function putError($num, $messRu, $metod, $params) {
        $errorMessage['200'] = 'OK';
        $errorMessage['203'] = 'Non-Authoritative Information';
        $errorMessage['404'] = 'Not Found';
        $errorMessage['405'] = 'Method Not Allowed';
        header('HTTP/1.1 ' . $num . $errorMessage[$num]);
        if ($params['debug'] == true) {
            echo '<center><h1>' . $num . ' ' . $errorMessage[$num] . '</h1></center><hr>' . 'Метод ' . $metod . '. ' .$messRu;
        }    
        die;
    }

    public function connect($params) {
        try {
            $pdo = new \PDO('mysql:dbname=' . $params['database'] . ';host=' . $params['host'] . ';charset=utf8', $params['username'], $params['password']);
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
        return $pdo;
    }    

    public function prepareget($params, $table, $condition, $requestData, $metod) {
        $pdo = $this->connect($params);
        $sql = 'SELECT * FROM ' . $table;
        if (!empty($condition)) {
            $sql .= ' WHERE ' . $condition;
        }
        $r = [];
        $query = $pdo->prepare($sql);
        if (!$query->execute()) {
            $this->putError(404, 'Ошибка выполнения запроса: ' . $sql, $metod, $params);
        }
        while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
            $r[] = $row;
        }
        $pdo = null; // Close connectuin
        if (sizeof($r) == 0) {
            $this->putError(404, 'Данных не найдено', $metod, $params);
            die;
        }    
        return $r;
    }

    public function get($params, $table, $condition, $requestData) {
        $r = $this->prepareget($params, $table, $condition, $requestData, 'GET', $params);
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($r, JSON_UNESCAPED_UNICODE);
    }

    public function post($params, $table, $condition, $requestData) {
        $pdo = $this->connect($params);
        $i = 0;
        $sql = 'INSERT INTO ' . $table . ' ( ';
        foreach ($requestData as $key=>$r) {
            if ($i !== 0) {
                $sql .= ', ';
            }
            $sql .= $key;
            $i++;
        }
        $i = 0;
        $sql .= ') VALUES (';
        foreach ($requestData as $key=>$r) {
            if ($i !== 0) {
                $sql .= ', ';
            }
            $sql .= '\'' . $r . '\'';
            $i++;
        }
        $sql .= ')';
        $query = $pdo->prepare($sql);
        $rv = $query->execute();
        if (!$rv) {
            $this->putError(404, 'Ошибка выполнения запроса: ' . $sql, 'POST', $params);
        } else {
            $this->putError(200, 'Запись добавлена', 'POST', $params);
        }
        $pdo = null; // Close connectuin
    }
    public function put($params, $table, $condition, $requestData) {
        $r = $this->prepareget($params, $table, $condition, $requestData, 'PUT');
        $pdo = $this->connect($params);
        $i = 0;
        $sql = 'UPDATE ' . $table . ' SET ';
        foreach ($requestData as $key=>$r) {
            if ($i !== 0) {
                $sql .= ', ';
            }
            $sql .= $key . '=\'' . $r . '\'';
            $i++;
        }
        $sql .= ' WHERE ' . $condition;
        $query = $pdo->prepare($sql);
        $rv = $query->execute();
        if (!$rv) {
            $this->putError(404, 'Ошибка выполнения запроса: ' . $sql, 'PUT', $params);
        } else {
            $this->putError(200, 'Запись изменена', 'PUT', $params);
        }
        $pdo = null; // Close connectuin
    }
    public function delete($params, $table, $condition, $requestData) {
        $r = $this->prepareget($params, $table, $condition, $requestData, 'DELETE');
        $pdo = $this->connect($params);
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
        $query = $pdo->prepare($sql);
        $rv = $query->execute();
        if (!$rv) {
            $this->putError(404, 'Ошибка выполнения запроса: ' . $sql, 'DELETE', $params);
        } else {
            $this->putError(200, 'Запись удалена', 'DELETE', $params);
        }
        $pdo = null; // Close connectuin
    }
    public function getheader($method) {
        echo 'Метод: ' . strtoupper($method) . '<br>';
        $headers = getallheaders();
        foreach($headers as $key=>$header) {
            echo $key . ': ' . $header . '<br>';
        }
    }
    public function head($params, $table, $condition, $requestData) {
        if (!$params['supportMethods']) {
            $this->getheader('head');
        }
    }
    public function trace($params, $table, $condition, $requestData) {
        if (!$params['supportMethods']) {
            $this->getheader('trace');
        }
    }
}
