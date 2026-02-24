<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use DatabaseTransactions;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::where('email', 'admin@example.com')->first();
    }

    // ==========================================
    // Admin Panel Access
    // ==========================================

    public function test_admin_can_access_filament_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_redirected_from_admin(): void
    {
        $response = $this->get('/app');
        $response->assertRedirect();
    }

    public function test_member_cannot_access_admin_panel(): void
    {
        $member = User::where('role', 'member')->first();
        if (!$member) {
            $this->markTestSkipped('No member user available');
        }

        $response = $this->actingAs($member)->get('/app');
        $response->assertForbidden();
    }

    // ==========================================
    // Admin Resources Access
    // ==========================================

    public function test_admin_can_access_buku_resource(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/bukus');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_member_resource(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/members');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_pinjaman_resource(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/pinjamen');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_payments_resource(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/payments');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_categories_resource(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/categories');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_users_resource(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/users');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_reports_resource(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/reports');

        $response->assertStatus(200);
    }

    // ==========================================
    // Admin CRUD Create Pages
    // ==========================================

    public function test_admin_can_access_buku_create_page(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/bukus/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_pinjaman_create_page(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/pinjamen/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_payments_create_page(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/payments/create');

        $response->assertStatus(200);
    }

    // ==========================================
    // Verify No Commerce Elements in Admin
    // ==========================================

    public function test_pinjaman_form_does_not_have_biaya_section(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/pinjamen/create');

        $response->assertStatus(200);
        $response->assertDontSee('Total Price', false);
        $response->assertDontSee('Harga Akhir', false);
        $response->assertDontSee('Diskon', false);
    }

    public function test_payments_page_labeled_as_denda(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/app/admin/payments');

        $response->assertStatus(200);
        $response->assertSee('Denda', false);
    }
}
