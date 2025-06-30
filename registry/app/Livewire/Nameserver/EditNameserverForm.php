<?php

namespace App\Livewire\Nameserver;

use Livewire\Component;

class EditNameserverForm extends Component
{


    public $isChecked=false;
    public $multipleip= [
        ['nshostname' => '', 'nsip' => []],
    ];
    public $nicnameservers = [['nshostname'=>'ns1.nic.in','ip'=>''],['nshostname'=>'ns2.nic.in','ip'=>''],['nshostname'=>'ns7.nic.in','ip'=>''],['nshostname'=>'ns10.nic.in','ip'=>'']];


    public function toggleDiv()
    {
        $this->isChecked = !$this->isChecked;
    }


    public function addEntry()
    {
        $this->multipleip[] = ['nshostname' => '', 'ip' => ''];
    }
    
    public function removeEntry($index)
    {
        if($index > 1){
            unset($this->multipleip[$index]);
            $this->multipleip = array_values($this->multipleip);
        }
    }

    public function updateNameserver(){

         
    }

    public function render()
    {

       
        return view('livewire.nameserver.edit-nameserver-form');
    }
}
