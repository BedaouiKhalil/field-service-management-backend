<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{

    public function list(array $params)
    {
        $query = Task::with(['customer', 'technician']);
        $title = trim(data_get($params, 'title'));
        $status = trim(data_get($params, 'status'));
        $customer_id = data_get($params, 'customer_id');
        $technician_id = data_get($params, 'technician_id');

        if ($title) {
            $query->where('title', 'like', "%$title%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }

        if ($technician_id) {
            $query->where('technician_id', $technician_id);
        }

        $limit = min(data_get($params, 'limit', 10), 100);
        return $query->latest()->paginate($limit);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $task = Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'customer_id' => $data['customer_id'],
                'technician_id' => $data['technician_id'],
            ]);

            return $task;
        });
    }

    public function update(array $data, Task $task)
    {
        return DB::transaction(function () use ($data, $task) {

            $task->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'customer_id' => $data['customer_id'],
                'technician_id' => $data['technician_id'],
            ]);

            return $task;
        });
    }
}
