<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    const MAX_COUNT_OF_LIST = 10;

    public function test_getting_of_company_s_offices_by_client_email(): void
    {
        $company = $this->createCompanyWithClientAndOffices();
        $this->createCompaniesWithClientsAndOffices();
        $url = route('clients.offices.index', ['client' => $company->client->email]);

        $response = $this->get($url)->assertStatus(200);

        $response->assertJsonStructure(['data' => ['*' => ['id', 'number', 'created_at', 'updated_at']]]);
        $response->assertJsonCount($company->offices->count(), 'data');
        $this->assertNotEquals(Office::count(), $company->offices->count());
    }

    private function createCompanyWithClientAndOffices(): Company
    {
        $countOfOffices = $this->getRandomCount();

        return $this->createCompanyFactory($countOfOffices)->create();
    }

    private function createCompaniesWithClientsAndOffices(): void
    {
        $countOfOffices = $this->getRandomCount();
        $countOfCompanies = $this->getRandomCount();

        $this->createCompanyFactory($countOfOffices)->count($countOfCompanies)->create();
    }

    private function createCompanyFactory(int $countOfOffices): Factory
    {
        return Company::factory()
            ->has(Client::factory())
            ->has(Office::factory()->count($countOfOffices));
    }

    private function getRandomCount(): int
    {
        return $this->faker->numberBetween(1, self::MAX_COUNT_OF_LIST);
    }
}
