<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubArea;
use App\Scope\ApprovedScope;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Stmt\Static_;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'sub_area_id',
        'phone',
        'address',
        'is_active',
        'is_approved',
        'discount_rate',
        'account_balance',
        'is_has_custom_price',
        'message_token',
        'area_id',
        'in_accounts_order',
        'client_type',
        'bank',
        'activity',
        'name_in_invoice',
        'bank_account_owner',
        'bank_account_number',
        'iban_number',
        'civil_registry',
    ];

    protected static function boot()
    {
        parent::boot();
        // Static::addGlobalScope(new ApprovedScope);
    }
    // protected $append = ['orignalPhone'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['area_id', 'orignal_phone'];

    public function subArea()
    {
        return $this->belongsTo(SubArea::class, 'sub_area_id');
    }
    public function Area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function getAreaIdAttribute($key)
    {
        return  $this->subArea->area_id ?? null;
    }

    public function ServicePrice()
    {
        return $this->hasMany(ClientServicePrice::class);
    }

    // public function Area(){
    //     return $this->hasOne(Area::class);
    // }

    public function ClientKeys()
    {
        return $this->hasOne(ClientsTokens::class);
    }
    public function getOrignalPhoneAttribute()
    {
        return substr($this->phone, 4);
    }

    public function Orders()
    {
        return $this->hasMany(Order::class)->where('is_collected', 0);
    }

    public function Files()
    {
        return $this->morphMany(clientsFile::class, 'fileable');
    }
    public function getPendingCount()
    {
        return $this->Orders()->where('status', 'pending')->count();
    }

    public function getInProgress()
    {
        return $this->Orders()->where('status', 'inProgress')->count();
    }

    public function getPickup()
    {
        return $this->Orders()->where('status', 'pickup')->count();
    }
}