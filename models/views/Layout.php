<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 22.08.17
 * Time: 14:33
 */

namespace model\views;


trait Layout
{
    public $header = '../views/layout/head_page.html.php';
    public $footer = '../views/layout/footer.html.php';
    protected $modal = '../views/layout/modal.html.php';

    // const HTTP_HOST = $_SERVER['HTTP_HOST'];

    // public $addressHost = "http://".$_SERVER['HTTP_HOST'];

    protected $fileCSS;

    protected $fileJS;

    public function render()
    {
        include_once $this->header;
        if (isset($_SESSION['AutoPayment']))
        {
            include_once $this->modal;
            unset($_SESSION['AutoPayment']);
        }
        include_once $this->content;
        include_once $this->footer;
    }

    public function getNameHost()
    {
        $hostName = "http://".$_SERVER['HTTP_HOST'];

        return $hostName;
    }
}