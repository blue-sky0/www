<?php

namespace admin\controller;

use admin\service\SecurityAuditService;

class SecurityController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('Security');
        $this->assign("tableData", "");

        $service = new SecurityAuditService();
        $report = $service->runFullAudit();

        $this->assign('report', $report);
        $this->display("security.php");
    }
}
