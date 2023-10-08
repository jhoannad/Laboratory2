<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MusicModel;
use App\Models\PlaylistModel;
 
class MainController extends BaseController
{
    private $playlist;
    private $songs;

    public function __construct()
    {
        $this->playlist = new \App\Models\PlaylistModel();
        $this->songs = new \App\Models\MusicModel();
    }
    public function index()
    {
        $main = new MusicModel();
        $data['songs'] = $main->findAll();
        $data['song']= [];
        return view('songs',$data);
    }
    public function search()
    {
        $searchQuery = $this->request->getVar('search');

        if ($searchQuery) {
            $main = new MusicModel();
            $data['song'] = $main->like('musicname', $searchQuery)->findAll();
        }
        return view('songs', $data);
    }
    public function songupload()
    {
        if($this->request->getMethod() == 'post'){
            $rules = [
                    'myfile' => [
                        'rules' => 'uploaded[myfile]',
                        'label' => 'My File'
                    ]
                ];
            if($this->validate($rules)){
                $file = $this->request->getFile('myfile');
                $filename = pathinfo($file->getName(), PATHINFO_FILENAME);
                $main = new MusicModel();
                $data['songs'] = $main->findAll();
                $data['song'] = [];
                $datatoadd = [
                    'musicname' => $filename,
                    'file_path' => "0",
                ];
                $main->save($datatoadd);
                if($file->isValid() && !$file->hasMoved()){
                    $file->move('./songs');
                }
                return redirect()->to('/main');
                exit();
            }
        }
    }
    public function makeplaylist()
    {
        $data = [
            'name' => $this->request->getVar('pname'),
        ];
        $playlist = new PlaylistModel();
        $data = [
            'playlistname' => $this->request->getVar('playlistName'),
            'playlist_path' => "0"
        ];
        $this->playlist->save($data);
        return redirect()->to('/main');

        
    }
    public function deleteplaylist($id)
    {
        $play = new PlaylistModel();
        $record = $play->find($id);
        if($record != null){
            $play->delete($id);
            return redirect()->to('/main');
        }else{
            return "Record not found";
        }
    }
    public function addmusictoplaylist($id)
    {
        $play = new PlaylistModel();
        $main = new MusicModel();
        $playlistData = [
            'plist' => $play->findAll(),
            'play' => [],
        ];
        $musicData = [
            'songs' => $main->findAll(),
            'song' => [],
        ];
        $data = array_merge($playlistData, $musicData);
        return view('songs', $data);
    }
}
