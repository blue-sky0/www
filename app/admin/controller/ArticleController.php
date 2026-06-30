<?php

namespace admin\controller;

class ArticleController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Article');
        $this->assign("TablesName", $this->TablesName);

        $tableName = $_REQUEST['tableName'] ?? '';
        $tableData = "";
        if (!empty($tableName)) {
            $this->checkCsrf();
            $allFunction = new \admin\model\AllFunctionModel();
            $tableData = $allFunction->getTableData($tableName);
        }
        $this->assign("tableData", $tableData);

        $this->display("index.php");
    }
}
