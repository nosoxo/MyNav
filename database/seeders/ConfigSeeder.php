<?php

namespace Database\Seeders;

use App\Enums\ConfigTypeEnum;
use App\Models\Config;
use App\Models\ConfigGroup;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        //配置内容
        if (!config ('app.debug')) {
            dd ('非开发环境，无法执行');
        }

        $groupId = ConfigGroup::insertGroup ('base_info', '基本信息');
        Config::setConfig ($groupId, 'site_title', '网站标题', ConfigTypeEnum::STR_TYPE, 'MyNav');
        Config::setConfig ($groupId, 'site_short_title', '网站后台简称', ConfigTypeEnum::STR_TYPE, 'MyNav', '长度为7个字以内');
        Config::setConfig ($groupId, 'company_name', '公司名称', ConfigTypeEnum::STR_TYPE, 'MyNav');
        Config::setConfig ($groupId, 'icp', '备案信息', ConfigTypeEnum::STR_TYPE, '');
        Config::setConfig ($groupId, 'admin_theme', '后台主题', ConfigTypeEnum::ITEM_TYPE, 'onepage', '', ['iframe'=>'多标签模式','onepage'=>'单页面模式']);
        $groupId = ConfigGroup::insertGroup ('contact_info', '联系人信息');
        Config::setConfig ($groupId, 'contact_name', '联系人名称', ConfigTypeEnum::STR_TYPE, 'MyNav');
        Config::setConfig ($groupId, 'telephone', '联系号码', ConfigTypeEnum::STR_TYPE, '010-00001111');
        Config::setConfig ($groupId, 'email', '联系邮箱', ConfigTypeEnum::STR_TYPE, 'mynav@nosoxo.com');
        Config::setConfig ($groupId, 'fax', '公司传真', ConfigTypeEnum::STR_TYPE, '010-00001111');
        Config::setConfig ($groupId, 'qq', 'QQ', ConfigTypeEnum::STR_TYPE, '00000000');
        Config::setConfig ($groupId, 'weixin', '微信', ConfigTypeEnum::STR_TYPE, '00000001');
        Config::setConfig ($groupId, 'address', '公司地址', ConfigTypeEnum::STR_TYPE, 'xxxxxxxxxx');
    }
}
