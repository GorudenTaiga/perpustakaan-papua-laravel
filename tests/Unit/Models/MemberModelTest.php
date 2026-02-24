<?php

namespace Tests\Unit\Models;

use App\Models\Member;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MemberModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_member_has_correct_fillable_fields(): void
    {
        $member = new Member();
        $expected = [
            'users_id', 'valid_date', 'jenis',
            'membership_number', 'image', 'document_path'
        ];
        $this->assertEquals($expected, $member->getFillable());
    }

    public function test_member_table_name_is_member(): void
    {
        $member = new Member();
        $this->assertEquals('member', $member->getTable());
    }

    public function test_member_has_user_relationship(): void
    {
        $member = new Member();
        $relation = $member->user();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_member_has_wishlist_relationship(): void
    {
        $member = new Member();
        $relation = $member->wishlist();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_member_user_relationship_loads(): void
    {
        $member = Member::first();
        if ($member) {
            $user = $member->user;
            $this->assertInstanceOf(User::class, $user);
            $this->assertEquals($member->users_id, $user->id);
        } else {
            $this->markTestSkipped('No member data available');
        }
    }
}
