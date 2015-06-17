<?php
    require_once '../sessionUp.php';
    require_once '../connect/Connect.php';
    require_once '../autoloadClass.php';

    $action = (!empty($_REQUEST['action'])) ? $_REQUEST['action'] : '';
    $html = (!empty($_REQUEST['html'])) ? $_REQUEST['html'] : '';

    switch ($action) {
        case 'excel':
            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=handHygiene.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            echo $html;
            exit;
            break;
        default:
            # code...
            break;
    }
