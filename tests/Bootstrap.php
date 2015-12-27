<?php
namespace Bricks\Http\Session;

$apiMock;

function session_status(){
  global $apiMock;
  return $apiMock->session_status();
}

function session_name($name = null){
  global $apiMock;
  return $apiMock->session_name($name);
}

function session_id($id = null){
  global $apiMock;
  return $apiMock->session_id($id);
}

function session_set_save_handler(\SessionHandlerInterface $sessionhandler, $register_shutdown = true){
  global $apiMock;
  return $apiMock->session_set_save_handler($sessionhandler, $register_shutdown);
}

function session_start(array $options = []){
  global $apiMock;
  return $apiMock->session_start($options);
}

function session_write_close(){
  global $apiMock;
  return $apiMock->session_write_close();
}

function session_unset(){
  global $apiMock;
  return $apiMock->session_unset();
}

function session_destroy(){
  global $apiMock;
  return $apiMock->session_destroy();
}
