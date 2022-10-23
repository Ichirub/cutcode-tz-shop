<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Traits;

use App\Traits\Models\HasSlug;
use PHPUnit\Framework\TestCase;

/**
 * @TODO Add more tests
 */
class HasSlugTest extends TestCase
{
    public function test_is_slug_field_name_correct()
    {
        $trait = $this->getClassWithTrait();
        $this->assertEquals('slug', $trait::getSlugFieldName());
    }

    public function test_is_title_field_name_correct()
    {
        $trait = $this->getClassWithTrait();
        $this->assertEquals('title', $trait::getSlugTitleFieldName());
    }

    protected function getClassWithTrait()
    {
        return new class {
            use HasSlug;
        };
    }
}
