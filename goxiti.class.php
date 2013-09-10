<?php
/**
 *	[在线围棋习题(zxsq_goxiti.{modulename})] (C)2013-2099 Powered by @tecbbs.com.
 *	Version: v1.0
 *	Date: 2013-7-15 16:10
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_zxsq_goxiti {
	private $w;	//宽
	private $h;	//高
	private $hp;	//是否显示帮助链接
	private $hpurl;	//帮助链接
	
	function discuzcode($param) {
		global $_G;
		@extract($_G['cache']['plugin']['zxsq_goxiti']);//缓存插件变量值
		$this->w=$gobanWidth;
		$this->h=$gobanHeight;
		$this->hp=$isHelp;
		$this->hpurl=$helpUrl;
		
		// 如果内容中没有 goxiti 的话则不尝试正则匹配
		if (strpos($_G['discuzcodemessage'], '[/goxiti]') === false) {
			return false;
		}
		// 仅在解析discuzcode时执行对 goxiti 的解析
		if($param['caller'] == 'discuzcode') {
			$_G['discuzcodemessage'] = preg_replace('/\s?\[goxiti\][\n\r]*(\(;.+?\))[\n\r]*\[\/goxiti\]\s?/es', '$this->gelxiti(\'\\1\')', $_G['discuzcodemessage']);
			
		} else {
			$_G['discuzcodemessage'] = preg_replace('/\s?\[goxiti\][\n\r]*(\(;.+?\))[\n\r]*\[\/goxiti\]\s?/es', '', $_G['discuzcodemessage']);
		}
	}
	function gelxiti($sgfcode) {
		$sgfcode=str_replace("\r","",$sgfcode);
		$sgfcode=str_replace("[hr]","[hr ]",$sgfcode);	//[hr]和discuz水平线代码冲突
		$sgfcode=preg_replace('/\[url(.+?)\](.+?)\[\/url\]/','\\2',$sgfcode);	//解决发链接时自动转[url]代码和sgf解析的冲突

		$width=$this->w;
		$height=$this->h;
		if($width <400 || $height<300){
			$width=500;
			$height=400;				//设置棋盘大小
		}
		$helplink=$this->hpurl;
		$ish=$this->hp;
		include template('zxsq_goxiti:goxiti');
		return trim($goxiti);
		
	}



}

class plugin_zxsq_goxiti_forum extends plugin_zxsq_goxiti {
       function post_editorctrl_left() {  //函数名称就是前台页面嵌入点的名称
	   	   global $_G;
		   $lang = lang('plugin/zxsq_goxiti'); 
		   @extract($_G['cache']['plugin']['zxsq_goxiti']);//缓存插件变量值
			if(!in_array($_G['fid'],(array)unserialize($gobanForum))) return '';
		   $btn = "
		   <link rel=\"stylesheet\" href=\"source/plugin/zxsq_goxiti/template/btn_goxiti.css\" type=\"text/css\" />
		   <script src=\"source/plugin/zxsq_goxiti/js/addgoxiti.js\" type=\"text/javascript\"></script>
		   <a id=\"btn_goxiti\" title=".lang('plugin/zxsq_goxiti','title')." onClick=\"addgoxiti('btn_goxiti','".lang('plugin/zxsq_goxiti','title')."','".lang('plugin/zxsq_goxiti','l_submit')."','".lang('plugin/zxsq_goxiti','l_close')."','".lang('plugin/zxsq_goxiti','l_tips')."','".lang('plugin/zxsq_goxiti','l_help')."','"."')\" href='javascript:void(0);' >".lang('plugin/zxsq_goxiti','l_xiti')."</a>"; 
		   
		   return $btn;
		}
}


?>