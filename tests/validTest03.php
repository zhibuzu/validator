<?php
/**
 * Description:
 * User: jessehu
 * Date: 2017/3/26 下午8:49
 */

use Jessehu\Component\Validator\VariableTypeValidator;

$title = '25日视频直播国王vs勇士 库里一纪录冲历史前3';
$isNbaNews = true;
$score = 45;

$validator = VariableTypeValidator::createValidator();
$violations = $validator->validate(array(
    'title' => array('is_string', $title),
    'isNbaNews' => array('is_bool', $isNbaNews),
    'score' => array('is_int', $score)
));

if (0 !== count($violations)) {
    // 类型错误信息
    foreach ($violations as $violation) {
        echo $violation->getMessage().'<br>';
        echo $violation->getCodes().'<br>';
    }
}