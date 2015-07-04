<?php

/**
 * 基于 PHPMailer 的邮件扩展
 *
 * @author debmzhang <debmzhang@gmail.com>
 * @create 2014-11-27 12:12
 * @version $Id$
 */

namespace Custom\Email;
vendor('PHPMailer.PHPMailerAutoload');

class Email {

    public function send($to = '908379294@qq.com', $subject = '这是测试标题', $body = '这是测试内容', $cc = false){
        $host = C('HOST');
        $port = C('PORT');
        $charSet = C('CHAR_SET');
        $smtpDebug = C('SMTP_DEBUG');
        $smtpAuth = C('SMTP_AUTH');

        $username = C('USERNAME');
        $mailfrom = C('SEND_ADDRESS');
        $password = C('SEND_PASSWORD');
        $setFrom = C('SET_FROM');
        $openCc = C('OPEN_CC');

        if($openCc){
            if(!$cc || !is_array($cc)){
                $cc = C('CC_ADDRESS');
            }
        }

        $mail = new \PHPMailer;

        $mail->isSMTP();
        $mail->SMTPDebug = $smtpDebug;
        $mail->CharSet = $charSet;
        $mail->Host = $host;
        $mail->Port = $port;
        $mail->SMTPAuth = $smtpAuth;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->setFrom($mailfrom, $setFrom);
        $mail->addReplyTo($to, $to);
        $mail->addAddress($to, $to);

        if(is_array($cc) && $openCc){
            foreach($cc as $val){
                $mail->AddCC($val);
            }
        }

        $mail->Subject = $subject;
        $mail->msgHTML($body);

        return $mail->send();
    }

}
