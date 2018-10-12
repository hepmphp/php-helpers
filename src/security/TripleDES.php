<?php
/**
 * Created by JetBrains PhpStorm.
 * User: T171
 * Date: 16-10-10
 * Time: 上午10:57
 * To change this template use File | Settings | File Templates.
 */

namespace okfish\lib\security;
/**
 * Class TripleDES  3DES 加解密类, 可与java的3DES(DESede)加密方式兼容
 * Class TripleDES
 * @package Hepm\Security
 */
Class TripleDES {
    /**
     * @desc   加密
     *
     * @param  string $input 明文
     * @param  string $key   8个字符串
     * @param  string $iv    8个字符串
     * @return string
     */
    public function encrypt($input, $key, $iv) {
        $input = $this->__paddingPKCS7($input);
        $td    = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
        //使用MCRYPT_3DES算法,cbc模式
        mcrypt_generic_init($td, $key, $iv);
        //初始处理
        $data = mcrypt_generic($td, $input);
        //加密
        mcrypt_generic_deinit($td);
        //结束
        mcrypt_module_close($td);
        $data = $this->__removeBR(base64_encode($data));
        return $data;
    }
    /**
     * @desc   解密
     *
     * @param  string $encrypted 密文
     * @param  string $key       8个字符串
     * @param  string $iv        8个字符串
     * @return string
     */
    public function decrypt($encrypted, $key, $iv) {
        $encrypted = base64_decode($encrypted);
        $td        = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
        //使用MCRYPT_3DES算法,cbc模式
        mcrypt_generic_init($td, $key, $iv);
        //初始处理
        $decrypted = mdecrypt_generic($td, $encrypted);
        //解密
        mcrypt_generic_deinit($td);
        //结束
        mcrypt_module_close($td);
        $decrypted = $this->__unPaddingPKCS7($decrypted);
        return $decrypted;
    }
    /**
     * @des    填充密码，PKCS7填充
     * @param  string $data
     * @return string
     */
    private function __paddingPKCS7($data) {
        $block_size   = mcrypt_get_block_size('tripledes', 'cbc');
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }
    /**
     * @desc   删除填充符
     * @param  string $text
     * @return bool|string
     */
    private function __unPaddingPKCS7($text) {
        $pad = ord($text{strlen($text) - 1});
        if ( $pad > strlen($text) ) {
            return false;
        }
        // if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
        //     return false;
        // }
        return substr($text, 0, - 1 * $pad);
    }
    /**
     * @desc   删除回车和换行
     * @param  string $str
     * @return string
     */
    private function __removeBR($str) {
        $len     = strlen($str);
        $rebuild = "";
        $str     = str_split($str);
        for ( $i = 0; $i < $len; $i ++ )
            if ( $str[$i] != '\n' and $str[$i] != '\r' )
                $rebuild .= $str[$i];
        return $rebuild;
    }
}
