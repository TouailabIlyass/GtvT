<?php

namespace App\View\Components;

use Illuminate\View\Component;

use Illuminate\Support\Facades\Http;

class formClient extends Component
{
    public $client;
    public $payes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->payes = $this->listOfpayes();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-client');
    }
    public function listOfpayes()
    {
        //return ['test','test2'];
       return Http::timeout(3)->get('http://localhost:8001/payes')->json();
      /* $client = new \GuzzleHttp\Client([
        'base_uri' => 'http://localhost:8000',
        'defaults' => [
            'exceptions' => false
        ]
    ]);
       $data = $client->get('http://localhost:8000/payes');
       print_r($data);
            */
    }
}
