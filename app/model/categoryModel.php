<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/5/31
 * Time: 下午3:25
 */

namespace app\model;

use core\Model;

class categoryModel extends Model
{
    protected $table = 'category';
    public function getAllWithJoin()
    {
        $sql = "SELECT category.*, COUNT(article.id) as article_count FROM category LEFT JOIN article ON category.id = article.category_id GROUP BY category.id;";
        //var_dump($this->getAll($sql)); //测试debug 不加group by 只显示一条count = 6
        return $this->getAll($sql);

    }
}