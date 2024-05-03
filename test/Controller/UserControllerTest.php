<?php

namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller;

use PHPUnit\Framework\TestCase;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;

class UserControllerTest extends TestCase{
  private UserController $userController;
  private UserRepository $userRepository;

  protected function setUp():void{
    $this->userController = new UserController();
    $this->userRepository = new UserRepository(Database::getConnection());
    $this->userRepository->deleteAll();
  }

  public function testViewRegister(){
    $this->userController->register();

    $this->expectOutputRegex("[Register]");
    $this->expectOutputRegex("[Id]");
    $this->expectOutputRegex("[Name]");
    $this->expectOutputRegex("[Password]");
    $this->expectOutputRegex("[Register New User]");
  }

  // public function testPostRegisterSuccess(){

  // }  

  public function testPostRegisterValidationError(){
    $_POST['id'] = '';
    $_POST['name'] = 'EKo';
    $_POST['password'] = 'rahasia';

    $this->userController->postRegister();

    $this->expectOutputRegex("[Register]");
    $this->expectOutputRegex("[Id]");
    $this->expectOutputRegex("[Name]");
    $this->expectOutputRegex("[Password]");
    $this->expectOutputRegex("[Register New User]");
    $this->expectOutputRegex("[id, name, and password cannot blank]");
  }

  public function testPostRegisterDuplicate(){
    $user = new User();
    $user->id = "del";
    $user->name = "Del";
    $user->password = "del";

    $this->userRepository->save($user);

    $_POST['id'] = 'del';
    $_POST['name'] = 'Del';
    $_POST['password'] = 'del';

    $this->userController->postRegister();

    $this->expectOutputRegex("[Register]");
    $this->expectOutputRegex("[Id]");
    $this->expectOutputRegex("[Name]");
    $this->expectOutputRegex("[Password]");
    $this->expectOutputRegex("[Register New User]");
    $this->expectOutputRegex("[User is already exists]");
  }

}

