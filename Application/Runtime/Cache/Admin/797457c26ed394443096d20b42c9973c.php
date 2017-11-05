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
		<p class="fw-700 list-title">管理中心</p>
		<hr>
		<div class="am-g">
			<div class="am-u-sm-4">
					<div class="am-panel am-panel-primary">
							<div class="am-panel-hd">预约提醒</div>
							<div class="am-panel-bd">
									<div class="am-scrollable-vertical ">
											<table class="am-table am-table-striped am-table-hover">
													<thead>
														<tr>
															<td>姓名</td>
															<td>联系人</td>
															<td>电话</td>
														</tr>
													</thead>
													<tbody>
														<?php if(!empty($yy_tixiang)): if(is_array($yy_tixiang)): foreach($yy_tixiang as $key=>$vo): ?><tr>
															<td><a href="###"><?php echo ($vo["username"]); ?></a></td> 
															<td><?php echo ($vo["lxr_1"]); ?></td> 
															<td><?php echo ($vo["lxrtel_1"]); ?></td>
														</tr><?php endforeach; endif; ?>
														<?php else: ?>
														
														<tr><td colspan="3">无</td></tr><?php endif; ?>
													</tbody>
											</table>
									</div>
							</div>
						  </div>
					
			</div>
			<div class="am-u-sm-4">
					<div class="am-panel am-panel-secondary">
							<div class="am-panel-hd">签到提醒</div>
							<div class="am-panel-bd">
									<div class="am-scrollable-vertical ">
										<div class=" am-u-sm-6">
												<table class="am-table am-table-striped  am-table-hover " >
														<thead>
															<tr>
																<td>已签到</td>
															</tr>
														</thead>
														<tbody>
															<?php if(is_array($yqd_xs)): foreach($yqd_xs as $key=>$vo): ?><tr class="am-primary">
																<td><?php echo ($vo["username"]); ?></td> 
															</tr><?php endforeach; endif; ?>
	
														</tbody>
												</table>
										</div>
											<div class=" am-u-sm-6">
													<table class="am-table am-table-striped am-table-hover">
															<thead>
																<tr>
																	<td>未签到</td>
																</tr>
															</thead>
															<tbody>
																<?php if(is_array($wqd_xs)): foreach($wqd_xs as $key=>$vo): ?><tr class="am-danger">
																	<td><?php echo ($vo["username"]); ?></td> 
																</tr><?php endforeach; endif; ?>
															</tbody>
													</table>
											</div>
											
									</div>
							</div>
						  </div>
					
			</div>
			<div class="am-u-sm-4">
					<div class="am-panel am-panel-success">
							<div class="am-panel-hd">生日提醒</div>
							<div class="am-panel-bd">
									<div class="am-scrollable-vertical ">
											<table class="am-table am-table-striped am-table-hover">
													<thead>
															<tr>
																<th colspan="3">一周内学生生日提醒</th>
																
															</tr>

													</thead>
													<tbody>
															<?php if(!empty($xs_shengri)): if(is_array($xs_shengri)): foreach($xs_shengri as $key=>$v): ?><tr>
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
					
			</div>
			
		  </div>
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