<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTenant extends Model
{
    use HasFactory;

    protected $connection = 'master';
    protected $table = 'sales_tenants';
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(SalesDetailTenant::class);
    }
}
