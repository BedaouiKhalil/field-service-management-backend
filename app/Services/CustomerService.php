<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function list(array $params)
    {
        $query = Customer::with(['wilaya', 'commune']);

        $name = data_get($params, 'name');
        $wilayaId = data_get($params, 'wilaya_id');
        $communeId = data_get($params, 'commune_id');

        if (!empty($name)) {
            $query->where('name', 'LIKE', "%$name%");
        }

        if (!empty($wilayaId)) {
            $query->where('wilaya_id', $wilayaId);
        }

        if (!empty($communeId)) {
            $query->where('commune_id', $communeId);
        }

        $limit = min(data_get($params, 'limit', 10), 100);

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
