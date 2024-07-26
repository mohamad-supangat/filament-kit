<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class AdsFeeTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $product = Product::find(30);

        $this->assertTrue(true);
    }
}
