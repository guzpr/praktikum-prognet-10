<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{

    protected $client;

    public function __construct()
    {
        $client = new Client(['verify' => base_path().'/cacert.pem','headers' => ['key' => 'f01bffea968bed4d6e97a4d9b37bf9f7','content-type'=>'application/x-www-form-urlencoded']]);
        $this->client = $client;
    }

    public function getProvince(){
        $res = $this->client->request('GET', 'https://api.rajaongkir.com/starter/province');
        return $res->getBody();
    }
    
    public function getProvinceById($id){
        $res =  $this->client->request('GET', 'https://api.rajaongkir.com/starter/province?id'.$id);
        return $res->getBody();
    }    

    public function getCityByProvinceId($id){
        $res = $this->client->request('GET', 'https://api.rajaongkir.com/starter/city?province='.$id);
        return $res->getBody();
    }

    public function getCost(Request $request){
        $dataString = "origin=94&destination=".$request->destination."&weight=".$request->weight."&courier=".$request->courier;
        $res = $this->client->request('POST', 'https://api.rajaongkir.com/starter/cost',[
            "body"=>$dataString
        ]);
        return $res->getBody();

    }
}
