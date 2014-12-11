<?php

namespace core;

/**
 * Description of Formulario
 *
 * @author JoseMaria
 */
class Formulario {

    protected $campos = array();
    protected $validaciones = array();
    private $request = null;
    private $datos = null;

    public function __construct($request = array(), $datos = null) {
        if ($request) {
            $this->request = $request;
        }
        if ($datos) {
            $this->datos = $datos;
        }
        $this->setConfig();
        $this->setValidaciones();
    }

    public function setConfig() {
        
    }

    public function setValidaciones() {
        
    }

    public function isValid() {
        $campos = $this->request->post();
        foreach ($this->validaciones as $campo => $validacion) {
            if (isset($campos[$campo])) {
                $valorRequest = $campos[$campo];
                foreach ($validacion as $nval => $val) {
                    $res = $this->validar($valorRequest, $nval, $val);
                    if ($res["resultado"] === "KO") {
                        return false;
                    }
                }
            } else {
                if (isset($validacion["requerido"])) {
                    if ($validacion["requerido"]) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function form($config = array()) {
        $form = "<form class='formulario'";
        if ($config) {
            if (isset($config["method"])) {
                $form .= " method='" . $config["method"] . "' ";
            } else {
                
            }
            if (isset($config["action"])) {
                $form .= " action='" . $config["action"] . "'";
            } else {
                if (Distribuidor::getParametros()) {
                    $form .= " action='" . getUrl(Distribuidor::getControlador() . "/" . Distribuidor::getMetodo() . "/" . Distribuidor::getParametros()) . "'";
                } else {
                    $form .= " action='" . getUrl(Distribuidor::getControlador() . "/" . Distribuidor::getMetodo()) . "'";
                }
            }
        } else {
            if (Distribuidor::getParametros()) {
                $form .= " method='post' action='" . getUrl(Distribuidor::getControlador() . "/" . Distribuidor::getMetodo() . "/" . Distribuidor::getParametros()) . "' ";
            } else {
                $form .= " method='post' action='" . getUrl(Distribuidor::getControlador() . "/" . Distribuidor::getMetodo()) . "' ";
            }
        }
        $form .= ">";
        return $form;
    }

    public function render($config = array()) {

        $post = $this->request->post();

        $form = $this->form($config);

        foreach ($this->campos as $campo => $opciones) {

            if (isset($opciones["type"]) && $opciones["type"] == "hidden") {
                $form .= "<div class='form_group oculto' id='form_$campo'>";
            } else {
                $form .= "<div class='form_group' id='form_$campo'>";
            }

            if (isset($opciones["type"])) {
                switch ($opciones["type"]) {
                    case "hidden":
                        if ($this->datos[$campo]) {
                            $form .= "<input type='hidden' class='form_input' id='input_$campo' name='$campo' value='" . $this->datos[$campo] . "'>";
                        }
                        break;
                    case "submit":
                        $form .= "<input type='submit' class='btn' id='b_$campo' value='$campo' >";
                        break;
                    case "button":
                        $form .= "<input type='button' class='btn' id='b_$campo' value='$campo' >";
                        break;
                    case "select":
                        if ((isset($opciones["expandido"]) && $opciones["expandido"] == false) || !isset($opciones["expandido"])) {
                            if (isset($opciones["multiple"]) && $opciones["multiple"] == true) {
                                $form .= "<select id='input_$campo' class='form_input' name='$campo' multiple='multiple'>";
                            } else {
                                $form .= "<select id='input_$campo' class='form_input' name='$campo'>";
                            }
                            foreach ($opciones["choices"] as $indice => $choice) {
                                if ($this->datos[$campo] && $this->datos[$campo] == $indice) {
                                    $form .= "<option value='$indice' selected='selected'>$choice</option>";
                                } else {
                                    $form .= "<option value='$indice'>$choice</option>";
                                }
                            }
                            $form .= "</select>";
                        } else {
                            if (isset($opciones["multiple"]) && $opciones["multiple"] == true) {
                                foreach ($opciones["choices"] as $indice => $choice) {
                                    if (isset($this->datos[$campo]) && $this->datos[$campo] == $indice) {
                                        $form .= "<div class='form_checkbox'><input type='checkbox' id='input_" . $campo . "_" . $indice . "' class='input_checkbox' name='$campo' checked='checked'>";
                                    } else {
                                        $form .= "<div class='form_checkbox'><input type='checkbox' id='input_" . $campo . "_" . $indice . "' class='input_checkbox' name='$campo'>";
                                    }
                                    $form .= "<label for='input_" . $campo . "_" . $indice . "'>$choice</label></div>";
                                }
                            } else {
                                foreach ($opciones["choices"] as $indice => $choice) {
                                    if (isset($this->datos[$campo]) && $this->datos[$campo] == $indice) {
                                        $form .= "<div class='form_radio'><input type='radio' id='input_" . $campo . "_" . $indice . "' class='input_radio' name='$campo' checked='checked'>";
                                    } else {
                                        $form .= "<div class='form_radio'><input type='radio' id='input_" . $campo . "_" . $indice . "' class='input_radio' name='$campo' >";
                                    }
                                    $form .= "<label for='input_" . $campo . "_" . $indice . "'>$choice</label></div>";
                                }
                            }
                        }
                        break;
                    default:
                        if (isset($opciones["label"])) {
                            $form .= "<label for='input_$campo'>" . $opciones["label"] . "</label>";
                        } else {
                            $form .= "<label for='input_$campo'>$campo</label>";
                        }
                        if (isset($post[$campo])) {
                            $form .= "<input type='" . $opciones['type'] . "' id='input_$campo' name='$campo' class='form_input' value='" . $post[$campo] . "'>";
                        } else {
                            if (isset($this->datos[$campo])) {
                                $form .= "<input type='" . $opciones['type'] . "' id='input_$campo' name='$campo' class='form_input' value='" . $this->datos[$campo] . "'>";
                            } else {
                                $form .= "<input type='" . $opciones['type'] . "' id='input_$campo' name='$campo' class='form_input'>";
                            }
                        }
                }
            } else {
                if (isset($opciones["label"])) {
                    $form .= "<label for='input_$campo'>" . $opciones["label"] . "</label>";
                } else {
                    $form .= "<label for='input_$campo'>$campo</label>";
                }
                if (isset($post[$campo])) {
                    $form .= "<input type='text' id='input_$campo' name='$campo' class='form_input' value='" . $post[$campo] . "'>";
                } else {
                    if (isset($this->datos[$campo])) {
                        $form .= "<input type='text' id='input_$campo' name='$campo' class='form_input' value='" . $this->datos[$campo] . "'>";
                    } else {
                        $form .= "<input type='text' id='input_$campo' name='$campo' class='form_input'>";
                    }
                }
            }

            if (isset($post[$campo]) && isset($this->validaciones[$campo])) {
                $form .= $this->mostrarErrores($campo, $post[$campo]);
            }

            $form .= "</div>";
        }

        $form .= "</form>";

        return $form;
    }

    public function mostrarErrores($campo, $post) {
        $form = "";
        foreach ($this->validaciones[$campo] as $validacion => $valor) {
            $resultado = $this->validar($post, $validacion, $valor);
            if ($resultado["resultado"] == "KO") {
                $form = "<div class='form_error' id='error_$campo[0]'>" . $resultado["mensaje"] . "</div>";
            }
        }
        return $form;
    }

    public function validar($campo, $validacion, $valor) {
        $resultado = array();
        switch ($validacion) {
            case "requerido":
                if ($valor && $campo == "") {
                    $resultado = array("resultado" => "KO", "mensaje" => "El campo no puede estar vacío");
                } else {
                    $resultado = array("resultado" => "OK");
                }
                break;
            case "length" :
                if (strlen($campo) > $valor) {
                    $resultado = array("resultado" => "KO", "mensaje" => "El campo no puede superar la longuitud de $valor carácteres");
                } else {
                    $resultado = array("resultado" => "OK");
                }
                break;
            case "number" :
                break;
            case "fecha" :
                break;
            case "texto" :
                break;
        }

        return $resultado;
    }

}
