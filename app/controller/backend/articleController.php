<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/6/1
 * Time: 下午6:49
 */

namespace app\controller\backend;

use app\model\articleModel;
use app\model\categoryModel;
use core\Controller;
use core\Model;
use vendor\Pager;

class articleController extends Controller
{
    public function add()
    {
        $this->denyAccess();
        if ($_POST) {
            $data = array(
                'title' => $_POST['Title'],
                'content' => $_POST['Content'],
                'category_id' => $_POST['CateID'],
                'status' => $_POST['Status'],
                'published_date' => strtotime($_POST['PostTime']),
                'top' => isset($_POST['isTop']) ? $_POST['isTop'] : 2,
                'author_id' => $_SESSION['user']['id'],                             //   有什么作用?
            );
            if (articleModel::create()->add($data)) {
                $this->redirect('index.php?p=backend&c=article&a=addAccess');
            } else {
                $this->redirect('index.php?p=backend&c=article&a=add', 1, '添加失败');
            }
        } else {
            $category = categoryModel::create()
                ->limitlessLevelCategory(
                    categoryModel::create()->findAll());
            $this->loadHtml('article/add', array(
                'category' => $category,
            ));
        }
    }

    public function addAccess()
    {
        $this->loadHtml('article/addAccess');
    }

    public function getList()
    {
        $this->denyAccess();
        $where = '2 > 1';
        if ($_POST) {
            if ($_POST['category']) {
                $where .= " AND category_id = '{$_POST['category']}'";
            }
            if ($_POST['status']) {
                $where .= " AND status = '{$_POST['status']}'";
            }
            if (isset($_POST['istop'])) {
                $where .= " AND top = '{$_POST['istop']}'";
            }
            if ($_POST['search']) {
                $where .= " AND title LIkE '%{$_POST['search']}%'";
            }
        }

        //使用:
        /*
        $pager = new Pager(总的记录数, 每页记录数, 当前页数, 'php脚本index.php', array(参数
            'a' => 'index',
            'c' => 'product',
        ));

        $pagerHtml = $pager->showPage();
        */
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pagesize = 5;
        $pager = new Pager(articleModel::create()->count(), $pagesize, $page, 'index.php', array(
            'a' => 'getList',
            'p' => 'backend',
            'c' => 'article',
        ));
        $pagerHtml = $pager->showPage();
        $start = ($page - 1) * $pagesize;

//        $article = articleModel::create()->findAll($where, 'id DESC', $start, $pagesize);
        $article = articleModel::create()->getAllWithJoin($where, 'id DESC', $start, $pagesize);
        $category = categoryModel::create()
            ->limitlessLevelCategory(
                categoryModel::create()->findAll());
        $this->loadHtml('article/getList', array(
            'category' => $category,
            'article' => $article,
            'pagerHtml' => $pagerHtml,
        ));
        //$s->assign('category', $category);
    }

    public function delete()
    {
        $id = $_GET['id'];

        if (articleModel::create()->deleteById($id)) {
           $this->redirect('index.php?p=backend&c=article&a=getList', 1 , '删除成功');
        } else {
            return $this->redirect('index.php?p=backend&c=article&a=getList', 1, '删除失败');
        }
    }

//    public function update()
//    {
//        $id = $_GET['id'];
//
//        if ($_POST) {
//            echo 'ok';
//        } else {
//            $this->loadHtml('');
//        }
//    }
}