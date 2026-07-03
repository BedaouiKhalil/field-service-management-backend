<?php

namespace App\Http\Controllers\api;

use App\Constants\Permissions;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $service
    ) {
        $this->middleware('permission:' . Permissions::VIEW_CUSTOMER)->only(['index', 'show']);
    }

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
