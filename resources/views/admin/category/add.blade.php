<!--
 * @                       .::::.
 * @                     .::::::::.
 * @                    :::::::::::
 * @                 ..:::::::::::'
 * @              '::::::::::::'
 * @                .::::::::::
 * @           '::::::::::::::..
 * @                ..::::::::::::.
 * @              ``::::::::::::::::
 * @               ::::``:::::::::'        .:::.
 * @              ::::'   ':::::'       .::::::::.
 * @            .::::'      ::::     .:::::::'::::.
 * @           .:::'       :::::  .:::::::::' ':::::.
 * @          .::'        :::::.:::::::::'      ':::::.
 * @         .::'         ::::::::::::::'         ``::::.
 * @     ...:::           ::::::::::::'              ``::.
 * @    ````':.          ':::::::::'                  ::::..
 * @                       '.:::::'                    ':'````..
 * @
 * @Author: nosoxo loyo0801@gmail.com
 * @Date: 2023-03-13 13:09:54
 * @LastEditors: nosoxo loyo0801@gmail.com
 * @LastEditTime: 2023-03-13 13:09:54
 * @Description: 
 * @
 * @Copyright (c) 2023 by ${git_name_email}, All Rights Reserved. 
-->

@extends('layouts.app')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layui-row">
            <form class="layui-form" action="" lay-filter="example" onsubmit="return false;">
                {{ method_field($_method ?? '') }}
                {{csrf_field ()}}
                <input type="hidden" name="id" value="{{$category->id ?? ''}}">
                <input type="hidden" name="Category[user_id]" value="{{get_login_user_id ()}}">
                <div class="layui-form-item">
                    <label class="layui-form-label">分类名称 <span class="color-red">*</span></label>
                    <div class="layui-input-block ">
                        <input type="text" class="layui-input " name="Category[name]" maxlength="255"
                               autocomplete="off"
                               value="{{$category->name ?? ''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">排序 <span class="color-red">*</span></label>
                    <div class="layui-input-block">
                        <input type="number" name="Category[sort]" value="{{$category->sort ?? ''}}" maxlength="100"
                               autocomplete="off"
                               placeholder=""
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否私有 <span class="color-red">*</span></label>
                    <div class="layui-input-block">
                        <input type="radio" name="Category[flag]" value="1" title="是" {{ $category->flag === 1 ? 'checked' : '' }}>
                        <input type="radio" name="Category[flag]" value="0" title="否" {{ $category->flag === 0 ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">描述 <span class="color-red"></span></label>
                    <div class="layui-input-block">
                            <textarea placeholder="" class="layui-textarea" name="Category[description]"
                                      maxlength="500">{{$category->description ?? ''}}</textarea>
                    </div>
                </div>

                <div class="layui-form-item margin-bottom-submit">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="create">立即提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        layui.use(['form', 'layedit', 'laydate', 'layarea', 'table', 'tableSelect'], function () {
            var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate,
                layarea = layui.layarea;
            table = layui.layarea;
            //监听提交
            form.on('submit(create)', function (data) {
                if ($("input[name='_method']").val() === 'PUT') {
                    id = $("input[name='id']").val();
                    _url = '/admin/' + MODULE_NAME + '/' + id;
                } else {
                    _url = '/admin/' + MODULE_NAME;
                }
                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: data.field,
                    dataType: 'json',
                    beforeSend: function () {
                        $("#button[lay-filter='create']").removeClass('disabled').prop('disabled', false);
                        loading = layer.load(2)
                    },
                    complete: function () {
                        $("#button[lay-filter='create']").removeClass('disabled').prop('disabled', false);
                        layer.close(loading)
                    },
                    error: function () {
                        layer.msg(AJAX_ERROR_TIP, {
                            icon: 2,
                            time: FAIL_TIME,
                            shade: 0.3
                        });
                    },
                    success: function (data) {
                        if (data.code === 0) {
                            layer.msg(data.message, {icon: 6, time: SUCCESS_TIME, shade: 0.2});
                            setTimeout(function () {
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.$('button[lay-filter="data-search-btn"]').click();//刷新列表
                                parent.layer.close(index); //再执行关闭

                            }, SUCCESS_TIME)
                        } else {
                            layer.msg(data.message, {
                                icon: 2,
                                time: FAIL_TIME,
                                shade: 0.3
                            });
                        }

                    }
                })

                return false;
            });

        });
    </script>
@endsection
