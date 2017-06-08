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

    public function testValidateConstraint()
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
            $this->assertEquals(true, $validator->validateConstraint($value, $constraint));
        }
    }
}
