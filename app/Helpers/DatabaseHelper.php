<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    /**
     * Get the current database driver
     */
    public static function driver(): string
    {
        return DB::getDriverName();
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
     * Get database-agnostic MONTH() equivalent
     * 
     * @param string $column Column name (default: 'created_at')
     * @return string SQL expression
     */
    public static function monthExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "strftime('%m', {$column})";
        }
        return "MONTH({$column})";
    }

    /**
     * Get database-agnostic YEAR() equivalent
     * 
     * @param string $column Column name (default: 'created_at')
     * @return string SQL expression
     */
    public static function yearExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "strftime('%Y', {$column})";
        }
        return "YEAR({$column})";
    }

    /**
     * Get database-agnostic DATE() equivalent
     * 
     * @param string $column Column name (default: 'created_at')
     * @return string SQL expression
     */
    public static function dateExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "DATE({$column})";
        }
        return "DATE({$column})";
    }

    /**
     * Get database-agnostic DAY() equivalent
     * 
     * @param string $column Column name (default: 'created_at')
     * @return string SQL expression
     */
    public static function dayExpression(string $column = 'created_at'): string
    {
        if (static::isSqlite()) {
            return "strftime('%d', {$column})";
        }
        return "DAY({$column})";
    }

    /**
     * Build a year filter condition
     * 
     * @param string $column Column name
     * @param int|string $year Year value
     * @return array [sql, bindings]
     */
    public static function whereYear(string $column, $year): array
    {
        if (static::isSqlite()) {
            return [
                "strftime('%Y', {$column}) = ?",
                [(string)$year]
            ];
        }
        return [
            "YEAR({$column}) = ?",
            [$year]
        ];
    }

    /**
     * Build a month filter condition
     * 
     * @param string $column Column name
     * @param int|string $month Month value (1-12)
     * @return array [sql, bindings]
     */
    public static function whereMonth(string $column, $month): array
    {
        if (static::isSqlite()) {
            return [
                "strftime('%m', {$column}) = ?",
                [str_pad($month, 2, '0', STR_PAD_LEFT)]
            ];
        }
        return [
            "MONTH({$column}) = ?",
            [$month]
        ];
    }
}
