<?php

/**
 * Decription: 字符串长度约束类测试用例
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/06/07 下午 4:10
 * Project: validator
 */
require dirname(__DIR__) . '/../src/constraints/Length.php';

class LengthTest extends PHPUnit_Framework_TestCase
{
    public function testSetsMessageWithConstruct()
    {
        $message = '字符串长度与预期不符哦';
        $options = ['min' => 1, 'max' => 10];
        $lengthConstraint = new \Jessehu\Component\Validator\Contraints\Length($message, $options);
        $this->assertAttributeEquals($message, 'message', $lengthConstraint);
    }

    /**
     * 测试传入Length类构造函数的参数
     * @expectedException  Jessehu\Component\Validator\Exceptions\InvalidArgumentException
     */
    public function testInvalidArgumentExceptionWithConstruct()
    {
        $message = ['字符串长度与预期不符哦'];
        $options = ['min' => 1, 'max' => 10];
        new \Jessehu\Component\Validator\Contraints\Length($message, $options);
    }

    public function testInterpolate()
    {
        $lengthConstraint = new \Jessehu\Component\Validator\Contraints\Length('字符串长度必须为{min}至{max}之间', ['min' => 3, 'max' => 10]);

        $reflectionClass = new ReflectionClass(\Jessehu\Component\Validator\Contraints\Length::class);
        $reflectObj = $reflectionClass->getProperty('message');
        $reflectObj->setAccessible(true);
        $message = $reflectObj->getValue($lengthConstraint);
        $this->assertEquals('字符串长度必须为3至10之间', $message);
    }

    /**
     * test setValue method
     */
    public function testSetValue()
    {
        $message = '字符串长度与预期不符哦';
        $options = ['min' => 1, 'max' => 10];
        $lengthConstraint = new \Jessehu\Component\Validator\Contraints\Length($message, $options);
        $lengthConstraint->setValue('a1胡,.， 】');
        $this->assertAttributeEquals('a1胡,.， 】', 'value', $lengthConstraint);
    }

    /**
     * 验证错误
     */
    public function testValidatorException()
    {
        $message = '字符串长度与预期不符哦';
        $options = ['min' => 1, 'max' => 10];
        $value = 'a1胡,.， 】ui1';  // length = 11

        $lengthConstraint = new \Jessehu\Component\Validator\Contraints\Length($message, $options);
        $lengthConstraint->setValue($value);
        $this->assertEquals(new \Jessehu\Component\Validator\Exceptions\ValidatorException($message, 'LENGTH'), $lengthConstraint->validate());
    }

    /**
     * 验证正确
     */
    public function testValidate()
    {
        $message = '字符串长度与预期不符哦';
        $options = ['min' => 1, 'max' => 10];

        $lengthConstraint = new \Jessehu\Component\Validator\Contraints\Length($message, $options);
        $lengthConstraint->setValue('a1胡,.， 】ui');
        $this->assertEquals(true, $lengthConstraint->validate());

        $lengthConstraint->setValue('1234567890');
        $this->assertEquals(true, $lengthConstraint->validate());

        $lengthConstraint->setValue(' ');
        $this->assertEquals(true, $lengthConstraint->validate());
    }
}
