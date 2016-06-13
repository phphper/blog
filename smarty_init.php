<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/6/4
 * Time: 下午6:20
 */


require 'libs/Smarty.class.php';

$s = new Smarty;

$s->setTemplateDir('view');

$s->setCompileDir('view_c');

$s->setCacheDir('cache');

$s->setConfigDir('configs');

$s->left_delimiter = "<{";
$s->right_delimiter = "}>";

