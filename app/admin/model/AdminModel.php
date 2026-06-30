<?php

// 后台
namespace admin\model;

use \core\Model;

class AdminModel extends Model{
    //增加属性
    protected $table = 'admin';
    // 获取左侧小标题信息
    public function getAdminData(){
        // 获取 course, subject, types, a_Tips, a_href, a_content
		return $this->getAll();
    }
}