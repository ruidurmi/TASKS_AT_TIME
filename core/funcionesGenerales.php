<?php

//namespace {

    function stylesheets($css) {
        echo "<link type='text/css' rel='stylesheet' href='" . BASEURL . "/assets/css/$css.css' />";
    }

    function javascripts($js) {
        echo "<script type='text/javascript' src='" . BASEURL . "/assets/js/$js.js'></script>";
    }

    function images($imagen, $parametros = array("alt" => "")) {
        $img = "<img ";
        $img .= "src='" . BASEURL . "/assets/images/$imagen' ";
        foreach ($parametros as $parametro => $valor) {
            $img .= "$parametro='$valor'";
        }
        $img .= "/>";
        echo $img;
    }

    function getUrl($recurso) {
        return BASEURL . "/" . $recurso;
    }

//}