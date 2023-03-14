<?php

namespace App\Repositories;


use App\Models\Config;

class ConfigRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Config::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }

    /**
     * 保存配置内容 add by gui
     * @param Config $config
     * @param        $content
     * @return bool
     */
    public function saveContent (Config $config, $content)
    {
        $config->content = $content;
        if ($config->name == 'admin_theme') {
            //清除主题session
            get_admin_theme (true);
        }

        return $config->save ();
    }
}
