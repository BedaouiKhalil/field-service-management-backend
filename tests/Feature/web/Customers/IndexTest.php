<?php

declare(strict_types=1);

namespace Tests\Feature\web\Customers;

use App\Constants\Permissions;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

#[Group('customers')]
#[Group('customers:index')]
final class IndexTest extends CustomerTestCase
{
    private int $paginationLimit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paginationLimit = config('app.defaults.pagination_limit', 10);

        $this->actingAsUserWith(Permissions::VIEW_CUSTOMER);
    }

    #[Test]
    public function it_renders_the_index_view(): void
    {
        $this->getIndex()
            ->assertOk()
            ->assertViewIs('admin.customers.index')
            ->assertSeeText(['Customers', 'Location']);
    }

    #[Test]
    public function it_passes_customers_to_the_view(): void
    {
        Customer::factory()->count(4)->create();


        $this->getIndex()
            ->assertViewHas('customers', function ($customers) {
                $this->assertGreaterThanOrEqual(4, $customers->count());
                return true;
            });
        // ->assertViewHas('customers', fn ($c) => $c->count() === 4);
    }

    #[Test]
    public function it_paginates_results(): void
    {
        Customer::factory()->count($this->paginationLimit + 20)->create();

        $this->getIndex()
            ->assertViewHas('customers', function ($customers) {
                return $customers->perPage()  === $this->paginationLimit
                    && $customers->count()    === $this->paginationLimit
                    && $customers->lastPage() > 1;
            });
    }

    // ─────────────────────────────────────────────
    // Authorization
    // ─────────────────────────────────────────────

    #[Test]
    public function it_redirects_guests_to_login(): void
    {
        auth()->logout();

        $this->getIndex()
            ->assertRedirect(route('login'));
    }

    #[Test]
    public function it_forbids_users_without_permission(): void
    {
        $this->actingAs(User::factory()->create())
            ->getIndex()
            ->assertForbidden();
    }

    #[Test]
    public function it_allows_access_after_granting_permission(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->getIndex()->assertForbidden();

        $user->givePermissionTo(Permissions::VIEW_CUSTOMER);

        $this->actingAs($user)->getIndex()->assertOk();
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────

    private function getIndex(): TestResponse
    {
        return $this->get(route('admin.customers.index'));
    }
}
