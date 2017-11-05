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
		<form class="am-form view-list" action="<?php echo U('Admin/Caiwu/Index');?>" method="POST">
			<div class="am-g">
				<input type="text" class="am-radius form-keyword" placeholder="姓名" name="keyword" <?php if(isset($param['keyword'])): ?>value="<?php echo ($param["keyword"]); ?>"<?php endif; ?> />
				<button type="submit" class="am-btn am-btn-secondary am-btn-sm am-radius form-submit"><?php echo L('common_operation_query');?></button>
				<label class="fs-12 m-l-5 c-p fw-100 more-submit">
					<?php echo L('common_more_screening');?>
					<input type="checkbox" name="is_more" value="1" id="is_more" <?php if(isset($param['is_more']) and $param['is_more'] == 1): ?>checked<?php endif; ?> />
					<i class="am-icon-angle-down"></i>
				</label>

				<div class="more-where <?php if(!isset($param['is_more']) or $param['is_more'] != 1): ?>none<?php endif; ?>">
					
					<select  class="am-radius c-p m-t-10" name="pay_status">
						<option value="-1">付费状态</option>
						<?php if(is_array($pay_status_arr)): foreach($pay_status_arr as $key=>$v): ?><option value="<?php echo ($key); ?>" <?php if(isset($param['pay_status']) and $param['pay_status'] == $ey): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; ?>
					</select>
					<select  class="am-radius c-p m-t-10" name="kecheng">
						<option value="0"><?php echo L('fraction_subject_text');?></option>
						<?php if(is_array($subject_list)): foreach($subject_list as $key=>$v): ?><option value="<?php echo ($v["name"]); ?>" <?php if(isset($param['kecheng']) and $param['kecheng'] == $v['name']): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
					</select>
					<select name="ht_status" class="am-radius c-p m-t-10">
						<option value="-1">合同状态</option>
						<?php if(is_array($ht_status_arr)): foreach($ht_status_arr as $key=>$v): ?><option value="<?php echo ($key); ?>" <?php if(isset($param['ht_status']) and $param['ht_status'] == $key): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; ?>
					</select>
					<div class="param-date param-where m-l-5">
						<input type="text" name="time_start" readonly="readonly" class="am-radius m-t-10" placeholder="合同开始" id="time_start">
						<span>~</span>
						<input type="text" readonly="readonly" class="am-radius m-t-10" placeholder="合同结束" name="time_end" id="time_end">
					</div>
				</div>
			</div>
		</form>
		<!-- form end -->

		<!-- operation start -->
		<?php if(!IsMobile()): ?><div class="am-g m-t-15">
	            <a href="<?php echo ($excel_url); ?>" class="am-btn am-btn-success am-btn-xs am-icon-file-excel-o am-radius"> <?php echo L('common_operation_excel_export_name');?></a>
	            <!-- <a href="javascript:;" class="am-btn am-btn-primary am-btn-xs m-l-10 am-icon-cloud-upload am-radius" data-am-modal="{target: '#excel-import-win'}"> <?php echo L('common_operation_excel_import_name');?></a> -->
            	<!-- excel win html start -->
				
				<!-- excel win html end -->
	        </div><?php endif; ?>
        <!-- operation end -->

		<!-- list start -->
		<table class="am-table am-table-striped am-table-hover am-text-middle m-t-20">
			<thead>
				<tr>
					<th>合同编号</th>
					<th><?php echo L('fraction_username_text');?></th>
					<th class="am-hide-sm-only">课程</th>
					<th class="am-hide-sm-only">应付金额</th>
					<th class="am-hide-sm-only">已付金额</th>
					<th class="am-hide-sm-only">剩付金额</th>
					<th class="am-hide-sm-only">合同状态</th>
					<th>课时</th>
					<th>合同结束日期</th>
					<th>更新时间</th>
					<th><?php echo L('common_operation_name');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($list)): if(is_array($list)): foreach($list as $key=>$v): ?><tr id="data-list-<?php echo ($v["id"]); ?>-<?php echo ($v["student_id"]); ?>">
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["username"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["kecheng"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["price"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["yj_price"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["sy_price"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["ht_status"]); ?></td>
							<td class="am-hide-sm-only"><?php echo ($v["kc_sc"]); ?></td>
							<td><?php echo ($v["ht_end"]); ?></td>
							<td><?php echo ($v["updatetime"]); ?></td>
							
							<td>
								<a href="<?php echo U('Admin/Xuesheng/SaveInfo', array('kh_id'=>$v['kh_id']));?>">
									<button class="am-btn am-btn-default am-btn-xs am-radius am-icon-mortar-board" data-am-popover="{content: '生成学生资料', trigger: 'hover focus'}"></button>
								</a>
								<a href="<?php echo U('Admin/Caiwu/SaveInfo', array('id'=>$v['kh_id']));?>">
									<button class="am-btn am-btn-default am-btn-xs am-radius am-icon-edit" data-am-popover="{content: '<?php echo L('common_operation_edit');?>', trigger: 'hover focus'}"></button>
								</a>
								<button class="am-btn am-btn-default am-btn-xs am-radius am-icon-trash-o submit-delete" data-url="<?php echo U('Admin/Caiwu/Delete');?>" data-am-popover="{content: '<?php echo L('common_operation_delete');?>', trigger: 'hover focus'}" data-id="<?php echo ($v["id"]); ?>"></button>
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
								<th>一周内学生生日提醒</th>
								
							</tr>
					</thead>
					<tbody>
							<?php if(!empty($xs_shengri)): if(is_array($xs_shengri)): foreach($xs_shengri as $key=>$v): ?><tr>
													<!-- <td ><a href="javascript:;" data-type="nav" data-url="<?php echo U('Admin/Xuesheng/saveinfo',array('id'=>$v['id']));?>"><?php echo ($v["username"]); ?></a></td> -->
													<td ><a href="javascript:;" ><?php echo ($v["username"]); ?></a></td>
													<td><?php echo ($v["riqi"]); ?></td>
													<td>星期<?php echo ($v["xingqi"]); ?></td>
												</tr><?php endforeach; endif; endif; ?>


						
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