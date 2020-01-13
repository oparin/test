<?php

namespace App\helper;

/**
 * Class Database
 * @package App\helper
 */
class Database extends \PDO
{
    /**
     * Database constructor.
     */
    public function __construct()
    {
        parent::__construct('mysql:host=localhost;dbname=mvc', 'root', '');
    }
}