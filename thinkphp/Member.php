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

namespace app\admin\logic;

/**
 * 会员逻辑
 */
class Member extends AdminBase
{
    
 /**
     * 会员添加
     */
    public function memberAdd($data = [],$index=[])
    {
        

        $validate_result = $this->validateMember->scene('add')->check($data);
        
        if (!$validate_result) {
            
            return [RESULT_ERROR, $this->validateMember->getError()];
        }
        
        $url = url('memberList');
       //接点路径
        $p_man=M('member')->where('user_id="'.$data['father_uid'].'"')->find();
        $data['father_id']  = $p_man['id'];
        $data['p_level']  = $p_man['p_level']+1;
        $data['p_path']  = $p_man['p_path'].','.$p_man['id'];
        //推荐路径
        $re_man=M('member')->where('user_id="'.$data['re_uid'].'"')->find();
        $data['re_id']  = $re_man['id'];
        $data['re_level']  = $re_man['re_level']+1;
        $data['re_path']  = $re_man['re_path'].','.$re_man['id'];
        $data['is_pay']  = 1;
        $data['nickname']  = $data['username'];
        $data['user_id']  = $data['username'];
        $data['leader_id'] = MEMBER_ID;
        $data['is_inside'] = DATA_NORMAL;
        $data['treeplace']  = $data['TPL'];
        if($index==100){

            $result = $this->modelMember->addInfo($data);
        }else{
        $result = $this->modelMember->setInfo($data);}

        $new_man=M('member')->where('user_id="'.$data['user_id'].'"')->find();
        //var_dump($new_man);die;
        $this->juncway($new_man);
        $result && action_log('新增', '新增会员，username：' . $data['username']);
        
        return $result ? [RESULT_SUCCESS, '会员添加成功', $url] : [RESULT_ERROR, $this->modelMember->getError()];


    }
    
      
 //统计单数
    public function jiandan($ppath,$treeplace){
        $lirs = M('member') ->where('id','in',$ppath)->order('p_level desc')->field('*')->select();
        foreach($lirs as $lrs){
            $Fid= $lrs['id'];
         if($treeplace==0&& $Fid> 0){  
            M('member')->execute("update xt_member Set `zone_a`=zone_a+1 where `id`=".$Fid);
             }elseif($treeplace==1&& $Fid> 0){ 
            M('member')->execute("update xt_member Set `zone_b`=zone_b+1 where `id`=".$Fid);
             }elseif($treeplace==2&& $Fid> 0){ 
            M('member')->execute("update xt_member Set `zone_c`=zone_c+1 where `id`=".$Fid);
             }
             $treeplace=$lrs['treeplace'];
        }

    }



  public function agent($man,$params){
      $ratio=ratio();
       $lirs = $this->where('agent=4')->order('re_level desc')->select();

       foreach ($lirs as $lrs){
            if((int)substr($lrs['card'] , 4 , 2)==00
                &&(int)substr($lrs['card'] , 0 , 4)
                ==(int)substr($man['card'] , 0 , 4)
              ){
              $money=$ratio['agent_income'][$lrs['agent_level']]*($params['goods_price']-$params['goods_cost'])/100;
             $this->rw_bonus($lrs,2,$money,$man);//2代理奖              
             }elseif((int)substr($lrs['card'] , 0 , 6)
              ==(int)substr($man['card'] , 0 , 6)
            ){
            $money=$ratio['agent_income'][$lrs['agent_level']]*($params['goods_price']-$params['goods_cost'])/100;
            $this->rw_bonus($lrs,2,$money*0.9,$man);//2代理奖
            $this->rw_bonus($lrs,3,$money_count*0.1,$man);//消费钱包
       
             }


      }
        
  }





















 //接点方法，遍历出接点路径上的id
    public function juncway($man){
       // $man=M('member')->where('id='.$id)->find();

        // if($cpzj){$man['cpzj']=$cpzj;}
        //统计单数 
        $this->jiandan($man['p_path'],$man['treeplace']);

        // //直接进入现金钱包 //个人现金钱包22
        // $this->rw_bonus_inc($man,22,$man['cpzj'],$man);

        // //各种扣钱
        // $this->buckle_award($man);

        // //推荐奖
        // $re=M('member')->where('id='.$man['re_id'])->find();
        // $str=60+$re['u_level'];
        // $money_count=$man['cpzj']*feeratio('str'.$str)[5]/100;
        // $this->rw_bonus($re,1,$money_count,$man);//11推荐奖

        // //其他奖
        // $lirs = $this->where('id in (0'.$man['p_path'].'0) and is_fenh=0')->field('*')->order('p_level desc')->select();
        // foreach ($lirs as $lrs){//遍历出接点路径上的id      
        // $this->duipeng($lrs,$man);  
        // }
    }


   public function recoway($man,$params){
       
       $map['id']  = array('in',$man['re_path']);
       $lirs = $this->where($map)->order('re_level desc')->select();
       foreach ($lirs as $lrs){
       $this->reco_bouns($lrs,$params['goods_price']-$params['goods_cost'],$man);
      //团队业绩
       M('member')->where('id='.$lrs['id'])->setInc('team_money',$params['goods_price']);
       }
      //直推业绩
      M('member')->where('id='.$man['re_id'])->setInc('re_money',$params['goods_price']);

   }



public function reco_bouns($re_id_all,$money,$man){

         $ra=ratio()['reco']; $ratio=0;
         //直推奖$re_id拿奖
        foreach ($ra as $key => $value) {
            if($man['re_level']-$re_id_all['re_level']<=$key&&$value>=$ratio){
                $ratio=$value;
            }
        }
        $money_count=$money*$ratio/100;
       $this->rw_bonus($re_id_all,1,$money_count*0.9,$man);//11推荐奖
      $this->rw_bonus($re_id_all,3,$money_count*0.1,$man);//消费钱包
}













    //对碰奖
    public function duipeng($lrs,$man){
            $xL = $lrs['xl'];//左剩余
            $xR = $lrs['xr'];//右剩余
        $Encash['2']=$xL>0&&$xR>0?($xL!==$xR?($xL>$xR?$xR:$xL):$xL):0;
            $Ls = $xL - $Encash['2'];//左剩余减碰
            $Rs = $xR - $Encash['2'];//右剩余减碰
            $lrcpj = $this->lrjudgeway($lrs,$man);//取出左右  
          //取上下左右其中最小
          if($lrcpj[3]>=2){$cpmoney = min($lrcpj[0],$lrcpj[2],$lrs['cpzj']);}
          if($Encash['2']){//如果有对碰
            $result = $this->query('UPDATE xt_member SET `xl`='. $Ls .',`xr`='. $Rs .'  where `id`='. $lrs['id']);
           $str=60+$lrs['u_level'];
           $money_count=$cpmoney*feeratio('str'.$str)[6]/100;
           $this->rw_bonus($lrs,2,$money_count,$man);} //插入对碰奖
    }
 

 

   public function buckle_award($man){
           $head=M('member')->where('id=1')->find();
           $m=$man['cpzj']; $r=feeratio('str59');
           for($i=0;$i<=4;$i++){
            //0.按比例扣除会员钱包进入公司推荐钱包
            //1.按比例扣除会员钱包进入公司对碰钱包
            //2.按比例扣除会员钱包进入公司对等钱包 
            //3.按比例扣除会员钱包进入公司分红奖钱包
            //4.按比例扣除会员钱包进入公司手续费钱包
            $this->rw_bonus_dec($man,22,$m*$r[$i]/100,$head);
            $this->rw_bonus_inc($head,$i+1,$m*$r[$i]/100,$man);}
            //扣除会员钱包进入进入公司循环钱包
            $this->rw_bonus_dec($man,22,$m*0.5,$head);
            $this->rw_bonus_inc($head,6,$m*0.5,$man);
          }
    
  public function rw_bonus($my,$cnum=0,$money_count=0,$man){
            $head=M('member')->where('id=1')->find();
           // $usqlc .= "b".$bnum."=b".$bnum."+".$money_count." ";  
            $usqlc = "red_packet=red_packet+".$money_count." ";        //
            $this->execute("update xt_member set ".$usqlc." where id='".$my['id']."'");
             $this->addencAdd($my,$money_count,$bnum,$man);

             if($cnum<4){
            $usqlc = "c".$cnum."=c".$cnum."+".$money_count." ";          //
            $this->execute("update xt_member set ".$usqlc." where id='".$my['id']."'");}
      
    }
   
//先扣，然后发
 public function rw_bonus_dec($my,$bnum=0,$money_count=0,$man){
        
      if($money_count>0){  $this->addencAdd($my,-$money_count,$bnum,$man);  }
        //奖金扣除1.现金 2.推荐 3.组织 4.对等 5.分红6.手续。7.循环
      if($bnum>=30){
        $bnum=$bnum-30;
      $usqlc .= "b".$bnum."=b".$bnum."-".$money_count." ";          //
      $this->execute("update xt_member set ".$usqlc." where id='".$my['id']."'"); }else{
      $usqlc .= "b".$bnum."=b".$bnum."-".$money_count." ";          //
      $this->execute("update xt_member set ".$usqlc." where id='".$my['id']."'");
      }
      
    }
   
//先扣，然后发
 public function rw_bonus_inc($my,$bnum=0,$money_count=0,$man){
       if($money_count>0){$this->addencAdd($my,$money_count,$bnum,$man); }
        //奖金扣除1.现金 2.推荐 3.组织 4.对等 5.分红6.手续。7.循环
       if($bnum>=30){
       $bnum=$bnum-30; 
      $usqlc .= "b".$bnum."=b".$bnum."+".$money_count." ";          //
      $this->execute("update xt_member set ".$usqlc." where id='".$my['id']."'"); }else{
      $usqlc .= "b".$bnum."=b".$bnum."+".$money_count." ";          //
      $this->execute("update xt_member set ".$usqlc." where id='".$my['id']."'");
      }


    
    }

public function addencAdd($my,$money=0,$name=null,$man=0,$bz="",$time=0,$acttime=0){
        //var_dump($ID,$inUserID,$money,$name,$UID);
        //添加 到数据表
        if ($UID > 0) {
            $where = array();
            $where['user_id'] = $inUserID;
            $frs = $this->where($where)->field('nickname')->find();
            $name_two = $name;
            //$name = $frs['nickname'] . ' 开通会员 ' . $inUserID ;
            //$inUserID = $frs['nickname'];
        }else{
            $name_two = $name;
        }
        $data = array();
        $history = M('history');
        $data['user_id']        = $my['user_id'];
        $data['uid']            = $my['id'];
        $data['user_did']        =$man['user_id'];
        $data['action_type']    = $name;
        if($time >0){
            $data['pdt']        = $time;
        }else{
            $data['pdt']        = time();
        }
        $data['epoints']        = $money;
        if(!empty($bz)){
            $data['bz']         = $bz;
        }else{
            $data['bz']         = '无备注';
        }
        $data['did']            = $man['id'];
        $data['type']           = 1;
        $data['allp']           = 0;
        if($acttime>0){
            $data['act_pdt']    = $acttime;
        }
        $result = $history ->add($data);
        unset($data,$history);
    }

































































    /**
     * 获取会员信息
     */
    public function getMemberInfo($where = [], $field = true)
    {
        
        $info = $this->modelMember->getInfo($where, $field);
        
        $info['leader_nickname'] = $this->modelMember->getValue(['id' => $info['leader_id']], 'nickname');
        
        return $info;
    }
    
    /**
     * 获取会员列表
     */
    public function getMemberList($where = [], $field = 'm.*,b.nickname as leader_nickname', $order = '', $paginate = DB_LIST_ROWS)
    {
        
        $this->modelMember->alias('m');
        
        $join = [
                    [SYS_DB_PREFIX . 'member b', 'm.leader_id = b.id', 'LEFT'],
                ];
        
        $where['m.' . DATA_STATUS_NAME] = ['neq', DATA_DELETE];
        
        return $this->modelMember->getList($where, $field, $order, $paginate, $join);
    }
    
    /**
     * 导出会员列表
     */
    public function exportMemberList($where = [], $field = 'm.*,b.nickname as leader_nickname', $order = '')
    {
        
        $list = $this->getMemberList($where, $field, $order, false);
        
        $titles = "昵称,用户名,邮箱,手机,注册时间,上级";
        $keys   = "nickname,username,email,mobile,create_time,leader_nickname";
        
        action_log('导出', '导出会员列表');
        
        export_excel($titles, $keys, $list, '会员列表');
    }
    
    /**
     * 获取会员列表搜索条件
     */
    public function getWhere($data = [])
    {
        
        $where = [];
        
        !empty($data['search_data']) && $where['m.nickname|m.username|m.email|m.mobile'] = ['like', '%'.$data['search_data'].'%'];
        
        if (!is_administrator()) {
            
            $member = session('member_info');
            
            if ($member['is_share_member']) {
                
                $ids = $this->getInheritMemberIds(MEMBER_ID);
                
                $ids[] = MEMBER_ID;
                
                $where['m.leader_id'] = ['in', $ids];
                
            } else {
                
                $where['m.leader_id'] = MEMBER_ID;
            }
        }
        
        return $where;
    }
    
    /**
     * 获取存在继承关系的会员ids
     */
    public function getInheritMemberIds($id = 0, $data = [])
    {
        
        $member_id = $this->modelMember->getValue(['id' => $id, 'is_share_member' => DATA_NORMAL], 'leader_id');
        
        if (empty($member_id)) {
            
            return $data;
        } else {
            
            $data[] = $member_id;
            
            return $this->getInheritMemberIds($member_id, $data);
        }
    }
    
    /**
     * 获取会员的所有下级会员
     */
    public function getSubMemberIds($id = 0, $data = [])
    {
        
        $member_list = $this->modelMember->getList(['leader_id' => $id], 'id', 'id asc', false);
        
        foreach ($member_list as $v)
        {
            
            if (!empty($v['id'])) {
                
                $data[] = $v['id'];
            
                $data = array_unique(array_merge($data, $this->getSubMemberIds($v['id'], $data)));
            }
            
            continue;
        }
            
        return $data;
    }
    
    /**
     * 会员添加到用户组
     */
    public function addToGroup($data = [])
    {
        
        $url = url('memberList');
        
        if (SYS_ADMINISTRATOR_ID == $data['id']) {
            
            return [RESULT_ERROR, '天神不能授权哦~', $url];
        }
        
        $where = ['member_id' => ['in', $data['id']]];
        
        $this->modelAuthGroupAccess->deleteInfo($where, true);
        
        if (empty($data['group_id'])) {
            
            return [RESULT_SUCCESS, '会员授权成功', $url];
        }
        
        $add_data = [];
        
        foreach ($data['group_id'] as $group_id) {
            
            $add_data[] = ['member_id' => $data['id'], 'group_id' => $group_id];
        }
        
        if ($this->modelAuthGroupAccess->setList($add_data)) {
            
            action_log('授权', '会员授权，id：' . $data['id']);
        
            $this->logicAuthGroup->updateSubAuthByMember($data['id']);
            
            return [RESULT_SUCCESS, '会员授权成功', $url];
        } else {
            
            return [RESULT_ERROR, $this->modelAuthGroupAccess->getError()];
        }
    }
    
   
    
    /**
     * 会员编辑
     */
    public function memberEdit($data = [])
    {
        
       // $validate_result = $this->validateMember->scene('edit')->check($data);
        
        // if (!$validate_result) {
            
        //     return [RESULT_ERROR, $this->validateMember->getError()];
        // }
        
      if(!$data['password']){
        $man=M('member')->where('id='. $data['id'])->find();
        $data['password']= $man['password'];
      }
        
        $url = url('memberList');
        
        $result = $this->modelMember->setInfo($data);
        
        $result && action_log('编辑', '编辑会员，id：' . $data['id']);
        
        return $result ? [RESULT_SUCCESS, '会员编辑成功', $url] : [RESULT_ERROR, $this->modelMember->getError()];
    }
    
    /**
     * 设置会员信息
     */
    public function setMemberValue($where = [], $field = '', $value = '')
    {
        
        return $this->modelMember->setFieldValue($where, $field, $value);
    }
    
    /**
     * 会员删除
     */
    public function memberDel($where = [])
    {
        
        $url = url('memberList');
        
        if (SYS_ADMINISTRATOR_ID == $where['id'] || MEMBER_ID == $where['id']) {
            
            return [RESULT_ERROR, '天神和自己不能删除哦~', $url];
        }
        
        $result = $this->modelMember->deleteInfo($where);
                
        $result && action_log('删除', '删除会员，where：' . http_build_query($where));
        
        return $result ? [RESULT_SUCCESS, '会员删除成功', $url] : [RESULT_ERROR, $this->modelMember->getError(), $url];
    }


//拿奖$lrsid与$p_level层左右判断方法
    public function lrjudgeway($l_rs,$p_level)
    {
        $j=0;
        foreach ($l_rs as $voo) {
            $l_id=$voo['id'];
            $lnn = $this->where('(p_path like "%,' . $l_id . ',%" or id=' . $l_id . ') and is_pay>0 and p_level=' . $p_level)->count();//取出p层中，这条路径的数目
            if ($lnn > 0) {
                if ($j == 0) {
                    $lcpzj = $this->where('(p_path like "%,' . $l_id . ',%" or id=' . $l_id . ') and is_pay>0 and p_level=' . $p_level)->min('pdt');  //左边p层中，最小的注册金额的值
                    $lrcpj[] = $this->where('(p_path like "%,' . $l_id . ',%" or id=' . $l_id . ')and pdt=' . $lcpzj . ' and is_pay>0 and p_level=' . $p_level)->min('cpzj');
                } else {
                    $rcpzj = $this->where('(p_path like "%,' . $l_id . ',%" or id=' . $l_id . ') and is_pay>0 and p_level=' . $p_level)->min('pdt');//右边p层中，最小限制为'cpzj的值
                    $lrcpj[] = $this->where('(p_path like "%,' . $l_id . ',%" or id=' . $l_id . ')and pdt=' . $rcpzj . ' and is_pay>0 and p_level=' . $p_level)->min('cpzj');
                }
                $j++;
                $lrcpj[]=$j;
            }
        }
        return $lrcpj;
    }

}
