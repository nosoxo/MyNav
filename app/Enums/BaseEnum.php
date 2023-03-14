<?php

namespace App\Enums;


abstract class BaseEnum
{
    /*中文*/
    protected static $ATTRS = [];
    /*名称*/
    protected static $VALUES = [];
    /*颜色*/
    protected static $COLORS = [];

    public static function toName ($value)
    {
        $values = static::values ();

        return isset($values[ $value ]) ? $values[ $value ] : null;
    }

    public static function values ()
    {
        if (empty(static::$VALUES)) {
            $attrs = static::attrs ();

            $values = array_values ($attrs);
            $data   = [];
            foreach ($values as $value) {
                $data[ $value ] = $value;
            }

            return $data;

        } else {
            return static::$VALUES;
        }
    }

    public static function attrs ()
    {
        return static::$ATTRS;
    }

    public static function exists ($value)
    {
        foreach (static::values () as $item) {
            if ($value === $item) {
                return true;
                break;
            }
        }

        return false;
    }

    public static function getKV ()
    {
        $data = [];
        foreach (static::attrs () as $key => $value) {
            $data[] = [
                'key'   => $key,
                'value' => $value,
            ];
        }

        return $data;
    }

    /**
     * 获取带颜色标签
     * @param $value
     * @return string
     */
    public static function toHtml ($value)
    {
        $defaultColor = ColorEnum::INFO;
        $label = self::toLabel ($value);
        $color = array_key_exists ($value, static::$COLORS) ? static::$COLORS[ $value ] : $defaultColor;
        if(!$color)
            $color = $defaultColor;

        return '<span class="layui-badge" style="background-color: ' . $color . ' !important">' . $label . '</span>';
    }

    public static function toLabel ($value)
    {
        return isset(static::$ATTRS[ $value ]) ? static::$ATTRS[ $value ] : null;
    }
}
