<?php

namespace Blade\Validation;

use Exception;

use Blade\Interfaces\AxE\AxE;

class ValidationBuilder
{

	protected $field;
	protected $value;
	protected $args;


	/* Checks | Must be in order */
	protected $required = true;

	protected $dataType;

	//for all
	protected $length;
	protected $minLenth;
	protected $maxLength;

	protected $different;
	protected $same;

	//for numerics
	protected $minValue;
	protected $maxValue;

	//for dates
	protected $dateFormat;
	protected $before;
	protected $after;

	//for files
	protected $imageDimensions;
	protected $mimes;

	// for db check & validation
	protected $table;
	protected $column;
	protected $except;

	function __construct($field = null)
	{
		$this->field = $field;
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

	public function date()
	{
		$this->dataType = 'date';
		return $this;
	}

	public function format($format)
	{
		$this->dateFormat = $format;
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
		$this->minLength = ($min);
		$this->maxLength = ($max);
		return $this;
	}

	public function boolean()
	{
		$this->dataType = 'boolean';
		return $this;
	}

	public function differentFrom($field)
	{
		$this->different[] = $field;
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
		$this->table 	= $table;
		$this->column 	= $column;
		$this->except 	= $except;
		return $this;
	}

	public function exists($table)
	{
		$this->table 	= $table;
		return $this;
	}

	public function same($fieldValue)
	{
		$this->same[] = $fieldValue;
		return $this;
	}

	public function confirmed($confirmation_fieldValue)
	{
		$this->same[] = $confirmation_fieldValue;
		return $this;
	}


	public function validate($value = '')
	{
		$this->value = $value;

		$typeData = (is_null($this->dataType) ? 'alpha-numeric' : $this->dataType); 
		$typeArray = explode("|", $typeData);

		$type = $typeArray[0];
		$args = isset($typeArray[1]) ? $typeArray[1] : "";

		$this->args = $args;

		$court = new Court($type);
		return $court->judgement($this);

	}

	public function __get($key)
	{
		return $this->$key;
	}


}

