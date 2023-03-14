<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * 上传图片 add by gui
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function image (Request $request)
    {
        set_time_limit (0);
        $sourceType = $request->input ('type');
        $sourceId   = $request->input ('id', 0);
        if ($sourceType) {
            $sourceType = urldecode ($sourceType);
        }
        $name       = $request->input ('name', 'upfile');
        $images     = $request->file ($name);
        $filedir    = "uploads/" . date ('Ym') . '/';
        $imagesName = $images->getClientOriginalName ();
        $extension  = $images->getClientOriginalExtension ();
        $size       = $images->getSize ();
        $extension  = strtolower ($extension);
        if (!in_array ($extension, ['jpeg', 'jpg', 'png', 'gif'])) {
            return ['status' => 0, 'info' => '.' . $extension . '的后缀不允许上传'];
        }

        $newImagesName = md5_file ($images->getRealPath ()). "." . $extension;


        $path    = $filedir . $newImagesName;
        $content = file_get_contents ($images->getRealPath ());
        Storage::disk ('public')->put ($path, $content);
        $public_path = 'storage/' . $path;
        $insArr      = [
            'name'         => $imagesName,
            'path'         => $public_path,
            'storage_path' => $path,
            'file_md5'     => md5_file ($public_path),
            'file_sha1'    => sha1_file ($public_path),
            'source_type'  => $sourceType,
            'source_id'    => (int)$sourceId,
            'status'       => 1
        ];
        $Attachment  = Attachment::addFile ($insArr);
        if (!$Attachment) {
            return ajax_error_result ('上传失败');
        }

        Log::createLog (Log::INFO_TYPE, '上传图片记录', '', $Attachment->id, Attachment::class);
        $type = config ('gui.rich_editor');
        $data = [];
        switch ($type) {
            case 'umeditor':
                $data['code']         = 0;
                $data['id']           = $Attachment->id;
                $data['size']         = $size;
                $data['state']        = 'SUCCESS';
                $data['name']         = $newImagesName;
                $data['url']          = $Attachment->url;
                $data['type']         = '.' . $extension;
                $data['originalName'] = $Attachment->name;
                $data['src']          = $data['url'];

                //
                return @json_encode ($data);
                break;
            case 'wangEditor':
                $data['errno']  = 0;
                $row            = [
                    'url'  => $Attachment->url,
                    'alt'  => $Attachment->name,
                    'href' => $Attachment->url
                ];
                $data['data'][] = $row;
                break;
        }

        return $data;
    }

    /**
     * 上传表格 add by gui
     * @param Request $request
     * @param string  $name
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function excel (Request $request, $name = 'file')
    {
        set_time_limit (0);
        $files      = $request->file ($name);
        $filedir    = "Uploads/excel/" . date ('Ymd') . '/';
        $imagesName = $files->getClientOriginalName ();
        $extension  = $files->getClientOriginalExtension ();
        $size       = $files->getSize ();
        $extension  = strtolower ($extension);
        if (!in_array ($extension, ['xls', 'xlsx'])) {
            return ['status' => 0, 'info' => '.' . $extension . '的后缀不允许上传'];
        }

        $newImagesName = md5_file ($files->getRealPath ()) . "." . $extension;

        $files->move ($filedir, $newImagesName);
        $path       = $filedir . $newImagesName;
        $insArr     = [
            'name'      => $imagesName,
            'path'      => $path,
            'file_md5'  => md5_file ($path),
            'file_sha1' => sha1_file ($path),
            'status'    => 1
        ];
        $attachment = Attachment::addFile ($insArr);

        $result = [
            'data' => [
                'id'    => $attachment->id,
                'name'  => $attachment->name,
                'title' => str_replace ('.' . $extension, '', $attachment->name),
                'src'   => $attachment->url
            ]
        ];
        Log::createLog (Log::INFO_TYPE, '上传附件记录', '', $attachment->id, Attachment::class);

        return ajax_success_result ('上传成功', $result);
    }

    public function file (Request $request, $name = 'file')
    {
        set_time_limit (0);
        $sourceType = $request->input ('type','');
        $sourceId   = $request->input ('id', 0);
        if ($sourceType) {
            $sourceType = urldecode ($sourceType);
        }
        $files      = $request->file ($name);
        $filedir    = "uploads/file/" . date ('Ymd') . '/';
        $imagesName = $files->getClientOriginalName ();
        $extension  = $files->getClientOriginalExtension ();
        $size       = $files->getSize ();
        $extension  = strtolower ($extension);
        $allowExt   = config ('gui.allow_file_ext');
        if (!in_array ($extension, $allowExt)) {
            return ['status' => 0, 'info' => '.' . $extension . '的后缀不允许上传'];
        }

        $newFileName = md5_file ($files->getRealPath ()) . "." . $extension;

        $path    = $filedir . $newFileName;
        $content = file_get_contents ($files->getRealPath ());
        Storage::disk ('public')->put ($path, $content);
        $public_path = 'storage/' . $path;
        $insArr      = [
            'name'         => $imagesName,
            'path'         => $public_path,
            'storage_path' => $path,
            'file_md5'     => md5_file ($public_path),
            'file_sha1'    => sha1_file ($public_path),
            'source_type'  => $sourceType,
            'source_id'    => (int)$sourceId,
            'status'       => 1
        ];
        $attachment  = Attachment::addFile ($insArr);

        $result = [
            'data' => [
                'id'    => $attachment->id,
                'name'  => $attachment->name,
                'title' => str_replace ('.' . $extension, '', $attachment->name),
                'src'   => $attachment->url
            ]
        ];
        Log::createLog (Log::INFO_TYPE, '上传附件记录', '', $attachment->id, Attachment::class);

        return ajax_success_result ('上传成功', $result);
    }
}
