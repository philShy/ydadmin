<?php  
/** 
 * RSA�㷨�� 
 * ǩ�������ı��룺base64�ַ���/ʮ�������ַ���/�������ַ����� 
 * ��䷽ʽ: PKCS1Padding���ӽ��ܣ�/NOPadding�����ܣ� 
 * 
 * Notice:Only accepts a single block. Block size is equal to the RSA key size!  
 * ����Կ����Ϊ1024 bit�������ʱ������С��128�ֽڣ�����PKCS1Padding�����11�ֽ���Ϣ������������С��117�ֽ� 
 * 
 * @author: linvo 
 * @version: 1.0.0 
 * @date: 2013/1/23 
 */  
class Rsa{  

    private $pubKey = null;  
    private $priKey = null;  

    /** 
     * �Զ�������� 
     */  
    private function _error($msg){  
        die('RSA Error:' . $msg); //TODO  
    }  

    /** 
     * ���캯�� 
     * 
     * @param string ��Կ�ļ�����ǩ�ͼ���ʱ���룩 
     * @param string ˽Կ�ļ���ǩ���ͽ���ʱ���룩 
     */  
    public function __construct($public_key_file = '', $private_key_file = ''){  
        if ($public_key_file){  
            $this->_getPublicKey($public_key_file);  
        }  
        if ($private_key_file){  
            $this->_getPrivateKey($private_key_file);  
        }  
    }  

    /** 
     * ����ǩ�� 
     * 
     * @param string ǩ������ 
     * @param string ǩ�����루base64/hex/bin�� 
     * @return ǩ��ֵ 
     */  
    public function sign($data, $code = 'base64'){  
        $ret = false;  
        if (openssl_sign($data, $ret, $this->priKey)){  
            $ret = $this->_encode($ret, $code);  
        }  
        return $ret;  
    }  

    /** 
     * ��֤ǩ�� 
     * 
     * @param string ǩ������ 
     * @param string ǩ��ֵ 
     * @param string ǩ�����루base64/hex/bin�� 
     * @return bool  
     */  
    public function verify($data, $sign, $code = 'base64'){  
        $ret = false;      
        $sign = $this->_decode($sign, $code);  
        if ($sign !== false) {  
            switch (openssl_verify($data, $sign, $this->pubKey)){  
                case 1: $ret = true; break;      
                case 0:      
                case -1:       
                default: $ret = false;       
            }  
        }  
        return $ret;  
    }  

    /** 
     * ���� 
     * 
     * @param string ���� 
     * @param string ���ı��루base64/hex/bin�� 
     * @param int ��䷽ʽ��ò��php��bug������Ŀǰ��֧��OPENSSL_PKCS1_PADDING�� 
     * @return string ���� 
     */  
    public function encrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING){  
        $ret = false;      
        if (!$this->_checkPadding($padding, 'en')) $this->_error('padding error');  
        if (openssl_public_encrypt($data, $result, $this->pubKey, $padding)){  
            $ret = $this->_encode($result, $code);  
        }  
        return $ret;  
    }  

    /** 
     * ���� 
     * 
     * @param string ���� 
     * @param string ���ı��루base64/hex/bin�� 
     * @param int ��䷽ʽ��OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING�� 
     * @param bool �Ƿ�ת���ģ�When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block�� 
     * @return string ���� 
     */  
    public function decrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false){  
        $ret = false;  
        $data = $this->_decode($data, $code);  
        if (!$this->_checkPadding($padding, 'de')) $this->_error('padding error');  
        if ($data !== false){  
            if (openssl_private_decrypt($data, $result, $this->priKey, $padding)){  
                $ret = $rev ? rtrim(strrev($result), "\0") : ''.$result;  
            }   
        }  
        return $ret;  
    }  

    // ˽�з���  

    /** 
     * ���������� 
     * ����ֻ֧��PKCS1_PADDING 
     * ����֧��PKCS1_PADDING��NO_PADDING 
     *  
     * @param int ���ģʽ 
     * @param string ����en/����de 
     * @return bool 
     */  
    private function _checkPadding($padding, $type){  
        if ($type == 'en'){  
            switch ($padding){  
                case OPENSSL_PKCS1_PADDING:  
                    $ret = true;  
                    break;  
                default:  
                    $ret = false;  
            }  
        } else {  
            switch ($padding){  
                case OPENSSL_PKCS1_PADDING:  
                case OPENSSL_NO_PADDING:  
                    $ret = true;  
                    break;  
                default:  
                    $ret = false;  
            }  
        }  
        return $ret;  
    }  

    private function _encode($data, $code){  
        switch (strtolower($code)){  
            case 'base64':  
                $data = base64_encode(''.$data);  
                break;  
            case 'hex':  
                $data = bin2hex($data);  
                break;  
            case 'bin':  
            default:  
        }  
        return $data;  
    }  

    private function _decode($data, $code){  
        switch (strtolower($code)){  
            case 'base64':  
                $data = base64_decode($data);  
                break;  
            case 'hex':  
                $data = $this->_hex2bin($data);  
                break;  
            case 'bin':  
            default:  
        }  
        return $data;  
    }  

    private function _getPublicKey($file){  
        $key_content = $this->_readFile($file);  
        if ($key_content){  
            $this->pubKey = openssl_get_publickey($key_content);  
        }  
    }  

    private function _getPrivateKey($file){  
        $key_content = $this->_readFile($file);  
        if ($key_content){  
            $this->priKey = openssl_get_privatekey($key_content);  
        }  
    }  

    private function _readFile($file){  
        $ret = false;  
        if (!file_exists($file)){  
            $this->_error("The file {$file} is not exists");  
        } else {  
            $ret = file_get_contents($file);  
        }  
        return $ret;  
    }  

    private function _hex2bin($hex = false){  
        $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;      
        return $ret;  
    }  

}  