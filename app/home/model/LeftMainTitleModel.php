<?php

namespace home\model;
use \core\Model;

class LeftMainTitleModel extends Model{
    protected $table = 'leftMainTitle';

    public function getLeftMainTitleData($subject){
        $sql = "select * from {$this->getTable()} where subject = ?";
        return $this->prepare($sql, [$subject], true);
    }
}