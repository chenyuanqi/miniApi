<?php

namespace Home\Controller;


use Think\Controller;

class CategoryController extends CommonController {
    /**
     * api 说明文档添加分类
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function addCategory(){

        $this->title = '新增分类';
		$this->display();
    }


    /**
     * api 说明文档编辑分类 (数据简单过滤 | 永远不要相信用户输入)
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function editCategory(){

        $category = M('category')->find(I('get.id', '', 'htmlspecialchars,int'));

        !$category && $this->redirect('Index/index');
        $this->category = $category;
        $this->title    = '编辑分类『'.$category['title'].'』';        
		$this->display();
    }


    /**
     * api 说明文档删除分类 (数据简单过滤 | 永远不要相信用户输入)
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function delCategory() {
        if (1 != cookie('isLogin')) {
            $this->redirect('Index/index');
        }
        $result = M('category')->where(array(
            'id' => I('get.id', '', 'htmlspecialchars,int')
        ))->setField('status', 2);
    }


    /**
     * api 说明文档添加分类处理 (数据简单过滤 | 永远不要相信用户输入)
     * @method POST/AJAX
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function addCategoryAction(){
    	if (IS_POST) {
    		$cateData = array(
    			'create_uid' 	=> cookie('aid'),
    			'title' 		=> I('post.cname'),
    			'detail'		=> I('post.cdesc'),
    			'rank' 			=> I('post.order', '', 'htmlspecialchars,int'),
    			'status' 		=> I('post.display', '', 'htmlspecialchars,int') ==1 ?: 2,
    			'create_time' 	=> date('Y-m-d H:i:s')
    		);
    		$result = M('category')->add($cateData);

            unset($cateData);
    		!$result && exit('提示：添加分类失败，请稍后重试');
    		exit('success');
    	}
    }


    /**
     * api 说明文档添加分类处理 (数据简单过滤 | 永远不要相信用户输入)
     * @method POST/AJAX
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function editCategoryAction(){
        if (IS_POST) {
            $cateData = array(
                'id'            => I('post.id', '', 'htmlspecialchars,int'),
                'title'         => I('post.cname'),
                'detail'        => I('post.cdesc'),
                'rank'          => I('post.order', '', 'htmlspecialchars,int'),
                'status'        => I('post.display', '', 'htmlspecialchars,int') ==1 ?: 2
            );
            $result = M('category')->save($cateData);

            unset($cateData);
            !$result && exit('提示：编辑分类失败，请稍后重试');
            exit('success');
        }
    }

    
}