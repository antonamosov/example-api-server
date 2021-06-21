<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_storing(): void
    {
        $this->fakeSynchronization();
        $request = $this->getStoreRequest();

        $this->storeUserWithAssertions($request);
    }

    public function test_user_storing_if_address_is_empty(): void
    {
        $this->fakeSynchronization();
        $request = $this->getStoreRequest();
        unset($request['address']);

        $this->storeUserWithAssertions($request);
    }

    public function test_user_storing_if_email_does_not_exist_in_request(): void
    {
        $this->fakeSynchronization();
        $request = $this->getStoreRequest();
        unset($request['email']);

        $this->storeUserWithAssertions($request, 422);
    }

    public function test_user_storing_if_email_is_null(): void
    {
        $this->fakeSynchronization();
        $request = $this->getStoreRequest(['email' => null]);

        $this->storeUserWithAssertions($request, 422);
    }

    public function test_user_updated_if_user_with_this_email_exists(): void
    {
        $this->fakeSynchronization();
        $user = User::factory()->create();
        $request = $this->getStoreRequest(['email' => $user->email]);

        $this->storeUserWithAssertions($request);
    }

    public function test_user_storing_if_a_synchronization_is_failed(): void
    {
        $syncResponseStatus = $this->faker->numberBetween(400, 530);
        $this->fakeSynchronization($syncResponseStatus);
        $request = $this->getStoreRequest();

        $this->storeUserWithAssertions($request, 500);
        $this->assertDatabaseMissing('users', ['email' => $request['email']]);
    }

    public function test_user_updating_if_a_synchronization_is_failed(): void
    {
        $syncResponseStatus = $this->faker->numberBetween(400, 530);
        $this->fakeSynchronization($syncResponseStatus);
        $user = User::factory()->create();
        $request = $this->getStoreRequest(['email' => $user->email]);
        $userFields = Arr::only($user->toArray(), array_keys($request));

        $this->storeUserWithAssertions($request, 500);
        $this->assertDatabaseHas('users', $userFields);
    }

    private function fakeSynchronization(int $status = 200)
    {
        Http::fake(['https://example.com/users' => Http::response(null, $status)]);
    }

    private function storeUserWithAssertions(array $request, int $status = 200)
    {
        $response = $this->putJson('api/users', $request);

        $response->assertStatus($status);
        if ($status === 200) {
            $this->assertDatabaseHas('users', $request);
        }
    }

    private function getStoreRequest(array $additions = []): array
    {
        $request = User::factory()->raw();

        return array_merge($request, $additions);
    }
}
