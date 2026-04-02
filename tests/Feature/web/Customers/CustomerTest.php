<?php

namespace Tests\Feature\web\Customers;

use App\Constants\Permissions;
use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_check_if_index_works_fine(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permissions::VIEW_CUSTOMER);

        $response = $this->actingAs($user)->get(route('admin.customers.index'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertViewIs('admin.customers.index');
        $response->assertSeeText('Customers');
        $response->assertSeeText('Location');
    }

    public function test_check_if_index_contains_datas()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permissions::VIEW_CUSTOMER);

        Customer::truncate();
        Customer::factory()->count(4)->create();

        $response = $this->actingAs($user)->get(route('admin.customers.index'));
        $response->assertViewHas('customers', function ($customers) {
            return $customers->count() == 4;
        });
    }

    public function test_check_if_pagination_works()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permissions::VIEW_CUSTOMER);

        Customer::truncate();
        Customer::factory()->count(15)->create();

        $response = $this->actingAs($user)->get('/dashboard/customers');
        $response->assertViewHas('customers', function ($customers) {
            return $customers->count() == 10;
        });

        $response = $this->actingAs($user)->get('/dashboard/customers?page=2');
        $response->assertViewHas('customers', function ($customers) {
            return $customers->count() == 5;
        });
    }
}
