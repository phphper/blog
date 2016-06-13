<?php
/**
 * Created by PhpStorm.
 * User: zhao820019382
 * Date: 16/6/1
 * Time: 下午7:22
 */

namespace app\model;


use core\Model;

class articleModel extends Model
{
    protected $table = 'article';

    public function getAllWithJoin($where = '2 > 1', $sort = 'id ASC', $start = 0, $pagesize = 5)
    {
        $sql = "SELECT `article`.*, `category`.name AS category_name, `user`.`username`, count(`comment`.`id`) comment_count, `article`.published_date time
                FROM `article`
                LEFT JOIN `comment`  ON `comment`.`article_id` = `article`.id
                LEFT JOIN `category` ON `article`.category_id = `category`.id
                LEFT JOIN `user`     ON `article`.author_id = `user`.`id`
                WHERE {$where}
                GROUP BY `article`.`id`
                ORDER BY {$sort}
                ";
        if ($pagesize != false) {
            $sql .= "LIMIT {$start}, {$pagesize}";
        }
        return $this->getAll($sql);
    }

    public function getOneWithJoin($id)
    {
       $sql = "SELECT `article`.*, `user`.`username`, `category`.`name`, COUNT(`comment`.`id`) comment_count
                FROM `article`
                LEFT JOIN `user` ON `article`.`author_id` = `user`.`id`
                LEFT JOIN `category` ON `article`.`category_id` = `category`.`id`
                LEFT JOIN `comment` ON `comment`.`article_id` = `article`.`id`
                WHERE `article`.`id` = {$id}
                GROUP BY `article`.`id`
                 ";
        return $this->getOne($sql);
    }


    public function increaseReadeNumber($id)
    {
        $sql = "UPDATE `article` SET `read`=`read`+1 WHERE id={$id}";
        return $this->exec($sql);
    }

    public function increasePraiseNumber($id)
    {
        $sql = "UPDATE `article` SET `praise`=`praise`+1 WHERE id={$id}";
        return $this->exec($sql);
    }

}



