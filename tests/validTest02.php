<?php
/**
 * Description:
 * User: jessehu
 * Date: 2017/3/26 下午8:16
 */
require '../vendor/autoload.php';

use Jessehu\Component\Validator\Validation;

$validator = Validation::createValidator();

// 2. or use custom closure
$violations = $validator->validate('Jessehu', array(
    function ($value) {
        if ('Jesse hu' !== $value) {
            return 'variable value must be Jesse hu';
        }

        return true;
    }
));

//var_dump($violations);exit;

if (0 !== count($violations)) {
    // 类型错误信息
    foreach ($violations as $violation) {
        echo $violation->getMessage().'<br>';
        echo $violation->getCodes().'<br>';
    }
}
