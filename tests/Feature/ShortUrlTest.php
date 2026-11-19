<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $role, ?Company $company = null): User
    {
        return User::factory()->create([
            'role' => $role,
            'company_id' => $company?->id,
        ]);
    }

    private function makeUrl(User $user, string $code): ShortUrl
    {
        return ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => 'https://example.com/' . $code,
            'short_code' => $code,
        ]);
    }

    public function test_admin_and_member_can_create_short_urls(): void
    {
        $company = Company::create(['name' => 'Acme']);

        foreach (['admin', 'member'] as $role) {
            $user = $this->makeUser($role, $company);

            $this->actingAs($user)
                ->post('/urls', ['original_url' => 'https://example.com'])
                ->assertRedirect(route('dashboard'));

            $this->assertDatabaseHas('short_urls', ['user_id' => $user->id]);
        }
    }

    public function test_superadmin_cannot_create_short_urls(): void
    {
        $superAdmin = $this->makeUser('superadmin');

        $this->actingAs($superAdmin)
            ->post('/urls', ['original_url' => 'https://example.com'])
            ->assertForbidden();

        $this->assertDatabaseCount('short_urls', 0);
    }

    public function test_superadmin_can_see_urls_of_all_companies(): void
    {
        $companyA = Company::create(['name' => 'A']);
        $companyB = Company::create(['name' => 'B']);

        $this->makeUrl($this->makeUser('admin', $companyA), 'AAA111');
        $this->makeUrl($this->makeUser('admin', $companyB), 'BBB111');

        $this->actingAs($this->makeUser('superadmin'))->get('/dashboard')
            ->assertOk()
            ->assertSee('AAA111')
            ->assertSee('BBB111');
    }

    public function test_admin_sees_only_urls_of_own_company(): void
    {
        $companyA = Company::create(['name' => 'A']);
        $companyB = Company::create(['name' => 'B']);

        $adminA = $this->makeUser('admin', $companyA);
        $memberA = $this->makeUser('member', $companyA);
        $adminB = $this->makeUser('admin', $companyB);

        $this->makeUrl($adminA, 'AAA111');
        $this->makeUrl($memberA, 'AAA222');
        $this->makeUrl($adminB, 'BBB111');

        $this->actingAs($adminA)->get('/dashboard')
            ->assertOk()
            ->assertSee('AAA111')
            ->assertSee('AAA222')
            ->assertDontSee('BBB111');
    }

    public function test_member_sees_only_own_urls(): void
    {
        $company = Company::create(['name' => 'A']);
        $member1 = $this->makeUser('member', $company);
        $member2 = $this->makeUser('member', $company);

        $this->makeUrl($member1, 'MEM111');
        $this->makeUrl($member2, 'MEM222');

        $this->actingAs($member1)->get('/dashboard')
            ->assertOk()
            ->assertSee('MEM111')
            ->assertDontSee('MEM222');
    }

    public function test_short_url_is_publicly_resolvable_and_redirects(): void
    {
        $company = Company::create(['name' => 'A']);
        $member = $this->makeUser('member', $company);
        $url = $this->makeUrl($member, 'PUB123');

        // bina login kiye
        $this->get('/s/PUB123')->assertRedirect('https://example.com/PUB123');

        $this->assertEquals(1, $url->fresh()->hits);
    }
}