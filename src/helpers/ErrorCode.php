<?php
/**
 * User: fish
 * Date: 2016-08-04 01:02
 * ErrorCode.php
 */

namespace okfish\lib\helpers;
class ErrorCode {
    const SUCCESS  = 0;
    const FORM     = -1;//表单验证错误
    const LOGIC    = -2;//逻辑验证错误
    const DB       = -3;//数据库验证错误
    const API      = -4;//api接口错误
}