<?php

// 前台次首页
namespace admin\model;

use \core\Model;

class LeftSideSubtitleModel extends Model{
    //增加属性
    protected $table = 'leftSideSubtitle';
    // 获取左侧小标题信息
    public function getLeftSideSubtitleData(){
        // 获取 subject, title, a_Tips, a_href, a_content
		return $this->getAll();
    }

    // 获取 前后pageURL
    public function getPage($data,$page){
        //防止SQL注入
        $page = addslashes($page);
        $datas = array();
        // 获取 page 
        for($i=0;$i<count($data);$i++){
            if($data[$i]['a_href'] == $page){
                if($i==0){
                    $data[$i+1]["status"] = "0";
                    array_push($datas, $data[$i+1]);
                }
                elseif($i>0 && $i<count($data)-1){
                    array_push($datas, $data[$i-1]);
                    array_push($datas, $data[$i+1]);
                }
                elseif($i==count($data)-1){
                    $data[$i]["status"] = "1";
                    array_push($datas, $data[$i-1]);
                }
                return $datas;
            }
        }
    }
}