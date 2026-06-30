<?php


namespace models;
use \core\Model;

class NavModel extends Model{
    //增加属性
    protected $table = 'nav';
    // 获取导航栏信息
    public function getNavData(){
        // 获取 subject, imagesName
		return $this->getAll();
    }
}