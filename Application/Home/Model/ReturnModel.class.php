<?php
namespace Home\Model;
use Think\Model;

class ReturnModel extends Model {
    protected $_validate = array(
    	array("iid", 				"require", "所属接口 ID 不能为空"),
    	array("iid", 				"number",  "接口 ID 必须为数值型"), 
    	array("return_name", 		"require", "返回值名称不能为空"),
    	array("return_detail", 		"require", "返回值说明不能为空")
    );
}