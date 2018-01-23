<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo L('ADMIN_TITLE');?></title>
<link rel="shortcut icon" href="/Public/Static/images/favicon.ico" />
<link href="/Public/Static/css/bootstrap.min.css" rel="stylesheet">
<link href="/Public/Static/css/font-awesome.min.css" rel="stylesheet">
<link href="/Public/Static/css/common.css" rel="stylesheet">
<script type="text/javascript">
if(navigator.appName == 'Microsoft Internet Explorer'){
		if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
			alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
		}
}
</script>
<script>var require = { urlArgs: 'v=<?php echo date('YmdH'); ?>' };</script>
<script type="text/javascript" src="/Public/Static/js/lib/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/Static/js/app/lqCommonFun.js"></script>
<script type="text/javascript" src="/Public/Static/js/require.js"></script>
<script type="text/javascript" src="/Public/Static/js/app/config.js"></script>
</head>
<body>
 <div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <ul class="nav navbar-nav" id="top-nav">
      <li id="top-key-0"><a lqid="0" href="#"><i class="fa fa-home"></i>首页</a></li>
      <?php if(is_array($system_top_menu)): $key_top = 0; $__LIST__ = $system_top_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data_top): $mod = ($key_top % 2 );++$key_top;?><li id="top-key-<?php echo ($key_top); ?>"><a lqid="<?php echo ($key_top); ?>" href="#"><i class="fa fa-cog"></i><?php echo ($data_top["zc_caption"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      <li><a href="javascript:;" class="getUrl" lqHref="<?php echo U('Index/quickClearCache');?>" title="快速清缓存"><i class="fa fa-retweet"></i>快速清缓存</a></li>
    </ul>
    
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown topbar-notice"> <a type="button" data-toggle="dropdown"> <i class="fa fa-qrcode"></i> </a>
        <div class="dropdown-menu" aria-labelledby="dLabel">
          <div class="topbar-notice-panel">
            <div class="topbar-notice-arrow"></div>
            <div class="topbar-notice-head"> <span>平台二维码</span></div>
            <div class="topbar-notice-body" style="text-align:center;">
              <img src="/Public/Static/images/system-qrcode.jpg" width="300" />
            </div>
          </div>
        </div>
      </li>    
      <li class="dropdown topbar-notice"> <a type="button" data-toggle="dropdown"> <i class="fa fa-bell"></i> <span class="badge" id="notice-total">0</span> </a>
        <div class="dropdown-menu" aria-labelledby="dLabel">
          <div class="topbar-notice-panel">
            <div class="topbar-notice-arrow"></div>
            <div class="topbar-notice-head"> <span>系统公告</span> <a href="javascript:;" class="pull-right">更多公告>></a> </div>
            <div class="topbar-notice-body">
              <ul id="notice-container">
              </ul>
            </div>
          </div>
        </div>
      </li>
      
      <li class="dropdown"> <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="display:block;max-width:205px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><i class="fa fa-user"></i><?php echo ($login_admin_info["zc_account"]); ?>(<?php echo ($login_admin_info["zn_role_id_label"]); ?>)<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo U('Index/modifyMyself/action/info');?>"><i class="fa fa-user"></i> 修改账号</a></li>
          <li><a href="<?php echo U('Index/modifyMyself/action/pass');?>"><i class="fa fa-lock"></i> 修改密码</a></li>
          <li class="divider"></li>
          <?php if($login_admin_info["id"] == '1' ): ?><li><a href="<?php echo U('SystemMenu/index');?>"><i class="fa fa-sitemap fa-fw"></i> 系统菜单</a></li><?php endif; ?>
          <?php if($login_admin_info["zn_role_id"] == '1' ): ?><li><a href="<?php echo U('Index/clearCache');?>"><i class="fa fa-refresh fa-fw"></i> 更新缓存</a></li><?php endif; ?>
          <li><a href="/document" target="_blank"><i class="fa fa-gears"></i> 接口文档</a></li>
          <li class="divider"></li>
          <li><a href="javascript:;" class="getUrl" lqhref="<?php echo U('Login/opLoginOut');?>" title="退出当前登陆"><i class="fa fa-sign-out fa-fw"></i> 退出系统</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>

<div class="container-fluid"  style="padding-top:55px;">
  <div class="row">
    <div class="col-xs-12 col-sm-3 col-lg-2 big-menu" id="left-menu">
      <div id="search-menu">
        <input class="form-control input-lg" style="border-radius:0; font-size:14px; height:43px;" type="text" placeholder="输入菜单名称可快速查找">
      </div>
      <?php if(is_array($system_left_menu)): $key1 = 0; $__LIST__ = $system_left_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data1): $mod = ($key1 % 2 );++$key1;?><span class="left-menu" id="left-menu-<?php echo ($key1); ?>" <?php echo ($data1["system_style"]); ?>>
        <?php if(is_array($data1["system_menu"])): $key2 = 0; $__LIST__ = $data1["system_menu"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data2): $mod = ($key2 % 2 );++$key2;?><div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"><?php echo ($data2["zc_caption"]); ?></h4>
              <a class="panel-collapse collapsed" data-toggle="collapse" href="#frame-<?php echo ($data2["id"]); ?>"> <i class="fa fa-chevron-circle-down"></i> </a> </div>
            <ul class="list-group collapse in" id="frame-<?php echo ($data2["id"]); ?>">
              <?php if(is_array($data2["child"])): $key_child = 0; $__LIST__ = $data2["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data_child): $mod = ($key_child % 2 );++$key_child; if($data_child["zc_run"] == '' ): ?><a id="left-key-<?php echo ($data_child["id"]); ?>" lqid="<?php echo ($data_child["id"]); ?>" class="list-group-item" href="javascript:;" kw="<?php echo ($data_child["zc_caption"]); ?>"><?php echo ($data_child["zc_caption"]); ?></a>
              <?php else: ?>
              <?php if($data_child["zc_target"] == 'openWin' ): ?><a id="left-key-<?php echo ($data_child["id"]); ?>" lqid="<?php echo ($data_child["id"]); ?>" class="list-group-item" href="javascript:;" lqHref="<?php echo ($data_child["run"]); ?>" kw="<?php echo ($data_child["zc_caption"]); ?>"><?php echo ($data_child["zc_caption"]); ?></a>
              <?php else: ?>
              <a id="left-key-<?php echo ($data_child["id"]); ?>" lqid="<?php echo ($data_child["id"]); ?>" class="list-group-item" href="<?php echo ($data_child["run"]); ?>" kw="<?php echo ($data_child["zc_caption"]); ?>" target="<?php echo ($data_child["zc_target"]); ?>"><?php echo ($data_child["zc_caption"]); ?></a><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </span><?php endforeach; endif; else: echo "" ;endif; ?>
      <script type="text/javascript">
		require(['bootstrap'], function(){
			$('#search-menu input').keyup(function() {
				var a = $(this).val();
				$('.big-menu .list-group-item, .big-menu .panel-heading').hide();
				$('.big-menu .list-group-item').each(function() {
				$(this).css('border-left', '0');
				if(a.length > 0 && $(this).attr('kw').indexOf(a) >= 0) {
					$(this).parents(".panel").find('.panel-heading').show();
					$(this).show().css('border-left', '3px #428bca double');
				}
				});
				if(a.length == 0) {
					$('.big-menu .list-group-item, .big-menu .panel-heading').show();
				}
			});
		});
      </script> 
    </div>


<div class="col-xs-12 col-sm-9 col-lg-10">
    <div class="row">
        <div class="col-sm-6 common-search-btn"><a class="btn btn-primary" href="" title="刷新本页"> <i
                class="fa fa-refresh"></i> 刷新本页 </a></div>
        <div class="col-sm-6" style="float:right;text-align:right;padding:0;margin:0px;"><?php echo ($sys_current); ?></div>
    </div>

    <form id="LQForm" class="form-horizontal" method="post" action="">
        <div class="clearfix welcome-container">
            <div class="panel panel-info">
                <div class="panel-heading">短信发送器</div>
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">活动名称</label>

                        <div class="col-sm-8 col-xs-12">
                            <input type="text" name="activity" id="activity" class="form-control" value="" required  controlTitle="请输入活动名称" placeholder="请输入活动名称"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">客户手机</label>

                        <div class="col-sm-8 col-xs-12">
                            <input type="text" name="phone" id="phone" class="form-control" value="" required dataType="mobile"  controlTitle="请输入客户手机" placeholder="请输入客户手机"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">优惠金额</label>

                        <div class="col-sm-8 col-xs-12">
                            <input type="text" name="money" id="money" class="form-control" value="" required controlTitle="请输入优惠金额" placeholder="请输入优惠金额"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">有效期</label>

                        <div class="col-sm-8 col-xs-12">
                            <div class="input-group input-append date"><input type="text" class="form-control"
                                                                              placeholder="请输入有效期" controlTitle="请输入有效期" id="validity"
                                                                              name="validity" value=""
                                                                              required="required" controltitle="有效期">
                            </div>

                        </div>
                    </div>
                    <script type="text/javascript">
                        require(["datetimepicker"], function () {
                            var zd_send_time_option = {
                                lang: "zh",
                                step: 5,
                                timepicker: true,
                                closeOnDateSelect: true,
                                format: "Y-m-d"
                            };
                            $("#validity").datetimepicker(zd_send_time_option);
                        });
                    </script>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">优惠码</label>

                        <div class="col-sm-8 col-xs-12">
                            <input type="text" name="coupon" id="coupon" class="form-control" value="<?php echo rand(10000,60000); ?>" required controlTitle="请输入优惠码" placeholder="请输入优惠码"/>
                        </div>
                        <div class="pull-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <button class="btn btn-default" id="aFormSubmit"><i class="fa fa-file-excel-o"></i> 发送
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </form>

</div>
<script type="text/javascript" src="/Public/Static/js/lib/admin.validator.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //公共表单提交
        $("#LQFormSubmit,#aFormSubmit").click(function () {
            var loForm = document.getElementById("LQForm");
            if (adminValidator(loForm)) {
                util.commonAjaxSubmit();
            }
            return false;
        });
    });
</script>



	</div>
</div>
    
<div class="container-fluid footer" role="footer">
  <div class="page-header"></div>
  <span class="pull-left">
  <p>Powered by <a href="#"><b><?php echo L('PROJECT_TEAM');?></b></a> v2.0 &copy; 2016-2020 <a href="http://www.jianyuly.com/" target="_blank">www.jianyuly.com</a></p>
  </span> 
  <span class="pull-right">
  <p class="label label-info">{__RUNTIME__} </p>
  </span> 
 </div>

<?php if(ACTION_NAME == 'index'): ?><div class="TopBottomMenu">
	<ul>
		<li><a href="/sys-index.php/Member/index" title="会员列表">会员列表</a></li>
		<li><a href="/sys-index.php/LoanApply/index" title="装修贷订单">装修贷订单</a></li>
		<li><a href="/sys-index.php/HdApplication/index" title="咨询订单">咨询订单</a></li>
		<li><a href="/sys-index.php/HdOrder/index" title="家装订单">家装订单</a></li>
	</ul>
</div>
<script type="text/javascript" src="/Public/Static/js/dwsee.top.bottom.menu.min.js" ></script>
<script type="text/javascript">
$(document).ready(function() {$(this).dwseeTopBottomMenu()})
require(['layer'], function(){layer.photos({photos: '.imgtd',anim: 1});});	
</script><?php endif; ?> 
<script type="text/javascript" src="/Public/Static/js/admin.function.js"></script>
<script>
$(document).ready(function(){
//系统菜单的展示
var top_nav_id=util.cookie.get('top_nav_id');
var left_nav_id=util.cookie.get('left_nav_id');
if(top_nav_id) util.menuDisplay(top_nav_id,left_nav_id);
<?php if(ACTION_NAME=='index') { echo "$('#list-tbody tr:odd').addClass('tr_odd');//单双行样式\n"; echo "$('.opStatus').click(function(){util.visible($(this),'/sys-index.php/Sms/opVisible');});//快捷启用禁用操作\n"; echo "$('.opDelete').click(function(){util.delete($(this),'/sys-index.php/Sms/opDelete');});//单记录删除操作\n"; echo "$('tbody>tr>td[op]').dblclick(function(){util.ajaxEdit($(this),'/sys-index.php/Sms');});//单项编辑\n"; echo "$('tbody>tr>td>a[op]').click(function(){util.ajaxPropertyA($(this),'/sys-index.php/Sms');});//单项属性切换\n"; } ?>	
	//ajax点击响应href
	$(".getUrl").click(function(){util.getUrl($(this).attr("lqHref"));});
	//顶部菜单展示
	$("#top-nav a").click(function(){
		top_nav_id=$(this).attr("lqid");
		$("#top-nav").find("li").removeClass("active");
		if(top_nav_id){
			if(top_nav_id==0){
				 util.R(0,"<?php echo U('Index/index');?>");
				$("#left-menu-2").css({"display":"block"});
				return;
			}
			util.cookie.set('top_nav_id',top_nav_id);
			$("#left-menu").find(".left-menu").css({"display":"none"});
			$("#left-menu-"+top_nav_id).css({"display":"block"});
		}
	});
	//左则菜单焦点记录
	$(".list-group-item").click(function(){
		var lcHref=$(this).attr("lqHref");
		if(typeof lcHref!='undefined'){
		 util.openWin(lcHref,$(this).attr("kw"),'80%','80%');
		}else{
		 left_nav_id=$(this).attr("lqid");util.cookie.set('left_nav_id',left_nav_id);$(this).addClass("active");
		}
	});	
});
</script>
</body>
</html>