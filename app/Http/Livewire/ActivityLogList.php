<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLogList extends Component
{
    use WithPagination;

    public int|null $expanded = null;

    /**
     * @var Model|LogsActivity
     */
    public Model $model;

    protected $paginationTheme = 'simple-bootstrap';

    public function render()
    {
        $activities = $this->model->activities()->latest()->paginate(10);

        return view('livewire.activity-log-list', compact('activities'));
    }

    public function toggle(?int $id = null): void
    {
        if ($this->expanded !== $id) {
            $this->expanded = $id;
        } else {
            $this->expanded = null;
        }
    }
}
