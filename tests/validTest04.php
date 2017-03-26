<?php
/**
 * Description:
 * User: jessehu
 * Date: 2017/3/26 下午8:12
 */
require '../vendor/autoload.php';

use Jessehu\Component\Validator\Validation;

use Jessehu\Component\Validator\Contraints\NotBlank;

$validator = Validation::createValidator();

// 1. use Contraints Object
$violations = $validator->validate('Jessehu', array(
    new NotBlank('this variable can\'t be blank'),
    function ($value) {
        if ('Jesse hu' !== $value) {
            return 'variable value must be Jesse hu';
        }

        return true;
    }
), Validation::LOGIN_AND);

//var_dump($violations);exit;


if (0 !== count($violations)) {
    // 类型错误信息
    foreach ($violations as $violation) {
        echo $violation->getMessage().'<br>';
        echo $violation->getCodes().'<br>';
    }
}
