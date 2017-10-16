<?php
/**
 * 生成二维码
 * @author:ceb 2014-10-27
 * @param string $data 需生成二维码的字符串
 * @param array $config 二维码配置
 * @param string $savepath 二维码保存路径
 * @param string $saveandprint 设了二维码保存路径是否直接显示二维码图像
 * @param string $qrformat 二维码输出格式 png svg eps pdf
 */
function qrcode($data,$_config=false,$savepath=false,$saveandprint=false,$qrformat='png'){

    // $data = htmlspecialchars_decode(stripslashes($data)); //反转义
    $data = htmlspecialchars_decode($data);// 不对$data 使用 stripslashes,方法将用户输入的"\"=>"","\\"=>"\"
    $config = config('qrcode.QRCODE');
    if(is_array($_config)) $config = array_merge($config,$_config);
    if(!is_numeric($config['block_pixel'])||$config['block_pixel']<1) $config['block_pixel'] = 12;
    if(!is_numeric($config['margin_block'])||$config['margin_block']<1) $config['margin_block'] = 1;
    //将颜色字符串转成16进制
    $config['back_color'] = intval(str_replace('#','0x',$config['back_color']),16);
    if (!$config['fontcolor']) {
        $config['fontcolor']="#000000";
    }
    $fore_one = substr($config['fore_color'],0,1);
    if($fore_one=='#'){ //纯色前景
        if (!$config['incolor']) {
            $config['incolor']=$config['fore_color'];
        }
        if (!$config['outcolor']) {
            $config['outcolor']=$config['fore_color'];
        }
        $config['fore_color'] = intval(str_replace($fore_one,'0x',$config['fore_color']),16);
    }else if($fore_one=='@'){ //预设前景图
        $config['fore_color'] = $_SERVER['DOCUMENT_ROOT'].'/preset/fore/'.str_replace($fore_one,'',$config['fore_color']).'.png';
        if (!$config['incolor']) {
            $config['incolor']="#000000";
        }
        if (!$config['outcolor']) {
            $config['outcolor']="#000000";
        }
    }
    $config['fontcolor']=intval(str_replace('#','0x',$config['fontcolor']),16);
    $config['incolor']=intval(str_replace('#','0x',$config['incolor']),16);
    $config['outcolor']=intval(str_replace('#','0x',$config['outcolor']),16);
    if($config['transparent']==true){
        $config['back_color'] = 'transparent';
    }
    if (!$config['fontsize']) {
        $config['fontsize']=18;
    }
    if (!$config['fontfamily']) {
        $config['fontfamily']="msyh.ttf";
    }
    //无协议资源处理
    $data=recreate_httpurl($data);
    $config['logopath']=recreate_httpurl($config['logopath']);
    $config['fore_color']=recreate_httpurl($config['fore_color']);
    $config['background']=recreate_httpurl($config['background']);

    if($config['logopath'] && !$config['logoshape']){//对版本1中的老logo的处理 cxc
        if(strpos($config['logopath'], '/cli/images/beautify/')){//系统logo
            $newlogourl=substr($config['logopath'], 0,-4) . '-1.' . substr($config['logopath'], -3);
            if(fopen($newlogourl, 'r')){
                $config['logopath']=$newlogourl;
                $config['logoshape']='rectOld';
            }
        }else{
            $config['logoshape']='rectOld';
        }
    }
    if($config['text']){
        $config['text']=htmlspecialchars_decode(html_entity_decode(urldecode($config['text'])));
    }
    require_once app_path().'/../vendor/Org/qrcode.class.php';
    switch($qrformat){
        case 'svg': \Org\qrcode\_QRcode::svg($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint);break;
        case 'eps': \Org\qrcode\_QRcode::eps($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint);break;
        case 'pdf': \Org\qrcode\_QRcode::pdf($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint);break;
        default: \Org\qrcode\_QRcode::png($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint,$config['back_color'],$config['fore_color'],$config['size'],$config['logopath'],$config['text'],$config['fontsize'],$config['fontcolor'],$config['fontfamily'],$config);
    }
}


function visual_qrcode($data,$_config=false,$savepath=false,$saveandprint=false,$qrformat='png'){
    $data = htmlspecialchars_decode(stripslashes($data)); //反转义
    $config = config('qrcode.qrcode.QRCODE');
    if(is_array($_config)) $config = array_merge($config,$_config);
    if(!is_numeric($config['block_pixel'])||$config['block_pixel']<1) $config['block_pixel'] = 12; //如果传递的这两个参数不正确，则给默认值
    if(!is_numeric($config['margin_block'])||$config['margin_block']<1) $config['margin_block'] = 1;
    //将颜色字符串转成16进制
    $config['back_color'] = intval(str_replace('#','0x',$config['back_color']),16);
    if (!$config['fontcolor']) {
        $config['fontcolor']="#000000";
    }
    $fore_one = substr($config['fore_color'],0,1);
    if($fore_one=='#'){ //纯色前景
        if (!$config['incolor']) {
            $config['incolor']=$config['fore_color'];
        }
        if (!$config['outcolor']) {
            $config['outcolor']=$config['fore_color'];
        }
        $config['fore_color'] = intval(str_replace($fore_one,'0x',$config['fore_color']),16);
    }else if($fore_one=='@'){ //预设前景图
        $config['fore_color'] = $_SERVER['DOCUMENT_ROOT'].'/preset/fore/'.str_replace($fore_one,'',$config['fore_color']).'.png';
    }
    $config['fontcolor']=intval(str_replace('#','0x',$config['fontcolor']),16);
    // $config['incolor']=intval(str_replace('#','0x',$config['incolor']),16);
    // $config['outcolor']=intval(str_replace('#','0x',$config['outcolor']),16);
    if($config['transparent']==true){
        $config['back_color'] = 'transparent';
    }
    if (!$config['fontsize']) {
        $config['fontsize']=18;
    }
    if (!$config['fontfamily']) {
        $config['fontfamily']="msyh.ttf";
    }
    require_once app_path().'/../vendor/Org/visualQr.class.php';
    switch($qrformat){
        case 'svg': \Org\qrcode\_QRcode::svg($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint);break;
        case 'eps': \Org\qrcode\_QRcode::eps($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint);break;
        case 'pdf': \Org\qrcode\_QRcode::pdf($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint);break;
        default: \Org\qrcode\_QRcode::png($data,$savepath,$config['level'],$config['block_pixel'],$config['margin_block'],$saveandprint,$config['back_color'],$config['fore_color'],$config['size'],$config['logopath'],$config['text'],$config['fontsize'],$config['fontcolor'],$config['fontfamily'],$config);
    }
}

// 重组无协议资源 cxc
function recreate_httpurl($url){
    if($url && strpos($url, '//')===0){
        $url='http:'.$url;
    }
    return $url;
}
/**
 * 检查二维码生成请求参数是否合法
 * @author:ceb 2014-11-04
 */
/*
function checkParam(){
	if(isset($_GET)) $_TYPE = $_GET;
	else $_TYPE = $_POST;
	$_kid = $_TYPE['kid'];
	$_key = $_TYPE['key'];
	unset($_TYPE['type']);
	if($_kid==''||$_key=='') return false;
	if(!$APIKEY=config('qrcode.QRAPIKEY.'.$_kid)) return false;
	$param = array();
	$param[] = $APIKEY;
	foreach($_TYPE as $key=>$val){
		if($key=='key') continue;
		$param[] = $key.$val;
	}
	$key = hash('md5',implode('',$param));
	if($_key!=$key) return false;
	return true;
}
*/
function checkParam(){
    if(isset($_GET)) $_TYPE = $_GET;
    else $_TYPE = $_POST;
    $_kid = $_TYPE['kid'];
    $_key = $_TYPE['key'];
    $_time = $_TYPE['time'];
    unset($_TYPE['type']);
    unset($_TYPE['downsize']);
    if($_kid==''||$_key=='') return false;
    if(!$APIKEY=config('qrcode.QRAPIKEY.'.$_kid)) return false;
    $param = array();
    $param[] = $APIKEY;
    foreach($_TYPE as $key=>$val){
        if($key=='key'||$key=='time') continue;
        $param[] = $key.$val;
    }
    if($_time) $param[] = $_time;
    $key = hash('md5',implode('',$param));
    if($_key!=$key) return false;
    return true;
}

function upload_server_one($file) {
    $kid = 'qrapi';
    $data['remote_url'] = $file;
    $return = curl_post('http://upload.api.cli.im/upload.php?kid='.$kid,$data);
    $return = json_decode($return, true);
    return $return;
}

function upload_server_url($file,$token_id) {
    $kid = 'qrapi';
    $key = 'C156D5A7EB99C48IZZD9639WCD9631D7';
    $time = time();
    $key = hash('md5',$kid.$key.$time);
    $data['kid'] = $kid;
    $data['key'] = $key;
    $data['time'] = $time;
    $data['files'] = $file;
    $data['token_id'] = $token_id;
    $return = curl_post('http://upload.cli.im/api/sync',$data);
    $return = json_decode($return, true);
    return $return;
}

/*新的上传服务器方法*/
function upload_server($file,$file_type,$token_id,$coding='',$coding_type=1,$bucket='biz') {
    if(!$token_id) return false;
    import('@.Org.alioss.ossApi');
    $_aliyun_oss_api = new \ossApi($bucket);
    $return =$_aliyun_oss_api->uploadFile($file,$token_id,$bucket);
    if($return['status']==1){
        $savedata['token_id']=$token_id;
        $savedata['file_path']=$return['data'][0];
        $savedata['size']=$return['info']['size'][0];
        $savedata['file_type']=$file_type;
        $savedata['coding']=$coding;
        $savedata['coding_type']=$coding_type;
        $res=curl_post(config('qrcode.USER_DOMAIN').'/api/index/savefileinfo',$savedata);
    }
    return $return;
}

/*curl_post 方法*/
function curl_post($curlHttp, $postdata) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $curlHttp);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //不显示
    curl_setopt($curl, CURLOPT_TIMEOUT, 86400); //3600秒，超时
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postdata));
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}


function curl_get($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}