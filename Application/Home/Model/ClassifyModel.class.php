<?php

namespace Api\Model;

use Think\Model\RelationModel;

class ClassifyModel extends RelationModel {
	protected $_link = array(
		'explain' =>array(
			'mapping_type'  => self::HAS_MANY,
		    'foreign_key'   => 'uid',
		    'mapping_name'  => 'explain',
			'mapping_fields'=> 'id,title',
		),
			
	);

	
	
	
	
		
}