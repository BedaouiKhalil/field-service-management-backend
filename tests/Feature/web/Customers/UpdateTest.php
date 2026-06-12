<?php

declare(strict_types=1);

namespace Tests\Feature\web\Customers;

use App\Constants\Permissions;
use App\Models\Customer;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

#[Group('customers')]
#[Group('customers:update')]
final class CustomerUpdateTest extends CustomerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsUserWith(Permissions::MANAGE_CUSTOMER);
    }

    #[Test]
    public function it_renders_the_edit_view_with_correct_data(): void
    {
        $customer = Customer::factory()->create();
        $wilayas  = Wilaya::all();

        $this->getEditPage($customer)
            ->assertOk()
            ->assertViewIs('admin.customers.edit')
            ->assertViewHas('customer', fn ($c) => $c->id === $customer->id)
            ->assertViewHas('wilayas', fn ($w) => $w->pluck('id')->toArray() === $wilayas->pluck('id')->toArray())
            ->assertSeeText('Edit Customer')
            ->assertSee($customer->title);
    }

    #[Test]
    public function it_updates_a_customer_and_redirects(): void
    {
        $customer = Customer::factory()->create();
        $updatedPayload = Customer::factory()->make()->toArray();

        $this->updateCustomer($customer, $updatedPayload)
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas(
            'customers',
            $this->customerDatabaseFields($updatedPayload) + ['id' => $customer->id]
        );

        $this->assertDatabaseMissing(
            'customers',
            $this->customerDatabaseFields($customer->toArray()) + ['id' => $customer->id]
        );
    }

    // ─────────────────────────────────────────────
    // Authorization
    // ─────────────────────────────────────────────

    #[Test]
    public function it_redirects_guests_to_login(): void
    {
        auth()->logout();

        $this->updateCustomer(Customer::factory()->create())
            ->assertRedirect(route('login'));
    }

    #[Test]
    public function it_forbids_users_without_permission(): void
    {
        $customer = Customer::factory()->create();

        $this->actingAs(User::factory()->create())
            ->getEditPage($customer)
            ->assertForbidden();
    }

    #[Test]
    public function it_does_not_persist_when_forbidden(): void
    {
        $customer      = Customer::factory()->create();
        $originalName  = $customer->name;

        $this->actingAs(User::factory()->create())
            ->updateCustomer($customer, ['name' => 'Hacked Name']);

        $this->assertDatabaseHas('customers', [
            'id'   => $customer->id,
            'name' => $originalName,
        ]);
    }

    // ─────────────────────────────────────────────
    // Validation
    // ─────────────────────────────────────────────

    #[Test]
    #[DataProvider('requiredFieldsProvider')]
    public function it_rejects_missing_required_field(string $field): void
    {
        $customer        = Customer::factory()->create();
        $payload         = Customer::factory()->make()->toArray();
        $payload[$field] = '';

        $this->updateCustomer($customer, $payload)
            ->assertSessionHasErrors($field);
    }

    public static function requiredFieldsProvider(): array
    {
        return [
            'name is required'       => ['name'],
            'wilaya_id is required'  => ['wilaya_id'],
            'commune_id is required' => ['commune_id'],
        ];
    }

    #[Test]
    public function it_rejects_a_duplicate_nif(): void
    {
        $customerA = Customer::factory()->create();
        $customerB = Customer::factory()->create();

        $this->updateCustomer(
            $customerB,
            Customer::factory()->make(['nif' => $customerA->nif])->toArray()
        )->assertSessionHasErrors('nif');
    }

    #[Test]
    public function it_allows_keeping_own_nif(): void
    {
        $customer = Customer::factory()->create();

        $this->updateCustomer(
            $customer,
            Customer::factory()->make(['nif' => $customer->nif])->toArray()
        )->assertRedirect(route('admin.customers.index'));
    }

    #[Test]
    public function it_does_not_persist_on_validation_failure(): void
    {
        $customer     = Customer::factory()->create();
        $originalName = $customer->name;

        $this->updateCustomer($customer, ['name' => '', 'nif' => '']);

        $this->assertDatabaseHas('customers', [
            'id'   => $customer->id,
            'name' => $originalName,
        ]);
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────

    private function getEditPage(Customer $customer): TestResponse
    {
        return $this->get(route('admin.customers.edit', $customer));
    }

    private function updateCustomer(Customer $customer, array $payload = []): TestResponse
    {
        $payload = $payload ?: Customer::factory()->make()->toArray();

        return $this->patch(route('admin.customers.update', $customer), $payload);
    }
}
