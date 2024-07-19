<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\DeviceClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{

    //--------------- Function Login ----------------\\

    public function getAccessToken(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $userStatus = Auth::User()->statut;
            if ($userStatus === 0) {
                return response()->json([
                    'message' => 'This user not active',
                    'status' => 'NotActive',
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Incorrect Login',
                'status' => false,
            ]);
        }

        $user = auth()->user();
        $tokenResult = $user->createToken('Access Token');
        $token = $tokenResult->token;
        $this->setCookie('Stocky_token', $tokenResult->accessToken);

        return response()->json([
            'Stocky_token' => $tokenResult->accessToken,
            'username' => Auth::User()->username,
            'status' => true,
        ]);
    }

    //--------------- Function Logout ----------------\\

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user()->token();
            $user->revoke();
            $this->destroyCookie('Stocky_token');
            return response()->json('success');
        }
    }


    public function destroy_session()
    {
        // Hapus semua session kecuali session CSRF
        session()->forget(['_token']);
        session()->forget(['table_name']);

        /// Ambil semua value dari kolom 'value' di tabel DeviceClient
        $device_ids = DeviceClient::pluck('value')->toArray();

        // Masukkan semua nilai ke dalam sesi 'device_id'
        session()->put('device_id', $device_ids);

        return response()->json([
            'status' => true,
        ], 200);
    }

    public function getDeviceId(Request $request)
    {
        $device_id = $request->deviceId;
        // cek device id from datatabase
        $checkDevice = DeviceClient::where('value', $device_id)->first();

        // dd($checkDevice);

        if (!empty($checkDevice)) {
            // set session device id
            session()->put('device_id', $device_id);
            // cek session auth login
            Auth::user();

            return redirect('/app/dashboard');
        } else {

            // if (!empty(session()->get('device_id'))) {
            //     $device = $device_id;
            // } else {
            //     $device = session()->get('device_id');
            // }

            return view('errors.error_device', ['device_id' => $device_id]);
        }
    }
}