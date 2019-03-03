<?php 

$wx = new Wx();

class Wx {

	/* 和公众平台越好的token值 */
	private const TOKEN = 'guanjiani';
	private $obj;
	private $xml;
	
	/* 构造方法，自动验证 */
	public function __construct() 
	{
		if ( !empty($_GET['echostr']) ) {
			//有echostr就开始验证
			echo $this->checkSignature();
		} else {
			// 获取原始数据
			$this->xml = file_get_contents('php://input');
			// xml转对象
			$this->obj = simplexml_load_string($this->xml, 'SimpleXMLElement', LIBXML_NOCDATA);
			// 调用私有方法返回回复
			$this->acceptMesage();
		}
	}

	/**
	 *  接收消息处理
	 * @return [type] [description]
	 */
	private function acceptMesage() {
		// 消息类型
		$type = $this->obj->MsgType;
		$msg = '';
		// 动态获取方法
		$funName = $type . 'Fun';			
		// 调用配置文件
		$this->xml = include 'config.php';
		// 调用
		echo $msg = $this->$funName();
		// 写发送日志
		if ( !empty($msg) ) {
			$this->writeLog($msg, 1);
		}
	}

	/**
	 *  文本消息回复
	 * @return [type] [description]
	 */
	private function textFun() {
		// 获取配置文件中的xml
		$xml = $this->xml['text']; 
		// 调用语言包
		$content = include 'Language.php';

		if ( $content == '图文' ) {
			// 返回图文 
			return $this->newsFun();
		} else {
			// 更换占位符
			$msg = sprintf($xml, $this->obj->FromUserName, $this->obj->ToUserName, time(), $content);
		}
		// 返回
		return $msg;
	}

	/**
	 *  回复图片消息
	 * @return [type] [description]
	 */
	private function imageFun() {
		// 获取配置文件中的xml
		// $xml = $this->xml['image']; 
		// // 更换占位符
		// $msg = sprintf($xml, $this->obj->FromUserName, $this->obj->ToUserName, time(), $content);
		// // 返回
		// return $msg;
	}

	private function newsFun() {
		// 获取配置文件中的xml
		$xml = $this->xml['news']; 
		$img = './img/yl.jpg';
		$url = '521.guanjiani.cn';
		// 更换占位符
		$msg = sprintf($xml, $this->obj->FromUserName, $this->obj->ToUserName, time(), $this->obj->Content.'链接', "点击查看图文信息", $img, $url);
		// 返回
		return $msg;		
	}

	/**
	 *  写日志
	 * @param  string      $xml  [description] xml数据
	 * @param  int|integer $flag [description] 0 接收 1 发送
	 * @return [type]            [description]
	 */
	private function writeLog(string $xml, int $flag = 0) {
		$title = $flage == 0 ? '接收' : '发送';
		$dtime = date('Y-m-d H:i:s');

		/* 日志内容 */
		$log = $title . "[{$dtime}]\n";
		$log .= "----------------------------------------\n";
		$log .= $xml . "\n";
		$log .= "----------------------------------------\n";

		// 写日志 追加内容
		file_put_contents('wx.xml', $log, FILE_APPEND);
	}

	/**
	 *  初次接入验证
	 * @return string
	 */
	private function checkSignature() 
	{
		// 公众平台传过来的数据
		$nonce = $_GET['nonce'];
		$echostr = $_GET['echostr'];
		$timestamp = $_GET['timestamp'];
		$signature = $_GET['signature'];

		$tmpArr['nonce'] = $nonce;
		$tmpArr['token'] = self::TOKEN;   
		$tmpArr['timestamp'] = $timestamp;
		// 进行字典排序
		sort($tmpArr, SORT_STRING);
		// 拼接成字符串并进行sha1加密
		$tmpArr = sha1( implode($tmpArr) );
		// 验证通过
		return $tmpArr == $signature ? $echostr : '';
	}
}
