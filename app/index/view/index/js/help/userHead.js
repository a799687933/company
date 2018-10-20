Object.html =   '<div class="userHead">' +
                '<div class="headTop">' +
                '<div class="headImgDiv"><img src="img/defaultUser.png" class="headImg"></div>' + 
                '<div class="baseInfo">' +
                '<div class="baseInfoDiv">账号：<span class="baseInfoSpan">13509876789</span></div>' +
                '<div class="baseInfoDiv">昵称：<span class="baseInfoSpan">我是Jack</span></div>' +
                '<div class="baseInfoDiv">性别：<span class="baseInfoSpan">男</span></div></div>' +
                '<div class="goModifyPage"><a href="info.html" class="goInfoPage">修改资料</a></div></div>' +
                '<div class="headPage cl-fix">'+
                (location.href.indexOf('user.html')>-1?'<a href="javascript:;" class="userPageList active">我的订单</a>' : '<a href="user.html" class="userPageList">我的订单</a>')+
                (location.href.indexOf('addrList.html')>-1?'<a href="javascript:;" class="userPageList active">收货地址</a>':'<a href="addrList.html" class="userPageList">收货地址</a>') +
                (location.href.indexOf('couponList.html')>-1?'<a href="javascript:;" class="userPageList active">优惠券<span class="couponNum">2</span></a>':'<a href="javascript:;" class="userPageList">优惠券<span class="couponNum">2</span></a>') +
                (location.href.indexOf('recharge.html')>-1?'<a href="javascript:;" class="userPageList active">我的余额</a>':'<a href="recharge.html" class="userPageList">我的余额</a>')+
                (location.href.indexOf('pwd.html')>-1 || location.href.indexOf('payPwd.html')>-1?'<a href="javascript:;" class="userPageList active">修改密码</a>':'<a href="pwd.html" class="userPageList">修改密码</a>')+
                '</div></div>';
document.write(Object.html);
delete Object.html;