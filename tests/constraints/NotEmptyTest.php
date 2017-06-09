<?php

/**
 * Decription:
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/06/08 下午 6:30
 * Project: validator
 */
require dirname(__DIR__) . '/../src/constraints/NotEmpty.php';

class NotEmptyTest extends PHPUnit_Framework_TestCase
{
    public function testValidatorException()
    {
        $notEmpty = new \Jessehu\Component\Validator\Contraints\NotEmpty('该值不能为空');

        $notEmpty->setValue('');
        $this->assertEquals(new \Jessehu\Component\Validator\Exceptions\ValidatorException('该值不能为空', 'NOT-EMPTY'), $notEmpty->validate());
    }

    public function testValidate()
    {
        $notEmpty = new \Jessehu\Component\Validator\Contraints\NotEmpty('该值不能为空');

        $values = array(
            '1',
            ' ',
            1,
            array(0)
        );

        foreach ($values as $value) {
            $notEmpty->setValue($value);
            $this->assertTrue($notEmpty->validate());
        }
    }
}
