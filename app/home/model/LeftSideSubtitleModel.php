<?php

namespace home\model;

use \core\Model;

class LeftSideSubtitleModel extends Model{
    protected $table = 'leftSideSubtitle';

    public function getLeftSideSubtitleData($subject){
        $sql = "select * from {$this->getTable()} where subject = ?";
        return $this->prepare($sql, [$subject], true);
    }

    public function hasPage($data, $page){
        foreach ($data as $row) {
            if (isset($row['page']) && $row['page'] === $page) {
                return true;
            }
        }
        return false;
    }

    public function getPage($data,$page){
        $datas = array();
        if (empty($data)) {
            return $datas;
        }
        for($i=0;$i<count($data);$i++){
            if (!isset($data[$i]['page'])) {
                continue;
            }
            if($data[$i]['page'] == $page){
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
        return $datas;
    }
}