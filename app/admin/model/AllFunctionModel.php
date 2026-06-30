<?php

// 后台

namespace admin\model;

use core\Model;

class AllFunctionModel extends Model
{
    //增加属性
    protected $table;
    // 获取库的表名
    public function getLibTablesName()
    {
        // 获取 course, subject, types, a_Tips, a_href, a_content
        // return $this->getAllTablesName();
        $tablesName = $this->getAllTablesName();
        foreach ($tablesName as $row) {
            //保存到$this->tableName属性
            $this->tableName[] = str_replace("S_", "", $row['Tables_in_study']);  // 去掉S_
        }
        return $this->tableName;

    }
    public function getTableExcel($tableName, $page, $perPage = 18)     //  $perPage 每页显示条数
    {
        $this->table = $tableName;
        // echo '表名：'.$this->table.'<br/>';
        $total = $this->getTableStatistics()[0]['total'];   
        $totalPages = ceil($total / $perPage);                
        // echo '总记录数：'.$totalPages.'<br/>';
        $offset = ($page - 1) * $perPage;                           // 计算偏移量
        $data = $this->getPageViewData($offset, $perPage);
        return [
            'total' => $total,                                                          // 获取总记录数
            'totalPages' => $totalPages,                                                // 计算总页数
            'data' => $data,                                                            // 当前页数据
            'nextPage' => $page < $totalPages ? $page + 1 : $totalPages,                // 下一页页码
            'prevPage' => $page > 1 ? $page - 1 : 1                                     // 上一页页码
        ];
    }
    // 表条数统计
    public function getTableStatistics()
    {
        // 获取 subject
        $sql = "SELECT COUNT(*) as total FROM  {$this->getTable()}";
        //执行
        return $this->query($sql, true);
    }
    
    // 获取表数据
    public function getTableData($tableName)
    {
        $this->table = $tableName;
        // echo '表名：'.$this->table.'<br/>';
        $data = $this->getAll();
        return $data;       
    }
    
}
