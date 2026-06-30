<?php

namespace home\model;

use \core\Model;

class RightContentModel extends Model{
    protected $table = 'rightContent';

    public function getRightContentData($subject, $page){
        $sql = "select * from {$this->getTable()} where subject = ? and page = ?";
        return $this->prepare($sql, [$subject, $page], true);
    }
}