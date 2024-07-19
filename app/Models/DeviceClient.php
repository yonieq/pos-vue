<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceClient extends Model
{
    use HasFactory;

    protected $connection = 'master';
    protected $table = 'device_clients';

    protected $guarded = [];
}