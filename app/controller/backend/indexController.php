<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/5/30
 * Time: 上午11:43
 */
namespace app\controller\backend;


class indexController extends \core\Controller
{
    
    public function index()
    {
        $this->denyaccess();
        $this->s->display('app/view/backend/index/index.html');
    }

    public function getList()
    {
        $this->denyaccess();
        $this->s->display('app/view/backend/index/list.html');

    }

    public function menu()
    {
        $this->denyaccess();
        $this->s->display('app/view/backend/index/menu.html');
    }

    public function header()
    {
        $this->denyaccess();
        $this->s->display('app/view/backend/index/header.html');

    }

}