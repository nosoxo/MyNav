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
 * @Date: 2023-03-13 13:05:29
 * @LastEditors: nosoxo loyo0801@gmail.com
 * @LastEditTime: 2023-03-14 17:59:48
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
            <input type="hidden" name="id" value="{{$link->id ?? ''}}">
            <input type="hidden" name="Link[user_id]" value="{{get_login_user_id ()}}">
            <div class="layui-form-item">
                <label class="layui-form-label">URL <span class="color-red">*</span></label>
                <div class="layui-input-block ">
                    <input id="name" type="text" class="layui-input " name="Link[url]" maxlength="255" autocomplete="off" value="{{$link->url ?? ''}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">链接名称 <span class="color-red">*</span></label>
                <div class="layui-input-block ">
                    <input type="text" class="layui-input " name="Link[title]" maxlength="255" autocomplete="off" value="{{$link->title ?? ''}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所属分类 <span class="color-red">*</span></label>
                <div class="layui-input-block ">
                    <select id="survey_id" name="Link[category_id]" lay-filter="survey_id" class=" width-120">
                        <option value=""></option>
                        @foreach($categories as $category)
                        <option data-name="" value="{{$category->id}}" @if($category->id==$link->category_id)selected="selected"@endif>{!! $category->name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排序 <span class="color-red">*</span></label>
                <div class="layui-input-block">
                    <input type="number" name="Link[sort]" value="{{$link->sort ?? ''}}" maxlength="100" autocomplete="off" placeholder="" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">是否私有 <span class="color-red">*</span></label>
                <div class="layui-input-block">
                    <input type="radio" name="Link[flag]" value="1" title="是" {{ $link->flag === 1 ? 'checked' : '' }}>
                    <input type="radio" name="Link[flag]" value="0" title="否" {{ $link->flag === 0 ? 'checked' : '' }}>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">描述 <span class="color-red"></span></label>
                <div class="layui-input-block">
                    <textarea placeholder="" class="layui-textarea" name="Link[description]" maxlength="500">{{$link->description ?? ''}}</textarea>
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
    layui.use(['form', 'layedit', 'laydate', 'layarea', 'table', 'tableSelect'], function() {
        var form = layui.form,
            layer = layui.layer,
            layedit = layui.layedit,
            laydate = layui.laydate,
            layarea = layui.layarea;
        table = layui.layarea;
        //监听提交
        form.on('submit(create)', function(data) {
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
                beforeSend: function() {
                    $("#button[lay-filter='create']").removeClass('disabled').prop('disabled', false);
                    loading = layer.load(2)
                },
                complete: function() {
                    $("#button[lay-filter='create']").removeClass('disabled').prop('disabled', false);
                    layer.close(loading)
                },
                error: function() {
                    layer.msg(AJAX_ERROR_TIP, {
                        icon: 2,
                        time: FAIL_TIME,
                        shade: 0.3
                    });
                },
                success: function(data) {
                    if (data.code === 0) {
                        layer.msg(data.message, {
                            icon: 6,
                            time: SUCCESS_TIME,
                            shade: 0.2
                        });
                        setTimeout(function() {
                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            parent.$('button[lay-filter="data-search-btn"]').click(); //刷新列表
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