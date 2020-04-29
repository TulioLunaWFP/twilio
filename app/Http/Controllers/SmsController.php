<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use DB;

class SmsController extends Controller
{
    public function index()
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $client = new Client($accountSid, $authToken);

        
        $sqlcustomer = DB::table('customers')->where('id','<',1900)->orderby('id','desc')->get(); //for less than 1900 citezens is optional 
     


        foreach($sqlcustomer as $customer)
        {
        
        
        try
        {
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                $customer->CellularPhone,
           array(
                 // A Twilio phone number you purchased at twilio.com/console
                 'from' => '+123459789', //your valid twilio nunmber
                 // the body of the text message you'd like to send
                 'body' => 'Hello! '. $customer->FirstName. ' This is an alert from city hall!!!',
                 "mediaUrl" => array("http://localhost/mms/public/mms/alert.jpg") //localhost or your ip o your domain
             )
         );
        }
    
        catch (Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }


        }//fin del foreach


        //public function
        }

//class Controller
}

?>
