<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../model/Relatorio.php';

  $action     = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';

  $rel = new Relatorio();

  switch($action){
    case 'abc':
      # code...
      break;

    default:
      $lista = $rel->getListaGeral();
      include_once '../view/relTotal.php';
      break;
  }