<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../autoloadClass.php';

  $action    = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $idLocalSetor   = (!empty($_REQUEST['idLocalSetor']))     ? $_REQUEST['idLocalSetor']     : '';
  $setorForm     = (!empty($_REQUEST['setor']))     ? $_REQUEST['setor']     : '';
  $local     = (!empty($_REQUEST['local']))     ? $_REQUEST['local']     : '';


  $setor = new SetorModel();
  unset($flashData);

  switch($action){
    case 'insert':
      //insere ou atualiza o usuário
      if(!empty($idLocalSetor)) {
        $setor->setId($idLocalSetor);
        Session::setFlashData('alert-info', 'Setor alterado com sucesso!');
      }else{
        Session::setFlashData('alert-info', 'Setor cadastrado com sucesso!');
      }
      $setor->setSetor($setorForm);
      $setor->setLocal($local);
      $setor->saveSetor();

      header('Location: setor.php');
      exit;
    break;

    case 'edit':
      $setor = $setor->getSetorById($idLocalSetor);
      echo json_encode($setor);
      break;

    case 'delete':
      $setor->deleteSetor($idLocalSetor);
      Session::setFlashData('alert-info', 'Setor deletado com sucesso!');
    break;

    default:
      //entra no formulário
      $lista = $setor->getAllSetors();
      $local = $setor->getAllLocals();
      $flashData = Session::getFlashData();
      include_once '../view/setor.php';
      break;
  }