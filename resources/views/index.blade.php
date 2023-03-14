<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>导航</title>
{{--    <link rel="shortcut icon" href="https://api.nosoxo.com/static/nav/favcion.ico"/>--}}
    <link rel="stylesheet" href="{{asset('static/nav/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('static/nav/css/style.css')}}">
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?aeb6126cc6d99b1d7fcf657327944508";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>

<body>
<div class="container" id="container">
    <aside class="left-bar" id="leftBar">
        <div class="title">
            <p>MyNav</p>
        </div>
        <nav class="nav">
            <div class="item active"><a href=""><i class="iconfont icon-daohang2"></i>导航</a><i class="line"></i></div>
            <ul class="nav-item" id="navItem">
                <!-- 遍历左侧导航 -->
                @foreach($categories as $category)
                    @if($loop->first)
                        <li><a href="#{{$category->id}}" class="active">{!!$category->name!!}</a></li>
                    @else
                        <li><a href="#{{$category->id}}" >{!!$category->name!!}</a></li>
                    @endif
                @endforeach
            </ul>
            <div class="item comment"><a target="_blank" href="#"><i class="iconfont icon-liuyan"></i>留言</a></div>
        </nav>
    </aside>
    <section class="main">
        <div id="mainContent">
            <!-- 手机端菜单 -->
            <div id="menu"><a href="#">菜单</a></div>
            <!-- 遍历 -->
            @foreach($categories as $category)
                <div class="box">
                    <a href="#" name="{{$category->id}}"></a>
                    <div class="sub-category">
                        <div>{!!$category->name!!}</div>
                    </div>
                    <div>
                        @foreach($category->links as $link)
                            <a target="_blank" href="/url/{{$link->id}}" title="{{$link->description}}">
                                <div class="item">
                                    <div class="no-logo"><img src="https://favicon.nosoxo.com/get.php?url={{$link->url}}" style="margin-right:5px;position: relative;top:3px;"width="16" height="16">{{$link->title}}</div>
                                    <div class="desc">{{$link->description}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
        @endforeach
            <footer class="footer">
                <div class="copyright">
                    <div>
                        Copyright © 2022 Powered by
                        <a href="https://github.com/nosoxo/MyNav/">MyNav</a>.
                    </div>
                </div>
            </footer>
        </div>
    </section>
    <script>
        var oMenu = document.getElementById('menu');
        var oBtn = oMenu.getElementsByTagName('a')[0];
        var oLeftBar = document.getElementById('leftBar');
        oBtn.onclick = function () {
            if (oLeftBar.offsetLeft == 0) {
                oLeftBar.style.left = -249 + 'px';
            } else {
                oLeftBar.style.left = 0 + 'px';
            }
            if (document.documentElement.clientWidth <= 481) {
                document.onclick = function () {
                    if (oLeftBar.offsetLeft == 0) {
                        console.log(123);
                        oLeftBar.style.left = -249 + 'px';
                    }
                }
            }
        }

        var oNavItem = document.getElementById('navItem');
        var aA = oNavItem.getElementsByTagName('a');
        for (var i = 0; i < aA.length; i++) {
            aA[i].onclick = function () {
                for (var j = 0; j < aA.length; j++) {
                    aA[j].className = '';
                }
                this.className = 'active';
            }
        }
    </script>
</div>
</body>
</html>
