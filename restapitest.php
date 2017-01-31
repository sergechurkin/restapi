<?php

function runRestApi($method, // Вызываемый метод
        $supportMethods,     // WEB сервер поддерживает метоы PUT и DELETE
        $isHeader,           // Получать заголовки
        $token,              // Токен 
        $url,                // URL 
        $table,              // Имя таблицы MySql
        $condition,          // Условие выборки записей таблицы
        $requestData) {      // Массив передаваемых параметров ['имя поля'=>'значение', ...]
    $curl = curl_init();
    $t = (empty($table)) ? '' : '?table=' . $table;
    $c = (empty($condition)) ? '' : '&condition=' . urlencode($condition);
    if (!$supportMethods) {
        $m = '&method=' . $method;
        $methodReal = 'POST';
    } else {
        $m = '';
        $methodReal = $method;
    }
    curl_setopt($curl, CURLOPT_URL, $url . $t . $c . $m);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $methodReal);
    curl_setopt($curl, CURLOPT_HEADER, $isHeader);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "OAuth-Token: $token"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestData));

    $response = curl_exec($curl);
    echo $response;
    $header = curl_getinfo($curl);
    $errorMessage[203] = 'Ошибка авторизации. Неверный токен.';
    $errorMessage[404] = 'Данные не найдены';
    $errorMessage[405] = 'Недопустимый метод';
    $errMess = (isset($errorMessage[$header['http_code']])) ? $errorMessage[$header['http_code']] : '';
    if ($header['http_code'] !== 200) {
        echo '<br>Метод ' . $method . '. Ошибка: ' . $header['http_code'] . ' ' . $errMess;
    }    
    if ($method == 'HEAD') {
        echo '<br>';
        $header = curl_getinfo($curl);
        foreach ($header as $key=>$h) {
            if (!is_array($h)) {
                echo $key . ': '  . $h . '<br>';
            }    
        }    
    }
    curl_close($curl);
}
/*
 * Примеры Вызова методов API
 */

/*
runRestApi( 'HEAD',
        0,
        0,
        'eb3d372a302cac84802ab4a7ac66e34ec05820eb', 
        'https://sergechurkin-guestbook.000webhostapp.com/restapi.php/',
        '', 
        '', 
        []);

runRestApi( 'TRACE',
        0,
        0,
        'eb3d372a302cac84802ab4a7ac66e34ec05820eb', 
        'https://sergechurkin-guestbook.000webhostapp.com/restapi.php/',
        '', 
        '', 
        []);
*/
runRestApi( 'GET',
        0,
        0,
        'eb3d372a302cac84802ab4a7ac66e34ec05820eb', 
        'https://sergechurkin-guestbook.000webhostapp.com/restapi.php/',
        'tst_gbook', 
        "id=2", 
        []);
/*
runRestApi( 'POST',
        0,
        0,
        'eb3d372a302cac84802ab4a7ac66e34ec05820eb', 
        'https://sergechurkin-guestbook.000webhostapp.com/restapi.php/',
        'tst_gbook', 
        '', 
        ['name'=>'Ted', 'email'=>'ted@email.com', 'subject'=>'Test subject', 'body'=>'Test body', ]);
*/
