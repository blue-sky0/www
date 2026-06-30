<?php

// 后台
namespace admin\model;

use \core\Model;

class TemporaryModel extends Model{
    //增加属性
    protected $table = 'temporary';
    // 获取左侧小标题信息
    public function getCategory(){
        // 获取 subject
		return $this->getAll();
    }
    public function updateCategory($data ,$condition){
        $this->updateTableData($data ,$condition);
    }
}