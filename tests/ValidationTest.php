<?php

/**
 * Decription:
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/06/08 上午 8:51
 * Project: validator
 */
require dirname(__DIR__) . '/src/Validation.php';

class ValidationTest extends PHPUnit_Framework_TestCase
{
    public function testCreateValidator()
    {
        $validator = new Jessehu\Component\Validator\Validation();

        $this->assertEquals($validator, \Jessehu\Component\Validator\Validation::createValidator());
    }

    /**
     * @expectedException \Jessehu\Component\Validator\Exceptions\InvalidArgumentException
     */
    public function testInvalidArgumentValidateConstraint()
    {
        $value = '123';
        $baseValue = '123';
        $constraint = array();

        $validator = \Jessehu\Component\Validator\Validation::createValidator();
        $validator->validateConstraint($value, $constraint);

        $validator = \Jessehu\Component\Validator\Validation::createValidator();
        $validator->validateConstraint($value, '');
    }

    /**
     * 测试自定义约束
     */
    public function testCustomConstraint()
    {
        $values = [
            '123',
            123
        ];
        $baseValue = '123';
        $constraint = function ($value) use ($baseValue) {
            if ($baseValue != $value) {
                return 'two value should be same!';
            }

            return true;
        };

        $validator = \Jessehu\Component\Validator\Validation::createValidator();

        foreach ($values as $value) {
            $this->assertTrue($validator->validateConstraint($value, $constraint));
        }
    }

    /**
     * 测试Length约束
     */
    public function testLength()
    {
        $validator = \Jessehu\Component\Validator\Validation::createValidator();

        // test1
        $violations = $validator->validate('123456789', array(
            new \Jessehu\Component\Validator\Contraints\Length('正确的字符串长度应为{min}-{max}之间', ['min' => 1, 'max' => 10])
        ));
        $this->assertEquals(0, count($violations));

        // test2
        $violations = $validator->validate('123456789', array(
            new \Jessehu\Component\Validator\Contraints\Length('正确的字符串长度最大应为{max}', ['max' => 9])
        ));
        $this->assertEquals(0, count($violations));

        // test3
        $violations = $validator->validate('123456789', array(
            new \Jessehu\Component\Validator\Contraints\Length('正确的字符串长度最大应为{max}', ['max' => 8])
        ));
        $this->assertEquals(1, count($violations));
        $this->assertEquals('正确的字符串长度最大应为8', $violations[0]->getMessage());

        // test3
        $violations = $validator->validate('123456789', array(
            new \Jessehu\Component\Validator\Contraints\Length('正确的字符串长度最小应为{min}', ['min' => 10])
        ));
        $this->assertEquals(1, count($violations));
        $this->assertEquals('正确的字符串长度最小应为10', $violations[0]->getMessage());
    }

    /**
     * 测试Range约束
     */
    public function testRange()
    {
        $validator = \Jessehu\Component\Validator\Validation::createValidator();

        // test1
        $violations = $validator->validate(1.7, array(
            new \Jessehu\Component\Validator\Contraints\Range('数值大小范围为{min}-{max}', ['min' => 1.5, 'max' => 8.5])
        ));
        $this->assertEquals(0, count($violations));

        // test2
        $violations = $validator->validate(10, array(
            new \Jessehu\Component\Validator\Contraints\Range('数值大小范围为{min}-{max}', ['min' => 1.5, 'max' => 8.5])
        ));
        $this->assertEquals(1, count($violations));
        $this->assertEquals('数值大小范围为1.5-8.5', $violations[0]->getMessage());
    }
}
