<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../model/LocalModel.php';
  require_once '../model/SetorModel.php';
  require_once '../model/CategoriaModel.php';
  require_once '../model/Relatorio.php';

  $action     = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $idLocal     = (!empty($_REQUEST['idLocal']))     ? $_REQUEST['idLocal']     : '';

  $rel = new Relatorio();

  switch($action){
    case 'getAllSetor':
      $setor = $rel->getSetorLocal($idLocal);
      break;

    default:
      $local = $rel->getAllLocal();
      $lista = $rel->getListaGeral();
      include_once '../view/relTotal.php';
      break;
  }