<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceNote;
use Livewire\WithPagination;
use Livewire\WithFileUploads;


class ShowServices extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $name, $descr, $is_active, $photo, $service_id, $note,$price;
    public $notes = [];
    public $updateMode = false;


    public function edit($id)
    {
        $this->updateMode = true;
        $service = Service::where('id', $id)->first();
        $this->service_id = $id;
        $this->name = $service->name;
        $this->price = $service->price;

        $this->descr = $service->descr;
        $this->is_active = $service->is_active;
        $this->photo = $service->photo;
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required|string',
            'descr' => 'string|nullable',
            // 'is_active' => 'nullable',
            // 'photo' => 'nullable|image',
        ]);

        // return $this->is_active;

        if ($this->service_id) {
            // $this->is_active = $validatedDate['is_active'] == 1 ? 1 : 0;
            $service = Service::find($this->service_id);
            // dd($this->photo, $service['photo']);
            if ($this->photo !== $service['photo']) {
                $photo_path = $this->photo->store('services');

                $service->update([
                    'name' => $this->name,
                    'descr' => $this->descr,
                    // 'is_active' => $this->is_active,
                    'photo' => $photo_path,
                    'price' =>$this->price,
                ]);
            } else {
                $service->update([
                    'name' => $this->name,
                    'descr' => $this->descr,
                    'price' =>$this->price,
                    // 'is_active' => $this->is_active,
                ]);
            }
            $this->updateMode = false;
            session()->flash('success', __('translation.item.updated.successfully'));
            $this->emit('areaUpdate'); // Close model to using to jquery
            $this->resetInputFields();
        }
    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->descr = '';
        $this->is_active = '';
        $this->photo = '';
        $this->note = '';
        $this->service_id = '';
    }
    public function showNotes($id)
    {
        $this->notes = ServiceNote::where('service_id', $id)->orderBy('id', 'DESC')->get();
        $this->service_id = $id;
    }

    public function addNote()
    {
        ServiceNote::create(['body' => $this->note, 'service_id' => $this->service_id]);
        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.show-services', [
            'data' => Service::orderBy('id', 'desc')->paginate(10),
        ]);
    }
}
