<?php
namespace app\admin\service;
use app\admin\model\User;
use think\Db;
class TreeService{

	// 获取下线会员
	public function get_referral_member($pid){
		return User::where('re_id', $pid)->select();
	}
}