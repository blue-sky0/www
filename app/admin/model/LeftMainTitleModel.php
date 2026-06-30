<?php

// 前台次首页
namespace admin\model;
use \core\Model;

class LeftMainTitleModel extends Model{
    //增加属性
    protected $table = 'leftMainTitle';
    // 获取左侧大标题信息
    public function getLeftMainTitleData(){
        // 获取 subject, title
		return $this->getAll();
    }
}