<?php

namespace core;

use vendor\Smarty;

class Controller
{
    protected $s;

    protected function initSmarty()
    {
        $s = new Smarty();
        //定界符设置
        $s->left_delimiter = '<{';
        //定界符设置
        $s->right_delimiter = '}>';
        // templates 目录改为 view 目录之后，Smarty找不到templates目录了怎么？
        // 将Smarty默认的模版目录从templates目录修改为view
        $s->setTemplateDir(VIEW_PATH);
        // 自定义编译文件目录,将文件放到系统的临时目录里
        // sys_get_temp_dir();
        $s->setCompileDir(sys_get_temp_dir() . DS . 'view_c');
        // 自定义缓存文件目录,将缓存文件放到系统的临时目录里
        $s->setCacheDir(sys_get_temp_dir() . DS . 'cache');
        // 自定义配置文件目录
        $s->setConfigDir(CONFIG_PATH);

        $this->s = $s;

    }

    public function __construct()
    {
        $this->initSmarty();
    }


    protected function denyaccess()
    {
        if (isset($_SESSION['loginFlag']) && ($_SESSION['loginFlag'] == true)) {

        } else {
            $this->redirect('index.php?a=login&p=backend&c=user', 1, '请登录');
            exit();
        }
    }

    protected function loadHtml($name,$data = array())
    {
        foreach($data as $variableName => $variableValue) {
            $$variableName = $variableValue;
        }
        require VIEW_PATH . DS . PLATFROM . DS  . $name .'.html';
    }

    //跳转
    public static function redirect($url, $waitTime = '0', $msg = '')
    {
        header('Refresh: ' . $waitTime . '; url=' . $url);
        echo $msg;
    }
}