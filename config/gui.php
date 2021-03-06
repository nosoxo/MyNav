<?php
/*
|-----------------------------------------------------------------------------------------------------------
| laravel-admin-cms [ 简单高效的开发插件系统 ]
|-----------------------------------------------------------------------------------------------------------
| Licensed ( MIT )
| ----------------------------------------------------------------------------------------------------------
| Copyright (c) 2020-2021 https://gitee.com/liaodeiy/laravel-admin-cms All rights reserved.
| ----------------------------------------------------------------------------------------------------------
| Author: 廖春贵 < liaodeity@gmail.com >
|-----------------------------------------------------------------------------------------------------------
*/

//系统基础配置
return [
    /*
      |--------------------------------------------------------------------------
      | Admin Theme
      |--------------------------------------------------------------------------
      |
      | 设置后台默认主题为"iframe"或"onepage".
      | 获取当前主题"get_admin_theme()".
      */
    'admin_theme'           => 'onepage',

    /*
      |--------------------------------------------------------------------------
      | 演示站点测试专用
      |--------------------------------------------------------------------------
      |
      | 防止修改超级管理权限用户【正式上线可以设置为false】
      | 可删除判断代码：`app/Http/Controllers/Admin/UserAdminController.php:252`
      */
    'deny_edit_super_admin' => true,

    /*
     |--------------------------------------------------------------------------
     | 富文本编辑器类型
     |--------------------------------------------------------------------------
     |
     | `umeditor`和`wangEditor`
     */
    'rich_editor'           => 'wangEditor',

    /*
     |--------------------------------------------------------------------------
     | 基础数据表
     |--------------------------------------------------------------------------
     |
     | 可以通过`php artisan dev:backup`备份基础表内容
     */
    'base_table'            => [
        'users',
        'user_admins',
        'config_groups',
        'configs',
        'menus',
        'roles',
        'permissions',
        'role_has_permissions',
        'model_has_roles',
        'model_has_permissions',
        'categories',
        'links',
    ],
    /*
     |--------------------------------------------------------------------------
     | 允许上传的附件后缀
     |--------------------------------------------------------------------------
     |
     */
    'allow_file_ext'        => [
        'zip',
        'rar',
        'xls',
        'doc',
        'ppt',
        'xlsx',
        'docx',
        'pptx',
        'png',
        'jpg',
        'gif',
        'mp4',
        'mp3',
        'ogg'
    ],
    /*
     |--------------------------------------------------------------------------
     | 是否开启云上传附件模式
     |--------------------------------------------------------------------------
     | 阿里云：oss（开通地址：https://www.aliyun.com/product/oss?userCode=hhlk0aji）
     | 七牛云：kodo（开通地址：https://s.qiniu.com/jyQv6v）
     | 不开启则设置为空。
     */
    'upload_driver'         => env ('UPLOAD_YUN_DRIVER', ''),

];
