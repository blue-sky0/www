<?php

namespace models;
use \core\Model;

class SubjectModel extends Model{
    protected $table = 'subject';
    public function getHomePageData(){
        return $this->getAll();
    }
}
