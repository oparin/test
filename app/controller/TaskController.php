<?php

namespace App\Controller;

use App\Helper\Validator;
use App\Helper\View;
use App\Model\Task;

/**
 * Class TaskController
 * @package App\Controller
 */
class TaskController
{
    protected $view;

    /**
     * TaskController constructor.
     */
    public function __construct() {

    }

    public function allAction()
    {
        $key    = (isset($_GET['key']) ? $_GET['key'] : 'id');
        $sort   = (isset($_GET['sort']) ? $_GET['sort'] : 'asc');
        $task   = new Task();

        // Pagination
        $count = 3;
        $totalPage  = ceil($task->getCountTasks() / $count);
        $page       = (isset($_GET['page']) ? $_GET['page'] : 1);
        $start      = $page * $count - $count;


        $data   = $task->getAllTasks($key, $sort, $start, $count);

        $view = new View();
        $view->setData([
            'page' => $page,
            'tasks' => $data,
            'totalPage' => $totalPage,
        ]);
        $view->render('index');
    }

    public function newAction()
    {
        $errors = [];
        if (isset($_POST['submit'])) {
            $username = new Validator($_POST['username']);
            $username->notEmpty();
            if ($username->isError()) {
                $errors['username'] = $username->getError();
            }

            $email = new Validator($_POST['email']);
            $email->notEmpty()->email();
            if ($email->isError()) {
                $errors['email'] = $email->getError();
            }

            $description = new Validator($_POST['description']);
            $description->notEmpty();
            if ($description->isError()) {
                $errors['description'] = $description->getError();
            }

            if (empty($errors)) {
                $task = new Task();
                $task->saveTask($username->getValue(), $email->getValue(), $description->getValue());
                $_SESSION['flash'] = 'New task created!';

                return header('Location: ../task/new');
            }
        }
        $view = new View();

        $view->setData([
            'error'         => $errors,
            'username'      => (isset($username)) ? $username->getValue() : null,
            'email'         => (isset($email)) ? $email->getValue() : null,
            'description'   => (isset($description)) ? $description->getValue() : null,
        ]);
        $view->render('new');
    }
}