<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/5/31
 * Time: 下午3:05
 */

namespace app\controller\backend;


use app\model\categoryModel;
use core\Controller;

class categorycontroller extends Controller
{
    public function add()
    {
        $this->denyaccess();
        if($_POST) {
            var_dump($_POST);
            $data = array(
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'sort' => $_POST['Order'],
                'parent_id' => $_POST['ParentID'],
            );
            if (categoryModel::create()->add($data)) {
                $this->redirect('index.php?p=backend&c=category&a=getList', 1, '添加成功');
            } else {
              return  $this->redirect('index.php?p=backend&c=category&a=add', 1 , '添加失败');
            }
        } else {
            $categorys = categoryModel::create()->limitlessLevelCategory(categoryModel::create()->findAll());
            $this->loadHtml('category/add', array(
                'categorys' => $categorys,
            ));
        }
    }

    public function getList()
    {
        $this->denyaccess();
        $categorys = CategoryModel::create()
                        ->limitlessLevelCategory(
                            CategoryModel::create()->getAllWithJoin());
        $this->loadHtml('category/list', array(
            'categorys' => $categorys,
        ));
    }

    public function update()
    {
        $id = $_GET['id'];
        $this->denyaccess();

        if ($_POST) {
            $data = array(
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'sort' => $_POST['Order'],
                'parent_id' => $_POST['ParentID'],
            );
        if (categoryModel::create()->updateById($id, $data)) {
            $this->redirect('index.php?p=backend&c=category&a=getList', 1, 'ok');
        } else {
           return $this->redirect('index.php?p=backend&c=category&a=update' . $id , 1, 'no');
        }
        } else {
            $category = categoryModel::create()->findOneById($id);
            $category_name = categoryModel::create()->limitlessLevelCategory(categoryModel::create()->findAll());
            $this->loadHtml('category/update', array(
                'category' => $category,
                'category_name' => $category_name,
            ));
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->denyaccess();
        if (categoryModel::create()->count("parent_id = '{$id}'") > 0) {
            return $this->redirect('index.php?p=backend&c=category&a=getList', 1, '删除失败');
        } else if (categoryModel::create()->deleteById($id)) {
            $this->redirect('index.php?p=backend&c=category&a=getList', 1, 'is ok');
        } else {
            return $this->redirect('index.php?p=backend&c=category&a=getList',1 , 'is false');
        }

    }
}