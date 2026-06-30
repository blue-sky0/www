<?php

namespace admin\controller;

class DataController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('DataIE');
        $this->assign("TablesName", $this->TablesName);

        $tableName = $_REQUEST['tableName'] ?? '';
        $this->assign("tableName", $tableName);

        $tableData = "";
        if (!empty($tableName)) {
            $this->checkCsrf();
            $page = $_REQUEST['page'] ?? 1;
            $allFunction = new \admin\model\AllFunctionModel();
            $tableData = $allFunction->getTableExcel($tableName, $page);
        }
        $this->assign("tableData", $tableData);

        $this->display("index.php");
    }
}
