<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowOrderTracking extends Component
{
    public $searchText;
    public $data = [];
    public $tracking_id;

    public function search()
    {
        $this->data = DB::table('orders')->select('order_trackings.*')
            ->join('order_trackings', 'order_trackings.order_id', '=', 'orders.id')
            ->where('tracking_number', $this->searchText)
            ->get();
        // dd($this->data->count());
        if ($this->data->count() == 0) {
            session()->flash('error', __('translation.data.not.found'));
        }
    }

    public function mount()
    {
        // dd($this->tracking_id);
        if ($this->tracking_id) {
            $this->searchText = $this->tracking_id;
            $this->search();
        }
    }
    public function render()
    {
        return view('livewire.show-order-tracking', [
            'data' => $this->data,
        ]);
    }
}
