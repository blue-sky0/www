<?php

// 前台首页

namespace models;

use core\Model;

class CourseModel extends Model
{
    //增加属性
    protected $table = 'course';
    // 获取分类标题信息
    public function getTitleData()
    {
        // 获取 course
        return $this->getAll();
    }

}
