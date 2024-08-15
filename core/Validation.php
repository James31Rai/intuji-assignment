<?php 

namespace Core;

class Validation
{
    private $errors = [];
    private $request;
    
    public function validate(array $rows)
    {
        $request = new Request();
        if (empty($request->all())) {
            return false;
        }
        $this->request = $request = $request->all();
        foreach ($this->request as $key => $value) {
            if (is_string($value)) {
                $this->request[$key] = filter_var(trim($value), FILTER_UNSAFE_RAW);
            }
        }

        foreach ($rows as $row) {
            $this->eachName = $name = $row[0];
            $title = $row[1];
            $rules = $row[2]; // must be array

            foreach ($rules as $rule) {
                $ruleSplit = explode(':', $rule);
                $rule = $ruleSplit[0];
                $ruleValue = $ruleSplit[1] ?? null;
                $eachReturn = true;
                switch ($rule) {
                    case 'required':
                        $eachReturn = $this->validateRequired($request[$name]);
                        break;
                    case 'min':
                        $eachReturn = $this->validateMinLength($request[$name], $ruleValue);
                        break;
                    case 'max':
                        $eachReturn = $this->validateMaxLength($request[$name], $ruleValue);
                        break;
                    case 'email':
                        $eachReturn = $this->validateEmail($request[$name]);
                        break;
                }

                if (!$eachReturn) {
                    $this->errors[$name] = $title . $this->eachError;
                    $this->eachError = "";
                    break;
                }
            }
            $this->eachName = "";
        }
        if (!empty($this->errors)) {
            return false;
        }
        return $this->request;
    }

    private $eachError = "";
    private $eachName = "";
    function validateRequired($value)
    {
        $this->eachError = " is Required.";
        return !empty($value);
    }
    
    function validateMaxLength($value, $max)
    {
        $this->eachError = " is too long. Max length is $max.";
        return strlen($value) <= $max;
    }

    function validateMinLength($value, $min)
    {
        $this->eachError = " is too short. Min length is $min.";
        return strlen($value) >= $min;
    }

    public function validateEmail($email)
    {
        $this->eachError = " is not a valid email.";
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}