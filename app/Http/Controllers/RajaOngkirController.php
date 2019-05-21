<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{

    protected $client;

    public function __construct()
    {
        $client = new Client(['verify' => base_path().'/cacert.pem','headers' => ['key' => 'd6d36ef0a06034ee138e8d25a44a8cdb','content-type'=>'application/x-www-form-urlencoded']]);
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
        $data = array(
            "origin" => $request->origin,
            "destination" => $request->destination,
            "weight" => $request->weight,
            "courier" => $request->courier
        );
        $dataString = "origin=".$request->origin."&destination=".$request->destination."&weight=".$request->weight."&courier=".$request->courier;
        $res = $this->client->request('POST', 'https://api.rajaongkir.com/starter/cost',[
            "body"=>$dataString
        ]);
        return $res->getBody();

    }
}
