<?php

namespace Tests\Unit\Models;

use App\Models\Payments;
use App\Models\Pinjaman;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PaymentsModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_payments_has_correct_fillable_fields(): void
    {
        $payments = new Payments();
        $expected = [
            'pinjaman_id', 'amount', 'payment_date',
            'payment_method', 'keterangan'
        ];
        $this->assertEquals($expected, $payments->getFillable());
    }

    public function test_payments_has_pinjaman_relationship(): void
    {
        $payments = new Payments();
        $relation = $payments->pinjaman();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
    }

    public function test_payments_does_not_have_commerce_labels(): void
    {
        $payments = new Payments();
        $fillable = $payments->getFillable();
        $this->assertContains('keterangan', $fillable);
        $this->assertContains('amount', $fillable);
    }

    public function test_payment_can_be_created_with_pinjaman(): void
    {
        $pinjaman = Pinjaman::first();
        if (!$pinjaman) {
            $this->markTestSkipped('No pinjaman data available');
        }

        $payment = Payments::create([
            'pinjaman_id' => $pinjaman->id,
            'amount' => 5000,
            'payment_date' => now()->toDateString(),
            'payment_method' => 'cash',
            'keterangan' => 'Denda keterlambatan 1 hari',
        ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'amount' => 5000,
            'keterangan' => 'Denda keterlambatan 1 hari',
        ]);
    }
}
