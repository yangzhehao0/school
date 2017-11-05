<?php if (!defined('THINK_PATH')) exit();?><!-- header start -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php echo C('DEFAULT_CHARSET');?>" />
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">
	<title><?php echo L('common_site_title');?></title>
	<link rel="stylesheet" type="text/css" href="/Public/Common/Lib/assets/css/amazeui.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Common/Lib/amazeui-switch/amazeui.switch.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Common/Lib/amazeui-chosen/amazeui.chosen.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Common/Css/Common.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/<?php echo ($default_theme); ?>/Css/Common.css" />
	<?php if(!empty($module_css)): ?><link rel="stylesheet" type="text/css" href="/Public/<?php echo ($module_css); ?>" /><?php endif; ?>
</head>
<body>
<!-- header end -->

<!-- right content start  -->
<div class="content-right">
	<div class="content">
		<!-- form start -->
		<form class="am-form view-list" action="<?php echo U('Admin/Kehu/Index');?>" method="POST">
			
			<div class="am-g">
				<input type="text" class="am-radius form-keyword" placeholder="姓名/手机" name="keyword" />
				<button type="submit" class="am-btn am-btn-secondary am-btn-sm am-radius form-submit">查询</button>
				<label class="fs-12 m-l-5 c-p fw-100 more-submit">
					更多筛选					<input type="checkbox" name="is_more" value="1" id="is_more">
					<i class="am-icon-angle-down"></i>
				</label>

				<div class="more-where">
	
					<select name="gender" class="am-radius c-p m-t-10 m-l-5 param-where">
						<option value="-1">性别</option>
						<option value="0">保密</option><option value="1">女</option><option value="2">男</option>					</select>
					<div class="param-date param-where m-l-5">
						<input type="text" name="time_start" readonly="readonly" class="am-radius m-t-10" placeholder="出生开始" id="time_start">
						<span>~</span>
						<input type="text" readonly="readonly" class="am-radius m-t-10" placeholder="出生结束" name="time_end" id="time_end">
					</div>

					<input type="text" class="am-radius c-p m-t-10 m-l-5 param-where"  placeholder="年龄" name="age" >
					<!-- <select name="groupid" class="am-radius c-p m-t-10 m-l-5 param-where" >
						<option value="-1">客户状态</option>
						<option value="1">预约</option><option value="2">到访</option><option value="3">潜在</option>	
					</select> -->
				</div>



			</div>
        </form>
        <!-- form end -->

        <!-- operation start -->
        <div class="am-g m-t-15">
            <a href="<?php echo U('Admin/Kehu/SaveInfo');?>" class="am-btn am-btn-secondary am-radius am-btn-xs am-icon-plus"> <?php echo L('common_operation_add');?></a>
            <?php if(!IsMobile()): ?><a href="<?php echo ($excel_url); ?>" class="am-btn am-btn-success am-btn-xs m-l-10 am-icon-file-excel-o am-radius"> <?php echo L('common_operation_excel_export_name');?></a>
            	<a href="javascript:;" class="am-btn am-btn-primary am-btn-xs m-l-10 am-icon-cloud-upload am-radius" data-am-modal="{target: '#excel-import-win'}"> <?php echo L('common_operation_excel_import_name');?></a>
            	<!-- excel win html start -->
				<div class="am-popup am-radius" id="excel-import-win">
	<div class="am-popup-inner">
		<div class="am-popup-hd">
			<!-- <h4 class="am-popup-title"><?php echo L('common_operation_excel_import_name');?></h4> -->
			<span data-am-modal-close class="am-close">&times;</span>
		</div>
		<div class="am-popup-bd">
			<!-- win form start -->
			<form class="am-form form-validation excel-form" action="<?php echo ($excel_import_form_url); ?>" method="POST" request-type="ajax-fun" request-value="ExcelImportCallback" enctype="multipart/form-data">
				<input type="hidden" name="max_file_size" value="<?php echo MyC('home_max_limit_file', 51200000);?>" />
				<div class="am-alert am-radius am-alert-tips m-t-0" data-am-alert>
					<?php if(!empty($excel_import_format_url)): ?><p class="m-b-0"><a href="<?php echo ($excel_import_format_url); ?>" class="cr-blue"><?php echo L('common_excel_format_download_name');?></a><span class="m-r-5"></p><?php endif; ?>
					<?php if(!empty($excel_import_tips)): ?><p class="m-t-10"><?php echo ($excel_import_tips); ?></p><?php endif; ?>
					<p class="cr-red"><?php echo L('common_excel_import_tips');?></p>
				</div>
				<div class="am-form-group am-form-file">
					<button type="button" class="am-btn am-btn-default am-btn-sm am-radius"><i class="am-icon-cloud-upload"></i> <?php echo L('common_select_file_text');?></button>
					<input type="file" name="excel" multiple data-validation-message="<?php echo L('common_select_file_tips');?>" accept="application/vnd.ms-excel" required />
				</div>
				<div class="am-form-group">
					<button type="submit" class="am-btn am-btn-primary am-radius btn-loading-example am-btn-sm w100" data-am-loading="{loadingText:'<?php echo L('common_form_loading_tips');?>'}"><?php echo L('common_operation_confirm');?></button>
				</div>
			</form>
			<!-- win form end -->

			<!-- import tips start -->
			<div class="am-alert am-alert-success am-radius excel-import-success none"><?php echo L('common_import_success_name');?> <strong>0</strong> <?php echo L('common_unit_tiao_name');?></div>
			<div class="am-panel am-panel-danger am-radius excel-import-error none">
				<div class="am-panel-hd p-l-10"><?php echo L('common_import_error_name');?> <strong>0</strong>  <?php echo L('common_unit_tiao_name');?></div>
				<table class="am-table"><tbody></tbody></table>
			</div>
			<!-- import tips end -->
		</div>
	</div>
</div>
				<!-- excel win html end --><?php endif; ?>
        </div>
        <!-- operation end -->

		<!-- list start -->
		<table class="am-table am-table-striped am-table-hover am-text-middle m-t-10 m-l-5">
			<thead>
				<tr>
					<th>编号</th>
					<th>日期</th>
					<?php if($_SESSION['admin']['id'] == 1): ?><th>分校</th><?php endif; ?>

				<th>姓名</th>


					<th class="am-hide-sm-only">年龄</th>
					<th>性别</th>
					<th class="am-hide-sm-only">联系人</th>
					<th class="am-hide-sm-only">电话</th>
					<th class="am-hide-sm-only">咨询课程</th>
					<th>跟踪</th>
					
					<th>状态</th>	
					
					

					<th><?php echo L('common_operation_name');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($list)): if(is_array($list)): foreach($list as $key=>$v): ?><tr id="data-list-<?php echo ($v["id"]); ?>-<?php echo ($v["id_card"]); ?>">
							<td><?php echo ($v["id"]); ?></td>
							<?php if($v['groupid'] == 1): ?><td><?php echo ($v["yuyue_time"]); ?></td>
							<?php elseif($v['groupid'] == 2): ?>
								<td><?php echo ($v["daofang_time"]); ?></td>
							<?php else: ?>
								<td><?php echo ($v["updatetime"]); ?></td><?php endif; ?>
							
							<?php if($_SESSION['admin']['id'] == 1): ?><td><?php echo ($v["xqname"]); ?></td><?php endif; ?>
							<td class="am-hide-sm-only"><?php echo ($v["username"]); ?></td>
							<td><?php echo ($v["age"]); ?>岁</td>
							<td class="am-hide-sm-only"><?php echo ($v["sex"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["lxr_1"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["lxrtel_1"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["zx_kc"]); ?></td>
		
							
							<td class="am-hide-sm-only"><button class="am-btn am-btn-default am-btn-xs am-radius" onclick="xinzeng_genjin(<?php echo ($v["id"]); ?>)">增加</button> | <button class="am-btn am-btn-default am-btn-xs am-radius" onclick="chakan_genjin(<?php echo ($v["id"]); ?>)">查看</button>
								
							</td>
							
							<td class="am-hide-sm-only">
							<?php if($v['groupid'] <= 3): ?><input type="radio" value="1"  <?php if($v['groupid'] == 1): ?>checked="checked"<?php endif; ?>onclick="gaibian(<?php echo ($v["id"]); ?>,1)">预约
							<input type="radio" value="3" <?php if($v['groupid'] == 3): ?>checked="checked"<?php endif; ?> onclick="gaibian(<?php echo ($v["id"]); ?>,2)">到访
							<input type="radio" value="2"  <?php if($v['groupid'] == 2): ?>checked="checked"<?php endif; ?> onclick="gaibian(<?php echo ($v["id"]); ?>,3)">潜在
							<?php else: ?>
							<?php echo C('kehu_group')[$v['groupid']]; endif; ?>
							</td>
							

							<td class="view-operation">
								<?php if($v['groupid'] == 3): ?><a href="<?php echo U('Admin/Caiwu/SaveInfo', array('id'=>$v['id']));?>">
									<button class="am-btn am-btn-default am-btn-xs am-radius am-icon-line-chart" data-am-popover="{content: '生成财务', trigger: 'hover focus'}"></button>
								</a><?php endif; ?>
								<a href="<?php echo U('Admin/Kehu/SaveInfo', array('id'=>$v['id'],'groupid'=>$groupid));?>">
									<button class="am-btn am-btn-default am-btn-xs am-radius am-icon-edit" data-am-popover="{content: '<?php echo L('common_operation_edit');?>', trigger: 'hover focus'}"></button>
								</a>
								<button class="am-btn am-btn-default am-btn-xs am-radius am-icon-trash-o submit-delete" data-url="<?php echo U('Admin/Kehu/Delete');?>" data-am-popover="{content: '<?php echo L('common_operation_delete');?>', trigger: 'hover focus'}" data-id="<?php echo ($v["id"]); ?>"></button>
							</td>
						</tr><?php endforeach; endif; ?>
				<?php else: ?>
					<tr><td colspan="10" class="table-no"><?php echo L('common_not_data_tips');?></td></tr><?php endif; ?>
			</tbody>
		</table>
		<!-- list end -->

		<!-- page start -->
		<?php if(!empty($list)): echo ($page_html); endif; ?>
		<!-- page end -->
	</div>
</div>
<!-- right content end  -->
		
<!-- footer start -->
<!-- commom html start -->
<!-- delete html start -->
<div class="am-modal am-modal-confirm" tabindex="-1" id="common-confirm-delete">
	<div class="am-modal-dialog am-radius">
		<div class="am-modal-bd"><?php echo L('common_delete_tips');?></div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel><?php echo L('common_operation_cancel');?></span>
			<span class="am-modal-btn" data-am-modal-confirm><?php echo L('common_operation_confirm');?></span>
		</div>
	</div>
</div>
<!-- delete html end -->

<!-- delete html start -->
<div class="am-modal am-modal-confirm" tabindex="-1" id="common-confirm-qiandao">
	<div class="am-modal-dialog am-radius">
		<div class="am-modal-bd">确定为该学生签到吗？</div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel><?php echo L('common_operation_cancel');?></span>
			<span class="am-modal-btn" data-am-modal-confirm><?php echo L('common_operation_confirm');?></span>
		</div>
	</div>
</div>
<!-- delete html end -->

<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
		<div class="am-modal-dialog">
		  <div class="am-modal-hd">生日提醒
			<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
		  </div>
		  <div class="am-modal-bd">
			<table class="am-table am-table-striped am-table-compact am-table-hover xs_shengri" >
					<thead>
							<tr>
								<th colspan="3">一周内学生生日提醒</th>
								
							</tr>
							<!-- <tr>
									<th >姓名</th>
									<th >日期</th>
									<th >星期</th>
									
								</tr> -->
					</thead>
					<tbody>
							<?php if(!empty($xs_shengri)): if(is_array($xs_shengri)): foreach($xs_shengri as $key=>$v): ?><tr>
													<!-- <td ><a href="javascript:;" data-type="nav" data-url="<?php echo U('Admin/Xuesheng/saveinfo',array('id'=>$v['id']));?>"><?php echo ($v["username"]); ?></a></td> -->
													<td ><a href="javascript:;" ><?php echo ($v["username"]); ?></a></td>
													<td><?php echo ($v["riqi"]); ?></td>
													<td>星期<?php echo ($v["xingqi"]); ?></td>
												</tr><?php endforeach; endif; ?>
									<?php else: ?>
									
									<tr><td>无</td></tr><?php endif; ?>
						</tbody>
			</table>
		  </div>
		</div>
	  </div>
<!-- commom html end -->
</body>
</html>

<!-- 类库 -->
<script type="text/javascript" src="/Public/Common/Lib/jquery/jquery-2.1.0.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/assets/js/amazeui.min.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/echarts/echarts.min.js"></script>

<!-- ueditor 编辑器 -->
<script type="text/javascript" src="/Public/Common/Lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/ueditor/lang/zh-cn/zh-cn.js"></script>

<!-- 颜色选择器 -->
<script type="text/javascript" src="/Public/Common/Lib/colorpicker/jquery.colorpicker.js"></script>

<!-- 元素拖拽排序插件 -->
<script type="text/javascript" src="/Public/Common/Lib/dragsort/jquery.dragsort-0.5.2.min.js"></script>

<!-- amazeui插件 -->
<script type="text/javascript" src="/Public/Common/Lib/amazeui-switch/amazeui.switch.min.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/amazeui-chosen/amazeui.chosen.min.js"></script>

<!-- 项目公共 -->
<script type="text/javascript" src="/Public/Common/Js/Common.js"></script>
<script type="text/javascript" src="/Public/Admin/<?php echo ($default_theme); ?>/Js/layer/layer.js"></script>

<!-- 控制器 -->
<?php if(!empty($module_js)): ?><script type="text/javascript" src="/Public/<?php echo ($module_js); ?>"></script><?php endif; ?>

<script>
	setInterval(function() {
    var now = (new Date()).toLocaleString();
    $('#current-time').text(now);
}, 1000);
    $('#doc-modal-1').on('close.modal.amui', function(){
        var url = "<?php echo U('Admin/Admin/update_tixiang');?>";
        console.log(url);
       $.get(url);
        
      });
    
//   $("#yizhiwei_01").trigger('click');    
</script>
<?php if($is_tx): ?><script>
      $("#yizhiwei_01").trigger('click');  
</script><?php endif; ?>
<!-- footer end -->

<?php if(!IsMobile()): ?><!-- excel win js start -->
	<script>
/**
 * [ExcelImportCallback excel导入回调（公共表单方法校验需要放在这里，不能校验其它文件的方法）]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-02-11T21:46:50+0800
 * @param    {[object]}    data [回调数据]
 */
function ExcelImportCallback(data)
{
	if(data.code == 0)
	{
		// 成功
		if(data.data.success > 0)
		{
			$('.excel-import-success').removeClass('none');
			$('.excel-import-success').find('strong').text(data.data.success);
		} else {
			$('.excel-import-success').addClass('none');
		}

		// 失败
		if(data.data.error.length == 0)
		{
			$('.excel-import-error').addClass('none');
		} else {
			$('.excel-import-error').removeClass('none');
			$('.excel-import-error').find('strong').text(data.data.error.length);
			var html = '';
			for(var i in data.data.error)
			{
				html += '<tr><td>'+data.data.error[i]+'</td></tr>';
			}
			$('.excel-import-error').find('table tbody').html(html);
		}
	} else {
		Prompt(data.msg);
	}
	$.AMUI.progress.done();
	$('.form-validation').find('button[type="submit"]').button('reset');
}
</script>
	<!-- excel win js end --><?php endif; ?>

<script>


 function xinzeng_genjin(khid){
		var khid = khid;

		
		var url = "/admin.php?m=Admin&c=Kehu&a=xinzeng_genjin";
		

		if(typeof(khid)=="undefined"){
			layer.msg('参数错误,请刷新页面重试');
				// window.location.reload();
				return false;
		}

		layer.prompt(
			{title: '新增跟进记录', formType: 2},
			 function(content){
				$.ajax({
					url:url,
					type:"POST",
					async:false,
					data:{khid:khid,content:content},
					dataType:'json',
					success:function(meg){
						if(meg.code == 0){
							layer.msg('添加成功');
							
						}else{
							layer.msg('失败，请重试');
						}
						

					}
				});	

			layer.closeAll();
			
		});

	}

	function chakan_genjin(khid){

		var khid = khid;

		var url = "/admin.php?m=Admin&c=Kehu&a=chakan_genjin";

		if(typeof(khid)=="undefined"){
			layer.msg('参数错误,请刷新页面重试');
				// window.location.reload();
				return false;
		}
		$.ajax({
			url:url,
			type:"POST",
			async:false,
			data:{khid_id:khid},
			dataType:'json',
			success:function(meg){
					layer.open({
						type: 1,
						title:'跟进记录',
						skin: 'layui-layer-rim', //加上边框
						area: ['600px', 'auto'], //宽高
						content: meg
					});
			}
		});	

		
	}

	 function gaibian(id, zt){
		var id = id;
		var zt = zt;


		
		var url = "/admin.php?m=Admin&c=Kehu&a=gaibian";

				$.ajax({
					url:url,
					type:"POST",
					async:false,
					data:{id:id,zt:zt},
					dataType:'json',
					success:function(msg){
		
							layer.msg(msg.msg)
						location.reload();
					}
				});	





	}






</script>