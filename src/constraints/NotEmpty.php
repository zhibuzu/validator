<?php
/**
 * Decription: 非空：当一个变量并不存在，或者它的值等同于FALSE，注意与NotBlank的区别
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/06/08 下午 5:44
 * Project: validator
 */

namespace Jessehu\Component\Validator\Contraints;

use Jessehu\Component\Validator\VariableTypeValidator;
use Jessehu\Component\Validator\Exceptions\ValidatorException;
use Jessehu\Component\Validator\Exceptions\InvalidArgumentException;

class NotEmpty implements ContraintInterface
{
    private $value;

    private $code = 'NOT-EMPTY';

    private $message = '这个值不能为空';

    public function __construct($message = '')
    {
        if (is_array($message) || (is_object($message) && !method_exists($message, '__toString'))) {
            throw new InvalidArgumentException(__NAMESPACE__ . '/Length::__construct accepts argument <message> must be a string or an object with a __toString method.');
        }

        $this->message = $message ? (string)$message : $this->message;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function validate()
    {
        if (empty($this->value)) {
            return new ValidatorException($this->message, $this->code);
        }

        return true;
    }
}
