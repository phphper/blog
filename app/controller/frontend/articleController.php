<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/6/6
 * Time: 下午6:42
 */

namespace app\controller\frontend;


use app\model\articleModel;
use app\model\commentModel;
use core\Controller;
use app\model\categoryModel;

class articleController extends Controller
{
    public function getList()
    {
        $articles = articleModel::create()->getAllWithJoin();
        $categorys = categoryModel::create()->limitlessLevelCategory(
                        categoryModel::create()->findAll());
        $this->s->assign(array(
            'articles' => $articles,
            'categorys' => $categorys,
        ));
        $this->s->display('app/view/frontend/article/getList.html');
    }

        public function detail()
    {
        $id = $_GET['id'];
        articleModel::create()->increaseReadeNumber($id);
        $detail = articleModel::create()->getOneWithJoin($id);
        $categoryLimit = categoryModel::create()->limitlessLevelCategory(categoryModel::create()->getAllWithJoin());
        $comment = commentModel::create()->limitlessLevel(commentModel::create()->getAllWithJoinUserComment($id));
        $newcomment = commentModel::create()->getAllWithJoinUserComment($id);
        $this->s->assign(array(
            'detail' => $detail,
            'comment' => $comment,
            'categoryLimit' => $categoryLimit,
            'newcomment' => $newcomment,

        ));

        $this->s->display('app/view/frontend/article/detail.html');
    }


    public function praise()
    {
        $this->denyAccess();

        $id = $_GET['id'];
        if (!isset($_SESSION["praise_$id"]) || $_SESSION["praise_$id"]!=true) {
            articleModel::create()->increasePraiseNumber($id);
            $_SESSION["praise_$id"] = true;
            self::redirect("index.php?p=frontend&c=article&a=detail&id={$id}", 1, 'ok');
        } else {
            self::redirect("index.php?p=frontend&c=article&a=detail&id={$id}", 1, 'no');
        }
    }

}