# MyNav

<p align="center">
  <a href="https://github.com/laravel/framework">
    <img src="https://img.shields.io/badge/laravel-8.48.2-brightgreen.svg" alt="laravel">
  </a>
  <a href="https://www.layui.com">
    <img src="https://img.shields.io/badge/layui-2.5.5-brightgreen.svg" alt="layui">
  </a>
  <img src="https://img.shields.io/badge/License-MIT-yellow.svg">
</p>

使用PHP + MySQL开发的简约导航/书签管理器，欢迎体验。

## Demo

- MyNav：[https://mynavdemo.nosoxo.com](https://mynavdemo.nosoxo.com)

- 后台地址：[https://mynavdemo.nosoxo.com/admin](https://mynavdemo.nosoxo.com/admin)

- 账号：admin

- 密码：123456

- 演示说明：理性演示，勿删除基础数据，可自行添加数据，自行删除（数据库会定时重置抹除数据）

## 运行环境

Laravel 8 需要 PHP 7.3.0 或以上， PHP函数：putenv、proc_open；
MySQL 5.7+ （版本策略）。

## 部署配置

- 获取代码
```bash
git clone https://github.com/nosoxo/MyNav.git
cd mynav
composer install
cp .env.example .env #配置文件
```
- 在.env文件中配置数据库
```bash
php artisan key:generate
```
- 数据库表迁移
```bash
php artisan migrate
```
- 基础数据信息填充
```bash
php artisan db:seed --class=InitSeeder
```
- 上传文件路径符号链接
```bash
php artisan storage:link
```
- 项目启动
```bash
php artisan serve
```
- 网站运行目录和伪静态

    运行目录为public

    伪静态：
```bash
location / {  
  try_files $uri $uri/ /index.php$is_args$query_string;  
  }
```
- 项目访问
    
  MyNav地址：`http://localhost`

  后台地址：`http://localhost/admin`

  后台账号：admin

  后台密码：123456

## 许可证

完全开源免费，请保留项目开源版权说明。本项目遵循开源协议 [MIT license](https://opensource.org/licenses/MIT).
