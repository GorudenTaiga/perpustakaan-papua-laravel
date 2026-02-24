<?php

namespace Tests\Unit\Models;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_has_correct_fillable_fields(): void
    {
        $user = new User();
        $expected = ['name', 'email', 'password', 'role'];
        $this->assertEquals($expected, $user->getFillable());
    }

    public function test_user_has_correct_hidden_attributes(): void
    {
        $user = new User();
        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
    }

    public function test_user_has_member_relationship(): void
    {
        $user = new User();
        $relation = $user->member();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_admin_user_exists(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $this->assertNotNull($admin);
        $this->assertEquals('admin', $admin->role);
    }

    public function test_member_user_has_member_record(): void
    {
        $user = User::where('role', 'member')->first();
        if ($user) {
            $this->assertNotNull($user->member);
            $this->assertInstanceOf(Member::class, $user->member);
        } else {
            $this->markTestSkipped('No member user available');
        }
    }

    public function test_user_password_is_hashed(): void
    {
        $user = new User();
        $casts = $user->getCasts();
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }
}
