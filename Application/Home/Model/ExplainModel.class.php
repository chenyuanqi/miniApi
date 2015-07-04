<?php

namespace Api\Model;

use Think\Model\RelationModel;

class ExplainModel extends RelationModel {
	protected $_link = array(
		'parameter' =>array(
			'mapping_type'  => self::HAS_MANY,
		    'foreign_key'   => 'uid',
		    'mapping_name'  => 'par',
			'mapping_order' => 'create_time desc',
		),
			
		'return_value' => array(
		    'mapping_type'  => self::HAS_MANY,
		    'foreign_key'   => 'uid',
		    'mapping_name'  => 'ret',
			'mapping_order'	=> 'create_time desc'
   		 )

			
	);

	
	
	
	
		
}