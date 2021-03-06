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
        error_reporting(0);

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