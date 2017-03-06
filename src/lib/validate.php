<?php
/**
 * Decription: 数据验证类，对客户端设置的验证配置项进行相应验证
 * Author: Jesse Hu (hu2014jesse@gmail.com)
 * Date: 2017/03/06 上午 9:12
 * Project: fookii-validate
 */

namespace Fookii\Validate;

class validate
{
	/**
	 * 验证数据
	 * @param array $params  验证规则及错误提示信息配置项
	 * @param bool $endLogic 是否有错误发生即终止验证并返回结果
	 * @param Object|null $prevException 前一个异常对象
	 * @return \Exception | null
	 */
	public function validateData ($params, $endLogic = true, $prevException = null)
	{
		try {
			$validateTypes = array(
				'is_array' => $params,
				'is_bool' => $endLogic
			);
			$this->validateType($validateTypes);
		} catch (\Exception $e) {
			echo "arguments type error. code: {$e->getCode()}，message: {$e->getMessage()}";
		}

		if (($endLogic && !is_null($prevException)) || count($params) < 1) {
			return $prevException;
//			throw $prevException;
		} else {
			try {
				$this->validateUnit(array_shift($params));
			} catch (\Exception $e) {
				$prevException = new \Exception($e->getMessage(), $e->getCode(), $prevException);
			}

			return $this->validateData($params, $endLogic, $prevException);
		}
	}

	/**
	 * 对一个要验证的数据单元进行验证
	 * @param array $unit 数据单元
	 * @throws \Exception
	 */
	public function validateUnit($unit)
	{
		try {
			$this->validateType(array('is_array' => $unit));
		} catch (\Exception $e) {
			echo "arguments type error. code: {$e->getCode()}，message: {$e->getMessage()}";
		}

		$data = $unit['data'];
		$rules = $unit['rules'];
		// 是否需满足全部验证规则， true：只要有一个规则不满足就抛出异常；false：只要有一个规则满足就不跑出异常
		$useAnd = isset($unit['useAnd']) ? $unit['useAnd'] : true;
		// 是否抛出异常
		$flag = $useAnd ? false : true;
		$code = 0;
		$message = '';

		foreach ($rules as $ruleUnit) {
			// 验证规则
			$rule = $ruleUnit['rule'];
			// 异常码
			$code = isset($ruleUnit['code']) ? $ruleUnit['code'] : 0;
			// 异常消息
			$message = $ruleUnit['message'];

			if (is_string($rule)) {
				$handle = $rule;
				$arguments = array($data);
			} else {
				$handle = $rule[0];
				unset($rule[0]);
				$arguments = $rule;
			}


			if ($useAnd) {
				if (!call_user_func_array($handle, $arguments)) {
					$flag = true;
					break;
				}
			} else {
				if (call_user_func_array($handle, $arguments)) {
					$flag = false;
					break;
				}
			}
		}

		if ($flag) {
			throw new \Exception($message, $code);
		}
	}

	/**
	 * 验证数据类型
	 * @param array $params
	 * @throws
	 */
	public function validateType ($params)
	{
		foreach ($params as $handle => $param) {
			if (!call_user_func($handle, $param)) {
				$error = $this->getTypeError($handle);
				throw new \Exception($error['message'], $error['code']);
			}
		}
	}

	/**
	 * 获取数据类型错误的描述：错误信息描述，错误码
	 * @param $handle
	 * @return array $res
	 */
	public function getTypeError ($handle)
	{
		$res = array('code' => 0, 'message' => 'Unexpect type, must be ');
		switch ($handle) {
			case 'is_bool':
				$res['code'] = -1;
				$res['message'] .= 'Boolen';
				break;
			case 'is_int':
				$res['code'] = -2;
				$res['message'] .= 'Integer';
				break;
			case 'is_float':
				$res['code'] = -3;
				$res['message'] .= 'Float';
				break;
			case 'is_numeric':
				$res['code'] = -4;
				$res['message'] .= 'Numeric';
				break;
			case 'is_string':
				$res['code'] = -5;
				$res['message'] .= 'String';
				break;
			case 'is_array':
				$res['code'] = -6;
				$res['message'] .= 'Array';
				break;
			case 'is_object':
				$res['code'] = -7;
				$res['message'] .= 'Object';
				break;
			case 'is_resource':
				$res['code'] = -8;
				$res['message'] .= 'Resource';
				break;
			case 'is_null':
				$res['code'] = -9;
				$res['message'] .= 'Null';
				break;
		}

		return $res;
	}
}
