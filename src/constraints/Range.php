<?php
/**
 * Decription: 数值大小范围约束
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/06/09 上午 9:09
 * Project: validator
 */

namespace Jessehu\Component\Validator\Contraints;

use Jessehu\Component\Validator\VariableTypeValidator;
use Jessehu\Component\Validator\Exceptions\ValidatorException;
use Jessehu\Component\Validator\Exceptions\InvalidArgumentException;

class Range implements ContraintInterface
{
    private $value;

    private $code = 'RANGE';

    private $message = '数值大小范围不正确';

    private $options = array();

    public function __construct($message = '', array $options = array())
    {
        if (is_array($message) || (is_object($message) && !method_exists($message, '__toString'))) {
            throw new InvalidArgumentException(__CLASS__ . '::__construct accepts argument <message> must be a string or an object with a __toString method.');
        }

        $this->message = $message ? (string)$message : $this->message;
        $this->options = $options;

        // 消息可包括占位符，只能使用第二个参数$options中存在的元素替换
        $this->message = $this->interpolate($this->message, $options);
    }

    /**
     * Interpolates options values into the message placeholders.
     * @param string $message
     * @param array $options
     * @return string $message
     */
    protected function interpolate($message, array $options = array())
    {
        $replace = array();
        foreach ($options as $key => $option) {
            if (!is_array($option) && (!is_object($option) || method_exists($option, '__toString'))) {
                $replace['{' . $key . '}'] = $option;
            }
        }

        return strtr($message, $replace);
    }

    /**
     * @param string $value 仅接收一个数字或数字字符串
     * @return $this
     */
    public function setValue($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(__CLASS__ . '::setValue accepts argument <value> must be a numeric.');
        }

        $this->value = (float)$value;

        return $this;
    }

    public function validate()
    {
        if (isset($this->options['min']) && $this->value < (float)$this->options['min']) {
            return new ValidatorException($this->message, $this->code);
        }

        if (isset($this->options['max']) && $this->value > (float)$this->options['max']) {
            return new ValidatorException($this->message, $this->code);
        }

        return true;
    }
}
