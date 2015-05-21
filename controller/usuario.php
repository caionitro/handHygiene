<?php
  //require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../model/UsuarioModel.php';

  $action     = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $idUsuario  = (!empty($_REQUEST['idUsuario']))  ? $_REQUEST['idUsuario']  : '';
  $nome       = (!empty($_REQUEST['nome']))       ? $_REQUEST['nome']       : '';
  $email      = (!empty($_REQUEST['email']))      ? $_REQUEST['email']      : '';
  $login      = (!empty($_REQUEST['login']))      ? $_REQUEST['login']      : '';
  $senha      = (!empty($_REQUEST['senha']))      ? $_REQUEST['senha']      : '';
  $campo      = (!empty($_REQUEST['campo']))      ? $_REQUEST['campo']      : '';

  $user = new UsuarioModel();

  switch($action){
    case 'insert':
      //insere ou atualiza o usuário
      if(!empty($idUsuario)) $user->setId($idUsuario);
      $user->setNome($nome);
      $user->setEmail($email);
      $user->setLogin($login);
      $user->setSenha($senha);
      $user->saveUser();

      header('Location: usuario.php');
    break;

    case 'edit':
      $usuario = $user->getUserById($idUsuario);
      echo json_encode($usuario);
      break;

    case 'delete':
      $user->deleteUser($idUsuario);
    break;

    case 'login':
      $valores = array();
      parse_str($campo, $valores);
      extract($valores);

      $user->setLogin($valores['login']);
      $user->setSenha($valores['senha']);
      $login = $user->userLogin();
      echo json_encode($login);
      break;

    default:
      //entra no formulário
      $lista = $user->getAllUsers();
      include_once '../view/usuario.php';
      break;
  }