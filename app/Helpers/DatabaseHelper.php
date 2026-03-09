<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    private static ?string $cachedDriver = null;

    /**
     * Get the current database driver (cached per request)
     */
    public static function driver(): string
    {
        return static::$cachedDriver ??= DB::getDriverName();
    }

    /**
     * Check if using SQLite
     */
    public static function isSqlite(): bool
    {
        return static::driver() === 'sqlite';
    }

    /**
     * Check if using MySQL
     */
    public static function isMysql(): bool
    {
        return in_array(static::driver(), ['mysql', 'mariadb']);
    }

    /**
     * Check if using PostgreSQL
     */
    public static function isPostgres(): bool
    {
        return static::driver() === 'pgsql';
    }

    /**
     * Get database-agnostic MONTH() equivalent
     */
    public static function monthExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "strftime('%m', {$column})";
        }
        if (static::isPostgres()) {
            return "EXTRACT(MONTH FROM {$column})";
        }
        return "MONTH({$column})";
    }

    /**
     * Get database-agnostic YEAR() equivalent
     */
    public static function yearExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "strftime('%Y', {$column})";
        }
        if (static::isPostgres()) {
            return "EXTRACT(YEAR FROM {$column})";
        }
        return "YEAR({$column})";
    }

    /**
     * Get database-agnostic DATE() equivalent
     */
    public static function dateExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "DATE({$column})";
        }
        if (static::isPostgres()) {
            return "{$column}::date";
        }
        return "DATE({$column})";
    }

    /**
     * Get database-agnostic DAY() equivalent
     */
    public static function dayExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "strftime('%d', {$column})";
        }
        if (static::isPostgres()) {
            return "EXTRACT(DAY FROM {$column})";
        }
        return "DAY({$column})";
    }

    /**
     * Build a year filter condition
     */
    public static function whereYear(string $column, $year): array
    {
        if (static::isSqlite()) {
            return [
                "strftime('%Y', {$column}) = ?",
                [(string)$year]
            ];
        }
        if (static::isPostgres()) {
            return [
                "EXTRACT(YEAR FROM {$column}) = ?",
                [(int)$year]
            ];
        }
        return [
            "YEAR({$column}) = ?",
            [$year]
        ];
    }

    /**
     * Build a month filter condition
     */
    public static function whereMonth(string $column, $month): array
    {
        if (static::isSqlite()) {
            return [
                "strftime('%m', {$column}) = ?",
                [str_pad($month, 2, '0', STR_PAD_LEFT)]
            ];
        }
        if (static::isPostgres()) {
            return [
                "EXTRACT(MONTH FROM {$column}) = ?",
                [(int)$month]
            ];
        }
        return [
            "MONTH({$column}) = ?",
            [$month]
        ];
    }

    /**
     * Get the appropriate LIKE operator (ILIKE for PostgreSQL)
     */
    public static function likeOperator(): string
    {
        return static::isPostgres() ? 'ilike' : 'like';
    }
}
