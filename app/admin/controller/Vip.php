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

namespace app\admin\controller;
use app\common\model\ShopCategory;
use app\admin\logic\Member;

/**
 * 前端首页控制器
 */
class Vip extends AdminBase
{
   


 public function transfer(){
        $member=new  Member;
        $validate = validate('Transfer');;
        $params = $this->request->param();
        if($params){
       if($params['number']>$this->user['b0']){
           $this->error('金额不足');
         }
       if(!$params['type']){
           $this->error('请选择类型');
         }
        if (!$validate->scene('transfer')->check($params)) {
            return  $this->error($validate->getError());
        }
        
        $to_user =M('member')->where('username="'.$params['to_user_id'].'"')->find();
        $params['type']=$params['type']-1;
        $bnum=30+$params['type'];//转账记录
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





public function charge_member(){
        $member=new  Member;
       // $validate = validate('Transfer');;
        $params = $this->request->param();
        if($params){
        // if (!$validate->scene('transfer')->check($params)) {
        //     return  $this->error($validate->getError());
        // }
       
         if(!$params['type']){
           $this->error('请选择类型');
         }
         if($params['number']<=0){
          $this->error('数目不正确');
         }
        $params['type']=$params['type']-1;
        $bnum=50+$params['type'];//转账记录
        $data[status]=1;

        $man= M('member')->where("user_id='".$params['user_id']."'")->find();
        $member->addencAdd($man,$params['number'],$bnum,$this->user,$data);
        M('member')->where("user_id='".$params['user_id']."'")->setInc('b0',$params['number']);



        $this->success('充值申请成功！');
         }
        $this->assign('user',$this->user);

         $where['uid']=['=',$this->user['id']];
         $where['action_type']=['=',50];
         $where['epoints']=['>=',0];
         $list=$this->logicshop->history($where,5);

         $this->assign('type_arr',$this->feeratio['type_name']); 
       
         $this->assign('list',$list);
        
         return $this->fetch();   
    }





public function task_member_submit(){
        $member=new  Member;
       // $validate = validate('Transfer');;
        $params = $this->request->param();
        if($params){
         M('history')->where("id=". $params['id'])->setfield('status',3);
         M('history')->where("id=". $params['id'])->setfield('img_ids',$params['img_ids']);
         $this->success('提交 任务成功！');
         }
         $where['uid']=['=',$this->user['id']];
         $where['action_type']=['=',61];
         $where['status']=['in','0'];
         $list=$this->logicshop->history($where,5);
       // foreach ($list as $key => $value) {
       //    $list[$key]['img_ids_array']=str2arr($value[img_ids]);
       //  }
         $this->assign('type_arr',$this->feeratio['type_name']); 
         $this->assign('countdown',50000);
         $this->assign('list',$list);
         return $this->fetch();   
    }








   







































  
   
































    
 
 




public function logout()
    {
    session('member_info',      null);
    session('member_auth',      null);
    session('member_auth_sign', null);
    $this->success('注销成功', url('index/index'));
    }


  //我的收入
    public function income(){

        $this->assign('data',$this->user);
        return $this->fetch();
        
    } 

    //分享
    public function qcode(){

        //    $user=$this->user;
        $url="http://bshare.optimix.asia/barCode?site=weixin&url=http://vip5.gxbbwrj.com/j8830/public/admin/login/login.html/public/index/index/member_add/TPL/1/RID/".$user[id]."/FID/".$user[id];
        $this->assign('url',$url);
        return $this->fetch();
        return $this->fetch();
    }


//提现申请
    public function withdrawadd(){
     
        $uid=session('member_info')['id'];
        

        $info = M('member')->field('*')->where('id='.$uid)->find();
        // if($info){
        //     $data['keti']= floor($info['keti']);
        // }else{
        //     $data['keti']= 0;
        // }

        $banks = array('中国工商银行','中国银行','中国农业银行','中国建设银行','中国邮政储蓄银行','广发银行','浦发银行','平安银行','交通银行','招商银行','兴业银行','中信银行','民生银行','光大银行');

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

        $this->assign('banks',$banks);
        $this->assign('data',$data);
       
        $param=$this->request->param();
       if($param) {
        $card =  $param['zhi'];
        $name = $param['zname'];
        $password2 = $param['password2'];
        $bank = $param['bank'];
        $kaihu = $param['kaihu'];
        $num = $param['num'];
        if(!$this->user['card']){
           $this->error('请实名，我的资料里补全信息');}
        foreach ($param as  $value) {
             if(!$value){
           $this->error('有没填的提现信息');
                }
           }
        $match = '/^[1-9]*[1-9][0-9]*$/';
        if(!preg_match($match, $num)){
           $this->error('请输入正确的提现数');
        }
        if( $num < 100){
          $this->error('请输入大于100的提现数');
        }
         //var_dump($param);
        $zint = $num / 100;
        if( floor($zint) != $zint ){
            $this->error('请输入100的倍数');
        }
        if(empty($card)){
          $this->error('请输入银行卡号');
        }
        if(empty($name)){
           $this->error('请输入开户人姓名');
        }
        if(empty($password2)){
            $this->error('请输入提现密码');
        }
        if($num>$this->user['b0']){
           $this->error('金额不足');
         }
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
            $data['bank'] = $bank;
            $data['kaihu'] = $kaihu;
            $data['ctime'] = time();

         if(M('draw')->insert($data)){
         $users = M('member')->where("id=".$uid)->setDec('b0',$num);
          $this->success('提现成功',url('vip'));
         }
     }


        $where['uid']=session('member_info')['id'];
        $list=$this->logicshop->draw($where,5);
        // foreach ($list as $key => $value) {
        //         if(!empty($value['action_type']||$value['action_type']==0)){
        //             $list[$key]['bzxx']=$value['user_id'].$this->feeratio['type_name'][$value['action_type']];
        //         }else{
        //             $list[$key]['bzxx']='其他';
        //         }
        //      }
         $this->assign('list',$list);
         return $this->fetch();
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
//    .'&nbsp;&nbsp;姓名：'.$username.'&nbsp;&nbsp;级别编号：'.$getjbbh.'  推荐人：'.$rs['re_uid'].'  '    $myName = $UserID."(".$username.") [".$HYJJ[$uLevel]."](".$user_tel.")";
        $myName = $UserID;
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

 // $lirs = M('member') ->where('id in (0'.$rss['p_path'].'0)')->order('p_level desc')->field('*')->select();
 //        foreach($lirs as $lrs){
 //            $Fid= $lrs['id'];
 //           if($Mmid==$Fid){
 //                        $tree= $treeplace; }
 //             $treeplace=$lrs['treeplace'];
 //        }
 //          $nex_man=M('member') ->where('father_id='.$Mmid)->select();
 //         foreach ($nex_man as $value) {
 //                if ($value['id']==$rss['id']){

 //                    $tree=$rss['treeplace'];
 //                }
 //         }

//            $z_myName = $rsuserid."(".$rusername.") [".$HYJJ[$rslv]."](".$user_tel2.")";
//            .'&nbsp;&nbsp;姓名：'.$rusername.'&nbsp;&nbsp;级别编号：'.$getjbbhs.'   推荐人：'.$rss['re_uid'].'  '.$team[$tree]
            $z_myName = $rsuserid;

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
        $levell=$man['re_level']+4;
        $rwhere['re_level']=array('lt',$levell);


        $z_count = $member->where($rwhere)->count();//人数
        // if($this->user['id']==1){
            $trs = $member->where($rwhere)->order('is_pay desc,create_time asc')->select();
        // }
        
        $zz = 1;
        $z_tree = array();
        //var_dump( $trs);
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
            $z_myName = $rsuserid.'&nbsp;&nbsp;姓名：'.$rusername.'&nbsp;&nbsp;级别编号：'.$getjbbhs.'   推荐人：'.$rss['re_name'].'  '.$team[$rss['treeplace']];
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
        $this->assign('zzz_str',$zzz_str);
        $this->display();
        exit;

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


   


/*
	 * 发邮件功能
	*/
	public function writemsg(){
		$this->assign('mrs',$this->user);
		 return $this->fetch();
	}
	
	/*
	 * 发邮件处理功能
	 * @UserID 接收人
	 * @Title 标题
	 * @Msg 信息内容
	 * @level 发送类型 1为公司，2为会员
	*/
	public function writeSave(){
		$UserID   = trim($_POST['UserID']);
		$Title    = trim($_POST['Title']);
		$Msg      = trim($_POST['Msg']);
		$level    = trim($_POST['level']);

		if( $level == 1 ){
			$gsrs = M('member')->where('id=1')->field('user_id')->find();
			$UserID = $gsrs['user_id'];
		}

		// exit;

		$member = M ('member');
		// if (empty($UserID)){
		// 	$this->error('数据错误!');
		// 	exit;
		// }

		if (strlen($Title) > 200){
			$this->error ('主题太长!');
			exit;
		}
		$this->_messagesAdd($UserID,$Title,$Msg);
	}


	private function _messagesAdd($UserID='0',$Title='',$Msg=''){
		$member = M ('member');
		$Users = M ('Msg');
		$where = array();
		$ID =$this->user['id'];
		
		//收件人
		$where1 = array();
		$where1['user_id'] = $UserID;
		// if($UserID == '公司'){
		// 	$gsrs = M('member')->where('id=1')->field('user_id')->find();
		// 	$where1['user_id'] = $gsrs['user_id'];
		// }
		

		$vo = $member->where($where1)->find();
		if (!$vo){
			$this->error('收件人不存在！');
			exit;
		}
		// if($ID>1){
		// 	if($ID == $vo['id']){
		// 		$this->error('不能给自已发邮件！');
		// 		exit;
		// 	}
		// }

		
		//发件人
		$where['id'] = $ID;
		$vo2 = $member->where($where)->find();
		if (!$vo2){
			$this->error('没有该记录!');
			exit;
		}

		// if ( $vo2['user_id'] == $UserID ){
		// 	$this->error("不能给自已发邮件！");
		// 	exit;
		// }

		//开始事务处理
		$Users->startTrans();
        $nowdate = strtotime(date('c'));
        
		//留言表
		$data = array();
		$data['f_uid']		= $vo2['id'];
		$data['f_user_id']	= $vo2['user_id'];
		$data['s_uid']		= $vo['id'];
		$data['s_user_id']	= $vo['user_id'];
		$data['title']		= $Title;
		$data['content']	= $Msg;
		$data['f_time']		= time();
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
	
	/*
	 * 收件箱
	 * */
	public function inmsg(){
		$map = array();
		$map['s_uid']   =$this->user['id'];
		$map['s_del']   = 0;
        $list = M('msg')->where($map)->order('id desc')->select();
        $this->assign('list',$list);//数据输出到模板
        //=================================================
		 return $this->fetch();
	}
	
	/*
	 * 删除收件箱记录
	 * */
	public function s_del(){
		$boxID = $_POST['tabledb'];
		$msg = M('msg');
		$map = array();
		$map['id']  = array('in',$boxID);
		$map['s_uid'] = $this->user['id'];
		$lirs = $msg->where($map)->select();
		foreach($lirs as $rs){
			$where = "id=".$rs['id'];
			$f_del = $rs['f_del'];
			if($f_del==1){
				$delre = $msg->where($where)->delete();
			}else{
				$data = array();
				$data['s_del'] = 1;
				$delre = $msg->where($where)->save($data);
			}
		}
		unset($msg,$map,$boxID);
		$this->success('删除成功！');
		exit;
	}
	
	/*
	 * 查看收件箱记录
	 * */
	public function s_view(){
		$msg = M('msg');
		$did = (int)input('did');
		$map = array();
		$map['id']  = $did;
		$map['s_uid'] = $this->user['id'];
		$mrs = $msg->where($map)->find();
		if($mrs){
			$read = $mrs['s_read'];
			if($read==0){
				$msg->where($map)->setField('s_read',1);
			}
			$this->assign('vo',$mrs);
			 return $this->fetch();
		}else{
			$this->error('操作失败');
			exit;
		}
	}
	
	/*
	 * 回复邮件
	 * */
	public function replyAC(){
		$Pid = (int) $_POST['id'];
		$Msg = $_POST['Msg'];
		if ($Pid == 0){
			$this->error('数据错误!');
			exit;
		}
		if (strlen($Pid) > 12){
			$this->error ('参数错误!');
			exit;
		}
		$this->_messagesShowReply($Pid,$Msg);
	}


	private function _messagesShowReply($Pid=0,$Msg=''){
		$ID = $this->user['id'];
		$msg = M ('msg');
		$member = M ('member');
		$where = array();//
		$where['s_uid'] = $ID;
		$where['id'] = $Pid;
	
		$vo = $msg ->where($where)->find();
		if (!$vo){
			$this->error ('参数错误!');
			exit;
		}
		//发件人
		$where = array();
		$where['id'] = $ID;
		$vo2 = $member->where($where)->find();
		if (!$vo2){
			$this->error('没有该记录!');
			exit;
		}
		$Title = '回复：'. $vo['title'];
		
		$data = array();
		$data['f_uid']		= $vo2['id'];
		$data['f_user_id']	= $vo2['user_id'];
		$data['s_uid']		= $vo['f_uid'];
		$data['s_user_id']	= $vo['f_user_id'];
		$data['title']		= $Title;
		$data['content']	= $Msg;
		$data['f_time']		= time();
		$rs1 = $msg->add($data);
		unset($msg,$data);
		if ($rs1){
			$this->success('回复成功！');
			exit;
		}else{
			$this->error('回复失败');
			exit;
		}
	}
	



	/*
	 * 发件箱
	 * */
	public function outmsg(){
		$msg = M('msg');
		$map = array();
		$map['f_uid']   = $this->user['id'];
		$map['f_del']   = 0;

        $list = $msg->where($map)->order('id desc')->select();
        $this->assign('list',$list);//数据输出到模板
        //=================================================
	 return $this->fetch();
	}
	
	/*
	 * 删除收件箱记录
	 * */

public function f_del(){
		$boxID = $_POST['tabledb'];
		$msg = M('msg');
		$map = array();
		$map['id']  = array('in',$boxID);
		$map['f_uid'] = $this->user['id'];
		$lirs = $msg->where($map)->select();
		foreach($lirs as $rs){
			$where = "id=".$rs['id'];
			$f_del = $rs['f_del'];
			if($f_del==1){
				$delre = $msg->where($where)->delete();
			}else{
				$data = array();
				$data['f_del'] = 1;
				$delre = $msg->where($where)->save($data);
			}
		}
		unset($msg,$map,$boxID);
		$this->success('删除成功！');
		exit;
	}


	/*
	 * 查看收件箱记录
	 * */
	public function f_view(){
		$msg = M('msg');
		$did = (int)$_GET['did'];
		$map = array();
		$map['id']  = $did;
		$map['f_uid'] = $this->user['id'];
		$mrs = $msg->where($map)->find();
		if($mrs){
			$read = $mrs['f_read'];
			if($read==0){
				$msg->where($map)->setField('f_read',1);
			}
			$this->assign('vo',$mrs);
			$this->display("f_view2");
		}else{
			$this->error('操作失败');
			exit;
		}
	}











 /**
     * 会员列表
     */
    public function memberList()
    {
       
         $where['m.is_pay']=0;
         $list=$this->logicMember->getMemberList($where);


        $is_agent=$this->feeratio['is_agent'];


        foreach ($list as $key => $value) {
            $is_pay=$value['is_pay'];
            if($is_pay){
                 $list[$key]['status']=1;
            }else{
                 $list[$key]['status']=0;
            }

          $list[$key]['is_agent']=$is_agent[ $value['is_agent']];

        }
        $this->assign('list',$list);
        return $this->fetch('member_list');
    }







 /**
     * 奖金查询
     */
    public function bonusList(){
        $date       = $this->request->param('date', '');
        $username   = $this->request->param('username', '');
        $data = $this->logicFinance->getBonusList($date, $username);
      foreach ($this->feeratio['type_name'] as $key => $value) {
           if($key>=1&&$key<=10){
            $type_name[$key]['name']=$value; 
            $type_name[$key]['bkey']=$key;
               }
          }
        $this->assign('type_name', $type_name);
        $this->assign('sum', $data['sum']);
        $this->assign('list', $data['list']);
        return $this->fetch('bonus_list');
    }

    /**
     * 奖金查询→明细
     */
    public function bonusList2(){
        $times_id   = $this->request->param('times_id', 0, 'intval');
        $username   = $this->request->param('username', '');

        $data = $this->logicFinance->getBonusList2($times_id, $username);

        if (!$data) {
            return $this->error('暂无数据！');
        }


       foreach ($this->feeratio['type_name'] as $key => $value) {
           if($key>=1&&$key<=10){
            $type_name[$key]['name']=$value; 
            $type_name[$key]['bkey']=$key;
               }
          }
        $this->assign('type_name', $type_name);
        $this->assign('date', $data['date']);
        $this->assign('sum', $data['sum']);
        $this->assign('list', $data['list']);
        
        return $this->fetch('bonus_list2');
    }

    /**
     * 奖金查询→明细→明细
     */
    public function bonusList3(){
        $times_id   = $this->request->param('times_id', 0, 'intval');
        $username   = $this->request->param('username', '');

        $list = $this->logicFinance->getBonusList3($times_id, $username);

        if (!$list) {
            return $this->error('暂无数据！');
        }

        $this->assign('type_arr',$this->feeratio['type_name']); 
         $this->assign('cash',$this->feeratio['money_type']); 
        $this->assign('list', $list);
        
        return $this->fetch('bonus_list3');
    }

 /**
     * 奖金查询→明细→明细
     */
    public function bonusList4(){
       // $times_id   = $this->request->param('times_id', 0, 'intval');
        $username   = $this->request->param('username',$this->user['username']);

        $list = $this->logicFinance->getBonusList3($times_id, $username);

        if (!$list) {
            return $this->error('暂无数据！');
        }

        $this->assign('type_arr',$this->feeratio['type_name']); 
        $this->assign('cash',$this->feeratio['money_type']); 
        $this->assign('list', $list);
        
        return $this->fetch('bonus_list4');
    }



//数据记录
    public function record(){

  //  $man= M('member')->where('user_id=764709')->find();
   // $member=new Member($this->feeratio);
   // $member->recoway($man);

     $where['uid']=session('member_info')['id'];
     if($params['today']){
        $today = strtotime(date("Y-m-d"),time());
        $today_end = strtotime(date("Y-m-d"),time())+3600*24;
        $where['pdt']=array('between',array($today,$today_end));
     }
     $list=$this->logicshop->history($where,8);
     $this->assign('type_arr',$this->feeratio['type_name']); 
     $this->assign('list',$list);
     return $this->fetch();
    }



    }





















