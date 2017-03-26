<?php
/**
 * Description: 非空约束
 * User: jessehu
 * Date: 2017/3/26 上午10:55
 */

namespace Jessehu\Component\Validator\Contraints;

use Jessehu\Component\Validator\VariableTypeValidator;

use Jessehu\Component\Validator\Exceptions\ValidatorException;

class NotBlank implements ContraintInterface
{

    private $value;

    private $code = 'NOT-BLANK';

    private $message = '这个值不能为空';

    public function __construct($message = '')
    {
        $validator = VariableTypeValidator::createValidator();
        $violations = $validator->validate(array(
            'message' => array('is_string', $message)
        ));

        if (0 !== count($violations)) {
            throw new \InvalidArgumentException(__NAMESPACE__ . '\NotBlank::__construct accepts argument <message> must be a string.');
        }
        
        $this->message = $message ?: $this->message;
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