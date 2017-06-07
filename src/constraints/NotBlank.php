<?php
/**
 * Description: 非空约束
 * User: jessehu
 * Date: 2017/3/26 上午10:55
 */

namespace Jessehu\Component\Validator\Contraints;

use Jessehu\Component\Validator\VariableTypeValidator;
use Jessehu\Component\Validator\Exceptions\ValidatorException;
use Jessehu\Component\Validator\Exceptions\InvalidArgumentException;

class NotBlank implements ContraintInterface
{

    private $value;

    private $code = 'NOT-BLANK';

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
        if ('' === $this->value || null === $this->value) {
            return new ValidatorException($this->message, $this->code);
        }

        return true;
    }
}
