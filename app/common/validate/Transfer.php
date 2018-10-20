<?php
namespace app\common\validate;
use think\Db;
class Transfer extends ValidateBase
{

////用     // onebase用
//        $message=validate('Transfer')->charge_member($params);
//       if(!is_bool($message)) return [RESULT_ERROR, $message];

// //验证类开始  
//   $message=validate('Transfer')->charge_member($params);
//   if(!is_bool($message))  return  $this->error($message);
//  //验证类结束






     // 验证规则
    protected $rule =   [
        //注册
        'username'  => 'require|unique:member',
        'password'  => 'require|confirm|length:6,20',
        'password2' => 'require|confirm|length:6,20',
        //'email'   => 'require|email|unique:member',
        'nickname'  => 'require',
        //'mobile'  => 'unique:member',
         'agent_uid'=> 'require|agent_uid',
         're_uid'   => 'require|re_uid',
        'father_uid'=> 'require|father_uid',
         'verify'   => 'require|captcha',
    ];
    
    protected $message = [
        'to_user_id.require' => '对方账号不能为空！',
        'number.require'       => '数量不能为空！',
        'number.gt'           => '金额必须大于0！',
        'username.require'    => '用户名不能为空',
        'username.unique'     => '用户名已存在',
        'nickname.require'    => '昵称不能为空',
        'password.require'    => '密码不能为空',
        'password.confirm'    => '两次密码不一致',
        'password.length'     => '密码长度为6-20字符',
        'password2.require'   => '安全密码不能为空',
        'password2.confirm'   => '两次安全密码不一致',
        'password2.length'    => '安全密码长度为6-20字符',
        'agent_uid.require'   =>  '报单中心不能为空',
        'father_uid.require'  =>  '接点人不能为空',
        're_uid.require'      =>  '推荐人不能为空',
        'email.require'       => '邮箱不能为空',
        'email.email'         => '邮箱格式不正确',
        'email.unique'        => '邮箱已存在',
        'mobile.unique'       => '手机号已存在'

    ];

    // 应用场景
    protected $scene = [
       //注册
       'add'   =>  ['username','password','password2','agent_uid','re_uid','father_uid','verify'],
    ];



  public function transfer($params = []){
          $user=user();
        $to_user_id=M('member')->where('username="'. $params['to_user_id'].'"')->find();
		  $message = [
		        $params['number']>$user['b0'] 
		                                               => '金额不足',
		        !$params['type']                 
		                                              =>'请选择类型',
				    empty($params['number'])||!is_numeric($params['number'])
				                                          =>'输入不能为空!',
		        $params['number'] <= 0           
		                                              =>'输入的数字有误!',
		        is_float($params['number']/100) 
		                                               =>'需要是100的倍数!',
		        $params['to_user_id']== $user['user_id']
		                                               =>'不能转给自己!',
		        empty($params['password2'])
		                                               =>'请输入安全密码',
		        $params['password2']!=$user['password2']
		                                               =>'安全密码不正确',
		        !$to_user_id   
		                                              => '会员账号不存在', 
		    ];
		    return !$message[1] ? true : $message[1];
    }




public function charge_member($params = []){
        $user=user();
        $where['uid'] = $user['id'];
        $where['action_type'] =50;
        $where['status']=0;
        $vo3 = M('history')->where($where)->find();
        $message = [
		        $params['number']>$user['b0'] 
		                                               => '金额不足',
		        !$params['type']                 
		                                              =>'请选择类型',
				empty($params['number'])||!is_numeric($params['number'])
				                                          =>'输入不能为空!',
		        $params['number'] <= 0           
		                                              =>'输入的数字有误!',
		        is_float($params['number']/100) 
		                                               =>'需要是100的倍数!',
		        $vo3
		                                               =>'上次充值还没通过审核!',
		      
		        strlen($params['number'])>9   
		                                               => '充入太大!' ,

                !$params['img_ids']
                                                      =>'请上传凭证',   
		    ];
       return !$message[1] ? true : $message[1];
}






public function withdrawadd($params = []){
	        $user=user();
	        $where['uid'] = $user['id'];
	        $where['status']=0;
	        $vo3 = M('draw')->where($where)->find();
	        $match = '/^[1-9]*[1-9][0-9]*$/';
        
		 $message = [
		        $params['num']>$user['b0'] 
		                                               => '金额不足',
		        !$params['type']                 
		                                              =>'请选择类型',
				    empty($params['num'])||!is_numeric($params['num'])
				                                          =>'输入不能为空!',
		        $params['num'] <= 0           
		                                              =>'输入的数字有误!',
		        is_float($params['num']/100) 
		                                               =>'需要是100的倍数!',
		        $vo3
		                                               =>'上次充值还没通过审核!',
		        empty($params['password2'])
		                                               =>'请输入安全密码',
		        $params['password2']!=$user['password2']
		                                               =>'安全密码不正确',
		        strlen($params['num'])>9   
		                                               => '提现太大!' ,
                !$user['card']   
		                                               =>
		                                                '请实名，我的资料里补全信息!',
		       !preg_match($match, $params['num'])  
		                                               =>
		                                                '请输入正确的提现数', 
		       empty($params['zhi'])  
		                                               =>
		                                                '请输入银行卡号',
              empty($params['bank_name'])  
                                                           =>
                                                        '请选择提现类型',
		       empty($params['zname'])  
		                                               =>
		                                                '请输入开户人姓名',                 
				];
         return !$message[1] ? true : $message[1];
}




 protected function re_uid($value, $rule, $data = []){
    $re_uid=M('member')->where('user_id="'.$data['re_uid'].'"')->find();
  
   $message = [
		        $re_uid['is_pay']<=0 
		                                               =>'推荐人不存在或未激活',
		       strlen($data['consignee_name'])<1             
		                                              =>'请输入收货人姓名',
			    strlen($data['mobile'])<11
				                                      =>'请输入收货人手机号',
		      strlen($data['province'])<1          
		                                              =>'请选择省份',
		      strlen($data['city'])<1 
		                                               =>'请选择城市',
		      strlen($data['county'])<1
		                                               =>'请选择区域',
		      strlen($data['address'])<1
		                                               =>'请输入详细地址',
		    
		    ];
       return !$message[1] ? true : $message[1];
    }





protected function agent_uid($value, $rule, $data = []){
    $agent_uid=M('member')->where('user_id="'.$data['agent_uid'].'"')->find();
        if($agent_uid['is_pay']<=0){
          return '报单中心不存在或未激活';
        }
        if($agent_uid['is_agent']<=1){
          return '不是报单中心';
        }
       return true;
    }

protected function father_uid($value, $rule, $data = []){
    $father_uid=M('member')->where('father_uid="'.$data['father_uid'].'" and treeplace='.$data['TPL'])->find();
     $father_id=M('member')->where('user_id="'.$data['father_uid'].'"')->find();
     //var_dump($father_id);
        if($father_uid){
          return '该区已有会员';
        }
        if($father_id['is_pay']<=0){
          return '接点人不存在或未激活';
        }
       return true;
    }


// foreach ($message as $key=>$value) {
		    //          if($key){ return $value;  }
		    //        }s


}