<?php

$url = $_GET['url'];
$controller;
switch ($_GET['url']) {
  case 'users':
    $controller = "UserController";
    break;
  case 'courses':
    $controller = "CourseController";
    break;
  case 'quizzes':
    $controller = "QuizzeController";
    break;
  case 'questionstypes':
    $controller = "QuestionTypeController";
    break;
  case 'questions':
    $controller = "QuestionController";
    break;
  case 'answers':
    $controller = "AnswerController";
    break;
  default:
    header('HTTP/1.0 404 Not Found');
    break;
}

if (!empty($controller)) {
  require_once "WebApi/controller/$controller.php";
  $controller = ucwords($controller);
  $controller = new $controller;

  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (empty($_GET['id'])) {
      $controller->getAll(); 
    } else {
      $controller->getById($_GET['id']);
    }
  } else if($_SERVER['REQUEST_METHOD'] == "POST") {
    $controller->create();
  } else if($_SERVER['REQUEST_METHOD'] == "PUT") {
    $controller->update();
  } else if($_SERVER['REQUEST_METHOD'] == "DELETE") {
    $controller->delete($_GET['id']);
  }
}
?>