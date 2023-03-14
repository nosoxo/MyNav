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
                    <th>分类名称</th>
                    <td>{{$category->name ?? ''}}</td>
                </tr>
                <tr>
                    <th>描述</th>
                    <td>{{$category->description ?? ''}}</td>
                </tr>
                <tr>
                    <th>排序</th>
                    <td>{{$category->sort ?? ''}}</td>
                </tr>
                <tr>
                    <th>私有</th>
                    <td>@if($category->flag==1) 是 @else 否 @endif</td>
                </tr>
                <tr>
                    <th>创建时间</th>
                    <td>{{$category->created_at ?? ''}}</td>
                </tr>
                <tr>
                    <th>更新时间</th>
                    <td>{{$category->updated_at ?? ''}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')

@endsection
