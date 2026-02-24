<?php

namespace Tests\Unit\Models;

use App\Models\Wishlist;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WishlistModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_wishlist_has_correct_fillable_fields(): void
    {
        $wishlist = new Wishlist();
        $expected = ['member_id', 'buku_id'];
        $this->assertEquals($expected, $wishlist->getFillable());
    }

    public function test_wishlist_has_member_relationship(): void
    {
        $wishlist = new Wishlist();
        $relation = $wishlist->member();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_wishlist_has_buku_relationship(): void
    {
        $wishlist = new Wishlist();
        $relation = $wishlist->buku();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }
}
