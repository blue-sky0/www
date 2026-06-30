<?php

namespace admin\controller;

use admin\service\AccessLogService;

class BehaviorAnalysisController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('BehaviorAnalysis');
        $this->assign("tableData", "");

        $service = AccessLogService::getInstance();

        $trend = $service->getAccessTrend(7);
        $topPages = $service->getTopPages(7, 15);
        $referrers = $service->getTopReferrers(7, 10);
        $realtime = $service->getRealTimeStats();

        $this->assign('trend', $trend);
        $this->assign('topPages', $topPages);
        $this->assign('referrers', $referrers);
        $this->assign('realtime', $realtime);

        $trendLabels = [];
        $trendPv = [];
        $trendUv = [];
        foreach ($trend as $d) {
            $trendLabels[] = $d['date'];
            $trendPv[] = (int)$d['pv'];
            $trendUv[] = (int)$d['uv'];
        }
        $this->assign('trendLabels', json_encode($trendLabels));
        $this->assign('trendPv', json_encode($trendPv));
        $this->assign('trendUv', json_encode($trendUv));

        $this->display("analysis.php");
    }

    public function list()
    {
        $this->assignCommon();

        $filters = [
            'user_type' => $_GET['user_type'] ?? '',
            'ip_address'=> $_GET['ip_address'] ?? '',
            'url'       => $_GET['url'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to'   => $_GET['date_to'] ?? '',
        ];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $service = AccessLogService::getInstance();
        $result = $service->getAccessList($filters, $page);
        $totalPages = max(1, ceil($result['total'] / 50));

        $this->assign('logs', $result['rows']);
        $this->assign('total', $result['total']);
        $this->assign('page', $page);
        $this->assign('totalPages', $totalPages);
        $this->assign('prevPage', max(1, $page - 1));
        $this->assign('nextPage', min($totalPages, $page + 1));
        $this->assign('filters', $filters);

        $this->display("analysis_list.php");
    }

    public function journey()
    {
        $sessionId = $_GET['session_id'] ?? '';
        $service = AccessLogService::getInstance();
        $journey = $service->getUserJourney($sessionId);

        $this->assignCommon();
        $this->assign('journey', $journey);
        $this->assign('sessionId', $sessionId);
        $this->display("analysis_journey.php");
    }
}
