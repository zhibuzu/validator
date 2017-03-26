<?php
/**
 * Description: 变量值类型验证
 * User: jessehu
 * Date: 2017/3/26 下午12:37
 */

namespace Jessehu\Component\Validator;

use Jessehu\Component\Validator\Exceptions\InvalidTypeException;

class VariableTypeValidator implements VariableTypeValidatorInterface
{
    protected static $validator = null;

    // 变量类型检测函数配置
    protected $variableTypeFuncs = array(
        // 布尔类型
        'is_bool' => array(-1, 'Boolen'),

        // 整型
        'is_int'     => array(-2, 'Integer'),
        'is_integer' => array(-2, 'Integer'),

        // 浮点类型
        'is_float' => array(-3, 'Float'),
        'is_double' => array(-3, 'Float'),

        // 数字或数字字符串
        'is_numeric' => array(-4, 'Numeric'),

        // 字符串
        'is_string' => array(-5, 'String'),

        // 数组类型
        'is_array' => array(-6, 'Array'),

        // 对象
        'is_object' => array(-7, 'Object'),

        // 资源
        'is_resource' => array(-8, 'Resource'),

        // NULL
        'is_null' => array(-9, 'Null'),
    );

    public function __construct()
    {

    }

    /**
     * 创建验证器对象
     * @return VariableTypeValidator|null
     */
    public static function createValidator()
    {
        if (!(self::$validator instanceof self)) {
            self::$validator = new static();
        }
        
        return self::$validator;
    }

    /**
     * 验证值类型
     * @param $validateParams
     * @return array
     */
    public function validate($validateParams)
    {
        // 检测到的全部类型异常对象数组
        $violations = array();

        if (!is_array($validateParams)) {
            throw new \InvalidArgumentException('variable type validator validate function only accepts array. argument is' . print_r($validateParams));
        }

        foreach ($validateParams as $variableSymbol => $variableValidateRule) {
            $validTypeFunc = $variableValidateRule[0];
            $validValue = $variableValidateRule[1];
            try {
                $this->isValidVariableTypeFunc($validTypeFunc);

                if (!call_user_func($validTypeFunc, $validValue)) {
                    $violations[] = new InvalidTypeException("Variable: {$variableSymbol} type must be: " .
                        $this->variableTypeFuncs[$validTypeFunc][1] . ", Input type is" . gettype($validValue),
                        $this->variableTypeFuncs[$validTypeFunc][0]);
                }
            } catch (\InvalidArgumentException $e) {
                throw $e;
            }
        }

        return $violations;
    }

    /**
     * 检测传入的变量类型检测函数是否合法（属于预定义的变量类型检测函数配置）
     * @param $variableTypeFunc
     */
    public function isValidVariableTypeFunc($variableTypeFunc)
    {
        $variableTypeFuncs = array_keys($this->variableTypeFuncs);
        if (!is_string($variableTypeFunc) || !in_array($variableTypeFunc, $variableTypeFuncs, true)) {
            new \InvalidArgumentException('Use Invalid Variable Type validate Function: ' . $variableTypeFunc);
        }
    }
}
