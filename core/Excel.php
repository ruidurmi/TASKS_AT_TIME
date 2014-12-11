<?php

namespace core;

require_once 'Model.php';

/**
 * Description of Excel
 *
 * @author Chema
 */
class Excel extends Model {

    public function getExcel($nombre, $datos, $utf8 = false) {
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $nombre . '.xls');
        $h = array();
        foreach ($datos as $row) {
            foreach ($row as $key => $val) {
                if ($key !== "_id") {
                    if (!in_array($key, $h)) {
                        $h[] = $key;
                    }
                }
            }
        }
        //echo the entire table headers
        echo '<table><tr>';
        foreach ($h as $key) {
            $key = ucwords($key);
            if ($utf8) {
                echo '<th>' . utf8_decode($key) . '</th>';
            } else {
                echo '<th>' . $key . '</th>';
            }
        }
        echo '</tr>';

        foreach ($datos as $row) {
            echo '<tr>';
            foreach ($row as $key => $val) {
                if ($key !== "_id") {
                    if ($utf8) {
                        if (preg_match("/^[0-9]+$/",$val)) {
                            echo '<td style="mso-number-format:' . "'0'" . ';">' . utf8_decode($val) . '</td>';
                        } else if (preg_match("/[\\|\/\-]+/i", $val)) {
                            echo '<td style="mso-number-format:' . "'dd/mm/YYYY'" . ';">' . utf8_decode($val) . '</td>';
                        }else{
                            echo '<td>' . utf8_decode($val) . '</td>';
                        }
                    } else {
                        if (preg_match("/^[0-9]+$/",$val)) {
                            echo '<td style="mso-number-format:' . "'0'" . ';">' . $val . '</td>';
                        } else if (preg_match("/[\\|\/\-]+/i", $val)) {
                            echo '<td style="mso-number-format:' . "'dd/mm/YYYY'" . ';">' . $val . '</td>';
                        }else{
                            echo '<td>' . $val . '</td>';
                        }
                    }
                }
            }
        }
        echo '</tr>';
        echo '</table>';
    }

}
