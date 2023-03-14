#MyNav

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

### 演示demo

- MyNav：[https://mynav.nosoxo.com](https://mynav.nosoxo.com)

- 后台地址：[https://mynav.nosoxo.com/admin](https://mynav.nosoxo.com/admin)

- 账号：admin

- 密码：admin

- 演示说明：理性演示，误删除基础数据，可自行添加数据，自行删除（数据库会定时重置抹除数据）

### 如何使用

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
``
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
- 项目访问
    
  后台地址：`http://d/admin`

  后台账号：admin

  后台密码：123456（生产环境必须修改密码）

## 许可证

完全开源免费，请保留项目开源版权说明。本项目遵循开源协议 [MIT license](https://opensource.org/licenses/MIT).
