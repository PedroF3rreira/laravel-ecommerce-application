<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config;

class Setting extends Model
{
    use HasFactory;

    /**
     * tabele do banco de dados
     * @var string
     */
    protected $table = 'settings'; 

    /**
     * abilita inserção em massa para esses campos da tabela
     * @var [type]
     */
    protected $fillable = ['key', 'value'];

    /**
     * *
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        $setting = new self();
        $entry = $setting->where('key', $key)->first();

        if(!$entry){
            return;
        }

        return $entry->value;
    }

    /**
     * @param $key
     * @param null $value
     * @param boolean $value
     */
    public static function set($key, $value = null)
    {
        $setting = new self();
        $entry = $setting->where('key', $key)->firstOrFail();
        $entry->value = $value;
        $entry->saveOrFail();
        Config::set('key', $value);

        if(Config::get($key) == $value){
            return true;
        }

        return false;
    }
}
