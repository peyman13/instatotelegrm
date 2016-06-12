<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use MetzWeb\Instagram\Instagram;

use Input;
use Session;

class InstagaramController extends Controller
{
	public $instagram;

	public function __construct(){
		$this->instagram = new Instagram(array(
            'apiKey'      => 'a39e526f057246bba8a36e6183abf584',
            'apiSecret'   => '66f14b75d1b44e31b7044b2062799497',
            'apiCallback' => 'http://192.168.91.128/instagram/redirect'
        ));
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        echo "<a href=".$this->instagram->getLoginUrl(['basic','public_content','follower_list']).">Login with Instagram</a>";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect(Request $request)
    {
        // grab OAuth callback code
		$code = Input::get("code");
		$data = $this->instagram->getOAuthToken($code);

        $request->session()->put('token', $data->access_token);

        $curl = curl_init();
        // Set some options - we are passing in a useragent too here

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/users/self/?access_token='.$request->session()->get('token')
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $request->session()->put('info', $resp);

        Session::save();

        return redirect('instagram/selfMedia');
    }

    public function selfMedia(Request $request){
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$request->session()->get('token')
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        $data = json_decode($resp,true)['data'];

        return view("panel.selfmedia",["data" => json_decode($resp,true)['data']]);
    }    

    public function getMedia(Request $request, $mediaid){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/media/'.$mediaid.'?access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $decode = json_decode($resp);
        print_r($decode);

        dd($request->session()->get('token'));
    }    

    public function getLikeMedia(Request $request, $mediaid){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/media/'.$mediaid.'/likes?access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $decode = json_decode($resp,true);

        return $decode;
    }    

    public function getCommentMedia(Request $request, $mediaid){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/media/'.$mediaid.'/comments?access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $decode = json_decode($resp,true);

        return $decode;
    } 

    public function getShortCode(Request $request){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/media/shortcode/BGKCHwqECyWe0geVWNulEzO-ppDfK2vx6adQ1Q0?access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $decode = json_decode($resp);
        print_r($decode);

        dd($request->session()->get('token'));
        // https://api.instagram.com/v1/users/self/media/recent/?access_token=ACCESS-TOKEN
    }    

    public function shearchUser(Request $request){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/users/search?q=peymandev&access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $decode = json_decode($resp);
        print_r($decode);

        dd($request->session()->get('token'));
        // https://api.instagram.com/v1/users/self/media/recent/?access_token=ACCESS-TOKEN
    }
    public function getTimeLine(Request $request){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/users/3314463177/media/recent/?access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $decode = json_decode($resp);
        print_r($decode);

        dd($request->session()->get('token'));
        // https://api.instagram.com/v1/users/self/media/recent/?access_token=ACCESS-TOKEN
    }    
    public function follows(Request $request){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/users/self/follows?access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        
        return view("panel.follow",["data" => json_decode($resp,true)['data'], "title" => "follow"]);
    }    

    public function followed_by(Request $request){
        // set user access token

        // $token = session();
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/users/self/followed-by?access_token='.$request->session()->get('token')
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $decode = json_decode($resp, true);

        return view("panel.follow",["data" => json_decode($resp,true)['data'], "title" => "follow_by"]);
    }



}
