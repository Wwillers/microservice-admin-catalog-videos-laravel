<?php

namespace Tests\Unit\domain\entity;

use core\domain\entity\Category;
use core\domain\exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class CategoryUnitTest extends TestCase {

    public function testAttributes() {
        $category = new Category(
            name: 'Category 1',
            description: 'Description of category 1',
            isActive: true
        );
        $this->assertNotEmpty($category->id);
        $this->assertNotEmpty($category->createdAt);
        $this->assertEquals('Category 1', $category->name);
        $this->assertEquals('Description of category 1', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testActivated() {
        $category = new Category(
            name: 'Category 1',
            isActive: false
        );

        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDisabled() {
        $category = new Category(
            name: 'Category 1',
            isActive: true
        );

        $this->assertTrue($category->isActive);
        $category->disable();
        $this->assertFalse($category->isActive);
    }

    public function testUpdate() {
        $uuid = Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'Category 1',
            description: 'Description of category 1',
            isActive: true,
            createdAt: '2021-10-10 10:00:00'
        );

        $category->update(
            name: 'Category 2',
            description: 'Description of category 2'
        );
        $this->assertEquals($uuid, $category->id);
        $this->assertEquals('Category 2', $category->name);
        $this->assertEquals('Description of category 2', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testExceptionName() {
        try {
            new Category(
                name: 'Ne',
                description: 'Description of new category',
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->isInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('Value must have at least 3 characters', $th->getMessage());
        }
    }

    public function testExceptionDescription() {
        $this->expectException(EntityValidationException::class);
        new Category(
            name: 'New category',
            description: str_repeat('a', 256),
        );
    }

}
