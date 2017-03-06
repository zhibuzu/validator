<?php
/**
 * Decription: 单元测试类
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/03/06 上午 9:46
 * Project: fookii-validate
 */

namespace Fookii\ValidateTest;

use Fookii\Validate\validate;

class validateTest extends \PHPUnit_Framework_TestCase
{
	public static function testNoempty($str)
	{
		return !empty($str);
	}

	public static function testEmpty ($str)
	{
		return empty($str);
	}


	public function testValidateData ()
	{
		$tel = '15999899876';
		$zip = '523800';
		$validator = new validate();
		$validateParams = array (
			array(
				'data' => $zip,
				'rules' => array(
					array(
						'rule' => array(array(__NAMESPACE__ . '\validateTest', 'testEmpty'), $zip),
						'message' => '请输入非空邮政编号'
					),
					array(
						'rule' => array('preg_match', "/^[1-9]\d{5}$/", $zip),
						'message' => '请输入正确的邮政编号'
					)
				),
				'useAnd' => false
			),
			array(
				'data' => $tel,
				'rules' => array(
					array(
						'rule' => array(array(__NAMESPACE__ . '\validateTest', 'testNoempty'), $tel),
						'message' => '请输入非空手机号码',
						'code' => -1
					),
					array(
						'rule' => array('preg_match', "/^1[0-9][0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $tel),
						'message' => '请输入正确的手机号码',
						'code' => -2
					)
				),
			)
		);

		var_dump($validator->validateData($validateParams, false));exit;
//		$this->assertEquals(null, $validator->validateData($validateParams, false));
	}
}