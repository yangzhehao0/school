<?php

/**
 * 模块方法
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */

/**
 * [PowerCacheDelete 后台管理员权限缓存数据清除]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-02-26T23:45:26+0800
 */
function PowerCacheDelete()
{
	$admin = M('Admin')->getField('id', true);
	if(!empty($admin))
	{
		foreach($admin as $id)
		{
			S(C('cache_admin_power_key').$id, null);
			S(C('cache_admin_left_menu_key').$id, null);
		}
	}
}
// function calcAge($birthday) {  
//     $iage = 0;  
//     if (!empty($birthday)) {  
//         $year = date('Y',strtotime($birthday));  
//         $month = date('m',strtotime($birthday));  
//         $day = date('d',strtotime($birthday));  
            
//         $now_year = date('Y');  
//         $now_month = date('m');  
//         $now_day = date('d');  

//         if ($now_year > $year) {  
//             $iage = $now_year - $year - 1;  
//             if ($now_month > $month) {  
//                 $iage++;  
//             } else if ($now_month == $month) {  
//                 if ($now_day >= $day) {  
//                     $iage++;  
//                 }  
//             }  
//         }  
//     }  
//     return $iage;  
// }  
function get_role_name($id){
    return M('Role')->where(array('id'=>$id))->getField('name');
}
?>