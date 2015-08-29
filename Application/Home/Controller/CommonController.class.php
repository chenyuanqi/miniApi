<?php

namespace Api\Controller;


use Think\Controller;

class CommonController extends Controller {
    /**
     * api 说明文档初始化
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function _initialize() {
        // 设置报错级别
        // error_reporting(0);
/*$str = '{"errcode": "00002","errinfo": "注册失败"}';
$foo = base64_encrypt($str); 
$done= base64_decrypt(array('test' => $foo));
O('加密前：'.$str);
O('加密后：'.$foo);
O('数据解密后：');
O($done);*/
    	// 左侧大分类数据
        $cateData = M('category')->where(array(
        	'status' => 1
        ))->order('rank desc')->select();
        // 大分类下的接口
        foreach ($cateData as &$value) {
            $value['interface'] = M('interface')->where(array(
                'cid'    => $value['id'],
                'status' => 1
            ))->select();
        }

        $this->cateData = $cateData;
    }
    
}