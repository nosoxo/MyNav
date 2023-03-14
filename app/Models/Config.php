<?php

namespace App\Models;

use App\Enums\ConfigTypeEnum;
use App\Traits\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use DateTimeFormat;
    //1=字符串、2=数字、3=数组、4=键值对数组、5=JSON、6=文本框
    const STR_TYPE  = 1;
    const NUM_TYPE  = 2;
    const ARR_TYPE  = 3;
    const ITEM_TYPE = 4;
    const JSON_TYPE = 5;
    const TEXT_TYPE = 6;
    protected $fillable = ['name', 'title', 'group_id', 'type', 'content', 'param_json', 'description'];

    public function group ()
    {
        return $this->belongsTo (ConfigGroup::class);
    }
    public static function getValue ($name, $default = null)
    {
        $name   = strtolower (trim ($name));
        $config = Config::where ('name', $name)->first ();
        if (!$config) {
            return $default;
        }
        $content = $config->content;
        switch ($config->type) {
            case ConfigTypeEnum::NUM_TYPE:
                $content = (int)$content;
                break;
            case ConfigTypeEnum::ARR_TYPE:
                $content = json_decode ($content, true);
                if (!$content || !is_array ($content)) {
                    $content = [];
                }
                break;
            case ConfigTypeEnum::ITEM_TYPE:
                //
                break;
            case ConfigTypeEnum::JSON_TYPE:
                $json = json_decode ($content, true);
                if (!$json) {
                    $content = '{}';
                }
                break;
            default:
                $content = $config->content;
        }

        return $content ?? $default;
    }

    public static function setConfig ($groupId, $name, $title, $type, $content, $desc = '', $json = '')
    {
        if (is_array ($json)) {
            $json = json_encode ($json, JSON_UNESCAPED_UNICODE);
        }
        $name   = strtolower (trim ($name));
        $config = Config::updateOrCreate ([
            'name' => $name
        ], [
            'name'        => $name,
            'title'       => $title,
            'group_id'    => $groupId,
            'type'        => (int)$type,
            'content'     => $content,
            'param_json'  => $json,
            'description' => $desc
        ]);

        return $config;
    }

    public function getParamItem (Config $config)
    {
        $json = $config->param_json ?? '';
        switch ($config->type) {
            case ConfigTypeEnum::ARR_TYPE;
                if ($json) {
                    return json_decode ($json);
                } else {
                    return [];
                }
                break;
            case ConfigTypeEnum::ITEM_TYPE:
                if ($json) {
                    return json_decode ($json);
                } else {
                    return [];
                }
                break;
            default:
                return $json;
                break;
        }
    }
}
