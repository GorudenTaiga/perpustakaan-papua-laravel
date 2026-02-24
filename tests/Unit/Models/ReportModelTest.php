<?php

namespace Tests\Unit\Models;

use App\Models\Report;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReportModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_report_has_correct_fillable_fields(): void
    {
        $report = new Report();
        $expected = [
            'total_registrations', 'total_members',
            'total_loans', 'total_returns'
        ];
        $this->assertEquals($expected, $report->getFillable());
    }

    public function test_report_table_name_is_report(): void
    {
        $report = new Report();
        $this->assertEquals('report', $report->getTable());
    }

    public function test_report_casts_fields_to_integer(): void
    {
        $report = new Report();
        $casts = $report->getCasts();
        $this->assertEquals('integer', $casts['total_registrations']);
        $this->assertEquals('integer', $casts['total_members']);
        $this->assertEquals('integer', $casts['total_loans']);
        $this->assertEquals('integer', $casts['total_returns']);
    }

    public function test_calculate_totals_returns_correct_structure(): void
    {
        $totals = Report::calculateTotals();
        $this->assertArrayHasKey('total_registrations', $totals);
        $this->assertArrayHasKey('total_members', $totals);
        $this->assertArrayHasKey('total_loans', $totals);
        $this->assertArrayHasKey('total_returns', $totals);
        $this->assertIsInt($totals['total_registrations']);
        $this->assertIsInt($totals['total_members']);
        $this->assertIsInt($totals['total_loans']);
        $this->assertIsInt($totals['total_returns']);
    }

    public function test_calculate_totals_returns_non_negative_values(): void
    {
        $totals = Report::calculateTotals();
        $this->assertGreaterThanOrEqual(0, $totals['total_registrations']);
        $this->assertGreaterThanOrEqual(0, $totals['total_members']);
        $this->assertGreaterThanOrEqual(0, $totals['total_loans']);
        $this->assertGreaterThanOrEqual(0, $totals['total_returns']);
    }
}
