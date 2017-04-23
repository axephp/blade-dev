<?php

namespace Blade\Validation;

use Exception;

use Blade\Interfaces\AxE\AxE;

class ValidationBuilder
{

	protected $axe;

	protected $field;

	protected $required;
	protected $filled;

	protected $dataType;

	protected $length;
	protected $minLenth;
	protected $maxLength;
	protected $minValue;
	protected $maxValue;

	protected $dateFormat;
	protected $before;
	protected $after;

	protected $different;

	protected $imageDimensions;
	protected $mimes;

	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}

	public function field($field, $value='')
	{
		$this->field = [$field, $value];
		return $this;
	}


	public function chars($length = null)
	{
		$this->dataType = 'characters';
		$this->length = $length;
		return $this;
	}

	public function charsAndDash($value='')
	{
		$this->dataType = 'characters|dash';
		return $this;
	}

	public function numeric()
	{
		$this->dataType = 'numeric';
		return $this;
	}


	public function numberExactly($length)
	{
		$this->dataType = 'numeric|exactly';
		$this->length = $length;
		return $this;
	}

	public function numberBetween($min, $max)
	{
		$this->dataType = 'numeric|between';
		$this->minValue = $min;
		$this->maxValue = $max;
		return $this;
	}


	public function alphaNumeric()
	{
		$this->dataType = 'alpha-numeric';
		return $this;
	}

	public function after($date)
	{
		$this->dataType = 'date|after';
		$this->after = $date;
		return $this;
	}

	public function before($date)
	{
		$this->dataType = 'date|before';
		$this->before = $before;
		return $this;
	}

	public function interval($before, $after)
	{
		$this->dataType = 'date|interval';
		$this->before = $before;
		$this->after = $after;
		return $this;
	}

	public function beforeOrEqual($date)
	{
		$this->dataType = 'date|inclusive';
		$this->before = $date;
		return $this;
	}

	public function size($length)
	{
		$this->length = $length;
		return $this;
	}

	public function min($count)
	{
		$this->minLength = $count;
		return $this;
	}

	public function max($count)
	{
		$this->maxLength = $count;
		return $this;
	}

	public function sizeBetween($min, $max)
	{
		$this->min = ($min);
		$this->max = ($max);
		return $this;
	}

	public function boolean()
	{
		$this->dataType = 'boolean';
		return $this;
	}

	public function date()
	{
		$this->dataType = 'date';
		return $this;
	}

	public function dateFormat($format)
	{
		$this->dataType = 'date|formatted';
		$this->dateFormat = $format;
		return $this;
	}

	public function differentFrom($field)
	{
		$this->different = $field;
		return $this;
	}

	public function accepted()
	{
		$this->dataType = 'boolean';
		return $this;
	}

	public function image()
	{
		$this->dataType = 'image';
		return $this;
	}

	public function imageDimensions($minwidth, $minheight)
	{
		$this->dataType 		= 'image|dimensions';
		$this->minDimensions 	= [$minwidth, $minheight];
		return $this;
	}


	public function email()
	{
		$this->dataType = 'email';
		return $this;
	}


	public function file()
	{
		$this->dataType = 'file';
		return $this;
	}

	public function filled()
	{
		$this->filled = true;
		return $this;
	}

	public function json()
	{
		$this->dataType = 'json';
		return $this;
	}

	public function mimes(array $mimes)
	{
		$this->dataType = 'file|mimes';
		$this->mimes 	= $mimes;
		return $this;
	}

	public function required()
	{
		$this->required = true;
		return $this;
	}

	public function optional()
	{
		$this->required = false;
		return $this;
	}

	public function url()
	{
		$this->dataType = 'url';
		return $this;
	}

	public function unique($table, $column, $except)
	{
		# code...
	}

	public function exists($table, $field)
	{
		# code...
	}

	public function same($fieldValue)
	{
		$this->field[1] = $fieldValue;
		return $this;
	}

	public function confirmed($confirmation_field)
	{
		dump($this->axe->resolve('route'));
		return $this;
	}

	public function validate()
	{
		if ($this->onlyCharacters) {
			preg_match(['a-zA-Z'], $this->field[1]);
		}elseif ($this->onlyNumbers) {
			preg_match(['0-9'], $this->field[1]);
		}
	}


}

