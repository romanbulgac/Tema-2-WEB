<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\AdminsModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class EventController extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {
                $model = new EventModel();
                $data['events'] = $model->orderBy('title')->findAll();
                return view('admin/events/events', $data);
            }
            else
            {
                $this->response->redirect(site_url("/admin"));
            }
        }
        else
        {
            $this->response->redirect(site_url("/admin"));
        }

    }

    public function view($id = null){
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {
                if ($id == null) {
                    return view('errors/html/error_404');
                }
                $model = new EventModel();
                $data['event'] = $model->where('id', $id)->first();
                return view('admin/events/view', $data);
            }
            else
            {
                $this->response->redirect(site_url("/admin"));
            }
        }
        else
        {
            $this->response->redirect(site_url("/admin"));
        }
    }

    public function upload()
    {
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {
                return view('admin/events/upload');
            }
            else
            {
                $this->response->redirect(site_url("/admin"));
            }
        }
        else
        {
            $this->response->redirect(site_url("/admin"));
        }
    }

    public function save(){
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {

                $model = new EventModel();
                $url1 = $this->do_upload();
                $url = $stripped = substr($url1, 1);
                $title = $this->request->getPost('title');
                $description = $this->request->getPost('description');
                $date = $this->request->getPost('date');

                $data = ['title' => $title, 'description' => $description, 'date' => $date, 'image' => $url];
                $id = $model->insert($data);
                $this->response->redirect(site_url("/admin/events/view/{$id}"));
            }
            else
            {
                $this->response->redirect(site_url("/admin")); }
        }
        else
        {
            $this->response->redirect(site_url("/admin")); }
    }

    private function do_upload(){
        $type = explode('.', $_FILES["image"]["name"]);
        $type = $type[count($type) - 1];
        $url = "./images/".uniqid(rand()).'.'.$type;

        if (in_array($type, array("jpg", "jpeg", "gif", "png")))
        {
            if (is_uploaded_file($_FILES["image"]["tmp_name"]))
            {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $url))
                {
                    return $url;
                }
            }
        }
        return "";

    }
    public function edit($id = null){
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {

                $model = new EventModel();
                $data['event'] = $model->where('id', $id)->first();
                return view('admin/events/edit', $data);
            }
            else
            {
                $this->response->redirect(site_url("/admin"));
            }
        }
        else
        {
            $this->response->redirect(site_url("/admin"));
        }
    }

    public function update($id = null){
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {
                helper(['form', 'url']);
                $model = new EventModel();

                $url1 = $this->do_upload();
                $url = $stripped = substr($url1, 1);
                $title = $this->request->getVar('title');
                $description = $this->request->getVar('description');
                $date = $this->request->getVar('date');
                if (!isset($url)){
                    $data = ['title' => $title, 'description' => $description, 'date' => $date];
                }
                else{
                    $data = ['title' => $title, 'description' => $description, 'date' => $date, 'image' => $url];
                }
                $data = ['title' => $title, 'description' => $description, 'date' => $date, 'image' => $url];
                $save = $model->where('id',$id)->update(null, $data);
                $this->response->redirect(site_url("/admin/events/view/{$id}"));

            }
            else
            {
                $this->response->redirect(site_url("/admin"));
            }
        }
        else
        {
            $this->response->redirect(site_url("/admin"));
        }

    }

    public function delete($id = null){
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {
                if ($id == null) {
                    $data['message'] = "Event not found";
                    return view('errors/html/error_404', $data);
                }
                $model = new EventModel();
                $model->where('id', $id)->delete();
                $this->response->redirect(site_url("/admin/events"));
            }
            else
            {
                $this->response->redirect(site_url("/admin"));
            }
        }
        else
        {
            $this->response->redirect(site_url("/admin"));
        }
    }

    public function search()
    {
        $session = session();
        if ($session->get('username')){
            $admins = new AdminsModel();
            $admin = $admins->where('username', $session->get('username'))->first();
            if (isset($admin) && $session->get('password') == $admin['password'])
            {
                $search = $this->request->getPost('search');
                $model = new EventModel();
                $events = $model->like('title', $search)->orLike('description', $search)->findAll();
                $data['events'] = $events;
                return view('admin/events/events', $data);
            }
            else
            {
                $this->response->redirect(site_url("/admin"));
            }
        }
        else
        {
            $this->response->redirect(site_url("/admin"));
        }
    }

}