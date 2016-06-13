<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/6/8
 * Time: 上午12:51
 */

namespace app\controller\frontend;


use app\model\commentModel;
use core\Controller;

class commentController extends Controller
{
    public function add()
    {
        $this->denyAccess();

        if (CommentModel::create()->add(array(
            'user_id' => $_SESSION['user']['id'],
            'article_id' => $_GET['article_id'],
            'parent_id' => $_POST['inpRevID'],
            'content' => $_POST['txaArticle'],
            'published_time' => time(),
        ))) {
            self::redirect("index.php?p=frontend&c=article&a=detail&id={$_GET['id']}", 1, 'ok');
        } else {
            self::redirect("index.php?p=frontend&c=article&a=detail&id={$_GET['id']}", 1, 'no');
        }
    }
}