<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_shopper_account_cannot_open_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_can_open_the_dashboard(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get('/admin')
            ->assertOk()
            ->assertSee('Visitors today')
            ->assertSee('Sales');
    }
}
