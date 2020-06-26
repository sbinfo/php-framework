<?php

namespace app\controllers;

use vendor\core\base\Controller;

class PostsNew extends Controller
{
    public function indexAction()
    {
        echo 'PostsNew::index';
    }

    public function testAction()
    {
        debug($this->route);
        echo 'PostsNew::test';
    }

    public function testPageAction()
    {
        echo 'PostsNew::testPage';
    }

    public function before() {

    }

}