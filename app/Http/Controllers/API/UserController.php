<?php

namespace App\Http\Controllers\API;

use App\User;
use App\UserDetail;
use App\UserDriver;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client as OClient;

class UserController extends Controller
{
    public function login() {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $oClient = OClient::where('password_client', 1)->first();
            return $this->getTokenAndRefreshToken($oClient, request('email'), request('password'));
        }
        else {
            return response()->json([
                'success' => false,
                'error'=>'Login failed.'], 401);
        }
    }

    public function register(Request $request) {
        $name = substr($request->email,0,(stripos($request->email, "@")));
        if($request->name) { $name = $request->name;}

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data'=>$validator->errors()], 401);
        }

        $password = $request->password;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $detailInput['name'] = $name;
        $detailInput['user_id'] = $user->id;
        $detail = UserDetail::create($detailInput);
        $oClient = OClient::where('password_client', 1)->first();
        return $this->getTokenAndRefreshToken($oClient, $user->email, $password);
    }

    public function getTokenAndRefreshToken(OClient $oClient, $email, $password) {
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;
        $response = $http->request('POST', $_ENV['APP_URL'].'oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);

        $result = json_decode((string) $response->getBody(), true);
        return response()->json([
            'success' => true,
            'data' => $result], 200);
    }

    public function details(Request $request) {
        $detail = UserDetail::where('user_id', $request->user()->id)->first();
        $driver = UserDriver::where('user_id', $request->user()->id)->first();
        return response()->json([
            'success' => true,
            "role"=> $request->user()->role,
            "email"=> $request->user()->email,
            "email_verified_at"=> $request->user()->email_verified_at,
            "name"=> $detail->name,
            "url_img"=> $detail->url_img,
            "url_ktp"=> $detail->url_ktp,
            "ktp_confirmed"=> $detail->ktp_confirmed,
            "no_hp"=> $detail->no_hp,
            "no_hp_confirmed"=> $detail->no_hp_confirmed,
            "status"=> $detail->status,
            "address"=> $detail->address,
            "birthday"=> $detail->birthday,
            "rt"=> $detail->rt,
            "shop"=> $detail->shop,
            "driver"=> $detail->driver,
            "community"=> $detail->community,
            "is_active"=> $detail->is_active], 200);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data'=>$validator->errors()], 401);
        }
        $password = User::whereId($request->user()->id)->update([
            'password'   => bcrypt($request->password),
        ]);
        if ($password) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal!',
            ], 500);
        }
    }

    public function updateDetails(Request $request)
    {
        $detail = UserDetail::where('user_id', $request->user()->id)->update([
            'name'     => $request->input('name'),
            'no_hp'    => $request->input('no_hp'),
            'status'   => $request->input('status'),
            'address'  => $request->input('address'),
            'birthday' => $request->input('birthday'),
        ]);
        if ($detail) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal!',
            ], 500);
        }
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/profil';
        $file->move($tujuan_upload,$nama_file);
        $detail = UserDetail::where('user_id', $request->user()->id)->update([
            'url_img' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function uploadKtp(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_ktp_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/shop';
        $file->move($tujuan_upload,$nama_file);
        $detail = UserDetail::where('user_id', $request->user()->id)->update([
            'url_ktp' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'data' => 'Successfully logged out'
        ]);
    }

    public function refreshToken(Request $request) {
        $refresh_token = $request->header('Refreshtoken');
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;

        try {
            $response = $http->request('POST', $_ENV['APP_URL'].'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refresh_token,
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'scope' => '*',
                ],
            ]);
            return json_decode([
                'success' => true,
                'data' => (string) $response->getBody()], true);
        } catch (Exception $e) {
            return response()->json([
            'success' => false,
            'data' => 'unauthorized',
            'error' => $e], 401);
        }
    }

    public function unauthorized() {
        return response()->json([
            'success' => false,
            'data' => 'unauthorized'], 401);
    }
}
