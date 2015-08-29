<?php

namespace Api\Model;


use Think\Model;

class CategoryModel extends Model {
    protected $_validate = array(
    	array("create_uid", "require", "创建者不能为空"), 
    	array("create_uid", "number",  "创建者 ID 必须为数值型"), 
    	array("title", 		"require", "分类名称不能为空"), 
    	array("detail", 	"require", "分类描述不能为空")
    );
}