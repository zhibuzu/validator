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
        $len = mb_strlen($this->value, 'utf-8');
        if (isset($this->options['min']) && $len < (int)$this->options['min']) {
            return new ValidatorException($this->message, $this->code);
        }

        if (isset($this->options['max']) && $len > (int)$this->options['max']) {
            return new ValidatorException($this->message, $this->code);
        }

        return true;
    }
}
