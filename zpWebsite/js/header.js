$(function () {
    // 当前路由对应导航css
    setTimeout(() => {
        whichMenuActive();

        var t = JSON.parse(sessionStorage.getItem('token'));
        var r = JSON.parse(sessionStorage.getItem('role'));
        var i = JSON.parse(sessionStorage.getItem('header_img'));
        var n = JSON.parse(sessionStorage.getItem('nickname'));
        var s = JSON.parse(sessionStorage.getItem('sex'));
        var l = JSON.parse(sessionStorage.getItem('is_upload')); //0=未传简历 1=反之
        var uu = JSON.parse(sessionStorage.getItem('username'));

        var u = '';
        if (!isDataValid(n)) {
            u = uu ? uu.split('@')[0].split('').splice(0, 6).join('') : '';
        }
        if (isDataValid(n) && isDataValid(s)) {
            var ss = (s == '男') ? '先生' : '女士';
            u = n + ss;
        }
        if (isDataValid(t) && isDataValid(r)) { //有token\role
            if (r == 2) { //2=招聘者
                setTimeout(() => {
                    $('#haveToken2').removeClass('d-none');
                    isDataValid(i) ? $('#haveToken2 img').attr('src', i) : '';
                    $('#zperName').text('欢迎您，' + u)
                }, 100)
            }
            if (r == 3) { //3=应聘者
                setTimeout(() => {
                    //是否显示查看简历 根据是否传过简历
                    l == 1 ? $("#download").removeClass('d-none') : $("#download").addClass('d-none');

                    $('#haveToken3').removeClass('d-none');
                    isDataValid(i) ? $('#haveToken3 img').attr('src', i) : '';
                    $('#yperName').text('欢迎您，' + u)
                }, 100)
            }
        } else {
            setTimeout(() => {
                $('#noToken').removeClass('d-none');
            }, 100)
        }
    }, 10);

    //url变化监听器
    if (('onhashchange' in window) && ((typeof document.documentMode === 'undefined') || document.documentMode == 8)) {
        // 浏览器支持onhashchange事件
        window.onhashchange = hashChange; // TODO，对应新的hash执行的操作函数
    } else {
        // 不支持则用定时器检测的办法
        setInterval(function () {
            // 检测hash值或其中某一段是否更改的函数， 在低版本的iE浏览器中通过window.location.hash取出的指和其它的浏览器不同，要注意
            var ischanged = isHashChanged();
            if (ischanged) {
                hashChange(); // TODO，对应新的hash执行的操作函数
            }
        }, 150);
    }
});

//监听触发操作
function hashChange() {
    whichMenuActive();
}

// 根据url添加当前菜单激活状态
function whichMenuActive() {
    setTimeout(() => {
        const url = document.URL;
        $('.header .nav-link').removeClass('active');
        $.each($('.header .nav-link'), function (i, val) {
            if (val.href == url || url.indexOf(val.href) > -1) {
                $(this).addClass('active');
                console.log($(this))
            }
        });
    }, 50)
}

function uploadFile() {
    var fileList = event.target.files;

    let url = httpUrl + '/admin/Uploadc/upload';
    if (fileList.length > 0) {
        var file;
        file = fileList[0];
        // 通过FormData将文件转成二进制数据
        let formData;
        formData = new FormData();
        formData.append('file', file, file.name);
        // ajax请求
        $.ajax({
            type: 'POST', //请求方式
            url: url, //请求路径 
            data: formData, //参数
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function (XMLHttpRequest) {},
            success: function (data) { //成功
                if (data.resultcode >= 0) {
                    var u = data.data.url;
                    sendJl(u);
                    setTimeout(() => {
                        $('#exampleModalCenter').modal('hide');
                        window.localStorage.setItem('postfileSc', 0);
                        window.location.reload();
                    }, 200)
                } else {
                    window.localStorage.setItem('postfileSc', -1);
                }
            },
            error: function (obj, msg, e) { //异常
                window.localStorage.setItem('postfileSc', -1);
            }
        });
    }
}
//发送简历
function sendJl(e) {
    var url = httpUrl + '/admin/Web_Userc/uploadResume/token/' + getToken();
    var params = {
        "file_url": e
    };
    $.ajax({
        type: 'POST', //请求方式
        url: url, //请求路径 
        data: JSON.stringify(params), //参数
        dataType: 'JSON',
        contentType: 'application/x-www-form-urlencoded;charset=utf-8',
        beforeSend: function (XMLHttpRequest) {},
        success: function (data) {
            if (data.resultcode >= 0) { // 成功
                JSON.parse(sessionStorage.setItem('is_upload', '1'));
                toastr.success(data.resultmsg)
            } else {
                toastr.error(data.resultmsg)
            }
        },
        error: function (obj, msg, e) { //异常
            toastr.error(data.msg)
        }
    });
}
//下载简历
function downloadJl() {
    let url = httpUrl + '/admin/Web_Userc/downloadResume/token/' + getToken();
    $.ajax({
        type: 'get', //请求方式
        url: url, //请求路径 
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded;charset=utf-8',
        beforeSend: function (XMLHttpRequest) {},
        success: function (data) { //成功
            if (data.resultcode >= 0) {
                window.open(data.data.file_url);
            }
        },
        error: function (obj, msg, e) { //异常
            toastr.error('网络异常，下载失败！')
        }
    });
}
// 招聘者-发布职位
function wantfb() {
    if (isDataValid(JSON.parse(sessionStorage.getItem('company_id')))) {
        sessionStorage.setItem('isUpd', false);
        window.location.href = document.URL.substring(0, document.URL.indexOf(
            '')) + 'postJob.html';
    } else {
        window.location.href = document.URL.substring(0, document.URL.indexOf(
            '')) + 'zperInfo.html';
    }
}

// 用户-修改信息
function uploadInfo() {
    var r = JSON.parse(sessionStorage.getItem('role'));
    if (r == 2) {
        window.location.href = document.URL.substring(0, document.URL.indexOf(
            '')) + 'zperInfo.html';
    }
    if (r == 3) {
        window.location.href = document.URL.substring(0, document.URL.indexOf(
            '')) + 'finderInfo.html';
    }
}