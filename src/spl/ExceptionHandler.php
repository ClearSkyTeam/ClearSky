<?php
abstract class ExceptionHandler{
	/**
	 * @param $errno
	 * @param $errstr
	 * @param $errfile
	 * @param $errline
	 *
	 * @return \Exception
	 */
	public static function handler($errno, $errstr, $errfile, $errline){
		if(error_reporting() === 0){
			return false;
		}

		$exception = null;

		if(self::errorStarts($errstr, "Undefined offset: ")){
			$exception = new ArrayOutOfBoundsException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Undefined index: ")){
			$exception = new ArrayOutOfBoundsException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Uninitialized string offset: ")){
			$exception = new StringTagOutOfBoundsException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Uninitialized string offset: ")){
			$exception = new StringTagOutOfBoundsException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Undefined variable: ")){
			$exception = new UndefinedVariableException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Undefined property: ")){
			$exception = new UndefinedPropertyException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Illegal string offset ")){
			$exception = new InvalidKeyException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Illegal offset type: ")){
			$exception = new InvalidKeyException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Use of undefined constant ")){
			$exception = new UndefinedConstantException($errstr, $errno);
		}elseif(self::errorStarts($errstr, "Accessing static property ")){
			$exception = new InvalidStateException($errstr, $errno);
		}elseif(strpos($errstr, " could not be converted to ") !== false){
			$exception = new ClassCastException($errstr, $errno);
		}elseif(
			$errstr === "Trying to get property of non-object"
			or $errstr === "Attempt to assign property of non-object"
		){
			$exception = new InvalidStateException($errstr, $errno);
		}elseif(
			strpos($errstr, " expects parameter ") !== false
			or strpos($errstr, " must be ") !== false
		){
			$exception = new InvalidArgumentException($errstr, $errno);
		}elseif(
			self::errorStarts($errstr, "Wrong parameter count for ")
			or self::errorStarts($errstr, "Missing argument 1 for ")
			or preg_match('/^.*\\(\\) expects [a-z]{1,} [0-9]{1,} parameters?, [0-9]{1,} given$/', $errstr) > 0
		){
			$exception = new InvalidArgumentCountException($errstr, $errno);
		}

		if($exception === null){
			$exception = new RuntimeException($errstr, $errno);
		}

		$er = new ReflectionObject($exception);
		$file = $er->getProperty("file");
		$file->setAccessible(true);
		$file->setValue($exception, $errfile);
		$line = $er->getProperty("line");
		$line->setAccessible(true);
		$line->setValue($exception, $errline);

		throw $exception;
	}

	private static function errorStarts($error, $str){
		return substr($error, 0, strlen($str)) === $str;
	}
}