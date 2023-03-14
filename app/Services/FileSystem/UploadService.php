<?php

namespace App\Services\FileSystem;


use App\Enums\UploadDriverEnum;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;

class UploadService
{
    /**
     *  add by gui
     * @param null $driver
     * @return UploadInterface
     * @throws BusinessException
     */
    public static function disk ($driver = null)
    {
        if (is_null ($driver)) {
            $driver = config ('gui.upload_driver');
        }
        $app = null;
        switch ($driver) {
            case UploadDriverEnum::QINIU:
                $app = new QiniuService();
                break;
            case UploadDriverEnum::ALIYUN:
                $app  = new OssService();
                break;
            default:
                throw new BusinessException('不存在' . $driver . '云驱动');
                break;
        }

        return $app;
    }

    /**
     * 注册云存储驱动
     */
    public static function boot ()
    {
        if (config ('gui.upload_driver')) {
            // 注册七牛云云存储驱动
            Storage::extend (UploadDriverEnum::QINIU, function ($app, $config) {
                return new Filesystem(new QiniuAdapter($config['prefix']));
            });
            // 注册阿里云驱动
            Storage::extend (UploadDriverEnum::ALIYUN, function ($app, $config) {
                return new Filesystem(new AliyunAdapter($config['prefix']));
            });
        }
    }
}
