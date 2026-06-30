<?php

//命名空间
namespace home\controller;
//引入公共控制器
use \core\Controller;

class IndexController extends Controller{
	/**
     * 构造函数
     */
    public function __construct()
    {
        // 必须调用父类构造函数
        parent::__construct();

        // 初始化数据
        // $this->init();
    }
	
    //默认方法
    public function index(){

		// 导航栏
		$nav = new  \models\NavModel();
		$res_nav = $nav->getNavData();
        // echo '<pre>';
        // print_r($res_nav);       
        // echo '</pre>';
		// 首页归类
		$homePage = new \models\SubjectModel();
		$rev_homePage = $homePage->getHomePageData();
		// echo '<pre>';
        // print_r($rev_homePage);       
        // echo '</pre>';

		
		$S = S;
		$page = Page;
		if (!empty($S)) {
			foreach ($rev_homePage as $item) {
				if ($item['subject'] === $S) {
					$images = $item['imagesName'];
				}
		    }

			// 左侧大标题
			$mainTitle = new \home\model\LeftMainTitleModel();
			$res_mainTitle = $mainTitle->getLeftMainTitleData($S);

			// 左侧小标题
			$leftTitle = new \home\model\LeftSideSubtitleModel();
			$res_leftTitle = $leftTitle->getLeftSideSubtitleData($S);

			// 如果 page 为空或不在数据中，使用第一个子标题的 page
			if (empty($page) || !$leftTitle->hasPage($res_leftTitle, $page)) {
				$page = $res_leftTitle[0]['page'] ?? '';
			}

			// 前后网页URL连接
			$frontBackpage = $leftTitle->getPage($res_leftTitle, $page);
			if ($frontBackpage === null) {
				$frontBackpage = [];
			}

			// 右侧内容
			$rightContent = new \home\model\RightContentModel();
			$res_rightContent = $rightContent->getRightContentData($S, $page);
			$content = '';
			foreach ($res_rightContent as $item) {
				$content = $item['content'];
		    }
			$this->assign("FrontBackpagedata",$frontBackpage);
			$this->assign("MainTitledata",$res_mainTitle);		
			$this->assign("LeftTitledata",$res_leftTitle);
			$this->assign("RightContentdata",$content);
			$this->assign("page",$page);


		} else {

			// 首页标题
			$title = new \models\CourseModel();
			$rev_title = $title->getTitleData();

			

			$this->assign("Titledata",$rev_title);		
			$this->assign("HomePagedata",$rev_homePage);
			// echo __DIR__ . '<br>';

		}


		$this->assign("Images",$images ?? '');
		$this->assign("S",$S);
		$this->assign("Navdata",$res_nav);
		$this->display("index.php");
    	
   
    }
	


}