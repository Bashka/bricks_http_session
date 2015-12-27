<?php
namespace Bricks\Http\Session;

/**
 * Объектная модель доступа к сессии.
 *
 * @author Artur Sh. Mamedbekov
 */
class Session{
  /**
   * @param string $name [optional] Имя сессии.
   * @param string $sid [optional] Идентификатор сессии.
   * @param \SessionHandlerInterface $storage [optional] Хранилище данных 
   * сессии.
   */
  public function __construct($name = 'PHPSESSID', $sid = null, \SessionHandlerInterface $storage = null){
    if(session_status() != PHP_SESSION_NONE){
      return;
    }
    session_name($name);
    if(!is_null($sid)){
      session_id($sid);
    }
    if(!is_null($storage)){
      session_set_save_handler($storage, true);
    }
    session_start();
  }

  public function __destruct(){
    session_write_close();
  }

  /**
   * Отчищает сессию.
   */
  public function clean(){
    if(session_status() != PHP_SESSION_ACTIVE){
      return;
    }
    session_unset();
  }

  /**
   * Уничтожает сессию.
   */
  public function destroy(){
    if(session_status() != PHP_SESSION_ACTIVE){
      return;
    }
    session_destroy();
  }

  /**
   * Получает текущий идентификатор сессии.
   *
   * @return string Идентификатор сессии.
   */
  public function sid(){
    return session_id();
  }

  public function __set($name, $value){
    if(session_status() != PHP_SESSION_ACTIVE){
      return;
    }
    $_SESSION[$name] = $value;
  }

  public function __get($name){
    if(session_status() != PHP_SESSION_ACTIVE){
      return;
    }
    return $_SESSION[$name];
  }

  public function __unset($name){
    if(session_status() != PHP_SESSION_ACTIVE){
      return;
    }
    unset($_SESSION[$name]);
  }

  public function __isset($name){
    if(session_status() != PHP_SESSION_ACTIVE){
      return;
    }
    return isset($_SESSION[$name]);
  }
}
