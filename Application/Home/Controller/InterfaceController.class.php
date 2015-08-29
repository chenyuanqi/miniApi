<?php

namespace Api\Controller;


use Think\Controller;

class InterfaceController extends CommonController {
    /**
     * api 说明文档接口 —— 返回码说明
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function returnCode() {

        $this->title = '返回码说明';  
        $this->display();
    }


    /**
     * api 说明文档接口页
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function interfaceInfo() {

        $interfaceData = M('interface')->find(intval(I('get.id')));
        // 接口
        $this->interfaceData = $interfaceData;
        // 分类
        $this->categoryName  = M('category')->where(array(
            'id' => $interfaceData['cid']
        ))->getField('title');
        // 参数
        $this->paramData     = M('parameter')->where(array(
            'iid' => $interfaceData['id']
        ))->order('param_rank desc')->select();
        // 返回值中，iid 为 0 代表全局
        $this->returnData     = M('return')->where(array(
            'iid' => array('in', '0,'.$interfaceData['id']
        )))->order('return_rank desc')->select();
        $this->title = '『'.$interfaceData['interface_name'].'』接口详情';  
        $this->display();
    }


    /**
     * api 说明文档添加接口
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function addInterface(){
        // 分类名
        $categoryName= M('category')->where(array(
            'id' => I('get.cid')
        ))->getField('title'); 
        // 获取最新接口编号
        $code = M('interface')->order('id desc')->getField('interface_code');
        switch ($code) {
            case $code < 9:
                $this->code = '0000'.($code+1);
                break;
            
            case ($code >= 9) && ($code < 99):
                $this->code = '000'.($code+1);
                break;

            case ($code >= 99) && ($code <999):
                $this->code = '00'.($code+1);
                break;

            case ($code >= 999) && ($code <9999):
                $this->code = '0'.($code+1);
                break;

            default:
                $this->code = $code+1;
                break;
        }

        $this->title = '添加接口『分类：'.$categoryName.'』';  
		$this->display();
    }


    /**
     * api 说明文档编辑接口 (数据简单过滤 | 永远不要相信用户输入)
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function editInterface(){

        $interfaceData = M('interface')->find(I('get.id', '', 'htmlspecialchars,int'));

        !$interfaceData && $this->redirect('Index/index');
        // 接口
        $this->interfaceData = $interfaceData;
        // 参数
        $this->paramData     = M('parameter')->where(array(
            'iid' => $interfaceData['id']
        ))->order('param_rank desc')->select();
        // 返回值中，iid 为 0 代表全局
        $this->returnData     = M('return')->where(array(
            'iid' => array('in', $interfaceData['id']
        )))->order('return_rank desc')->select();
        $this->title = '编辑接口『'.$interfaceData['interface_name'].'』';  
		$this->display();
    }


    /**
     * api 说明文档删除接口
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function delInterface() {
        if (1 != cookie('isLogin')) {
            $this->redirect('Index/index');
        }
        $result = M('Interface')->where(array(
            'id' => I('get.id', '', 'htmlspecialchars,int')
        ))->setField('status', 2);
        $this->redirect('Index/index');
    }


    /**
     * api 说明文档添加接口处理
     * @param  具体参数参考数据库注释
     * @method POST/AJAX
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function addInterfaceAction(){
    	if (IS_POST) {
            // 接口数据 +
    		$interfaceData = array(
    			'cid' 	          => I('post.cid', '', 'htmlspecialchars,int'),
                'interface_code'  => I('post.num'),
    			'interface_name'  => I('post.name'),
    			'interface_detail'=> I('post.des'),
                'return_value'    => I('post.re'),
    			'interface_url'   => I('post.url'),
                'ext'             => I('post.memo'),
    			'create_time' 	  => date('Y-m-d H:i:s')
    		);
            D('Interface')->create($interfaceData);
            $result = D('Interface')->add($interfaceData);
            !$result && exit('提示：添加接口失败，请稍后重试');

            // 参数数据 ++
            $paramLen = count($_POST['p']['name']);
            for ($i = 0; $i < $paramLen; ++$i) { 
                $paramData = array();

                $paramData = array(
                    'iid'           => $result,
                    'param_name'    => $_POST['p']['name'][$i],
                    'param_detail'  => $_POST['p']['des'][$i],
                    'param_needs'   => $_POST['p']['type'][$i],
                    'param_type'    => $_POST['p']['mode'][$i],
                    'param_rank'    => $_POST['p']['order'][$i],
                    'create_time'   => date('Y-m-d H:i:s')
                );
                if(!$paramData['param_name']){
                    continue;
                }
                D('parameter')->create($paramData);
                D('parameter')->add($paramData);
            }
            
            // 返回值数据 +++
            $returnLen = count($_POST['r']['value']);
            for ($i = 0; $i < $returnLen; ++$i) { 
                $returnData = array();

                $returnData = array(
                    'iid'            => $result,
                    'return_name'    => $_POST['r']['value'][$i],
                    'return_detail'  => $_POST['r']['detail'][$i],
                    'return_rank'    => $_POST['r']['order'][$i],
                    'create_time'    => date('Y-m-d H:i:s')
                );
                if(!$returnData['return_name']){
                    continue;
                }
                D('return')->create($returnData);
                D('return')->add($returnData);
            }
            
            unset($interfaceData, $paramData, $returnData);
    		exit('success');
    	}
    }


    /**
     * api 说明文档添加接口处理
     * @method POST/AJAX
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function editInterfaceAction(){
        if (IS_POST) {
            // 接口数据 +
            $interfaceData = array(
                'id'              => I('post.id', '', 'htmlspecialchars,int'),
                'interface_code'  => I('post.num'),
                'interface_name'  => I('post.name'),
                'interface_detail'=> I('post.des'),
                'return_value'    => I('post.re'),
                'interface_url'   => I('post.url'),
                'ext'             => I('post.memo'),
                'lastupdate_time' => date('Y-m-d H:i:s')
            );
            D('Interface')->create($interfaceData);
            $result = D('Interface')->save($interfaceData);
            !$result && exit('提示：添加接口失败，请稍后重试');

            // 更新成功 + 更新版本号
            M('Interface')->where(array(
                'id' => I('post.id', '', 'htmlspecialchars,int')
            ))->setInc('version');

            // 参数数据 ++ 先清理 => 添加
            M('parameter')->where(array(
                'iid' => I('post.id', '', 'htmlspecialchars,int')))->delete();

            $paramLen = count($_POST['p']['name']);
            for ($i = 0; $i < $paramLen; ++$i) { 
                $paramData = array();

                $paramData = array(
                    'iid'           => I('post.id', '', 'htmlspecialchars,int'),
                    'param_name'    => $_POST['p']['name'][$i],
                    'param_detail'  => $_POST['p']['des'][$i],
                    'param_needs'   => $_POST['p']['type'][$i],
                    'param_type'    => $_POST['p']['mode'][$i],
                    'param_rank'    => $_POST['p']['order'][$i],
                    'create_time'   => date('Y-m-d H:i:s')
                );
                if(!$paramData['param_name']){
                    continue;
                }
                D('parameter')->create($paramData);
                D('parameter')->add($paramData);
            }

            // 返回值数据 +++
            M('return')->where(array(
                'iid' => I('post.id', '', 'htmlspecialchars,int')))->delete();

            $returnLen = count($_POST['r']['value']);
            for ($i = 0; $i < $returnLen; ++$i) { 
                $returnData = array();

                $returnData = array(
                    'iid'            => I('post.id', '', 'htmlspecialchars,int'),
                    'return_name'    => $_POST['r']['value'][$i],
                    'return_detail'  => $_POST['r']['detail'][$i],
                    'return_rank'    => $_POST['r']['order'][$i],
                    'create_time'    => date('Y-m-d H:i:s')
                );
                if(!$returnData['return_name']){
                    continue;
                }
                D('return')->create($returnData);
                D('return')->add($returnData);
            }

            unset($interfaceData, $paramData, $returnData);
            exit('success');
        }
    }

    
}