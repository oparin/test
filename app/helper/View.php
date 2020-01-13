<?php

namespace App\Helper;

/**
 * Class View
 * @package App\Helper
 */
class View
{
    protected $data = [];
    protected $view;

    /**
     * @param string     $name
     * @param null|mixed $data
     */
    public function renderView($name, $data = null, $totalPage = null, $page = null)
    {
        return file_get_contents('../app/view/'.$name.'.html');
    }

    /**
     * @param $name
     * @return mixed|string
     */
    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return "";
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param $viewName
     * @return false|string
     */
    public function render($viewName)
    {
        $view = '../app/view/'.$viewName.'.html';

        ob_start();
        include $view;
        echo ob_get_clean();
    }
}