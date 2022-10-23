<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Stringable;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            if (!$model->{self::getSlugFieldName()}) {
                $model->{self::getSlugFieldName()} = self::generateUniqueSlug($model);
            }
        });
    }

    protected static function generateUniqueSlug(Model $model): string
    {
        $slug = str($model->{self::getSlugTitleFieldName()})->slug();
        $count = self::countExistsBySlug($model, $slug);

        if ($count > 1) {
            $slug = $slug->append('-', $count);
        }

        return $slug->toString();
    }

    protected static function countExistsBySlug(Model $model, Stringable $slug): int
    {
        return $model->query()
                ->where(self::getSlugFieldName(), $slug)
                ->orWhere(self::getSlugFieldName(), 'like', $slug . '-%')
                ->count() + 1;
    }

    public static function getSlugFieldName(): string
    {
        return 'slug';
    }

    public static function getSlugTitleFieldName(): string
    {
        return 'title';
    }
}
