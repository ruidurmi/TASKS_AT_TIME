<?php

namespace app\controllers;

use core\Response;

class home extends \core\Controller {

    public function index() {

        $this->view(new Response("main:home:index"));
    }
}
