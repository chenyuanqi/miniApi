<?php

/**
 * PHPMail 扩展配置文件
 *
 * @author debmzhang <debmzhang@gmail.com>
 * @create 2014-11-27 17:45
 * @version $Id$
 * 文件包括Vendor/PHPMailer、Custom/Email及目前的email.php, +Common/conf/config.php
 */

return array(
    // 基础配置
    // 这里需要配置SMTP服务器, 使用发件邮箱的SMTP服务器地址, 如163为 smtp.163.com, qq: smtp.exmail.qq.com
    'HOST' => 'smtp.exmail.qq.com',
    'PORT' => 25,
    'CHAR_SET' => 'utf-8',
    'SMTP_DEBUG' => 0,
    'SMTP_AUTH' => FALSE, //邮箱认证
    // 'HRML' => TRUE, //HTML格式 false => TXT格式
	
    // 发件邮箱地址
    'SEND_ADDRESS' => 'info@dadazu.com',
	'USERNAME'	=>	'info@dadazu.com',
    // 发件邮箱密码
    'SEND_PASSWORD' => 'abc123456789,',
    // 设置发送人名称
    'SET_FROM' => '五星体育运动网站 Five-Star Sports Website',
    // 是否有抄送
    'OPEN_CC' => TRUE,
    // 抄送地址
    'CC_ADDRESS' => array(
        '908379294@qq.com',
    ),
);
