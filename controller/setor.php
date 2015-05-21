<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../model/LocalModel.php';
  require_once '../model/SetorModel.php';

  $action    = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $idLocalSetor   = (!empty($_REQUEST['idLocalSetor']))     ? $_REQUEST['idLocalSetor']     : '';
  $setorForm     = (!empty($_REQUEST['setor']))     ? $_REQUEST['setor']     : '';
  $local     = (!empty($_REQUEST['local']))     ? $_REQUEST['local']     : '';


  $setor = new SetorModel();

  switch($action){
    case 'insert':
      //insere ou atualiza o usuário
      if(!empty($idLocalSetor)) $setor->setId($idLocalSetor);
      $setor->setSetor($setorForm);
      $setor->setLocal($local);
      $setor->saveSetor();

      header('Location: setor.php');
    break;

    case 'edit':
      $setor = $setor->getSetorById($idLocalSetor);
      echo json_encode($setor);
      break;

    case 'delete':
      $setor->deleteSetor($idLocalSetor);
    break;

    default:
      //entra no formulário
      $lista = $setor->getAllSetors();
      $local = $setor->getAllLocals();

      include_once '../view/setor.php';
      break;
  }