<?php
/**
 * Description: 参数类型验证器接口
 * User: jessehu
 * Date: 2017/3/26 下午7:14
 */

namespace Jessehu\Component\Validator;


interface VariableTypeValidatorInterface
{
    public static function createValidator();

    public function validate($validateParams);
}