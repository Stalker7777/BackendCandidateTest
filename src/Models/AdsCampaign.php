<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AdsCampaign extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function existsRow(int $id): bool
    {
        if(self::query()->where('id', $id)->exists()) {
            return true;
        }

        return false;
    }

    public static function insertRow(array $row): void
    {
        self::query()->insert($row);
    }

    public static function updateRow(int $id, array $row): void
    {
        self::query()->where('id', $id)->update($row);
    }

    public static function deleteRow(int $id): void
    {
        self::query()->where('id', $id)->delete();
    }
}