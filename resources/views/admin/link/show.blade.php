@extends('layouts.app')
@section('body_class','bg-write')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layui-row">
            <table class="layui-table zhihe-show">
                <colgroup>
                    <col width="20%">
                    <col width="">
                    <col>
                </colgroup>
                <thead>
                </thead>
                <tbody>
                <tr>
                    <th>所属分类</th>
                    <td>{!!$link->category ?? ''!!}</td>
                </tr>
                <tr>
                    <th>链接名称</th>
                    <td>{{$link->title ?? ''}}</td>
                </tr>
                <tr>
                    <th>URL</th>
                    <td>{{$link->url ?? ''}}</td>
                </tr>
                <tr>
                    <th>描述</th>
                    <td>{{$link->description ?? ''}}</td>
                </tr>
                <tr>
                    <th>排序</th>
                    <td>{{$link->sort ?? ''}}</td>
                </tr>
                <tr>
                    <th>私有</th>
                    <td>@if($link->flag==1) 是 @else 否 @endif</td>
                </tr>
                <tr>
                    <th>点击次数</th>
                    <td>{{$link->click ?? ''}}</td>
                </tr>
                <tr>
                    <th>创建时间</th>
                    <td>{{$link->created_at ?? ''}}</td>
                </tr>
                <tr>
                    <th>更新时间</th>
                    <td>{{$link->updated_at ?? ''}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')

@endsection
