# validator
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Validator Component for validate variables such as strings, numbers and arrays

### Usage
```
require '../vendor/autoload.php';

use Jessehu\Component\Validator\Validation;

use Jessehu\Component\Validator\Contraints\NotBlank;

$validator = Validation::createValidator();

// use Contraints Object
$violations = $validator->validate('Jessehu', array(
    new NotBlank('this variable can\'t be blank')
));

// or use custom closure
$violations = $validator->validate('Jessehu', array(
    function ($value) {
        if ('Jesse hu' !== $value) {
            return 'variable value must be Jesse hu';
        }

        return true;
    }
));

if (0 !== count($violations)) {
    // 类型错误信息
    foreach ($violations as $violation) {
        echo $violation->getMessage().'<br>';
        echo $vialation->getCodes().'<br>';
    }
}

```


# Variable type validator
validate variable type

### Usage
```
require '../vendor/autoload.php';

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
        echo $vialation->getCode().'<br>';
    }
}
```
