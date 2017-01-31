# restapi
PHP RESTful API for mySql supports POST, GET, PUT, DELETE and HEAD, TRACE methods

## Установка

```
composer create-project sergechurkin/restapi path "1.1.x-dev"
```

Параметры подключения к базе MySQL задаются в `params.php`.

## Описание

Приложение RESTful API позволяет с помощью HTTP запросов манипулировать данными 
таблиц БД MySql. Оно поддерживает следующие методы стандарта 
[HTTP/1.1](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html):

|Метод|Пример URL|Параметры|Действие|
|-----|----------|---------|--------|
|GET|http://localhost/rest/restapi.php/?table= tst_gbook &condition= id > 10 and id < 24||Получение записей таблицы в формате `json`|
|POST|http://localhost/rest/restapi.php/|URL-кодированную строку запроса, содержащая значения полей (<поле>=<значение>)|Добавление записей в таблицу|
|PUT| http://localhost/rest/restapi.php/?table= tst_gbook&id=99|URL-кодированную строку запроса, содержащая значения полей (<поле>=<значение>)|Изменение записей таблицы|
|DELETE| http://localhost/rest/restapi.php/?table= tst_gbook&id=99||Удаление  записей из таблицы|
|HEAD и TRACE|http://localhost/rest/restapi.php/|Передаются только заголовки сообщений|Проверка связи|

В URL в качестве параметров передаются имя таблицы `table` и условие выбора 
записей `condition` (должно быть закодировано функцией `urlencode()`). 
Пример вызова методов содержится в скрипте `index.php`. 
В случае, если WEB сервер не поддерживает методы `PUT` и `DELETE`, можно 
настроить передачу метода как параметра URL. Для этого в `params.php`  
необходимо указать `'supportMethods' => false` и второй параметр функции, 
вызывающей API, задать как false. Пример вызова для данного случая -  
в `restapitest.php`. Его можно запустить по 
[ссылке]( http://sergechurkin-guestbook.vacau.com/restapitest.php). 
В результате выполнения будет получена запись таблицы  приложения 
[Гостевая книга](https://github.com/sergechurkin/guestbook) в формате `json`.

Приложение зарегистрировано на
[packagist](https://packagist.org/packages/sergechurkin/restapi).