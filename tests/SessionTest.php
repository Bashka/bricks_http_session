<?php
namespace Bricks\Http\Session;
require_once('Session.php');

/**
 * @author Artur Sh. Mamedbekov
 */
class SessionTest extends \PHPUnit_Framework_TestCase{
  /**
   * @var mixed Заглушка для тестирования API сессии.
   */
  private $apiMock;

  public function session_status(){
  }
  public function session_name($name = null){
  }
  public function session_id($id = null){
  }
  public function session_set_save_handler(\SessionHandlerInterface $sessionhandler, $register_shutdown = true){
  }
  public function session_start(array $options = []){
  }
  public function session_write_close(){
  }
  public function session_unset(){
  }
  public function session_destroy(){
  }

	public function setUp(){
    global $apiMock;
    $apiMock = $this->getMock(get_class($this));
    $this->apiMock = $apiMock;
  }

  /**
   * Должен открывать сессию.
   */
  public function testConstruct(){
    $this->apiMock->expects($this->once())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->once())
      ->method('session_name')
      ->with($this->equalTo('PHPSESSID'));

    $this->apiMock->expects($this->once())
      ->method('session_start');

    new Session;
  }

  /**
   * Не должен стартовать сессию, если она уже активна.
   */
  public function testConstruct_shouldExitIfSessionAction(){
    $this->apiMock->expects($this->once())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_ACTIVE));

    $this->apiMock->expects($this->never())
      ->method('session_start');

    new Session;
  }

  /**
   * Должен устанавливать sid и имя сессии.
   */
  public function testConstruct_shouldSetNameAndSid(){
    $this->apiMock->expects($this->once())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->once())
      ->method('session_name')
      ->with($this->equalTo('test'));

    $this->apiMock->expects($this->once())
      ->method('session_id')
      ->with($this->equalTo(1));
    
    new Session('test', 1);
  }

  /**
   * Должен устанавливать хранилище сессии.
   */
  public function testConstruct_shouldSetHandler(){
    $this->apiMock->expects($this->once())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $handlerMock = $this->getMock('SessionHandlerInterface');

    $this->apiMock->expects($this->once())
      ->method('session_set_save_handler')
      ->with($this->equalTo($handlerMock));
    
    new Session('PHPSESSID', null, $handlerMock);
  }

  /**
   * Должен сохранять и закрывать сессию.
   */
  public function testDestruct(){
    $this->apiMock->expects($this->once())
      ->method('session_write_close');

    $session = new Session;
    unset($session);
  }

  /**
   * Должен отчищать сессию.
   */
  public function testClean(){
    $this->apiMock->expects($this->at(0))
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->any())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_ACTIVE));

    $this->apiMock->expects($this->once())
      ->method('session_unset');

    $session = new Session;
    $session->clean();
  }

  /**
   * Должен прекращать работу, если сессия не активна.
   */
  public function testClean_shouldExitIfSessionNotAction(){
    $this->apiMock->expects($this->any())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->never())
      ->method('session_unset');

    $session = new Session;
    $session->clean();
  }

  /**
   * Должен уничтожать сессию.
   */
  public function testDestroy(){
    $this->apiMock->expects($this->at(0))
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->any())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_ACTIVE));

    $this->apiMock->expects($this->once())
      ->method('session_destroy');

    $session = new Session;
    $session->destroy();
  }

  /**
   * Должен прекращать работу, если сессия не активна.
   */
  public function testDestroy_shouldExitIfSessionNotAction(){
    $this->apiMock->expects($this->any())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->never())
      ->method('session_destroy');

    $session = new Session;
    $session->destroy();
  }

  /**
   * Должен возвращать идентификатор текущей сессии.
   */
  public function testSid(){
    $this->apiMock->expects($this->once())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->once())
      ->method('session_id')
      ->will($this->returnValue('test'));

    $this->assertEquals('test', (new Session)->sid());
  }

  /**
   * Должен устанавливать и возвращать значение сессии.
   */
  public function testSetAndGet(){
    $this->apiMock->expects($this->at(0))
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->any())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_ACTIVE));
    
    $session = new Session;
    $session->var = 'test';
    $this->assertEquals('test', $session->var);
  }

  /**
   * Должен удалять и проверять наличие значения сессии.
   */
  public function testIssetAndUnset(){
    $this->apiMock->expects($this->at(0))
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_NONE));

    $this->apiMock->expects($this->any())
      ->method('session_status')
      ->will($this->returnValue(PHP_SESSION_ACTIVE));
    
    $session = new Session;
    $session->var = 'test';
    $this->assertTrue(isset($session->var));
    unset($session->var);
    $this->assertFalse(isset($session->var));
  }
}
