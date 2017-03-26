<?php
/**
 * Description: 变量值验证器接口
 * User: jessehu
 * Date: 2017/3/26 下午7:06
 */

namespace Jessehu\Component\Validator;


interface ValidatorInterface
{
    public static function createValidator();
    
    public function validate($value, $constraints, $logic);
}