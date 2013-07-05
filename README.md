json_rpc
========

json rpc lib for php

```php
require_once 'json_rpc.class.php';

$j = new json_rpc('http://user:password@127.0.0.1:8332/');
$r = $j->hello();
var_dump($r);
```
