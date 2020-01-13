<?php

namespace App\Model;

use App\helper\Database;

/**
 * Class Task
 * @package App\Model
 */
class Task
{
    protected $db;

    protected $id;

    protected $username;

    protected $email;

    protected $description;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getCountTasks()
    {
        $sql    = "SELECT COUNT(id) as count_rows FROM tasks";
        $stmt   = $this->db->query($sql);

        return $stmt->FETCH(\PDO::FETCH_OBJ)->count_rows;
    }

    public function getAllTasks($key, $sort, $start, $count)
    {
        $sql    = "SELECT * FROM tasks ORDER BY $key $sort LIMIT $start, $count";
        $stmt   = $this->db->query($sql);

        return $stmt->FETCHALL(\PDO::FETCH_OBJ);
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $description
     * @return bool
     */
    public function saveTask($username, $email, $description)
    {
        $sql            = "INSERT INTO tasks (username, email, description) VALUES (:username, :email, :description)";
        $stmt           = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }

    /**
     * @param integer $id
     * @param string  $username
     * @param string  $email
     * @param string  $description
     * @param bool    $status
     * @return bool
     */
    public function updateTask($id, $username, $email, $description, $status)
    {
        $sql            = "UPDATE tasks SET username=:username, email=:email, description=:description, status=:status WHERE id=:id";
        $stmt           = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, \PDO::PARAM_BOOL);
        $stmt->execute();

        return true;
    }

    /**
     * @param integer $id
     * @return bool
     */
    public function editAdmin($id)
    {
        $sql            = "UPDATE tasks SET edit_admin=TRUE WHERE id=:id";
        $stmt           = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function getTaskById($id)
    {
        $sql    = "SELECT * FROM tasks WHERE id = :id";
        $stmt  = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->FETCH(\PDO::FETCH_OBJ);
    }
}