<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase {

    public function testIfUseTraits(): void {
        $expected = $this->traits();

        $traits = array_keys(class_uses($this->model()));

        $this->assertEquals($expected, $traits);
    }

    abstract protected function traits(): array;

    abstract protected function model(): Model;

    public function testFillables() {
        $expected = $this->fillables();
        $fillables = $this->model()->getFillable();
        $this->assertEquals($expected, $fillables);
    }

    abstract protected function fillables(): array;

    public function testIncrementingIsFalse() {
        $model = $this->model();
        $this->assertFalse($model->incrementing);
    }

    public function testIfHasCasts() {
        $expected = $this->casts();
        $casts = $this->model()->getCasts();
        $this->assertEquals($expected, $casts);
    }

    abstract protected function casts(): array;
}
