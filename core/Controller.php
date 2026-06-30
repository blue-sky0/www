<?php

namespace core;

/**
 * 控制器基类
 *
 * 封装 Smarty 模板引擎，提供 assign/display 方法。
 * 子类继承后可调用 $this->assign() 分配变量，$this->display() 渲染模板。
 */
class Controller{
	/** @var \Smarty Smarty 模板引擎实例 */
	protected $smarty;

	public function __construct(){
		//1.加载Smarty
		include VENDOR_PATH . 'smarty/Smarty.class.php';

		//2.实例化
		$this->smarty = new \Smarty();

		//3.设置Smarty
		// echo APP_PATH . P . '/view/'.'<br/>';
		// $this->smarty->template_dir = APP_PATH . P . '/view/' . C . '/';   	//模板目录
		$this->smarty->template_dir = APP_PATH . P . '/view/' ;   				//模板目录
		// echo $this->smarty->template_dir . '<br/>';

	    // 缓存配置：根据环境变量决定
	    $cacheEnabled = (getenv('CACHE_ENABLED') === 'true' || getenv('CACHE_ENABLED') === '1');
	    $this->smarty->caching = $cacheEnabled;									// 是否开启缓存
	    $this->smarty->cache_dir = APP_PATH . P . '/cache';   				//缓存目录（开启缓存后自动创建）
		// echo $this->smarty->cache_dir . '<br/>';

	    // 缓存时间
	    $cacheLifetime = (int)(getenv('CACHE_LIFETIME') ?: 120);
	    $this->smarty->cache_lifetime = $cacheLifetime;						// 缓存时间：单位是s

	   	$this->smarty->compile_dir = APP_PATH . P . '/template_c';   		//编译目录（Smarty自动创建）
		// echo $this->smarty->compile_dir . '<br/>';

		// 确保缓存和编译目录存在
		if (!is_dir($this->smarty->cache_dir)) {
			@mkdir($this->smarty->cache_dir, 0755, true);
		}
		if (!is_dir($this->smarty->compile_dir)) {
			@mkdir($this->smarty->compile_dir, 0755, true);
		}
	}

	/**
	 * 分配模板变量
	 *
	 * @param string $key   变量名
	 * @param mixed  $value 变量值
	 */
	protected function assign($key, $value){
	    $this->smarty->assign($key, $value);
	}

	/**
	 * 渲染模板
	 *
	 * @param string $file 模板文件名（如 index.php）
	 */
	protected function display($file){
	    $this->smarty->display($file);
	}

	/**
	 * 错误提示 + 跳转
	 *
	 * @param string $msg  提示信息
	 * @param string $a    目标方法
	 * @param string $c    目标控制器
	 * @param string $p    目标平台
	 * @param int    $time 停留秒数
	 */
	protected function error($msg, $a = A, $c = C, $p = P, $time = 3){
	    $refresh = 'Refresh:' . $time . ';url=' . URL . 'index.php?c=' . $c . '&a=' . $a . '&p=' . $p;
		echo $refresh.'<br/>';
	    header($refresh);
	    echo $msg;
	    exit;
	}

	/**
	 * 成功提示 + 跳转
	 *
	 * @param string $msg  提示信息
	 * @param string $a    目标方法
	 * @param string $c    目标控制器
	 * @param string $p    目标平台
	 * @param int    $time 停留秒数
	 */
	protected function success($msg, $a = A, $c = C, $p = P, $time = 3){
	    $refresh = 'Refresh:' . $time . ';url=' . URL . 'index.php?c=' . $c . '&a=' . $a . '&p=' . $p;
		echo $refresh.'<br/>';
	    header($refresh);
	    echo $msg;
	    exit;
	}
}