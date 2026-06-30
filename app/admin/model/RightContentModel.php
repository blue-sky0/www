<?php

// 前台次首页
namespace admin\model;

use \core\Model;

class RightContentModel extends Model{
    //增加属性
    protected $table = 'rightContent';
    // 获取左侧大标题信息
    public function getRightContentData($subject, $page){
		return $this->getAll();
    }
    // 类别统计 
    public function getCategoryStatistics(){
        $sql = "select subject,count(*) as count from {$this->getTable()} group by subject";
        //执行
		return $this->query($sql,true);
    }
}