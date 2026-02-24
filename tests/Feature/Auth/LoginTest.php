<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_login_page_contains_email_input(): void
    {
        $response = $this->get('/login');
        $response->assertSee('email', false);
        $response->assertSee('password', false);
    }

    public function test_login_page_has_title(): void
    {
        $response = $this->get('/login');
        $response->assertSee('Login', false);
    }

    public function test_login_page_has_register_link(): void
    {
        $response = $this->get('/login');
        $response->assertSee('register', false);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }

    public function test_admin_redirected_to_admin_panel_after_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('filament.admin.pages.dashboard');
    }

    public function test_member_can_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'member@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }

    public function test_member_redirected_to_dashboard_after_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'member@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
    }

    public function test_cannot_login_with_wrong_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_cannot_login_with_nonexistent_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_login_requires_email(): void
    {
        $response = $this->post('/login', [
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_login_requires_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
        ]);

        $this->assertGuest();
    }
}
