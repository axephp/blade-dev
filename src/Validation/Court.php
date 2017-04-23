<?php

namespace Blade\Validation;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Court
{


	protected $type;
	protected $args;

	protected $rules = [
			'alpha-numeric' => 'AlphaNumeric',
			'characters'	=> 'Characters',
			'numeric'		=> 'Numeric',
			'date'			=> 'Date',
			'boolean'		=> 'Boolean',
			'image'			=> 'Image',
			'file'			=> 'File',
			'json'			=> 'Json',
			'email'			=> 'Email',
			'url'			=> 'Url'
		];

	function __construct($type, $args)
	{
		$this->type = $type;
		$this->args = $args;
	}

	public function judgement($field)
	{
		
		$ruleName = $this->rules[$this->type];
		$ruleClass = "Blade\\Validation\\Rules\\{$ruleName}";

		$rule = new $ruleClass();

		return $rule->execute($field, $this->args);

	}

}