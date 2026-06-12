<?php

declare(strict_types=1);

namespace Tests\Feature\web\Customers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

abstract class CustomerTestCase extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $user;

    protected function actingAsUserWith(string ...$permissions): static
    {
        $this->user = $this->createUserWith(...$permissions);
        $this->actingAs($this->user);

        return $this;
    }

    protected function createUserWith(string ...$permissions): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo($permissions);

        return $user;
    }

    protected function customerDatabaseFields(array $data): array
    {
        return Arr::only($data, [
            'name',
            'nif',
            'wilaya_id',
            'commune_id',
        ]);
    }
}
