<?php
/**
 *	[����Χ��ϰ��(zxsq_goxiti.{modulename})] (C)2013-2099 Powered by @tecbbs.com.
 *	Version: v1.0
 *	Date: 2013-7-15 16:10
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_zxsq_goxiti {
	private $w;	//��
	private $h;	//��
	private $hp;	//�Ƿ���ʾ��������
	private $hpurl;	//��������
	
	function discuzcode($param) {
		global $_G;
		@extract($_G['cache']['plugin']['zxsq_goxiti']);//����������ֵ
		$this->w=$gobanWidth;
		$this->h=$gobanHeight;
		$this->hp=$isHelp;
		$this->hpurl=$helpUrl;
		
		// ���������û�� goxiti �Ļ��򲻳�������ƥ��
		if (strpos($_G['discuzcodemessage'], '[/goxiti]') === false) {
			return false;
		}
		// ���ڽ���discuzcodeʱִ�ж� goxiti �Ľ���
		if($param['caller'] == 'discuzcode') {
			$_G['discuzcodemessage'] = preg_replace('/\s?\[goxiti\][\n\r]*(\(;.+?\))[\n\r]*\[\/goxiti\]\s?/es', '$this->gelxiti(\'\\1\')', $_G['discuzcodemessage']);
			
		} else {
			$_G['discuzcodemessage'] = preg_replace('/\s?\[goxiti\][\n\r]*(\(;.+?\))[\n\r]*\[\/goxiti\]\s?/es', '', $_G['discuzcodemessage']);
		}
	}
	function gelxiti($sgfcode) {
		$sgfcode=str_replace("\r","",$sgfcode);
		$sgfcode=str_replace("[hr]","[hr ]",$sgfcode);	//[hr]��discuzˮƽ�ߴ����ͻ
		$sgfcode=preg_replace('/\[url(.+?)\](.+?)\[\/url\]/','\\2',$sgfcode);	//���������ʱ�Զ�ת[url]�����sgf�����ĳ�ͻ

		$width=$this->w;
		$height=$this->h;
		if($width <400 || $height<300){
			$width=500;
			$height=400;				//�������̴�С
		}
		$helplink=$this->hpurl;
		$ish=$this->hp;
		include template('zxsq_goxiti:goxiti');
		return trim($goxiti);
		
	}



}

class plugin_zxsq_goxiti_forum extends plugin_zxsq_goxiti {
       function post_editorctrl_left() {  //�������ƾ���ǰ̨ҳ��Ƕ��������
	   	   global $_G;
		   $lang = lang('plugin/zxsq_goxiti'); 
		   @extract($_G['cache']['plugin']['zxsq_goxiti']);//����������ֵ
			if(!in_array($_G['fid'],(array)unserialize($gobanForum))) return '';
		   $btn = "
		   <link rel=\"stylesheet\" href=\"source/plugin/zxsq_goxiti/template/btn_goxiti.css\" type=\"text/css\" />
		   <script src=\"source/plugin/zxsq_goxiti/js/addgoxiti.js\" type=\"text/javascript\"></script>
		   <a id=\"btn_goxiti\" title=".lang('plugin/zxsq_goxiti','title')." onClick=\"addgoxiti('btn_goxiti','".lang('plugin/zxsq_goxiti','title')."','".lang('plugin/zxsq_goxiti','l_submit')."','".lang('plugin/zxsq_goxiti','l_close')."','".lang('plugin/zxsq_goxiti','l_tips')."','".lang('plugin/zxsq_goxiti','l_help')."','"."')\" href='javascript:void(0);' >".lang('plugin/zxsq_goxiti','l_xiti')."</a>"; 
		   
		   return $btn;
		}
}


?>