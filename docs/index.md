# Объект сессии

Класс _Session_ предоставляет объектный интерфейс к сессиям в PHP. При 
инстанциации этого класса, сессия открывается, а при завершении работы с его 
экземпляром - сохраняется для дальнейшего использования.

Для доступа к значениям сессии используются свойства экземпляра:

```php
use Bricks\Http\Session;

$session = new Session;
$session->role = 'admin';
var_dump($session->role); // "admin"
var_dump(isset($session->role)); // true
unset($session->role);
var_dump(isset($session->role)); // false
```

Методы `clean` и `destroy` позволяют отчистить и уничтожить сессию:

```php
use Bricks\Http\Session;

$session = new Session;
$session->role = 'admin';
$session->clean();
var_dump(isset($session->role)); // false
```

Конструктор класса позволяет так же указать имя сессии, ее идентификатор и 
хранилище данных (экземпляр класса, реализующий интерфейс 
[SessionHandlerInterface][]):

```php
use Bricks\Http\Session;

$session = new Session('MYSESSION', md5($login));
...
```

[SessionHandlerInterface]: http://php.net/manual/ru/class.sessionhandlerinterface.php
