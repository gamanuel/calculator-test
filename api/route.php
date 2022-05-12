<?php
  require_once 'routeClass.php';
  require_once 'controller/calculatorController.php';
  require_once 'controller/historyController.php';

  $r = new Router();

  $r->addRoute("operation", "POST", "calculatorController", "mathOperation");
  $r->addRoute("history", "GET", "historyController", "index");

  $r->route($_GET['action'], $_SERVER['REQUEST_METHOD']);
