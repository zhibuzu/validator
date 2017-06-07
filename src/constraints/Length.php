<?php
/**
 * Decription: 字符串长度约束
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/06/07 上午 10:52
 * Project: validator
 */

namespace Jessehu\Component\Validator\Contraints;

use Jessehu\Component\Validator\VariableTypeValidator;
use Jessehu\Component\Validator\Exceptions\ValidatorException;
use Jessehu\Component\Validator\Exceptions\InvalidArgumentException;

class Length implements ContraintInterface
{
    private $value;

    private $code = 'LENGTH';

    private $message = '字符串长度不正确';

    private $options = array();

    public function __construct($message = '', array $options = array())
    {
        if (is_array($message) || (is_object($message) && !method_exists($message, '__toString'))) {
            throw new InvalidArgumentException(__NAMESPACE__ . '/Length::__construct accepts argument <message> must be a string or an object with a __toString method.');
        }

        $this->message = $message ? (string)$message : $this->message;
        $this->options = $options;
    }

    /**
     * @param string $value 仅接收一个字符串或一个带__toString方法的对象
     * @return $this
     */
    public function setValue($value)
    {
        if (is_array($value) || (is_object($value) && !method_exists($value, '__toString'))) {
            throw new InvalidArgumentException(__NAMESPACE__ . '/Length::setValue accepts argument <value> must be a string or an object with a __toString method.');
        }

        $this->value = (string)$value;

        return $this;
    }

    public function validate()
    {
        $len = mb_strlen($this->value);
        if (isset($this->options['min']) && $len < (int)$this->options['min']) {
            throw new ValidatorException($this->message, $this->code);
        }

        if (isset($this->options['max']) && $len > (int)$this->options['max']) {
            throw new ValidatorException($this->message, $this->code);
        }

        return true;
    }
}
