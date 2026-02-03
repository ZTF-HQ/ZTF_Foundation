<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    /**
     * Récupère une valeur de paramètre par sa clé
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Définit une valeur de paramètre
     */
    public static function set($key, $value, $group = 'general')
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->group = $group;
        $setting->save();

        return $setting;
    }

    /**
     * Récupère tous les paramètres d'un groupe
     */
    public static function getGroup($group)
    {
        return static::where('group', $group)->get()->pluck('value', 'key');
    }
}