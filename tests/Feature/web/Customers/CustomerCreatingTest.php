<?php

namespace Tests\Feature\web\Customers;

use App\Constants\Permissions;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class CustomerCreatingTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    protected $limit;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->givePermissionTo(Permissions::MANAGE_CUSTOMER);

        $this->actingAs($this->user);
    }

    public function test_check_if_create_page_open_successfuly(): void
    {
        $response = $this->get(route('admin.customers.create'));

        $response->assertOk()
            ->assertViewIs('admin.customers.create')
            ->assertSeeText('Create Customer');
    }

    public function test_create_customer(): void
    {
        $customer = Customer::factory()->make();

        $response = $this->post(route('admin.customers.store'), $customer->toArray());
        
        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('admin.customers.create'))
            ->assertSessionHas('success', 'Customer created successfully.');
        $this->assertDatabaseHas('customers', $customer->toArray());
    }
}
