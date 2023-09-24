<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SearchModel;

class HomeControl extends BaseController
{
    public function index()
    {

    }
    public function test()
    {
        $data = [
            'song' => $this->request->getPost('song'),
            'sPath' => $this->request->getPost('sPath'),
        ];

        $mode = new SearchModel();
        $data['main'] = $mode->findAll();
        //var_dump(data);
        return view('main', $data);
    }
    public function search()
    {
        $model = new SearchModel(); 
        $searchTerm = $this->request->getVar('search'); 

        $data['results'] = $model->searchSongs($searchTerm);

        return view('song/search_results', $data);
    }

    
}
