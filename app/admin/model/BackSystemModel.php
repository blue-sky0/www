<?php

// 后台
namespace admin\model;
use \core\Model;

class BackSystemModel extends Model{
    //增加属性
    protected $table = 'backSystem';
    // 获取左侧大标题信息
    public function getBackSystemData(){
        // 获取 course ,className,iconName
		return $this->getAll();
    }
}