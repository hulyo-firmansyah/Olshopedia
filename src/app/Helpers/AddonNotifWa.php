<?php
//app/Helpers/Envato/User.php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;
 
class AddonNotifWa {

    private $addonData = null;

    public function __construct($data_of){
        $addonData = $this->getAddonData($data_of);
    }

    private function getAddonData($data_of) {
        if(is_null($this->addonData)){
            $addonData = Cache::remember('data_addons_data_notif_wa_'.$data_of, 60000, function() use($data_of){
                $data = DB::table('t_addons_data')
                    ->where('data_of', $data_of)
                    ->get()->first();
                if(isset($data)){
                    if(is_null($data->notif_wa)){
                        return null;
                    } else {
                        return unserialize(decrypt($data->notif_wa));
                    }
                } else {
                    return null;
                }
            });
        }
        $this->addonData = $addonData;
    }

    public function getData($key){
        if(is_null($this->addonData)){
            return null;
        }
        return $this->addonData[$key];
    }

    public function isDataNull(){
        return is_null($this->addonData) ? true : false;
    }

    private function render(array $data, string $pesan){
        foreach(Fungsi::genArray($data) as $i => $v){
            $pesan = str_replace($i, $v, $pesan);
        }
        return $pesan;
    }

    public function kirim($no_tujuan, $pesan, $data = null){

        if(is_null($this->addonData)){
            return [
                'status' => false,
                'data' => 'Data kosong!'
            ];
        }

        try {
		
            $client = new \GuzzleHttp\Client(['base_uri' => 'http://gowagateway-silly-platypus.mybluemix.net/']);

            if(is_array($data) && !is_null($data)){
                $pesan = $this->render($data, $pesan);
            }

            $response = $client->request('POST', 'sendtxtmsg', [
                'form_params' => [
                    'APIKey' => $this->addonData['key'],
                    'phoneNumber' => Fungsi::cekPlus($no_tujuan),
                    'message' => $pesan
                ]
            ]);

            if($response->getStatusCode() == 200){
            	return [
                    'status' => true
                ];
            } else {
            	return [
                    'status' => false,
                    'data' => $response->getBody()
                ];
            }

        } catch(\GuzzleHttp\Exception\BadResponseException $e){
            return [
                'status' => false,
                'data' => $e->getResponse()
            ];
        }
    }
    
}