<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function showLogin(){
        return view('log');
    }

    public function normalLogin(Request $request)
    {
        $client = new Client();
        $userName = $request->input('name');
        $passWord = $request->input('password');

        // $serial_number = $request->input('serial_number');
        $serial_number = "111122223333345";

        $response = $client->request('POST', 'http://10.128.51.123:880/api/loginwithUnamePWKey', [
            'form_params' => [
                'name' => $userName,
                'password' => $passWord,
                'serial_number' => $serial_number
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $responseData = json_decode($response->getBody(), true);
        // $token =str($responseData['access_token']);




        $id = intval($responseData['id']);

        return response()->json(["user_id"=>$id]);
        // return $token;

    }

    public function loginWithOTP(Request $request)
    {
        $client = new Client();
        $userId = $request->input('user_id');
        $userOTP = $request->input('otp');
        try {

            $response = $client->request('POST', 'http://10.128.51.123:880/api/otp/login', [
                'form_params' => [
                    'user_id' => $userId,
                    'otp' => $userOTP
                ],

            ]);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);
            // Access the "Status" value from the response JSON
            $status = $responseData['status'];

            //perform action based on the status value
            if ($status == 200) {
                // return response()->json(['true']);
                return view('index');


            } else {
                return response("OTP Authentication Failed...Please try again");

                // return response()->json(['false']);
            }
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $errorMessage = $e->getMessage();
        }

        return response()->json([
            'statusCode' => $statusCode,
            'message' => isset($errorMessage) ? $errorMessage : 'Success',
        ]);
    }





    public function normalLogin22(Request $request)
    {

        try{

            $client = new Client();
       $aduserName = $request->input('name');
        $userName = "bluechip\\".$aduserName;
        $passWord = $request->input('password');

        // $serial_number = $request->input('serial_number');
        $serial_number = "111122223333345";

        $response = $client->request('POST', 'http://10.128.51.123:880/api/loginwithUnamePWKey', [
            'form_params' => [
                'name' => $userName,
                'password' => $passWord,
                'serial_number' => $serial_number
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $responseData = json_decode($response->getBody(), true);
        // $token =str($responseData['access_token']);




        $id = intval($responseData['id']);

        return view('OTP', [
            "user_id" => $id

        ]);

        }catch(Exception $e){

            return response("You AD username or Password incorrect");

        }



        // return response()->json(["user_id"=>$id]);
        // return $token;

    }

}
