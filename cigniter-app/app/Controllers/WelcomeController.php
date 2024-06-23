<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\FoodModel;
use CodeIgniter\HTTP\ResponseInterface;

class WelcomeController extends BaseController
{
    public function index()
    {
        $model = new EventModel();
        $events = $model->orderBy('title')->findAll();
        $data['events'] = array_slice($events, 0);

        $model = new FoodModel();
        $food = $model->orderBy('title')->findAll();
        $data['food'] = array_slice($food, 0);

        return view('index', $data);
    }
    public function about()
    {
        return view('about');
    }
    public function contact(){
        return view('contact');
    }
    public function gallery(){
        $model = new EventModel();
        $events = $model->orderBy('title')->findAll();
        $data['events'] = array_slice($events, 0);

        $model = new FoodModel();
        $food = $model->orderBy('title')->findAll();
        $data['food'] = array_slice($food, 0);
        return view('gallery', $data);
    }
    public function menu(){
        $model = new EventModel();
        $events = $model->orderBy('title')->findAll();
        $data['events'] = array_slice($events, 0);

        $model = new FoodModel();
        $food = $model->orderBy('title')->findAll();
        $data['food'] = array_slice($food, 0);
        return view('menu', $data);
    }
    public function reservation(){
        return view('reservation');
    }
    public function event($id = null){
        $model = new EventModel();
        $data['event'] = $model->where('id', $id)->first();
        return view('eventView', $data);
    }
}
