<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../autoloadClass.php';

  $action             = (!empty($_REQUEST['action']))               ? $_REQUEST['action']               : '';
  $idSetorCategoria   = (!empty($_REQUEST['idSetorCategoria']))     ? $_REQUEST['idSetorCategoria']     : '';
  $setor              = (!empty($_REQUEST['setor']))                ? $_REQUEST['setor']                : '';
  $local              = (!empty($_REQUEST['local']))                ? $_REQUEST['local']                : '';
  $categoriaForm      = (!empty($_REQUEST['categoria']))            ? $_REQUEST['categoria']            : '';


  $categoria = new CategoriaModel();
  unset($flashData);

  switch($action){
    case 'insert':
      //insere ou atualiza o usuário
      if(!empty($idSetorCategoria)) {
        $categoria->setId($idSetorCategoria);
        Session::setFlashData('alert-info', 'Categoria alterada com sucesso!');
      }else{
        Session::setFlashData('alert-info', 'Categoria cadastrada com sucesso!');
      }
      $categoria->setSetor($setor);
      $categoria->setLocal($local);
      $categoria->setCategoria($categoriaForm);
      $categoria->saveCategoria();

      header('Location: categoria.php');
    break;

    case 'edit':
      $categoriaById = $categoria->getCategoriaById($idSetorCategoria);
      echo json_encode($categoriaById);
      break;

    case 'delete':
      $categoria->deleteCategoria($idSetorCategoria);
      Session::setFlashData('alert-info', 'Categoria deletada com sucesso!');
    break;

    case 'getSetorSelect':
      $localSelect = $categoria->getSetorLocal($local);
      echo json_encode($localSelect);
      break;

    case 'getSetorLocal':
      $localCategoriaSelect = $categoria->getSetorLocalById($idSetorCategoria);
      echo json_encode($localCategoriaSelect);
      break;

    default:
      //entra no formulário
      //$setor = $categoria->getAllSetors();
      $lista = $categoria->getAllCategorias();
      $local = $categoria->getAllLocals();
      $flashData = Session::getFlashData();

      include_once '../view/categoria.php';
      break;
  }