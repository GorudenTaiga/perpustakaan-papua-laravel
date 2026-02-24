<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_category_has_correct_fillable_fields(): void
    {
        $category = new Category();
        $expected = ['nama', 'image'];
        $this->assertEquals($expected, $category->getFillable());
    }

    public function test_categories_exist_in_database(): void
    {
        $count = Category::count();
        $this->assertGreaterThan(0, $count);
    }

    public function test_first_category_has_name(): void
    {
        $category = Category::first();
        $this->assertNotNull($category);
        $this->assertNotEmpty($category->nama);
    }
}
