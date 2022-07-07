<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;
    public static function boot(){
        parent::boot();
        self::created(function ($order){
            info($order);
            Client::find($order->client_id)->update(['in_accounts_order' => 1]);
        });
    }
    protected $fillable = [
        'service_id',
        'tracking_number',
        'client_id',
        'sender_name',
        'sender_area_id',
        'sender_sub_area_id',
        'sender_address',
        'sender_phone',
        'representative_id',
        'receiver_name',
        'receiver_area_id',
        'receiver_sub_area_id',
        'receiver_address',
        'receiver_phone_no',
        'police_file',
        'receipt_file',
        'note',
        'delivery_fees',
        'order_fees',
        'total_fees',
        'payment_method',
        'is_company_fees_collected',
        'is_client_payment_made',
        'order_date',
        'delivery_date',
        'status',
        'transaction_id',
        'client_payment_transaction_id',
        'is_police_file_sent',
        'invoice_sn',
        'number_of_pieces',
        'is_deleted',
        'order_weight',
        'order_value',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function representative()
    {
        return $this->belongsTo(Representative::class, 'representative_id', 'id');
    }
    public function receiverArea()
    {
        return $this->belongsTo(Area::class, 'receiver_area_id', 'id');
    }
    public function receiverSubArea()
    {
        return $this->belongsTo(SubArea::class, 'receiver_sub_area_id', 'id');
    }
    public function senderArea()
    {
        return $this->belongsTo(Area::class, 'sender_area_id', 'id');
    }
    public function senderSubArea()
    {
        return $this->belongsTo(SubArea::class, 'sender_sub_area_id', 'id');
    }

    public function scopeIsDeleted($query)
    {
        return $query->where('is_deleted', 0);
    }

    public function OrderTracking()
    {
        return $this->hasMany(OrderTracking::class, 'order_id', 'id');
    }


}
