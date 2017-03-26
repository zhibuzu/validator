<?php
/**
 * Description: 定义约束对象要实现验证方法
 * User: jessehu
 * Date: 2017/3/26 上午11:44
 */

namespace Jessehu\Component\Validator\Contraints;


interface ContraintInterface
{
    // 设置验证值
    public function setValue($value);

    // 验证方法
    public function validate();
}