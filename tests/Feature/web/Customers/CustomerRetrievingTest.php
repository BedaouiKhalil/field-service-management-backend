<?php

namespace Tests\Feature\web\Customers;

use App\Constants\Permissions;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerRetrievingTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    protected $limit;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->limit = config('app.defaults.pagination_limit', 10);

        $this->user = User::factory()->create();
        $this->user->givePermissionTo(Permissions::VIEW_CUSTOMER);

        $this->actingAs($this->user);
    }

    public function test_check_if_index_open_successfuly(): void
    {
        $response = $this->get(route('admin.customers.index'));

        $response->assertOk()
            ->assertViewIs('admin.customers.index')
            ->assertSeeText(['Customers', 'Location']);
    }

    public function test_check_if_index_contains_datas()
    {
        Customer::query()->delete();
        Customer::factory()->count(4)->create();

        $response = $this->get(route('admin.customers.index'));

        $response->assertViewHas('customers', function ($customers) {
            return $customers->count() == 4;
        });
    }

    public function test_check_if_pagination_works(): void
    {
        $extra = 20;
        $totalToCreate = $this->limit + $extra;

        Customer::factory()->count($totalToCreate)->create();

        $response = $this->get(route('admin.customers.index'));

        $response->assertViewHas('customers', function ($customers) {
            return $customers->perPage() === $this->limit
                && $customers->count() === $this->limit
                && $customers->lastPage() > 1;
        });
    }


    public function test_customer_index_permission()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('admin.customers.index'))
            ->assertForbidden();

        $user->givePermissionTo(Permissions::VIEW_CUSTOMER);

        $this->get(route('admin.customers.index'))
            ->assertOk();
    }
}
