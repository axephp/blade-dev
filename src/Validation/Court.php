<?php

namespace Blade\Validation;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Court
{


	protected $type;

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

	function __construct($typeData)
	{
		$data = explode("|", $typeData);
		$this->type = $data[0];
	}

	public function judgement(ValidationBuilder $validator)
	{
		
		$ruleName = $this->rules[$this->type];
		$ruleClass = "Blade\\Validation\\Rules\\{$ruleName}";

		$rule = new $ruleClass();

		return $rule->execute($validator);

	}

}