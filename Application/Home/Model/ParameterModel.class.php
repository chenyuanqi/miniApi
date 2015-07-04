<?php
namespace Home\Model;
use Think\Model;

class ParameterModel extends Model {
    protected $_validate = array(
    	array("iid", 				"require", "所属接口 ID 不能为空"), 
    	array("iid", 				"number",  "接口 ID 必须为数值型"), 
    	array("param_name", 		"require", "参数名称不能为空")
    );
}