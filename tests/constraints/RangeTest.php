<?php

/**
 * Decription:
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/06/09 上午 10:26
 * Project: validator
 */
require dirname(__DIR__) . '/../src/constraints/Range.php';

class RangeTest extends PHPUnit_Framework_TestCase
{

    public function testSetValue()
    {
        $range = new \Jessehu\Component\Validator\Contraints\Range('数值大小范围为{min}-{max}', ['min' => 1.5, 'max' => 8.5]);
        $range->setValue(1.9);
        $this->assertAttributeEquals(1.9, 'value', $range);
    }

    public function testValidate()
    {
        $range = new \Jessehu\Component\Validator\Contraints\Range('数值大小范围为{min}-{max}', ['min' => 1.5, 'max' => 8.5]);
        $range->setValue(1.9);
        $this->assertTrue($range->validate());

        $range->setValue(9.9);
        $this->assertEquals(new \Jessehu\Component\Validator\Exceptions\ValidatorException('数值大小范围为1.5-8.5', 'RANGE'), $range->validate());

        $range->setValue('9.0');
        $this->assertEquals(new \Jessehu\Component\Validator\Exceptions\ValidatorException('数值大小范围为1.5-8.5', 'RANGE'), $range->validate());


        $range = new \Jessehu\Component\Validator\Contraints\Range('数值大小范围为{min}', ['min' => 1.5]);
        $range->setValue(1.9);
        $this->assertTrue($range->validate());
    }
}
