<?php
    require_once '../sessionUp.php';
    require_once '../connect/Connect.php';
    require_once '../autoloadClass.php';

    $action = (!empty($_REQUEST['action'])) ? $_REQUEST['action'] : '';
    $html = (!empty($_REQUEST['html'])) ? $_REQUEST['html'] : '';

    switch ($action) {
        case 'excel':
            // header("Content-Type:   application/vnd.ms-excel;");
            // header("Content-Disposition: attachment; filename=handHygiene.xls");
            // header("Expires: 0");
            // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            // header("Cache-Control: private",false);
            // echo $html;

            header("Content-Type: application/octet-stream"); 
            header("Content-Transfer-Encoding: binary"); 
            header('Expires: '.gmdate('D, d M Y H:i:s').' GMT'); 
            header('Content-Disposition: attachment; filename = "handHygiene.xls"'); 
            header('Pragma: no-cache'); 
             
            //these characters will make correct encoding to excel 
            echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNORE", $html); 
            exit;
            break;
        default:
            # code...
            break;
    }
