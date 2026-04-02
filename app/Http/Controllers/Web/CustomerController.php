<?php

namespace App\Http\Controllers\Web;

use App\Constants\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AddRequest;
use App\Http\Requests\Customer\EditRequest;
use App\Models\Customer;
use App\Models\Wilaya;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $service
    ) {
        $this->middleware('permission:' . Permissions::VIEW_CUSTOMER)->only(['index', 'show']);
        $this->middleware('permission:' . Permissions::MANAGE_CUSTOMER)->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = $this->service->list($request->all());

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wilayas = Wilaya::all();
        return view('admin.customers.create', compact('wilayas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddRequest $request)
    {
        $customer = $this->service->store($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $wilayas = Wilaya::all();

        return view('admin.customers.edit', compact('customer', 'wilayas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Customer $customer)
    {
        $customer = $this->service->update($request->validated(), $customer);

        return redirect()->back()
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->back()
            ->with('success', 'Customer deleted successfully.');
    }
}
