<?php
/**
 * 生成随机字符串
 * @param  length   $length       生成的字符串长度
 * @param  pool     $pool         需求池
 * @return string   #随机后的字符串
 * @author cyq <chenyuanqi90s@163.com>
 */
function random($length, $pool = ''){   
    $random = '';
    $check = '';
    
    if (empty($pool)) {   
        $pool    = 'abcdefghkmnpqrstuvwxyz';   
        $pool   .= '23456789';   
    }   
    srand ((double)microtime()*1000000);   
    for($i = 0; $i < $length; $i++){   
        $random .= substr($pool,(rand()%(strlen ($pool))), 1);   
    }  

    // 用于产生唯一的产品编号
    $check = M('Products')->where(array(
            'product_code' => $random))->find();
    if ($check) {
    	random($length, $pool);
    }
    return $random;   
}


/**
 * 生成随机字符串
 * @param  number   $length    生成的字符串长度
 * @return string              #返回{$length}位随机字符
 * @author cyq <chenyuanqi90s@163.com>
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


/**
 * 加密解密
 * @param  string   $key          要加密或解密的字符串
 * @param  string   $string       二级加密或解密的字符串
 * @param  decrypt  $decrypt      是否加密
 * @return decrypted | encrypted  #加密/解密后的字符串
 * @author cyq <chenyuanqi90s@163.com>
 */
function encryptDecrypt($key, $string, $decrypt){
    if($decrypt){
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "12");
        return $decrypted;
    }else{
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return $encrypted;
    }
}



//获取当前页面的url
function curPageURL() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}


/**
 *获取访客浏览器类型
 *@return 访客浏览器类型;
 */
function GetBrowser(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
      $br = $_SERVER['HTTP_USER_AGENT'];
      if (preg_match('/MSIE/i',$br)) {    
          $br = 'MSIE';
      } elseif (preg_match('/Firefox/i',$br)) {
          $br = 'Firefox';
      } elseif (preg_match('/Chrome/i',$br)) {
          $br = 'Chrome';
      } elseif (preg_match('/Safari/i',$br)) {
          $br = 'Safari';
      } elseif (preg_match('/Opera/i',$br)) {
          $br = 'Opera';
      } else {
          $br = 'Other';
      }
      return $br;
    } else {
      return "获取浏览器信息失败！";
    } 
}
  


/**
 * 文章阅读数自增一
 * @param  string   $db           所在数据表名
 * @param  int      $id           表中id
 * @param  name     $name         需要自增的字段
 * @return void(0)
 * @author cyq <chenyuanqi90s@163.com>
 */
function readInc($db, $id, $name = 'click_num') {
    M($db)->where(array('id'=>$id))->setInc($name);
}


/**
 * Utf-8、gb2312支持的汉字截取函数
 * @param  string   $string    要截取的字符串
 * @param  number   $sublen    要截取的长度
 * @param  number   $start     开始截取的位置 ( 默认0 )
 * @param  string   $code      字符编码 ( 默认'UTF-8' )
 * @return string              #截取后的字符串
 * @author cyq <chenyuanqi90s@163.com>
 */
function cutStr($string, $sublen, $start = 0, $code = 'UTF-8'){
    if($code == 'UTF-8'){
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);

        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
        return join('', array_slice($t_string[0], $start, $sublen));
    }else{
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';

        for($i=0; $i<$strlen; $i++){
            if($i>=$start && $i<($start+$sublen)){
                if(ord(substr($string, $i, 1))>129){
                    $tmpstr.= substr($string, $i, 2);
                }else{
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129) $i++;
        }
        if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
}


/**
 * 时间转换为相应的英文月(如2015-01-01 01:01:01 => Jan)
 * @param  datetime   $datetime    具体日期时间
 * @return string                  #返回相应的英文月份并截取3位
 * @author cyq <chenyuanqi90s@163.com>
 */
function _date_to_en($datetime) {
    $month = date('F', strtotime($datetime));
    return substr($month, 0, 3);
}


/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装） 
 * @return mixed
 */
function getIp($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


/**
 * msg_send短信发送
 * @param  int       $uid       用户id
 * @param  string    $phone     手机号码
 * @param  string    $Content   短信内容
 * @return string;
 **/
function msg_send($uid, $phone, $content = '') {
    srand((double) microtime() * 1000000); //create a random number feed.
    $authnum        = rand(100000, 999999); // ;
    $data["verify"] = $authnum;
    $data["phone"]  = $phone;
    
    if (!$content) {
        $data["content"] = "您本次操作的验证码是：" . $authnum . "，有效期半小时内，如果不是您本人操作请联系客服!【打打族】";
    } else {
        $data["content"] = $content;
    }

    $data['uid'] = $uid;
    $data["client_ip"]   = ip2long(getIp());
    $data["create_time"] = date("Y-m-d H:i:s");
    
    $id = M("mobile_log")->add($data);
    $mSendNum = $phone;
    
    if (!$content) {
        $mContent = "您本次操作的验证码是：" . $authnum . "，有效期半小时内，如果不是您本人操作请联系客服!【打打族】";
    } else {
        $mContent = $content;
    }
    
    $mUserName = "yangyo";
    $mpassword = "199205";
    $url       = "http://api.chanyoo.cn/utf8/interface/send_sms.aspx?username=$mUserName&password=$mpassword&receiver=$mSendNum&content=" . $mContent . "";
    $xml       = simplexml_load_file($url);
    setcookie("usermobile", $mSendNum);
    if ($xml->result >= 0) {
        return '短信发送成功';
        exit();
    } else {
    	M('mobile_log')->where(array(
    		'id' => $id
    	))->setField('status', 2);
        return '短信发送失败(' . $xml->result . ')';
        exit();
    }
    
}


/**
 *正则邮箱 /^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i
 *@param  需要验证的邮箱    $string
 *@return boolean;
 */
function RegularEmail($string){
    $resultStr = preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$string);
    if(intval($resultStr) == 1){
        return TRUE;
    }
    else{
        return FALSE;
    }
}



/**
 * json输出，去除空值
 */
function output($data) {
    array_walk($data, function(&$val) {
        
        if (is_null($val)) {
            $val = "";
        }
        return $val;
    });
    
    exit(json_encode($data));
}


/**
 * 通用返回函数，后期根据情况修改
 */
function Return_code($errcode) {
	$arr = array(
			'errcode' => $errcode
	);
	echo  json_encode($arr);
	exit();
}


/**
 * APP登录判断，返回用户ID及过期时间
 */
function app_check_login(){
	$token          = I("get.token");
	$map["token"]   = $token;
	$map['time']    = array('gt',date("Y-m-d H:i:s"));
	$data = M("user_app")->where($map)->find();
	if($data){
        ///更新 token 过期时间为操作的一周后
        M('user_app')->where(array(
            'id' => $data['id']))->setField('time', date("Y-m-d H:i:s", time() + 86400*7));
		return $data;
	}else{
        $arr = array(
            'Return_code' => '00002',
            'return_info' => 'Token 无效 或无 Token'
        );
		exit(json_encode($arr));
	}

}



/**
 * 强制文件下载
 * @param  $filename   文件地址
 * @return boolean;
 */
function download($filename){
    if ((isset($filename))&&(file_exists($filename))){
       header("Content-length: ".filesize($filename));
       header('Content-Type: application/octet-stream');
       header('Content-Disposition: attachment; filename="' . $filename . '"');
       readfile("$filename");
       return true;
    } else {
       return false;
    }
}


/**
 * 文件打包
 * @param  $filename   文件地址
 * @return boolean;
 */
function packup($fileArr = '', $cur_file = 'Data/', $save_path = 'Data/Zip/') {
    import('ORG.Util.FileToZip');
    
    $handler       = opendir($cur_file); //$cur_file 文件所在目录 
    $download_file = array();
    $i             = 0;
    while (($filename = readdir($handler)) !== false) {
        if ($filename != '.' && $filename != '..') {
            // 是否压缩特定文件
            if ($fileArr && !in_array($filename, $fileArr)) {
                continue;
            }
            
            $download_file[$i++] = $filename;
        }
    }
    
    closedir($handler);
    $scandir = new traverseDir($cur_file, $save_path); //$save_path zip包文件目录 
    $scandir->tozip($download_file);
    
}



/**
 * 详细时间转换
 * @author cyq <chenyuanqi90s@163.com>
 */
function tranTime($time){
    $rtime = date("m-d H:i", $time);
    $htime = date("H:i", $time);
    
    $time = time() - $time;
    
    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h   = floor($time / (60 * 60));
        $str = $h . '小时前 ';
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ';
        else
            $str = '前天 ';
    } else {
        $str = $rtime;
    }
    return $str;
}




/**
 * 调试输出sql语句、sql错误、打印数组 #Output
 * @param  String | Array   $foo     要打印输出的对象
 * @param  number           $module    模式, 默认为1, 其他则以封装好的 dump 方法
 * @return $Str (String)
 * @author cyq <chenyuanqi90s@163.com>
 */
function O($foo, $module = 0) {
    header("content-type:text/html;charset=utf-8");
    echo '<div style="color: #F16B17; font-family: georgia, verdana, tahoma, arial, sans-serif; font-size: 13px; width: 980px; min-width: 600px; line-height: 23px;margin: 0 auto;padding: 16px; background: #f2f2f2; word-break: break-word;">';

    // 输出除数组、sql语句外字符串等
    if (1 == $module) {
        echo '<h3 style="color: #0f9c7c;">Happy programming！您要输出的变量信息如下：</h3><pre>';
        var_dump($foo);
        exit('</pre></div>');
    }

    if (is_array($foo)) {
        // 添加块样式
        echo '<h3 style="color: #0f9c7c;">Happy programming！您要输出的数组信息如下：</h3><pre>';
        print_r($foo);
        exit('</pre></div>');
    } else {
        echo '<h3 style="color: #0f9c7c;">Happy programming！您正在执行的sql语句:</h3>' . M($foo)->_sql();
        $err = M($foo)->getDbError();
        $err && exit('<hr /><h3 style="color: red;">We’re So Sorry! sql错误信息：</h3>' . $err);
        die();
    }
}



/**
 * 输出 Php 全局变量 #Output 『TP』 
 * @param  number           $module    模式, 默认为0
 * @param  string           $else      使用非TP模式输出
 * @return $Str (String)
 * @author cyq <chenyuanqi90s@163.com>
 */
function P($module = 0, $else = null) {
    header("content-type:text/html;charset=utf-8");
    
    switch ($module) {
        case 0:
            $else ? var_dump($_REQUEST) : dump($_REQUEST);
            break;
        
        case 1:
            $else ? var_dump($_GET) : dump($_GET);;
            break;

        case 2:
            $else ? var_dump($_POST) : dump($_POST);
            break;

        case 3:
            $else ? var_dump($_SESSION) : dump($_SESSION);;
            break;

        case 4:
            $else ? var_dump($_COOKIE) : dump($_COOKIE);
            break;

        default:
            $else ? var_dump($_FILES) : dump($_FILES);
            break;
    }
}

