// 基础地址
httpUrl = 'http://121.42.231.8:80/recuritment/public/index.php'; //公共基础地址

$(function () {
    // 加载头部和底部
    $('#header').load('./header.html');
    $('#footer').load('./footer.html');
    var t = JSON.parse(sessionStorage.getItem('token'));
    var r = JSON.parse(sessionStorage.getItem('role'));
    if (isDataValid(t) && isDataValid(r)) {
        if (r == 2) { //2=招聘者
            $('#tab_bar_zp').load('./tab_barzp.html');
            getTabList('sdmsg');
        }
        if (r == 3) { //3=应聘者
            //加载侧边栏
            $('#tab_bar').load('./tabbar.html');
        }
        // 侧边栏
        setTimeout(() => {
            $('.tab_bar').mouseenter(function () {

                setTimeout(() => {
                    $('.tab_bar .nav-pills a p').each(function (i, n) {
                        $(n).css('opacity', '1');
                    })
                }, 0)
                if ($('.tab_bar .tab-content').width() == 0) {
                    $('.tab_bar').css('width', "60px");
                } else {
                    $('.tab_bar').css('width', "340px");
                }
                return;
            })
            $('.tab_bar').mouseleave(function () {
                if ($('.tab_bar .tab-content').width() == 0) {
                    $('.tab_bar').css('width', "30px")
                    $('.tab_bar .nav-pills a p').each(function (i, n) {
                        $(n).css('opacity', '0');
                    })
                    $('.tab_bar .nav-pills a').each(function (i, n) {
                        $(n).removeClass('active');
                    })
                } else {
                    $('.tab_bar').css('width', "340px");
                }
                return;
            })
            $('.tab_bar .nav-pills a').click(function (e) {
                var v = e.currentTarget.id.split('-')[2];
                $('.tab_bar').css('width', "340px");
                $('.tab_bar .tab-content').css('width', "280px");
                getTabList(v);
            })
            $(document).click(function (e) {
                var target = $(e.target);
                var a = target.closest(".tab_bar").length;
                if (a == 0) {
                    $('.tab_bar .nav-pills a p').each(function (i, n) {
                        $(n).css('opacity', '0');
                    })
                    $('.tab_bar .nav-pills a').each(function (i, n) {
                        $(n).removeClass('active');
                    })
                    $('.tab_bar').css('width', "30px")
                    $('.tab_bar .tab-content').css('width', "0")
                }
            })
        }, 100)

    }
    setTimeout(() => {
        if (document.URL.indexOf('registe.html') > -1 || document.URL.indexOf('login.html') > -1) { //注册、登录界面
            $('#header-rt').hide();
            var h = $(window).height() - $('.header').outerHeight(true);
            $('.main-body').css('height', h);
            $('.main-body').css('background', '#ffffff url(img/zpbc.png) center top no-repeat');
            $('.main-body').css('background-size', '100% 100%');

            // 清除登录信息
            sessionStorage.removeItem('token');
            sessionStorage.removeItem('role');
            sessionStorage.removeItem('username');
            // 滑块1 滑动验证
            $("#handler1").on("mousedown", function (e) {
                var disX = e.clientX - $("#drag1").offset().left;
                var maxWidth = $("#drag1").width() - $("#handler1").width();
                $(document).on("mousemove", function (e) {
                    var x = e.clientX - $("#drag1").offset().left - disX;
                    x = Math.max(Math.min(x, maxWidth), 0);
                    $("#handler1").css("left", x);
                    $("#drag_bg1").width(x);
                    if (x == maxWidth) {
                        $("#handler1").removeClass("handler_bg").addClass("handler_ok_bg");
                        $("#drag_text1").css("color", "#fff").html("验证成功");
                        $("#slider1").removeClass('d-block').addClass('d-none')
                        $(document).off("mousemove");
                        $(document).off("mouseup");
                        $("#handler1").off("mousedown");
                        e.preventDefault();
                    }
                });
                $(document).on("mouseup", function (e) {
                    $(document).off("mousemove");
                    $(document).off("mouseup");
                    var x = e.clientX - $("#drag1").offset().left - disX;
                    if (x < maxWidth) {
                        $("#handler1").css("left", 0);
                        $("#drag_bg1").width(0);
                    }
                });
                e.preventDefault();
            });

            // 滑块2 滑动验证
            $("#handler2").on("mousedown", function (e) {
                var disX = e.clientX - $("#drag2").offset().left;
                var maxWidth = $("#drag2").width() - $("#handler2").width();
                $(document).on("mousemove", function (e) {
                    var x = e.clientX - $("#drag2").offset().left - disX;
                    x = Math.max(Math.min(x, maxWidth), 0);
                    $("#handler2").css("left", x);
                    $("#drag_bg2").width(x);
                    if (x == maxWidth) {
                        $("#handler2").removeClass("handler_bg").addClass("handler_ok_bg");
                        $("#drag_text2").css("color", "#fff").html("验证成功");
                        $("#slider2").removeClass('d-block').addClass('d-none')
                        $(document).off("mousemove");
                        $(document).off("mouseup");
                        $("#handler2").off("mousedown");
                        e.preventDefault();
                    }
                });
                $(document).on("mouseup", function (e) {
                    $(document).off("mousemove");
                    $(document).off("mouseup");
                    var x = e.clientX - $("#drag2").offset().left - disX;
                    if (x < maxWidth) {
                        $("#handler2").css("left", 0);
                        $("#drag_bg2").width(0);
                    }
                });
                e.preventDefault();
            });
        }

        if (document.URL.indexOf('zperInfo.html') > -1 || document.URL.indexOf('postJob.html') > -1) {
            // $('#city').load('./city.html');
            $('#header-rt').show();
        }

        handleNav();
    }, 100);

    //职位详情页面
    if (document.URL.indexOf('detail.html') > -1) {
        var r = sessionStorage.getItem('role');
        $('.startchat').hide();
        if (r == 1 || r == 2) {

        }
        if (r == 3 || !isDataValid(r)) {
            $('.job-op').removeClass('d-none');
            setTimeout(() => {
                //求职者 感兴趣/举报
                $('.op-links').removeClass('d-none');
            }, 100)
            if (r == 3) {
                // 求职者-我要留言
                $('.btn-startchat').click(function () {
                    $('.startchat').css('top', $(this).offset().top - 1);
                    $('.startchat').css('left', $(this).offset().left - 254);
                    $('.startchat').toggle();
                });
            }
            if (!isDataValid(r)) {
                $('.btn-startchat').click(function () {
                    toastr.warning('请先登录～');
                    setTimeout(() => {
                        window.location.href = document.URL.substring(0, document.URL.indexOf(
                            '')) + 'login.html';
                    }, 1000)
                })
                setTimeout(() => {
                    $('.to-like').click(function () {
                        toastr.warning('请先登录～');
                        setTimeout(() => {
                            window.location.href = document.URL.substring(0, document.URL.indexOf(
                                '')) + 'login.html';
                        }, 1000)
                    })
                }, 100)
            }
        }
        //我要留言 外部点击关闭留言页面
        $(document).click(function (e) {
            var target = $(e.target);
            var a = target.closest(".btn-startchat").length;
            var b = target.closest(".startchat").length;
            if (a == 0 && b == 0) {
                $('.startchat').hide();
            }
        })
    }
    $(window).resize(function () {
        handleNav();
    });

    $('a[data-toggle="pill"]').on('click', function (e) {
        e.preventDefault();
        window.location.href = document.URL.substring(0, document.URL.indexOf('')) + $(this).attr('href');
    });

    $(window).scroll(function () {
        handleNav();
    });

    //关闭显示input输入框记录
    $('input').attr('autocomplete', 'off');

    //城市选择 外部点击关闭城市数据弹出页面
    $(document).bind("click", function (e) {
        var target = $(e.target);
        if (target.closest("li").length == 0) {
            $("#addr").hide();
        }
    })
    $(document).bind("click", function (e) {
        var target = $(e.target);
        if (target.closest("collapseExample").length == 0) {
            $("#collapseExample").collapse('hide');;
        }
    })
});


// 当滚动条滚动到顶部，固定首页页面菜单导航
function handleNav() {
    //为页面添加页面滚动监听事件
    const wst = $(window).scrollTop() //滚动条距离顶端值
    const url = document.URL;
    if (url.indexOf('index.html') > -1 || url.charAt(url.length - 1) == '/') { // 首页
        if ($('.aui-wrapper').outerHeight(true) + $('.header').outerHeight(true) < wst) {
            $('.aui-wrapper').addClass('to-fixed');
            $('.aui-container-bxo').css('padding-top', '110px');
            $('.aui-wrapper-header').addClass('aui-wrapper-header-scroll');
            $('.aui-wrapper-header-info').addClass('d-none');
            $('.search-logo-sec').removeClass('d-none');
        } else {
            $('.aui-wrapper-header').removeClass('aui-wrapper-header-scroll');
            $('.aui-wrapper').removeClass('to-fixed');
            $('.aui-container-bxo').css('padding-top', '0');
            $('.aui-wrapper-header-info').removeClass('d-none');
            $('.search-logo-sec').addClass('d-none');
        }
    }
}

// 职位详情
function detail(e, mark) {
    let url = httpUrl + '/admin/Web_Userc/positionDetail/id/' + e;
    localStorage.removeItem('detail');
    $.ajax({
        type: 'get', //请求方式
        url: url, //请求路径 
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded;charset=utf-8',
        beforeSend: function (XMLHttpRequest) {},
        success: function (data) { //成功
            if (data.resultcode >= 0) {
                if (data.data && data.data.length > 0) {
                    var newlists = data.data;
                    localStorage.setItem('detail', JSON.stringify(newlists));
                    if (isDataValid(mark)) {
                        window.open(document.URL.substring(0, document.URL.indexOf(
                            '')) + 'detail.html')
                    } else {
                        window.location.href = document.URL.substring(0, document.URL.indexOf(
                            '')) + 'detail.html';
                    }
                } else {}
            }
        },
        error: function (obj, msg, e) { //异常
            // console.log(msg);
        }
    })
}

//侧边栏数据请求
function getTabList(e) {
    var url;
    //1.求职者模块
    if (e == 'profile') { //收藏
        url = httpUrl + '/admin/Web_Userc/getCollection';
    }
    if (e == 'messages') { //留言
        url = httpUrl + '/admin/Web_Userc/getQLiuyan';
    }
    if (e == 'toudi') { //投递
        url = httpUrl + '/admin/Web_Userc/getDelivery';
    }
    //2.招聘者模块
    if (e == 'fabu') { //我的发布
        url = httpUrl + '/admin/Web_Userc/personalPosition';
    }
    if (e == 'sdmsg') { //收到留言
        url = httpUrl + '/admin/Web_Userc/getLiuyan';
    }
    if (e == 'jl') { //收到简历
        url = httpUrl + '/admin/Web_Userc/getResume';
    }
    url += '/token/' + getToken();
    $.ajax({
        type: 'get', //请求方式
        url: url, //请求路径 
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded;charset=utf-8',
        beforeSend: function (XMLHttpRequest) {},
        success: function (data) { //成功
            if (data.resultcode >= 0) {
                if (isDataValid(data.data.list)) {

                    var Classlists = data.data;

                    var template1 = $.templates('#myscList');
                    var template2 = $.templates('#mylyList');
                    var template3 = $.templates('#mytdList');

                    var template4 = $.templates('#zpfbList');
                    var template5 = $.templates('#zplyList');
                    var template6 = $.templates('#zpjlList');

                    $('.mysc').html(template1.render(Classlists));
                    $('.myly').html(template2.render(Classlists));
                    $('.mytd').html(template3.render(Classlists));

                    $('.zpfb').html(template4.render(Classlists));
                    $('.zply').html(template5.render(Classlists));
                    $('.zpjl').html(template6.render(Classlists));

                    e == 'sdmsg' && data.data.count > 0 ? $('#getLyNumber').html(data.data.count) : '';
                } else {}
            }
        },
        error: function (obj, msg, e) { //异常
            // console.log(msg);
        }
    });
}

// 获取Url参数
function getQueryString(name) {
    var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
    var r = window.location.search.substr(1).match(reg);
    if (r != null) {
        return unescape(r[2]);
    }
    return null;
}


/**
 * 判断是否为空
 */
function isDataValid(data) {
    if (data != null && data !== '' && data !== 'undefined' && data !== 'null' && data !== undefined) {
        return true;
    }
    return false;
}
// 获取token
function getToken() {
    return sessionStorage.getItem('token') ? JSON.parse(sessionStorage.getItem('token')) : null;
}
//token失效
function reLogin(e) {
    toastr.error(e.resultmsg);
    setTimeout(() => {
        window.location.href = document.URL.substring(0, document.URL
                .indexOf(
                    '')) +
            'login.html';
    }, 1000)
}