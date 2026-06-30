<?php

namespace admin\controller;

class UserAccountController extends BaseController
{
    public function index()
    {
        header('Location: ' . URL . 'index.php?p=admin&c=User');
        exit;
    }
}
