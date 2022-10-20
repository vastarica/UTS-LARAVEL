<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{
    public $posts;
    public $postId,$nama,$kota;
    public $isOpen = 0;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    public function showModal() {
        $this->isOpen = true;
    }

    public function hideModal() {
        $this->isOpen = false;
    }

    public function store(){
        $this->validate(
            [
                'nama' => 'required',
                'kota' => 'required'
            ]
        );

        Post::updateOrCreate(['id' => $this->postId], [
            'nama' => $this->nama,
            'kota' => $this->kota
        ]);

        $this->hideModal();

        $this->postId = '';
        $this->nama = '';
        $this->kota = '';
    }

    public function edit($id){
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->nama = $post->nama;
        $this->kota = $post->kota;

        $this->showModal();
    }

    public function delete($id){
        Post::find($id)->delete();
    }
}
