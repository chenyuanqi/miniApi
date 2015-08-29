<?php

namespace Api\Model;


use Think\Model;

class InterfaceModel extends Model {
    protected $_validate = array(
    	array("cid", 					"require", "分类 ID 不能为空"),
    	array("cid", 					"number",  "分类 ID 必须为数值型"),  
    	array("interface_code", 		"require", "接口编号不能为空"), 
    	array("interface_name", 		"require", "接口名称不能为空"),
    	array("interface_detail", 		"require", "接口描述不能为空"),
    	array("interface_url", 			"require", "接口 URL 不能为空"),
    	array("return_value", 			"require", "接口返回值不能为空")
    );
}