<?php

namespace admin\controller;

class DataReportController extends BaseController
{
    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('DataReport');
        $this->assign("tableData", "");

        $statsModel = new \admin\model\StatsModel();

        $userStats = $statsModel->getUserStats();
        $contentCount = $statsModel->getContentCount();
        $imageCount = $statsModel->getImageCount();
        $videoCount = $statsModel->getVideoCount();
        $storageSize = $statsModel->getStorageSize();

        $logStats = $statsModel->getRecentLogStats(7);
        $moduleStats = $statsModel->getLogModuleStats();
        $regTrend = $statsModel->getRegistrationTrend(7);
        $categoryStats = $statsModel->getContentCategoryStats();
        $dailyContent = $statsModel->getDailyNewUsers(7);

        $this->assign('userStats', $userStats);
        $this->assign('contentCount', $contentCount);
        $this->assign('imageCount', $imageCount);
        $this->assign('videoCount', $videoCount);
        $this->assign('storageSize', $storageSize);

        $this->assign('logStats', $logStats ?: []);
        $this->assign('moduleStats', $moduleStats ?: []);
        $this->assign('regTrend', $regTrend ?: []);
        $this->assign('categoryStats', $categoryStats ?: []);
        $this->assign('dailyContent', $dailyContent ?: []);

        $this->assign('regTrendJson', json_encode($regTrend ?: []));
        $this->assign('categoryStatsJson', json_encode($categoryStats ?: []));
        $this->assign('logStatsJson', json_encode($logStats ?: []));
        $this->assign('moduleStatsJson', json_encode($moduleStats ?: []));
        $this->assign('dailyContentJson', json_encode($dailyContent ?: []));

        $this->display("datareport.php");
    }
}
