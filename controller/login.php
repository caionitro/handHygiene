<?php
  require_once '../connect/Connect.php';
  require_once '../autoloadClass.php';

  $action     = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $campo      = (!empty($_REQUEST['campo']))      ? $_REQUEST['campo']      : '';

  $user = new LoginModel();

  switch($action){
    case 'login':
      $valores = array();
      parse_str($campo, $valores);
      extract($valores);

      $user->setLogin($login);
      $user->setSenha($senha);
      $login = $user->userLogin();
      echo json_encode($login);
      break;

    default:
      exit('Acesso negado!');
      break;
  }