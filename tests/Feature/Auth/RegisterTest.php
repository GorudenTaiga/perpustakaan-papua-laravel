<?php

namespace Tests\Feature\Auth;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_register_page_renders(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_register_page_has_name_field(): void
    {
        $response = $this->get('/register');
        $response->assertSee('name', false);
    }

    public function test_register_page_has_email_field(): void
    {
        $response = $this->get('/register');
        $response->assertSee('email', false);
    }

    public function test_register_page_has_password_field(): void
    {
        $response = $this->get('/register');
        $response->assertSee('password', false);
    }

    public function test_register_page_has_member_type_select(): void
    {
        $response = $this->get('/register');
        $response->assertSee('jenis', false);
    }

    public function test_register_page_has_title(): void
    {
        $response = $this->get('/register');
        $response->assertSee('Register', false);
    }

    public function test_register_page_has_login_link(): void
    {
        $response = $this->get('/register');
        $response->assertSee('login', false);
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User Registration',
            'email' => 'testregister_' . time() . '@example.com',
            'password' => 'password123',
            'jenis' => 'Umum',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_register_creates_user_and_member(): void
    {
        $email = 'testregister_' . time() . '_create@example.com';

        $this->post('/register', [
            'name' => 'Test User Created',
            'email' => $email,
            'password' => 'password123',
            'jenis' => 'Mahasiswa',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'member',
        ]);

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);

        $this->assertDatabaseHas('member', [
            'users_id' => $user->id,
            'jenis' => 'Mahasiswa',
        ]);
    }

    public function test_register_requires_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_register_requires_unique_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Duplicate Email',
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_register_requires_minimum_password_length(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'shortpw_' . time() . '@example.com',
            'password' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
