<?php

namespace Zx\Weather;

class Curl
{
    public static function curl($url,$postStr='',$header=''){
        if(!extension_loaded('curl')) exit('系统没有扩展php_curl.dll,出错了。');
        $ch = curl_init();
        if($header){
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        }
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_TIMEOUT,30);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

        if(!empty($postStr)){//post传递
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$postStr);
        }
        $str = curl_exec($ch);
        $err = curl_error($ch);

        if (false === $str || !empty($err))
        {
            $errno = curl_errno($ch);
            curl_close($ch);
            return 'Errno:'.$errno.';ErrInfo:'.$err;
        }else{
            curl_close($ch);
            return trim($str);
        }
    }
}
