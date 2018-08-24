<?php
namespace APP\Validation;

//DDL - validator using Respect.  Kinda watered down.  Catch failures in Controller....

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;
    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName($field)->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

    public function messages()
    {
        return $this->errors;
    }
}
