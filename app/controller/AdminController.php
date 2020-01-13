<?php

namespace App\Controller;

use App\Helper\Validator;
use App\Helper\View;
use App\Model\Task;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController
{
    public function loginAction()
    {
        $errors = [];
        if (isset($_POST['submit'])) {
            $login = new Validator($_POST['login']);
            $login->notEmpty();
            if ($login->isError()) {
                $errors['login'] = $login->getError();
            }

            $password = new Validator($_POST['password']);
            $password->notEmpty();
            if ($password->isError()) {
                $errors['password'] = $password->getError();
            }

            if (empty($errors)) {
                if ($login->getValue() == 'admin') {
                    if ($password->getValue() == '123') {
                        $_SESSION['admin'] = $login->getValue();
                        header('Location: ../task/all');
                    } else {
                        $errors['password'] = ['Incorrect password!'];
                    }
                } else {
                    $errors['login'] = ['Incorrect login!'];
                }
            }
        }

        $view = new View();
        $view->setData([
            'error'     => $errors,
            'login' => (isset($login)) ? $login->getValue() : null,
        ]);
        $view->render('login');
    }

    public function editAction()
    {
        if (isset($_SESSION['admin'])) {
            $errors = [];
            $taskModel = new Task();
            $task = $taskModel->getTaskById($_GET['id']);

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
                    $status = (isset($_POST['status'])) ? true : false;
                    $taskModel->updateTask($task->id, $username->getValue(), $email->getValue(), $description->getValue(), $status);
                    $_SESSION['flash'] = 'Task saved!';

                    if ($task->description != $description->getValue()) {
                        $taskModel->editAdmin($task->id);
                    }

                    return header('Location: ../../task/all');
                }
            }

            $view = new View();
            $view->setData([
                'error' => $errors,
                'username' => $task->username,
                'email' => $task->email,
                'description' => $task->description,
                'status' => $task->status
            ]);
            $view->render('edit');
        } else {
            header('Location: ../../admin/login');
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['admin']);

        header('Location: ../task/all');
    }
}