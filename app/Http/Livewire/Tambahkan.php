<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Tambah;

class Tambahkan extends Component
{
    use WithFileUploads;

    public $tambahkan;
    public $tambahId,$dosen,$matakuliah;
    public $isBuka = 0;
    public $image;

    public function render()
    {
        $this->tambahkan = Tambah::all();
        return view('livewire.tambahkan');
    }

    public function showModal() {
        $this->isBuka = true;
    }

    public function hideModal() {
        $this->isBuka = false;
    }

    public function store(){
        $this->validate(
            [
                'dosen' => 'required',
                'matakuliah' => 'required',
                'image' => 'image|max:2048'
            ]
        );

        Tambah::updateOrCreate(['id' => $this->tambahId], [
            'dosen' => $this->dosen,
            'matakuliah' => $this->matakuliah
        ]);

        $this->image->store('images');

        $this->hideModal();

        $this->tambahId = '';
        $this->dosen = '';
        $this->matakuliah = '';
    }

    public function edit($id){
        $tambah = Tambah::findOrFail($id);
        $this->tambahId = $id;
        $this->dosen = $tambah->dosen;
        $this->matakuliah = $tambah->matakuliah;

        $this->showModal();
    }

    public function delete($id){
        Tambah::find($id)->delete();
    }
}
