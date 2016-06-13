<?php

/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/6/6
 * Time: 下午12:35
 */
namespace app\controller\frontend ;
    use core\Controller;
    class testController extends Controller
    {
        public function test()
        {
            $a = 'hello';
            $this->s->assign('a', $a);
            $this->s->display('app/controller/frontend/test.html');
        }

    }
