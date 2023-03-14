@extends('layouts.app')
@section('style')

@endsection

@section('content')
    <div class="layuimini-container">
        <div class="layuimini-main">

            <fieldset class="table-search-fieldset">
                <legend>搜索信息</legend>
                <div style="margin: 10px 10px 10px 10px">
                    <form class="layui-form layui-form-pane" lay-filter="data-search-filter" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">分类名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="name" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">描述</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="description" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <button type="submit" class="layui-btn layui-btn-primary" lay-submit lay-filter="data-search-btn"><i
                                            class="layui-icon"></i> 搜 索
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="toolbarFilter">
                <div class="layui-btn-container">
                    @if( check_admin_auth ($MODULE_NAME.' create'))
                        <button class="layui-btn layui-btn-sm data-add-btn" lay-event="add"> 添加</button>
                    @endif
                </div>
            </script>
            <script type="text/html" id="currentTableBar">
                @if( check_admin_auth ($MODULE_NAME.' show'))
                <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                @endif
                @if( check_admin_auth ($MODULE_NAME.'_edit'))
                <a class="layui-btn layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
                @endif
                @if( check_admin_auth ($MODULE_NAME.'_delete'))
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
                @endif
            </script>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        layui.use(['form', 'table'], function () {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table,
                layuimini = layui.layuimini;
            form.render();
            table.render({
                elem: '#currentTableId',
                url: '/admin/' + MODULE_NAME,
                toolbar: '#toolbarFilter',
                defaultToolbar: ['filter',],
                cols: [[
                    {type: 'numbers'},
                    {field: 'name', title: '分类名称', hide: false, sort: true},
                    {field: 'description', title: '描述', width: 180},
                    {field: 'sort', title: '排序号', width: 80, align: 'center', hide: false, sort: true},
                    {field: '私有', title: '隐藏',width: 80, align: 'center'},
                    {title: '操作', width: 220, templet: '#currentTableBar', fixed: "right", align: "center"}
                ]],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true,
            });

            // 监听搜索操作
            form.on('submit(data-search-btn)', function (data) {
                var result = JSON.stringify(data.field);
                // layer.alert(result, {
                //     title: '最终的搜索信息'
                // });

                //执行搜索重载
                table.reload('currentTableId', {
                    page: {
                        curr: 1
                    }
                    , where: {
                        searchParams: result
                    }
                }, 'data');

                return false;
            });
            //监听表格复选框选择
            table.on('checkbox(currentTableFilter)', function (obj) {
                console.log(obj)
            });

            table.on('toolbar(currentTableFilter)', function (obj) {
                console.log(obj);
                var data = form.val("data-search-filter");
                var searchParams = JSON.stringify(data);
                switch (obj.event) {
                    case 'add':
                        var index = layer.open({
                            title: '',
                            type: 2,
                            shade: 0.2,
                            maxmin: false,
                            shadeClose: false,
                            area: ['60%', '65%'],
                            content: '/admin/' + MODULE_NAME + '/create',
                        });
                        break;
                    case 'batch-delete':
                        var checkStatus = table.checkStatus('currentTableId')
                            , data = checkStatus.data;
                        layer.confirm('确认删除记录？', function (index) {
                            layer.msg('删除' + data.length + '条记录', {icon: 6});
                            layer.close(index);
                        });
                        break;
                    case 'link':
                        setTimeout(function () {
                            table.resize();//
                        }, TABLE_RESIZE_TIME)
                        break;
                    case 'export_data':
                        window.location.href = '/admin/' + MODULE_NAME + '/export?searchParams=' + searchParams;
                        break;
                    case 'LAYTABLE_TIPS':
                        top.layer_module_tips(MODULE_NAME)
                        break;
                }
            });
            table.on('tool(currentTableFilter)', function (obj) {
                var data = obj.data;
                switch (obj.event) {
                    case 'edit':
                        var index = layer.open({
                            title: '',
                            type: 2,
                            shade: 0.2,
                            maxmin: false,
                            shadeClose: false,
                            area: ['60%', '65%'],
                            content: '/admin/' + MODULE_NAME + '/' + data.id + '/edit',
                        });
                        break;
                    case 'view':
                        var index = layer.open({
                            title: '',
                            type: 2,
                            shade: 0.2,
                            maxmin: false,
                            shadeClose: false,
                            area: ['60%', '65%'],
                            content: '/admin/' + MODULE_NAME + '/' + data.id,
                        });
                        break;
                    case 'delete':
                        layer.msg('确认永久删除？', {
                            time: 0 //不自动关闭
                            ,btn: ['确认', '取消']
                            ,yes: function(index){
                                layer.close(index);
                                $.ajax({
                                    type: 'POST',
                                    url: '/admin/' + MODULE_NAME + '/' + data.id,
                                    data: {
                                        _method: 'DELETE'
                                    },
                                    dataType: 'json',
                                    beforeSend: function () {
                                        loading = layer.load(2)
                                    },
                                    complete: function () {
                                        layer.close(loading)
                                    },
                                    error: function () {
                                        top.layer.msg(AJAX_ERROR_TIP, {
                                            icon: 2,
                                            time: FAIL_TIME,
                                            shade: 0.3
                                        });
                                    },
                                    success: function (data) {
                                        if (data.code === 0) {
                                            layer.msg(data.message, {icon: 6, time: SUCCESS_TIME, shade: 0.2});
                                            setTimeout(function () {
                                                $('button[lay-filter="data-search-btn"]').click();//刷新列表
                                            }, SUCCESS_TIME);
                                        } else {
                                            top.layer.msg(data.message, {
                                                icon: 2,
                                                time: FAIL_TIME,
                                                shade: 0.3
                                            });
                                        }
                                    }
                                });
                            }
                        });
                        break;
                }
            });

            //监听排序事件
            table.on('sort(currentTableFilter)', function (obj) { //注：sort 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                switch (obj.field) {
                    case 'category_name':
                        obj.field = 'category_id'
                        break;
                }
                table.reload('currentTableId', {
                    initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                    , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                        field: obj.field //排序字段
                        , order: obj.type //排序方式
                    }
                });

                // layer.msg('服务端排序。order by '+ obj.field + ' ' + obj.type);
            });
        });
    </script>
@endsection
