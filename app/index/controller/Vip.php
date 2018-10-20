<?php
// +---------------------------------------------------------------------+
// | OneBase    | [ WE CAN DO IT JUST THINK ]                            |
// +---------------------------------------------------------------------+
// | Licensed   | http://www.apache.org/licenses/LICENSE-2.0 )           |
// +---------------------------------------------------------------------+
// | Author     | Bigotry <3162875@qq.com>                               |
// +---------------------------------------------------------------------+
// | Repository | https://gitee.com/Bigotry/OneBase                      |
// +---------------------------------------------------------------------+

namespace app\index\controller;
use app\common\model\ShopCategory;
use app\admin\logic\Member;

/**
 * 前端首页控制器
 */
class Vip extends IndexBase
{
   


private function _messagesAdd($UserID='0',$Title='',$Msg=''){


        $member = M ('member');
        $Users = M ('Msg');
        $where = array();
        $ID =$this->user['id'];
        $Msg='6666';
        $Title='333'
        $UserID='100000';

        //收件人
        $where1 = array();
        $where1['user_id'] = $UserID;
        // if($UserID == '公司'){
        //  $gsrs = M('member')->where('id=1')->field('user_id')->find();
        //  $where1['user_id'] = $gsrs['user_id'];
        // }
        

        // $vo = $member->where($where1)->find();
        // if (!$vo){
        //     $this->error('收件人不存在！');
        //     exit;
        // }
        // if($ID>1){
        //  if($ID == $vo['id']){
        //      $this->error('不能给自已发邮件！');
        //      exit;
        //  }
        // }

        
        // //发件人
        // $where['id'] = $ID;
        // $vo2 = $member->where($where)->find();
        // if (!$vo2){
        //     $this->error('没有该记录!');
        //     exit;
        // }

        // if ( $vo2['user_id'] == $UserID ){
        //  $this->error("不能给自已发邮件！");
        //  exit;
        // }

        //开始事务处理
        $Users->startTrans();
        $nowdate = strtotime(date('c'));
        

        $vo=$this->user;
        $vo2=$this->user;
        //留言表
        $data = array();
        $data['f_uid']      = $vo2['id'];
        $data['f_user_id']  = $vo2['user_id'];
        $data['s_uid']      = $vo['id'];
        $data['s_user_id']  = $vo['user_id'];
        $data['title']      = $Title;
        $data['content']    = $Msg;
        $data['f_time']     = time();
        $rs1 = $Users->add($data);
        unset($data);
        if ($rs1){
            //提交事务
            $Users->commit();
            $this->success('留言成功！');
            exit;
        }else{
            //事务回滚：
            $Users->rollback();
            $this->error('操作失败');
            exit;
        }
    }





















































































    // 首页
    public function vip()
    {
      
      !session('member_info') && $this->redirect('admin/login/login');
       $today = strtotime(date("Y-m-d"),time());
       $ads=M('shop')->where('id=54')->find();
        $today_end = strtotime(date("Y-m-d"),time())+3600*24;
        $where['uid']=$this->user['id'];



        //总收益统计
        $where['action_type']=['in','1,2'];
        $count_all=M('history')->where($where)->sum('epoints');



        //静态收益统计
        $where['action_type']=['in','1'];
        $count_all_s=M('history')->where($where)->sum('epoints');

        //动态收益统计
        $where['action_type']=['in','2'];
        $count_all_d=M('history')->where($where)->sum('epoints');


        M('member')->where('id='.$this->user['id'])->setField('b6',$count_all);

        
   
        

        $where['pdt']=array('between',array($today,$today_end));
        $count=M('history')->where($where)->sum('epoints');
        $data=$this->user;


         //出局数目
         $data['remainder_ad']=floor($count_all_d/$this->feeratio['dynamic_out'][0])+floor($count_all_s/$this->feeratio['statistic_out'][0]);

   
         M('member')->where('id='.$this->user['id'])->setField('remainder_ad',$data['remainder_ad']);

        $data['today']=$count;
        $data['all_income']= $count_all;
        $this->assign('data',$data);
         return $this->fetch('index');
    }
    








 public function agent()
    {
      if(!$this->user['card']){
        return $this->error('请填写身份证','index/user/my_data');
      }
    $agent_a= M('member')->where('agent=4 and card_d="'.$this->user['card_d'].'"')->find();
    if($agent_a){  
    M('member')->where('id='.$this->user['id'])->setField('agent',3);
    $this->error('此区已有代理');
    }
     if(!$this->user['card_d']){  
            $this->error('身份证地址有误');   
    }

    M('member')->where('id='.$this->user['id'])->setField('agent',2);
    return $this->success('申请成功');
    }

public function red_packet(){
     
       $today=strtotime(date("Y-m-d"),time());

       $member= M('member');
       $id=session('member_info')['id'];
      if( $this->request->param()){
        if($this->user['red_packet_time']>=($today-3600*24)&&$this->user['red_packet']>0){
      $member->where('id='.$id)->setField('red_packet_time', $today);

      for($i=0;$i<=3;$i++){
      $member->where('id='.$id)->setInc('b'.$i,$this->user['c'.$i]);
      $member->where('id='.$id)->setDec('c'.$i,$this->user['c'.$i]);
    }
      $member->where('id='.$id)->setInc('b6',$this->user['red_packet']);
      $member->where('id='.$id)->setField('red_packet',0);
      $this->success('领取'.$this->user['red_packet'].'元成功');
  
        }elseif($this->user['red_packet_time']<($today-3600*24)&&$this->user['red_packet_time']>0){
       $member->where('id=1')->setInc('b0',$this->user['red_packet']);
       $member->where('id='.$id)->setField('red_packet',0);
            $this->error('点不开了');
        }elseif($this->user['red_packet_time']==0&&$this->user['red_packet']>0){
        $member->where('id='.$id)->setField('red_packet_time', $today);
       for($i=0;$i<=3;$i++){
            $member->where('id='.$id)->setInc('b'.$i,$this->user['c'.$i]);
            $member->where('id='.$id)->setDec('c'.$i,$this->user['c'.$i]);
          }


        $member->where('id='.$id)->setInc('b6',$this->user['red_packet']);
        $member->where('id='.$id)->setField('red_packet',0);

         $this->success('领取'.$this->user['red_packet'].'元成功');
        }
        if($this->user['red_packet']==0){
         $this->error('再点也不会有钱的!');
        }

     }
}

public function charge_member(){
        $member=new  Member;
    
        $params = $this->request->param();
         if(!$params['page']&&$params){


       //验证类开始  
        $message=validate('Transfer')->charge_member($params);
        if(!is_bool($message))  return  $this->error($message);
       //验证类结束

        $params['type']=$params['type']-1;
        $bnum=50+$params['type'];//记录

        $data['img_ids']=$params['img_ids'];
        $member->addencAdd($this->user,$params['number'],$bnum,$this->user,$data);



        $this->success('充值申请成功！');
         }
        $this->assign('user',$this->user);

         $where['uid']=['=',$this->user['id']];
         $where['action_type']=['=',50];
         $where['epoints']=['>=',0];
         $list=$this->logicshop->history($where,5);


         $this->assign('type_arr',$this->feeratio['type_name']); 
         $this->assign('weixin',config('weixin'));
         $this->assign('alipay',config('alipay'));
         $this->assign('list',$list);
         return $this->fetch();   
    }



   public function transfer(){
        $member=new  Member;
        $validate = validate('Transfer');;
        $params = $this->request->param();
         if(!$params['page']&&$params){
       //用     
         //验证类开始  
        $message=validate('Transfer')->transfer($params);
        if(!is_bool($message))  return  $this->error($message);
       //验证类结束

        $to_user =M('member')->where('username="'.$params['to_user_id'].'"')->find();
       // var_dump( $to_user);
        $bnum=29+$params['type'];//转账记录
        $member->rw_bonus_dec($this->user,$bnum,$params['number'],$to_user);

        $member->rw_bonus_inc($to_user,$bnum,$params['number'],$this->user);
        $this->success('成功！');
         }
        $this->assign('user',$this->user);
        $where['uid']=['=',$this->user['id']];
         $where['action_type']=['=',30];
         $where['epoints']=['<',0];
         $list=$this->logicshop->history($where,5);
         $this->assign('type_arr',$this->feeratio['type_name']); 
         $this->assign('list',$list);



         return $this->fetch();   
    }





 public function money_flow()
    {
         $params=$this->request->param();
           $sDate  = $params['S_Date'];
           $eDate  = $params['E_Date'];
           $UserID = $params['UserID'];
           $ss_type =$params['tp'];
           $s_Date = 0;
           $e_Date = 0;
            if(!empty($sDate)){
                $s_Date = strtotime($sDate);
            }else{
                $sDate = "2000-01-01";
            }
            if(!empty($eDate)){
                $e_Date = strtotime($eDate);
            }else{
                $eDate = date("Y-m-d");
            }
            if($s_Date>$e_Date&&$e_Date>0){
                $temp_d = $s_Date;
                $s_Date = $e_Date;
                $e_Date = $temp_d;
            }

            
           $list=$this->logicshop->history($params);
            foreach ($list as $key => $value) {
                if(!empty($value['action_type'])){
                    $list[$key]['bzxx']=$this->feeratio['type_name'][$value['action_type']];
                }else{
                    $list[$key]['bzxx']='其他';
                }
             }
            $this->assign('list',$list);
            $head=M('member')->where('id=1')->find();
            $this->assign('fck_rs',$head);
            $this->assign('S_Date',$sDate);
            $this->assign('E_Date',$eDate);
            $this->assign('ry',$ss_type);
            $this->assign('UserID',$UserID);
            $this->assign('fee_s7',$this->feeratio['type_name']);        //
            return $this->fetch('money_flow');
    }





public function logout()
    {
    session('member_info',      null);
    session('member_auth',      null);
    session('member_auth_sign', null);
    $this->success('注销成功', url('index/index'));
    }

//数据记录
    public function record(){

   // $man= M('member')->where('user_id=111111')->find();
   // $member=new Member($this->feeratio);
   // $member->recoway($man);
    //var_dump($man);
     $params['uid']=session('member_info')['id'];
     $params['action_type']=['in','1,2'];
     $list=$this->logicshop->history($params,8);
     $this->assign('type_arr',$this->feeratio['type_name']); 
     $this->assign('list',$list);
    
     return $this->fetch();
    }
    




  //我的收入
    public function income(){

        $this->assign('data',$this->user);
        return $this->fetch();
        
    } 


 

 

    //销售数量
    public function xslist(){
        
          $params['uid']=session('member_info')['id'];
          $re_id=session('member_info')['id'];
          $variable=M('member')->where("re_id=".$re_id)->select();
        foreach ($variable as $key => $value) {
            $b_re_id[$key]=$value[id];
        }

         $where['uid']=['in',$b_re_id];
         $where['action_type']=['=',0];
        $list=$this->logicshop->history($where,8);

        foreach ($list as $key => $value) {
                if(!empty($value['action_type']||$value['action_type']==0)){


                    $list[$key]['bzxx']=$value['user_id'].$this->feeratio['type_name'][$value['action_type']];
                }else{
                    $list[$key]['bzxx']='其他';
                }
             }
     $this->assign('list',$list);
     return $this->fetch();
    }

    //团队销量
    public function tdlist(){
        
           $id=session('member_info')['id'];

          
          $variable=M('member')->where('re_path',"like","%".$id."%")->select();
        foreach ($variable as $key => $value) {
            $b_re_id[$key]=$value[id];
        }

         $where['uid']=['in',$b_re_id];
         $where['action_type']=['=',0];
        $list=$this->logicshop->history($where,8);
        foreach ($list as $key => $value) {
                if(!empty($value['action_type']||$value['action_type']==0)){


                    $list[$key]['bzxx']=$value['user_id'].$this->feeratio['type_name'][$value['action_type']];
                }else{
                    $list[$key]['bzxx']='其他';
                }
             }
     $this->assign('list',$list);
     return $this->fetch();
    }

  


    //数据记录
    public function recordjson(){
        
        // $uid=session('userinfo')['id'];

        // $type = input('type');

        // if($type){
        //     $where['type'] = $type;
        // }

        // $where['uid'] = $uid;

        // $list = Db::name('bill')->where($where)->field('type,typeStr,ctime,rmb')->order('id desc')->paginate(10);
        // $rel = array();
        // foreach($list as $k => $v){
        //     $rel[$k]['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
        //     $rel[$k]['typeStr'] = $v['typeStr'];
        //     $rel[$k]['rmb'] = $v['rmb'];
        // }
        // $count=count($list);
        // if($count>0){
        //     return json(['data'=>$rel,'code'=>1,'msg'=>'success']);
        // }else{
        //     return json(['data'=>'','code'=>0,'msg'=>'没有数据']);
        // }
        // exit;
    }

 


//提现申请
    public function withdrawadd(){
     
        $uid=session('member_info')['id'];
        

        $info = M('member')->field('*')->where('id='.$uid)->find();
        
        $map['uid']=$uid;
        $map['status']=1;
        $drawal =M('draw')->where($map)->order('id desc')->find();

        if($drawal){
            $data['bank']=$drawal['bank'];
            $data['card']=$drawal['card'];
            $data['name']=$drawal['name'];
            // $data['bank']=$drawal['bank'];
            // $data['kaihu']=$drawal['kaihu'];
        }else{
            $data['card']='';
            $data['name']='';
            $data['bank']='';
           // $data['kaihu']='';
        }

        $this->assign('bank_name', $this->feeratio['bank']);
        $this->assign('data',$data);
    
        $param=$this->request->param();
       if(!$param['page']&&$param) {
        $card =  $param['zhi'];
        $name = $param['zname'];
        $password2 = $param['password2'];
      
        $kaihu = $param['kaihu'];
        $num = $param['num'];

   
        //用     
       //验证类开始  
       $message=validate('Transfer')->withdrawadd($param);
        if(!is_bool($message))  return  $this->error($message);
       //验证类结束

        $userInfo = $info;


        // if(comoray_md5($password2,$userInfo['salt']) != $userInfo['password2']){
        //     $this->error('提现密码错误');
        // }

        // if($userInfo['keti'] < $num){
        //     $this->error('金额不足');
        // }
            $data=[];
            $data['num'] = $num;
            $data['uid'] = $uid;
            $data['name'] = $name;
            $data['card'] = $card;
            $data['bank'] = $param['bank_name'];
            $data['kaihu'] = $kaihu;
            $data['ctime'] = time();

         if(M('draw')->insert($data)){
         $users = M('member')->where("id=".$uid)->setDec('b0',$num);
          $this->success('提现成功,等待审核通过',url('vip'));
         }
     }

         $where['uid']=session('member_info')['id'];
          $list=$this->logicshop->draw($where,5);  
          $this->assign('info',$this->user);
         $this->assign('list',$list);
          $this->assign('ratio',(100-$this->feeratio[poundage][0])/100);
         $this->assign('bank_n', $this->feeratio['bank']);
         return $this->fetch();
   }












    //我的经销商
    public function lists(){

        // $userid = session('userinfo')['id'];
        // $user = Db::name('mini_users')->where('id',$userid)->find();

        // $dj=array('','普通用户','VIP用户');
        // //一级经销商
        // $onelist=Db::name('mini_users')->where('refer',$userid)->field('id,paynum,plannum,renshu,username,jibie')->paginate(10);
        // $one=[];
        // $num['1']=0;//一级总人数
        // $share['1']=0;//一级的购买总数

        // if($onelist){

        //     foreach ($onelist as $k => $v) {
        //         $num['1']+=1;
        //             $share['1']+=$v['paynum'];

        //         // 等级名称

        //         $one[]=['id'=>$v['id'],'paynum'=>$v['paynum'],'plannum'=>$v['plannum'],'renshu'=>$v['renshu'],'username'=>$v['username'],'dengji'=>$dj[$v['jibie']]];

        //     }

        // }
        // $count = count($onelist);
        // $this->assign('count',$count);

        // $this->assign('user',$user);
        // $this->assign('one',$one);
        // $this->assign('share',$share);
        // $this->assign('num',$num);


        return $this->fetch();
    }

    //我的经销商
    public function listsjson(){

        // $userid = session('userinfo')['id'];

        // $dj=array('','普通用户','VIP用户');
        // //一级经销商
        // $onelist=Db::name('mini_users')->where('refer',$userid)->field('id,paynum,plannum,renshu,username,jibie')->paginate(10);
        // $one=[];
        // $num['1']=0;//一级总人数
        // $share['1']=0;//一级的购买总数

        // if($onelist){

        //     foreach ($onelist as $k => $v) {
        //         $num['1']+=1;
        //         $share['1']+=$v['paynum'];

        //         // 等级名称
        //         $one[]=['id'=>$v['id'],'paynum'=>$v['paynum'],'plannum'=>$v['plannum'],'renshu'=>$v['renshu'],'username'=>$v['username'],'dengji'=>$dj[$v['jibie']]];

        //     }

        // }

        //return json($one);
    }



    
    //提现明细
    public function withdrawlistjson(){

        // $uid = session('userinfo')['id'];
        // $pageParam=['query'=>[]];//设置保持分页的条件
        // $res = Db::name('mini_users')->where('id',$uid)->find();
        // $data = Db::name('drawal')->field('num,name,card,bank,kaihu,ctime,status,content')->where('uid',$uid)->order('id desc')->paginate(10);
        // $count = count($data);
        
        // $rel = array();
        // foreach($data as $v){
        //     $v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
        //     switch ($v['status']){
        //         case 0:
        //           $v['status']='待审核';
        //           break;  
        //         case 1:
        //           $v['status']='已完成';
        //           break;
        //         case 2:
        //           $v['status']='驳回：'.$v['content'];
        //           break;
        //     }
        //     $rel[] = $v;
        // }
        // return json($rel);
    }
    

      //分享
    public function qcode(){

          $user=$this->user;
        $rootPath =$_SERVER['HTTP_HOST'];
        $d="http://".$rootPath."/j8830/public/index/index/member_add/TPL/1/RID/".$user[id]."/FID/".$user[id];
        $url="http://bshare.optimix.asia/barCode?site=weixin&url=".$d;
        $this->assign('url',$url);
        $this->assign('d',$d);
        return $this->fetch();
       
    }

    //消息列表
    public function message(){
        // $uid = session('userinfo')['id'];
        // $pageParam=['query'=>[]];//设置保持分页的条件

        // $rel = array();
        // $data = Db::name('message')->where('uid',$uid)->order('status asc,id desc')->paginate(10);
        // $status=1;
        // if($data){
        //     foreach($data as $v){
        //         $v['time'] = date('Y-m-d H:i:s',$v['ctime']);
        //         $rel[] = $v;
        //         if($v['status']==0){
        //             $status=0;
        //         }
        //     }
        // }

        // if($status==0){
        //     $this->messageedit();
        // }

        // $count=count($rel);
        // $this->assign('count',$count);
        // $this->assign('data',$rel);
        return $this->fetch();
    }

    //标记已读
    public function messageedit(){
        // $uid = session('userinfo')['id'];

        // Db::name('message')->where('uid',$uid)->setField('status',1);

        // return json(['data'=>'','code'=>1,'msg'=>'success']);
        exit;
    }
























 

//推荐图

    public function tree1()
    {

       
        $member = M("member");
        $tt = $this->pb_img();
        $treemg1 = $tt[1];
        $treemg2 = $tt[2];
        $treemg3 = $tt[3];

        $jieimg1 = $tt[4];
        $jieimg2 = $tt[5];
        $jieimg3 = $tt[6];
        $jieimg4 = $tt[7];

        $openimg1 = $tt[8];
        $openimg2 = $tt[9];


        $ID  = $_GET['UID'];
        $Mmid=session('member_info')['id'];
        $this->assign('Mmid', $Mmid);
        if (empty($ID))$ID =session('member_info')['id'];

        if (!is_numeric($ID) || strlen($ID) > 20 ) $ID = session('member_info')['id'];

        $UserID = $_POST['UserID'];
        $csuerid=$UserID;
        if (strlen($UserID) > 20 ){
            $this->error( '错误操作！');
            exit;
        }

       if (!empty($UserID)){
            
            $frs = $member->where("user_id=".$UserID)->field('id')->find();

            if (!$frs){
                $this->error('没有找到该用户！');
                exit;
            }else{
                $ID = $frs['id'];
            }
        }
        $id = session('member_info')['id'];
        $this->assign('useid',$id);
        
        $where = array();
       $where['id'] = $ID;
       $where=['re_path'=>['exp'," like '%,".$Mmid.",%''$username' or id = '{$Mmid}'"]];
       // $where['area']= ['exp', "(re_path like '%,".$Mmid.",%' or id = ".$Mmid.")"] ;
        $rs = $member->where($where)->find();
        
        if (!$rs){
            $this->error('没有找到该用户！');
            exit;
        }else{
            
            $UID        = $rs['id'];
            $UserID     = $rs['user_id'];
            $username   = $rs['username'];
            $NickName   = $rs['nickname'];
            $FatherID   = $rs['father_id'];
            $FatherName = $rs['father_name'];
            $ReID       = $rs['re_id'];
            $ReName     = $rs['re_name'];
            $isPay      = $rs['is_pay'];
            $isAgent    = $rs['is_agent'];
            $isLock     = $rs['is_lock'];
            $uLevel     = $rs['u_level'];
            $grtLevel       = $rs['get_level'];
            $NanGua     = 'aappleeva';
            $ReNUMS     = $rs['re_nums'];
            $QiCheng_l  = $rs['l'];
            $QiCheng_r  = $rs['r'];
            $to_l   = $rs['today_l'];
            $ro_r  = $rs['today_r'];
            $user_tel = $rs['user_tel'];
            $getjbbh=$this->feeratio['str5'][$rs['u_level']];
            
        }
        
        $all_nn = $member->where('re_path like "%,'.$UID.',%" and is_pay=1')->count();
        $this->assign('all_nn', $all_nn);
        $zyj = $QiCheng_l+$QiCheng_r;
        $to_zyj = $to_l + $ro_r;

        $myIMG = "";
        $myName = "";
        $myTabN = "";
        if($isAgent>=2){
            $myIMG = $treemg1;
        }else{
            $myIMG = $treemg2;
        }
        $HYJJ = '';
        $this->_levelConfirm($HYJJ,1);
        //$LE = $HYJJ[$zLevel];
        $team[0]='A团队';
        $team[1]='B团队';
        $team[2]='C团队';
//        $myName = $UserID."(".$username.") [".$HYJJ[$uLevel]."](".$user_tel.")";
        $myName = $UserID.'&nbsp;&nbsp;姓名：'.$username.'&nbsp;&nbsp;推荐人：'.$rs['re_uid'].'  ';
        $myTabN = "m".$UID;

        $myStr = '<img name="img'.$UID.'" src="'.$myIMG.'" align="absmiddle"> '.$myName;

        $this->assign('myStr', $myStr);
        $this->assign('myTabN', $myTabN);
        $this->assign('ID', $ID);

        $this->assign('zyj', $zyj);
        $this->assign('to_zyj', $to_zyj);

        $z_tree = array();

       //子网络
        $rwhere     = array();
        $rwhere['re_id']    = $ID;

        $z_count = $member->where($rwhere)->count();//人数
        
        // if($this->user['id']==1){
            $trs = $member->where($rwhere)->order('is_pay desc,create_time asc')->select();
        // }
        
        $zz = 1;

        foreach($trs as $rss){
            
            $rssid = $rss['id'];
            $rsuserid = $rss['user_id'];
            $nickname = $rss['nickname'];
            $rusername = $rss['username'];
            $rsagent = $rss['is_agent'];
            $rslv = $rss['u_level'];
            $getrslv = $rss['get_level'];
            $user_tel2 = $rss['user_tel'];
            $z_rslv = $rslv-1;
            $rspay = $rss['is_pay'];
            $find_l = $rss['l'];
            $find_r  = $rss['r'];
            $getjbbhs=$this->feeratio['str5'][$rss['u_level']];
            $z_function = "";
            $z_myTabN = "m".$rssid;
            $oz_TabNN = "img".$rssid;
            $oz_img = "";
            $l_pp = ",";
            $zzz_count = $member->where('re_id='.$rssid)->count();//人数
            if($zzz_count>0){
                if($zz==$z_count){
                    $l_pp = $l_pp."1,";
                    $z_img = $jieimg1;
                  
                    $z_function = "openmm('".$z_myTabN."','".$oz_TabNN."','".$rssid."','1','".$l_pp."')";
                    
                     // var_dump( $z_function);die;
                    $oz_img = $openimg1;
                }else{
                    $z_img = $jieimg2;
                    $z_function = "openmm('".$z_myTabN."','".$oz_TabNN."','".$rssid."','1','".$l_pp."')";
                    $oz_img = $openimg2;
                }
            }else{
                if($zz==$z_count){
                    $z_img = $jieimg3;
                }else{
                    $z_img = $jieimg4;
                }
            }
            if($rsagent>=2){
                $z_us_img = $treemg1;
            }else{
                if($rspay>0){
                    $z_us_img = $treemg2;
                }else{
                    $z_us_img = $treemg3;
                }
            }

            $cf_mm = $this->cf_img(1);

            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);


//          $z_myName = $rsuserid."(".$rusername.") [".$HYJJ[$rslv]."](".$user_tel2.")";
            $z_myName = $rsuserid.'&nbsp;&nbsp;姓名：'.$rusername.'&nbsp;&nbsp; 推荐人：'.$rss['re_uid'].'  '.$team[$tree];

            $z_tree[$zz][0] = '<img id="'.$oz_TabNN.'" src="'.$z_img.'" align="absmiddle" onclick="'.$z_function.'">';
            $z_tree[$zz][0].= '<img id="fg'.$rssid.'" src="'.$z_us_img.'" align="absmiddle"> ';
            $z_tree[$zz][0].= $z_myName;
            if(!empty($oz_img)){
                $z_tree[$zz][0].= '<img id="o'.$oz_TabNN.'" src="'.$oz_img.'" align="absmiddle" style="display:none;">';
            }
            $z_tree[$zz][1] = $z_myTabN;
            $z_tree[$zz][2] = $cf_mm;
            $zz++;
        }
       // var_dump( $z_tree);
        $this->assign('z_tree', $z_tree);
        $this->assign('UserID', $csuerid);
        return $this->fetch('tree1');
    }


public function ajax_tree_m(){
       
$this->view->engine->layout(false);
        $member = M("member");

        $tt = $this->pb_img();
        $treemg1 = $tt[1];
        $treemg2 = $tt[2];
        $treemg3 = $tt[3];

        $jieimg1 = $tt[4];
        $jieimg2 = $tt[5];
        $jieimg3 = $tt[6];
        $jieimg4 = $tt[7];

        $openimg1 = $tt[8];
        $openimg2 = $tt[9];

        $_GET= $this->request->param();

        $reid = $_GET['reid'];
        $opnum = $_GET['nn'];
        $l_path = trim($_GET['pp']);
        $n_path = $l_path;
        if($opnum<1){
            $opnum = 1;
        }
        $ttt_mm = $opnum+1;
        $id = session('member_info')['id'];
        $man=$member->where('id='.$id)->find(); 


        $rwhere     = array();
        $rwhere['re_id']    = $reid;
        $levell=$man['re_level']+400;
        $rwhere['re_level']=array('lt',$levell);


        $z_count = $member->where($rwhere)->count();//人数
        // if($this->user['id']==1){
            $trs = $member->where($rwhere)->order('is_pay desc,create_time asc')->select();
        // }
        
        $zz = 1;
        $z_tree = array();
        
        foreach($trs as $rss){
            
        
            $rssid = $rss['id'];
            $rsuserid = $rss['user_id'];
            $nickname = $rss['nickname'];
            $rusername = $rss['username'];
            $rsagent = $rss['is_agent'];
            $rslv = $rss['u_level'];
            $getrslv = $rss['get_level'];
            $z_rslv = $rslv-1;
            $rspay = $rss['is_pay'];
            $find_l = $rss['l'];
            $find_r  = $rss['r'];
            $getjbbhs=$this->feeratio['str5'][$rss['u_level']];
            $z_function = "";
            $z_myTabN = "m".$rssid;
            $oz_TabNN = "img".$rssid;
            $oz_img = "";
            $zzz_count = $member->where('re_id='.$rssid)->count();//人数
            if($zzz_count>0){
                if($zz==$z_count){
                    $n_path = $n_path.$ttt_mm.",";
                    $z_img = $jieimg1;
                    $z_function = "openmm('".$z_myTabN."','".$oz_TabNN."','".$rssid."','".$ttt_mm."','".$n_path."')";
                    $oz_img = $openimg1;
                }else{
                    $z_img = $jieimg2;
                    $z_function = "openmm('".$z_myTabN."','".$oz_TabNN."','".$rssid."','".$ttt_mm."','".$n_path."')";
                    $oz_img = $openimg2;
                }
            }else{
                if($zz==$z_count){
                    $z_img = $jieimg3;
                }else{
                    $z_img = $jieimg4;
                }
            }
            if($rsagent>=2){
                $z_us_img = $treemg1;
            }else{
                if($rspay>0){
                    $z_us_img = $treemg2;
                }else{
                    $z_us_img = $treemg3;
                }
            }
          
            $cf_mm = $this->cf_img($opnum,$n_path);

            $HYJJ = '';
            //$this->_levelConfirm($HYJJ,1);
//            $z_myName = $rsuserid."(".$rusername.") [".$HYJJ[$rslv]."]";
            // $z_myName = $rsuserid;
            $z_myName = $rsuserid.'&nbsp;&nbsp;姓名：'.$rusername.' &nbsp;&nbsp推荐人：'.$rss['re_uid'].'  '.$team[$rss['treeplace']];
            $z_tree[$zz][0] = '<img id="'.$oz_TabNN.'" src="'.$z_img.'" align="absmiddle" onclick="'.$z_function.'">';
            $z_tree[$zz][0].= '<img id="fg'.$rssid.'" src="'.$z_us_img.'" align="absmiddle"> ';
            $z_tree[$zz][0].= $z_myName;
            if(!empty($oz_img)){
                $z_tree[$zz][0].= '<img id="o'.$oz_TabNN.'" src="'.$oz_img.'" align="absmiddle" style="display:none;">';
            }
            $z_tree[$zz][1] = $z_myTabN;
            $z_tree[$zz][2] = $cf_mm;
            $zz++;
        }


        $zzz_str = "";
        foreach($z_tree as $zzzz){

            $ttt_nnn = $this->cf_img($ttt_mm,$n_path);
            $zzz_str .= '<p>'.$zzzz[2].$zzzz[0].'</p>'.
                    '<table width="100%" border="0" cellspacing="0" cellpadding="0" id="'.$zzzz[1].'" class="treep2">' .
                    '<tr><td id="'.$zzzz[1].'_tree">'.$ttt_nnn.'<img src="'.__PUBLIC__.'/Images/loading2.gif" align="absmiddle"></td>' .
                    '</tr></table>';
        }
       // var_dump($zzz_str);
        $this->assign('zzz_str',$zzz_str);
       return $this->fetch();
       

    }



        protected function _levelConfirm(&$HYJJ,$HYid=1){
        
        $fee_s1 = $this->feeratio('vip_level');
        $HYJJ[1] = $fee_s1[0];
        $HYJJ[2] = $fee_s1[1];
        $HYJJ[3] = $fee_s1[2];
        $HYJJ[4] = $fee_s1[3];
        $HYJJ[5] = $fee_s1[4];
        $HYJJ[6] = $fee_s1[5];
        $HYJJ[7] = $fee_s1[6];
    }

    protected function _getLevelConfirm(&$HYJJ,$HYid=1){
        $HYJJ = array();
        $HYJJ[0] = "普卡";
        $HYJJ[1] = "金卡";
        $HYJJ[2] = "钻卡";
        $HYJJ[3] = "报单中心";
        $HYJJ[4] = "四星";
    }




private function pb_img(){

        $tt[1] = __STATIC__."/module/admin/ext/adminlte/dist/center.gif";
        $tt[2] = __STATIC__."/module/admin/ext/adminlte/dist/Official.gif";
        $tt[3] = __STATIC__."/module/admin/ext/adminlte/dist/trial.gif";

        $tt[4] = __STATIC__."/module/admin/ext/adminlte/dist/P2.gif";
        $tt[5] = __STATIC__."/module/admin/ext/adminlte/dist/P1.gif";
        $tt[6] = __STATIC__."/module/admin/ext/adminlte/dist/L2.gif";
        $tt[7] = __STATIC__."/module/admin/ext/adminlte/dist/L1.gif";

        $tt[8] = __STATIC__."/module/admin/ext/adminlte/dist/M2.gif";
        $tt[9] = __STATIC__."/module/admin/ext/adminlte/dist/M1.gif";

        return $tt;
    }

    private function cf_img($num=1,$array=','){
        for($i=1;$i<=$num;$i++){
            if(strpos($array,','.$i.',') !==false){
                $cf_img .= '<img src="'.__STATIC__.'/module/admin/ext/adminlte/dist/L5.gif" align="absmiddle">';
            }else{
           $cf_img .= '<img src="'.__STATIC__.'/module/admin/ext/adminlte/dist/L4.gif" align="absmiddle">';
            }
        }
        return $cf_img;
    }


    }





















