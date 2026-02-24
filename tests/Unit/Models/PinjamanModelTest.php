<?php

namespace Tests\Unit\Models;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Pinjaman;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PinjamanModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_pinjaman_has_correct_fillable_fields(): void
    {
        $pinjaman = new Pinjaman();
        $expected = [
            'member_id', 'buku_id', 'quantity', 'loan_date',
            'due_date', 'return_date', 'status', 'uuid', 'verif'
        ];
        $this->assertEquals($expected, $pinjaman->getFillable());
    }

    public function test_pinjaman_does_not_contain_commerce_fields(): void
    {
        $pinjaman = new Pinjaman();
        $fillable = $pinjaman->getFillable();
        $this->assertNotContains('total_price', $fillable);
        $this->assertNotContains('discount', $fillable);
        $this->assertNotContains('final_price', $fillable);
    }

    public function test_pinjaman_table_name_is_pinjaman(): void
    {
        $pinjaman = new Pinjaman();
        $this->assertEquals('pinjaman', $pinjaman->getTable());
    }

    public function test_pinjaman_has_member_relationship(): void
    {
        $pinjaman = new Pinjaman();
        $relation = $pinjaman->member();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_pinjaman_has_buku_relationship(): void
    {
        $pinjaman = new Pinjaman();
        $relation = $pinjaman->buku();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_pinjaman_member_relationship_loads(): void
    {
        $pinjaman = Pinjaman::first();
        if ($pinjaman) {
            $member = $pinjaman->member;
            $this->assertInstanceOf(Member::class, $member);
        } else {
            $this->markTestSkipped('No pinjaman data available');
        }
    }

    public function test_pinjaman_buku_relationship_loads(): void
    {
        $pinjaman = Pinjaman::first();
        if ($pinjaman) {
            $buku = $pinjaman->buku;
            $this->assertInstanceOf(Buku::class, $buku);
        } else {
            $this->markTestSkipped('No pinjaman data available');
        }
    }
}
