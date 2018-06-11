'use strict';

//百度统计代码
// var hash = location.hash,
// 	defaultUrl = '',
// 	_hmt = _hmt || [],
// 	visitorForm = $('meta[name=visitor-form]').attr('content') || 'site';

// _hmt.push(['_setCustomVar', 1, 'form', visitorForm, 2]);

// (function() {
// var hm = document.createElement("script"),
// 	s = document.getElementsByTagName("script")[0];

// hm.src = "https://hm.baidu.com/hm.js?fa2bd45e217bb7176d461a15f7f5b8a8";
// s.parentNode.insertBefore(hm, s);
// })();

// 登录模态窗
function loginModal () {
	 $('#loginBox').modal({
		 onHide: function(){
			 $('#loginForm').find('input').val('');
		 }
	 }).modal('show');
}

// 注册模态窗
function regsiterModal(){
	$('#regBox').modal({
		 onHide: function(){
			 $('#regForm').find('input').val('');
		 }
	 }).modal('setting', 'transition', 'horizontal flip').modal('show');
}

// 定时器
function waitTime(button, wait) {
    if (wait > 0) {
        wait -= 1;
        setTimeout(function () {
            waitTime(button, wait);
        }, 1000);
        button.text(wait + ' 秒后可重新获取').addClass('disabled');
    } else {
        button.text('获取验证码').removeClass('disabled');
    }
}

$(function () {
	
	// 默认打开登录弹框
    if (!$('body').hasClass('logged') && hash === "#login") {
        loginModal();
    }
    
    if(hash === "#register"){
    	regsiterModal();
    }
    
    window.onhashchange = function (){
    	var hash = location.hash;
    	
    	if(hash === "#register"){
        	regsiterModal();
        }
    };
    
    // 响应式菜单
	$('#navbar .menu').click(function (e) {
		e.stopPropagation();
	    var icon = $('.icon', $(this));
	    
	    $('#navbar nav').slideToggle('normal', function () {
	        $('#navbar .menu').toggleClass('active');
	        if ($(this).is(':visible')) {
	            icon.attr('class', 'remove icon');
	        } else {
	            icon.attr('class', 'sidebar icon');
	        }
	    });
	});

	$('body').click(function () {
	    if ($('#navbar .menu').is(':visible')) {
	        $('#navbar nav').slideUp();
	        $('#navbar .menu').removeClass('active').find('.icon').attr('class', 'sidebar icon');
	    }
	});
    
	// 登录表单
    $('#loginForm').form({
	    on: 'blur',
	    fields: {
	        mobile: 'regExp[/^1[3|4|5|7|8][0-9]{9}$/]',
	        logPad: ['minLength[6]', 'maxLength[16]', 'empty']
	    },
	    onSuccess: function (event, fields) {
	    	var _url = "/login",
	    		_data = "mobile="+fields["mobile"]+"&password="+fields["password"],
	    		redirectUrl = window.location.search,
				first = redirectUrl.indexOf('sendUrl');
	    	
	        // 显示遮罩层
	        $('#loginBox .ui.dimmable').dimmer({
	            closable: false
	        }).dimmer('show');

	        if($('#loginForm input[name=loginType]').is(':checked')){
	        	_url = "/login_nopassword";
	        	_data = "mobile="+fields["mobile"]+"&mcode="+fields["password"];
	        }
		
	        redirectUrl = defaultUrl || redirectUrl.substring(first + 8, redirectUrl.length);
	        
	        $.ajax({
	        	url: _url,
	        	type:"post",
	        	dataType:"json",
	        	data: _data,
	        	success:function(res) {
	        		if(res.status === 1) {
	        			if(first !== -1 || defaultUrl !== ''){
	        				window.location.href = decodeURIComponent(redirectUrl);
	        			}else{
	        				$('#navbar').find('a[href="/user"]').removeClass('openlogin');
	        				$('#loginBox .ui.dimmable').dimmer('hide');
	        				$('#loginBox').modal('hide');
	        			}
	        		} else {
	        			$('#loginBox .ui.dimmable').dimmer('hide');
	            		toastr.warning(res.message);
	        		}
	        	},
	        	error:function() {
	        		$('#loginBox .ui.dimmable').dimmer('hide');
	        		toastr.error('登录失败，请重试！');
	        	}
	        });

	    }
	});

    // 改变登录模式
	$('#loginForm input[name=loginType]').change(function () {
	    var pwd = $('#loginForm input[name=password]'),
	        btn = $('#loginForm .getcode'),
	        codeMessage = $('#loginForm .code.message');
	    
	    if ($(this).is(':checked')) {
	        pwd.attr({
	            'placeholder': '验证码',
	            'type': 'text',
	            'maxLength': 6
	        }).val('');
	        btn.show();
	        codeMessage.show();
	    } else {
	        pwd.attr({
	            'placeholder': '密码',
	            'type': 'password'
	        }).removeAttr('maxLength').val('');
	        
	        btn.hide();
	        codeMessage.hide();
	    };
	});

	// 跳转到注册
	$(document).on('click', '.openreg', function () {
		regsiterModal();
	});
	
	// 跳转到登录
	$(document).on('click', '.openlogin', function (e) {
		e.preventDefault();
		
		var $item = $(this);
		
		if($item.is('a')){
			defaultUrl = $item.attr('href');
		}
		
		loginModal();
	});
	
	// 注册表单
	$('#regForm').form({
	    on: 'blur',
	    fields: {
	        mobile: 'regExp[/^1[3|4|5|7|8][0-9]{9}$/]',
	        mcode: 'empty',
	        regPad: ['minLength[6]', 'maxLength[16]', 'empty'],
	        rePassword: ['match[regPad]', 'empty'],
	        agreement: 'checked'
	    },
	    onSuccess: function (event, fields) {

	        //显示遮罩层
	        $('#regBox .ui.dimmable').dimmer({
	            closable: false
	        }).dimmer('show');

	        $.ajax({
	        	url:"/register",
	        	type:"post",
	        	dataType:"json",
	        	data:"mobile="+fields["mobile"]+"&password="+fields["password"]+"&rePassword="+fields["rePassword"]+"&mcode="+fields["mcode"],
	        	success:function(res) {
	        		var url = window.location.search,
	        			first = url.indexOf('sendUrl') + 8;
	        		
	        		url = url.substring(first, url.length);
	        	
	        		if (res.status == 1) {
	        			if(url !== ''){
	        				toastr.success('注册成功，5秒后将为你自动跳转页面！');
	        				setTimeout(function(){
	        					window.location.href = decodeURIComponent(url);
	        				}, 5000);
	        				
	        				return;
	        			}
	        			
	        			toastr.success(res.message);
	                    $('#loginBox').modal('show');
	                } else {
	                	toastr.warning(res.message);
	                	$('#regBox .ui.dimmable').dimmer('hide');
	                }
	        		
	        	},
	        	error:function() {
	        		$('#regBox .ui.dimmable').dimmer('hide');
	                toastr.error('网络错误，请重新尝试 …');
	        	}
	        })
	    }
	});

	// 注册 -- 忘记密码
	$('body').on('click', '.forget', function () {
	    $('#forgetBox').modal({
			 onHide: function(){
				 $('#forgetForm').find('input').val('');
			 }
		 }).modal('setting', 'transition', 'horizontal flip').modal('show');
	});

	// 忘记密码表单
	$('#forgetForm').form({
	    on: 'blur',
	    fields: {
	        mobile: 'regExp[/^1[3|4|5|7|8][0-9]{9}$/]',
	        mcode: 'empty',
	        forPad: ['minLength[6]', 'maxLength[16]', 'empty'],
	        rePassword: ['match[forPad]', 'empty']
	    },
	    onSuccess: function (event, fields) {

	        // 显示遮罩层
	        $('#forgetBox .ui.dimmable').dimmer({
	            closable: false
	        }).dimmer('show');

	        $.get('/resetPassword', fields).done(function (res) {
	        	toastr.info(res.message);
	        	
	            if (res.status == 1) {
	                $('#loginBox').modal('show');
	            } else {
	            	$('#forgetBox .ui.dimmable').dimmer('hide');
	            }
	        }).fail(function () {
	            $('#forgetBox .ui.dimmable').dimmer('hide');
	            toastr.error('网络错误，请重新尝试 …');
	        });
	    }
	});

	// 获取验证码
	$(document).on('click', '.ui.button.getcode:not(.disabled)', function () {
		var $item = $(this),
			$form = $item.closest('.ui.form'),
    		mobile = $('[name=mobile]', $form).val(),
    		type = $('[name=type]', $form).val(), 
    		dataUrl = '/sms/send';
			
			dataUrl += $item.hasClass('from-ajax') ? '?from=ajax' : '';
			
		if (/^1[3|4|5|7|8][0-9]{9}$/.test(mobile)) {
		    $.getJSON(dataUrl, {
		        mobile: mobile,
		        type: type
		    }, function (res) {
		    	if(res.code === 1001){
        			loginModal();
        			return;
        		}
		    	
		        if (res.status == 1) {
		            $('.code.message', $form).html('验证码已经发送，请注意查收').show();
		            waitTime($item, 90);
		        } else {
		            toastr.warning(res.message);
		        }
		    });
		} else {
		    toastr.error('请填写正确的手机号', {timeOut: 500000});
		}
	});

	// // 会员中心菜单
	// $('.ui.sticky.menu').sticky({
	//     context: '#layout',
	//     offset: 10
	// });

	// // 客服组件
	// $('body').append('<script src="//assets-cdn.kf5.com/supportbox/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="admui.kf5.com" charset="utf-8"></script>');

	// // 打开客服弹出层
	// $('.open-kf').on('click', function(e){
	// 	e.preventDefault();
		
	// 	window.KF5SupportBoxAPI.hideButton();
	// 	window.KF5SupportBoxAPI.open();
	// });
});

