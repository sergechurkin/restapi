# restapi
PHP RESTful API for mySql supports POST, GET, PUT, DELETE and HEAD, TRACE methods

## ���������

```
composer create-project sergechurkin/restapi path "1.1.x-dev"
```

��������� ����������� � ���� MySQL �������� � `params.php`.

## ��������

���������� RESTful API ��������� � ������� HTTP �������� �������������� ������� 
������ �� MySql. ��� ������������ ��������� ������ ��������� 
[HTTP/1.1](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html):

|�����|������ URL|���������|��������|
|-----|----------|---------|--------|
|GET|http://localhost/rest/restapi.php/?table= tst_gbook &condition= id > 10 and id < 24||��������� ������� ������� � ������� `json`|
|POST|http://localhost/rest/restapi.php/|URL-������������ ������ �������, ���������� �������� ����� (<����>=<��������>)|���������� ������� � �������|
|PUT| http://localhost/rest/restapi.php/?table= tst_gbook&id=99|URL-������������ ������ �������, ���������� �������� ����� (<����>=<��������>)|��������� ������� �������|
|DELETE| http://localhost/rest/restapi.php/?table= tst_gbook&id=99||��������  ������� �� �������|
|HEAD � TRACE|http://localhost/rest/restapi.php/|���������� ������ ��������� ���������|�������� �����|

� URL � �������� ���������� ���������� ��� ������� `table` � ������� ������ 
������� `condition` (������ ���� ������������ �������� `urlencode()`). 
������ ������ ������� ���������� � ������� `index.php`. 
� ������, ���� WEB ������ �� ������������ ������ `PUT` � `DELETE`, ����� 
��������� �������� ������ ��� ��������� URL. ��� ����� � `params.php`  
���������� ������� `'supportMethods' => false` � ������ �������� �������, 
���������� API, ������ ��� false. ������ ������ ��� ������� ������ -  
� `restapitest.php`. ��� ����� ��������� �� 
[������]( http://sergechurkin-guestbook.vacau.com/restapitest.php). 
� ���������� ���������� ����� �������� ������ �������  ���������� 
[�������� �����](https://github.com/sergechurkin/guestbook) � ������� `json`.

���������� ���������������� ��
[packagist](https://packagist.org/packages/sergechurkin/restapi).