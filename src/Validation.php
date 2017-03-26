<?php
/**
 * Decription: 数据验证类，对客户端设置的验证配置项进行相应验证
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/03/06 上午 9:12
 * Project: fookii-validate
 */

namespace Jessehu\Component\Validator;

use Jessehu\Component\Validator\Contraints as Assert;

use Jessehu\Component\Validator\Exceptions as Exceptions;

class Validation implements ValidatorInterface
{
    // 验证目标变量为成功使用的逻辑
    // 逻辑AND：变量需满足指定的全部约束即为验证成功
    const LOGIN_AND = 1;

    // 逻辑OR：除非变量不满足所有的约束，否则即为验证成功
    const LOGIN_OR = 2;

    private static $validator = null;

    public function __construct()
    {
    }

    /**
     * 返回验证器单例
     * @return null|static
     */
    public static function createValidator()
    {
        if (!(self::$validator instanceof self)) {
            self::$validator = new static();
        }

        return self::$validator;
    }

    /**
     * 验证值是否满足约束
     * @param  string $value        要验证的值
     * @param  array   $constraints  约束数组
     * @param int $logic        判定验证结果对多个约束间需满足对逻辑
     * @return array
     */
    public function validate($value, $constraints, $logic = Validation::LOGIN_AND)
    {
        // 验证不合约束的数组
        $violations = array();

        if (!is_array($constraints)) {
            $constraints = array($constraints);
        }

        foreach ($constraints as $constraint) {
            if ($logic === Validation::LOGIN_AND) {
                $violation = $this->validateConstraint($value, $constraint);
                if ($violation instanceof Exceptions\ValidatorException) {
                    $violations[] = $violation;
                }
            } else {
                $violation = $this->validateConstraint($value, $constraint);
                if (!($violation instanceof Exceptions\ValidatorException)) {
                    $violations = array();
                    break;
                } else {
                    $violations[] = $violation;
                }
            }
        }

        return $violations;
    }

    /**
     * 验证约束条件是否满足
     * @param $value
     * @param $constraint
     * @return bool|Exceptions\ValidatorException
     */
    public function validateConstraint($value, $constraint)
    {
        if (!is_callable($constraint, false) && !is_callable(array($constraint, 'validate'), false)) {
            throw new \InvalidArgumentException('Use Invalid Validation Constraint');
        }

        // 约束为Jessehu\Component\Validator\Constraints中定义的约束对象
        if ($constraint instanceof Assert\ContraintInterface) {
            $violation = $constraint->setValue($value)->validate();
            if ($violation instanceof Exceptions\ValidatorException) {
                return $violation;
            }
        } else {
            $violation = $constraint($value);
            if (is_string($violation)) {
                return new Exceptions\ValidatorException($violation);
            }
        }

        return true;
    }
}
