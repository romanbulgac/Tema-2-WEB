<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminsModel;
use App\Models\EventModel;
use App\Models\FoodModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{

    public function test_input($data)
    {
        if (isset($data)) {
            $data = trim($data);//Remove whitespaces from both sides of a string
            $data = stripslashes($data);//Remove the backslash
            $data = htmlspecialchars($data);//Convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities
            return $data;
        }
        return null;
    }

    public function index()
    {
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {
                $model = new EventModel();
                $data['admin'] = $admin;
                $events = $model->orderBy('title')->findAll();
                $data['events'] = array_slice($events, 0, 3);

                $model = new FoodModel();
                $food = $model->orderBy('title')->findAll();
                $data['food'] = array_slice($food, 0, 3);


                return view('admin/dashboard', $data);
            }
            else
            {
                return (view('admin/login'));
            }
        }
        else
        {
            return view('admin/login');
        }
    }

    public function signUp()
    {
        $session = session();
        $login = $password = '';
        $input = $this->validate([
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[20]',
            'password' => 'required|alpha_numeric_space|min_length[3]|max_length[20]'
        ]);
        if (!$input) {
            $data['validation'] = $this->validator;
            return view('admin/login', $data);
        }
        else
        {
            $login = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $admins = new AdminsModel();
            $admin = $admins->where('username', $login)->first();
            if (isset($admin) && $admin['password'] == md5($password)){
                $session->set('username', $admin['username']);
                $session->set('password', $admin['password']);

                $this->response->redirect(site_url('/admin'));
            }
            else {
                $data['loginError'] = 'Wrong username or password';
                return view('admin/login', $data);
            }
        }

    }

    public function logout(){
        $session = session();
        $session->destroy();
        $this->response->redirect(site_url('/admin'));
    }
}
