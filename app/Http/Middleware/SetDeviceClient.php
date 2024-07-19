<?php

namespace App\Http\Middleware;

use App\Models\DeviceClient;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SetDeviceClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     // Periksa apakah 'device_id' ada di dalam sesi
    //     if (empty(session()->get('device_id'))) {
    //         return response()->view('errors.error_device', [], 400);
    //     } else {
    //         $device_id = session()->get('device_id');
    //         Log::info('device_id : ' . $device_id);

    //         $checkDevice = DeviceClient::where('value', $device_id)->get();

    //         if ($checkDevice->isEmpty()) {
    //             session()->forget('device_id');
    //             return response()->view('errors.error_device', [], 400);
    //         }
    //     }
    //     // Lanjutkan eksekusi middleware jika 'device_id' ada di dalam sesi
    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah 'device_id' ada di dalam sesi
        if (empty(session()->get('device_id'))) {
            return response()->view('errors.error_device', ['device_id' => 'Unknown (Please Open From Apps)'], 400);
        } else {
            $device_id = session()->get('device_id');
            // Jika 'device_id' adalah array, periksa masing-masing nilai
            $checkDevice = DeviceClient::where('value', $device_id)->first();

            if (empty($checkDevice)) {
                // kalo dia ga ada device_id
                return response()->view('errors.error_device', ['device_id' => $device_id], 400);
            }
        }
        // Lanjutkan eksekusi middleware jika 'device_id' ada di dalam sesi
        return $next($request);
    }
}