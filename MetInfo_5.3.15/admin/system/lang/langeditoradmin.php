<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
$cs=isset($cs)?$cs:0;
$listclass[$cs]='class="now"';
$query="select * from $met_language where site='1' and app='0' and lang='$langeditor' ORDER BY no_order";
$result=$db->query($query);
while($list= $db->fetch_array($result)){
	$list['value']=str_replace('"', '&#34;', str_replace("'", '&#39;',$list['value']));
	$langtext_b[]=$list;
	$langtext[$list['array']][]=$list;
	$langtext_a[$list['name']]=$list;
}
if($action=="modify"){
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	foreach($langtext_b as $key=>$val){
		$name=$val['name'].'_metinfo';
		$metino_name=$$name;
		if(isset($metino_name)&&$val['value']!=$metino_name){
			$metino_name = stripslashes($metino_name);
			$metino_name = str_replace("'","''",$metino_name);
			$metino_name = str_replace("\\","\\\\",$metino_name);
			$query="update $met_language set value='$metino_name' where id='$val[id]'";
			$db->query($query);
		}
	}
	$file=file_exists('../../../cache/langadmin_'.$langeditor.'.php');
	if(unlink('../../../cache/langadmin_'.$langeditor.'.php')||!$file){
		$relang=$lang_jsok;
		$relang.=$met_webhtm==0?'':$lang_otherinfocache1;
		metsave('../system/lang/langeditoradmin.php?anyid='.$anyid.'&langeditor='.$langeditor."&langid=".$metinfolangid.'&lang='.$lang.'&cs='.$cs,$relang,$depth);
	}else{
		metsave('../system/lang/langeditoradmin.php?anyid='.$anyid.'&langeditor='.$langeditor."&langid=".$metinfolangid.'&lang='.$lang.'&cs='.$cs,$lang_otherinfocache1,$depth);
	}
}else{
	$css_url=$depth."../templates/".$met_skin."/css";
	$img_url=$depth."../templates/".$met_skin."/images";
	include template('system/lang/langeditoradmin');
	footer();
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>