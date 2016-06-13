<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/6/3
 * Time: 下午1:14
 */

namespace app\controller\backend;
use vendor;

use app\model\commentModel;
use core\Controller;

class commentController extends Controller
{
    public function getList()
    {
        $comment = commentModel::create()->getAllwithJoin();
        return $this->loadHtml('comment/getList', array(
            'comment' => $comment,
        ));

        //使用:
        /*
        $pager = new Pager(总的记录数, 每页记录数, 当前页数, 'php脚本index.php', array(参数
            'a' => 'index',
            'c' => 'product',
        ));

        $pagerHtml = $pager->showPage();
        */
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pagesize = 1;
        $pager = new Pager(commentModel::create()->count(), $pagesize, $page, index.php, array(
            'p' => 'backend',
            'c' => 'comment',
            'a' => 'getList',
        ));
    }

    public function delete()
    {
        $id = $_GET['id'];
        if (commentModel::create()->deleteById($id)) {
            $this->redirect('index.php?p=backend&a=getList&c=comment',1 ,'删除成功');
        } else {
            $this->redirect('index.php?p=backend&a=getList&c=comment',1 ,'删除失败');
        }
    }


}