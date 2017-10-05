<?php
	//Auto load para carregar automaticamente as classes
	function my_autoload ($pClassName) {
        include(__DIR__ . "/model/" . $pClassName . ".php");
    }
    spl_autoload_register("my_autoload");
