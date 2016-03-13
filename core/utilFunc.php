<?php
	/**
     * 解密
     *
     * @param string $encryptedText 已加密字符串
     * @param string $key  密钥
     * @return string
     */
    function _decrypt($encryptedText,$key = null)
    {
        $key = $key === null ? _configValue('secret_key') : $key;
        $cryptText = base64_decode($encryptedText);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
        return trim($decryptText);
    }
 
    /**
     * 加密
     *
     * @param string $plainText 未加密字符串
     * @param string $key        密钥
     */
    function _encrypt($plainText,$key = null)
    {
        $key = $key === null ? _configValue('secret_key') : $key;
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
        return trim(base64_encode($encryptText));
    }

    function getRealIpAddr()  
    {  
    	if (!empty($_SERVER['HTTP_CLIENT_IP']))  
    	{  
    		$ip=$_SERVER['HTTP_CLIENT_IP'];  
    	}  
    	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
	    //to check ip is pass from proxy  
    	{  
    		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
    	}  
    	else  
    	{  
    		$ip=$_SERVER['REMOTE_ADDR'];  
    	}  
    	return $ip;  
    }
