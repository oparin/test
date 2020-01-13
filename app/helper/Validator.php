<?php

namespace App\Helper;

/**
 * Class Validator
 * @package App\Helper
 */
class Validator
{
    protected $value;
    protected $errors = [];

    /**
     * Validator constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return $this
     */
    public function notEmpty()
    {
        if (!$this->value) {
            $this->errors[] = 'This value cannot be empty!';
        }

        return $this;
    }

    public function email()
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'This value not valid Email!';
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        if (!empty($this->errors)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getError()
    {
        return $this->errors;
    }
}