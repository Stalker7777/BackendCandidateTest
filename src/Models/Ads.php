<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table = 'ads';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function existsRow(int $id, int $date_consumption): bool
    {
        if(self::query()->where(['id' => $id, 'date_consumption' => $date_consumption])->exists()) {
            return true;
        }

        return false;
    }

    public static function insertRow(array $row): void
    {
        self::query()->insert($row);
    }

    public static function updateRow(int $id, int $date_consumption, array $row): void
    {
        self::query()->where(['id' => $id, 'date_consumption' => $date_consumption])->update($row);
    }

    public static function deleteRow(int $id): void
    {
        self::query()->where('id', $id)->delete();
    }
}
