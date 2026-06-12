<?php

namespace App\Http\Controllers\api;

use App\Models\Customer;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $service
    ) {}

    public function index(Request $request)
    {
        $data = $this->service->list($request->all());

        return ApiResponse::paginated(collection: CustomerResource::collection($data) ,message: 'Customers list retrieved successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return ApiResponse::success(message: 'Customer details retrieved successfully', data: new CustomerResource($customer));
    }
}
