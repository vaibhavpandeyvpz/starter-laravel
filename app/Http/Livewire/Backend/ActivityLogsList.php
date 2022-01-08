<?php

namespace App\Http\Livewire\Backend;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLogsList extends Component
{
    use WithPagination;

    /**
     * @var int|null
     */
    public $expanded;

    /**
     * @var Model|LogsActivity
     */
    public $model;

    /**
     * @param Model|LogsActivity $model
     * @return void
     */
    public function mount($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        $activities = $this->model->activities()->latest()->paginate(10);
        return view('livewire.backend.activity-logs-list', compact('activities'));
    }

    public function toggle(?int $id = null)
    {
        if ($this->expanded !== $id) {
            $this->expanded = $id;
        } else {
            $this->expanded = null;
        }
    }
}
