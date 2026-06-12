<?php

declare(strict_types=1);

namespace Tests\Feature\web\Customers;

use App\Constants\Permissions;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

#[Group('customers')]
#[Group('customers:store')]
final class StoreTest extends CustomerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsUserWith(Permissions::MANAGE_CUSTOMER);
    }

    #[Test]
    public function it_stores_a_customer_and_redirects(): void
    {
        $payload = Customer::factory()->make()->toArray();

        $this->storeCustomer($payload)
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('customers', $this->customerDatabaseFields($payload));
    }

    #[Test]
    public function it_increments_the_customer_count(): void
    {
        $before = Customer::count();

        $this->storeCustomer();

        $this->assertDatabaseCount('customers', $before + 1);
    }

    // ─────────────────────────────────────────────
    // Authorization
    // ─────────────────────────────────────────────

    #[Test]
    public function it_redirects_guests_to_login(): void
    {
        auth()->logout();

        $this->storeCustomer()
            ->assertRedirect(route('login'));
    }

    #[Test]
    public function it_forbids_users_without_permission(): void
    {
        $this->actingAs(User::factory()->create())
            ->storeCustomer()
            ->assertForbidden();
    }

    #[Test]
    public function it_does_not_persist_when_forbidden(): void
    {
        $before = Customer::count();

        $this->actingAs(User::factory()->create())->storeCustomer();

        $this->assertDatabaseCount('customers', $before);
    }

    // ─────────────────────────────────────────────
    // Validation
    // ─────────────────────────────────────────────

    #[Test]
    #[DataProvider('requiredFieldsProvider')]
    public function it_rejects_missing_required_field(string $field): void
    {
        $payload = Customer::factory()->make()->toArray();
        $payload[$field] = '';

        $this->storeCustomer($payload)
            ->assertSessionHasErrors($field);
    }

    public static function requiredFieldsProvider(): array
    {
        return [
            'name is required'       => ['name'],
            'nif is required'        => ['nif'],
            'wilaya_id is required'  => ['wilaya_id'],
            'commune_id is required' => ['commune_id'],
        ];
    }

    #[Test]
    public function it_rejects_a_duplicate_nif(): void
    {
        $existing = Customer::factory()->create();

        $this->storeCustomer(
            Customer::factory()->make(['nif' => $existing->nif])->toArray()
        )->assertSessionHasErrors('nif');
    }

    #[Test]
    public function it_does_not_persist_on_validation_failure(): void
    {
        $before = Customer::count();

        $this->storeCustomer([]);

        $this->assertDatabaseCount('customers', $before);
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────

    private function storeCustomer(?array $payload = null): TestResponse
    {
        $payload ??= Customer::factory()->make()->toArray();

        return $this->post(route('admin.customers.store'), $payload);
    }
}
