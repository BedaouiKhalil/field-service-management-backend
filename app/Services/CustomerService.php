<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function list(array $params)
    {
        $query = Customer::with(['wilaya', 'commune']);

        if (!empty($params['name'])) {
            $query->where('name', 'LIKE', '%' . $params['name'] . '%');
        }

        if (!empty($params['wilaya_id'])) {
            $query->where('wilaya_id', $params['wilaya_id']);
        }

        if (!empty($params['commune_id'])) {
            $query->where('commune_id', $params['commune_id']);
        }

        $limit = $params['limit'] ?? 10;

        return $query->latest()->paginate($limit);
    }

    public function store(array $data)
    {
        return Customer::create($data);
    }

    public function update(array $data, Customer $customer)
    {
        $customer->update($data);
        return $customer->fresh();
    }
}
