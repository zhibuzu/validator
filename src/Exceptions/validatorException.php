<?php
/**
 * Description:
 * User: jessehu
 * Date: 2017/3/26 下午12:24
 */

namespace Jessehu\Component\Validator\Exceptions;


class ValidatorException extends RuntimeException
{
    protected $codes = '0';

    public function __construct($message, $code = '0', \RuntimeException $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->codes = $code;
    }

    public function getCodes()
    {
        return $this->codes;
    }
}