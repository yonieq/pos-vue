<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetailTenant extends Model
{
    use HasFactory;

    protected $connection = 'master';
    protected $table = 'sales_detail_tenants';
    protected $guarded = [];

    public function sales()
    {
        return $this->belongsTo(SalesTenant::class);
    }
}
