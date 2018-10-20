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
    

// 获取当前用户的ID
    public $feeratio;
    public function __construct($feeratio) {
            parent::__construct($feeratio); 
            $this->feeratio = $feeratio;

    }


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
      
        //推荐路径
        $re_man=M('member')->where('user_id="'.$data['re_uid'].'"')->find();
        $data['re_id']  = $re_man['id'];
        $data['re_level']  = $re_man['re_level']+1;
        $data['re_path']  = $re_man['re_path'].','.$re_man['id'];
        $data['is_pay']  = 0;
        $data['nickname']  = $data['username'];
        $data['user_id']  = $data['username'];
        $data['leader_id'] = MEMBER_ID;
        $data['is_inside'] = DATA_NORMAL;
        $data['treeplace']  = $data['TPL'];
       
        $data=array_filter($data);
        $result = $this->modelMember->setInfo($data);
        $result && action_log('新增', '新增会员，username：' . $data['username']);
        
        return $result ? [RESULT_SUCCESS, '会员添加成功', $url] : [RESULT_ERROR, $this->modelMember->getError()];
    }
    
      
 //统计单数
    public function jiandan($lrs,$man){
            $Fid= $lrs['id'];
            $ppath=$man['p_path'];
            $cpzj=$man['cpzj'];
            $treeplace=$man['treeplace']; 
         if($treeplace==0&& $Fid> 0){  
 M('member')->execute("update xt_member Set `zone_a`=zone_a+".$cpzj." where `id`=".$Fid);
 M('member')->execute("update xt_member Set `l`=l+".$cpzj." where `id`=".$Fid);
 $this->addencAdd($lrs,$cpzj,90,$man);

             }elseif($treeplace==1&& $Fid> 0){ 
            M('member')->execute("update xt_member Set `zone_b`=zone_b+1 where `id`=".$Fid);
             }elseif($treeplace==2&& $Fid> 0){ 

M('member')->execute("update xt_member Set `zone_c`=zone_c+".$cpzj." where `id`=".$Fid);
M('member')->execute("update xt_member Set `r`=r+".$cpzj." where `id`=".$Fid);
$this->addencAdd($lrs,$cpzj,91,$man);

             }
             $treeplace=$lrs['treeplace'];
    }


 //接点方法，遍历出接点路径上的id
    public function juncway($man){  
     $lirs = M('member') ->where('id','in',$man['p_path'])->order('p_level desc')->select();
        foreach ($lirs as $lrs){//遍历出接点路径上的id  
        //$this->jiandan($lrs,$man); //统计单数 
       // $this->achieve($lrs);
       // $this->see_you($lrs,$man); //统计单数 
        }

    }

  
   public function recoway($man,$params){
       //1静态收益
        $money=$this->feeratio['statistic_income'][0]; 
        $this->rw_bonus_inc($man,1,$money,$man);
        $this->bonus($man,$money, TIME_NOW, 'b1');
        M('member')->where('id='.$man['id'])->setinc('b6',$money);
       //  //dynamic_income
        //推荐路径
        $map['id']  = array('in',$man['re_path']);
        $map['is_pay']  = 1;
        $lirs = $this->where($map)->order('re_level desc')->select();
        foreach ($lirs as $lrs){
        $this->dynamic_income($man,$lrs);
       }
   }

//2动态奖
 public function dynamic_income($man,$lrs){
      $x_level=$man['re_level']-$lrs['re_level']+1;
      $money=$this->feeratio['dynamic_income'][$x_level];
       if($money>0){
      $this->rw_bonus_inc($lrs,2,$money,$man);
      $this->bonus($lrs,$money, TIME_NOW, 'b2');
       }
   }



   
//先扣，然后发
 public function rw_bonus_dec($my,$bnum=0,$money_count=0,$man){
        
      if($money_count>0){  $this->addencAdd($my,-$money_count,$bnum,$man);  }
        //50-充值奖金币|30-转账奖金币|21-激活会员
      if($bnum==21||$bnum==30||$bnum==11){
        $bnum=0;
      }
     M('member')->where('id='.$my['id'])->setDec('b'.$bnum,$money_count);
    }
   
//先扣，然后发
 public function rw_bonus_inc($my,$bnum=0,$money_count=0,$man){


       if($money_count>0){


        $this->addencAdd($my,$money_count,$bnum,$man); }
        //50-充值奖金币|30-转账奖金币|21-激活会员
      // if($bnum==50||$bnum==30||$bnum==1||$bnum==3||$bnum==4||$bnum==5||$bnum==6){
      // $bnum=0;
      // $money=$this->feeratio['tax'][0]*$money_count/100;
      // $this->rw_bonus_dec($my,11,$money,$my);
      // }
      if($bnum==30){
         $bnum=0;
      }
      if($bnum==2||$bnum==1){
      M('member')->where('id='.$my['id'])->setInc('b0',$money_count);
      }
      $usqlc .= "b".$bnum."=b".$bnum."+".$money_count." ";          //
      $this->execute("update xt_member set ".$usqlc." where id='".$my['id']."'"); 
    }

public function addencAdd($my,$money=0,$name=null,$man=0,$params){
       
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
        if(!empty($params['bz'])){
            $data['bz']         = $bz;
        }else{
            $data['bz']         = NULL;
        }
        
      if(!empty($params['task'])){
            $data['task']=$params['task'];
        }else{
            $data['task']      = NULL;
        }

      if(!empty($params['task_type'])){
            $data['task_type']=$params['task_type'];
        }else{
            $data['task_type']      = '';
        }


       if(!empty($params['img_ids'])){
                  $data['img_ids']=$params['img_ids'];
              }else{
                  $data['img_ids']      = '';
              }

        if(!empty($params['status'])){
            $data['status']=$params['status'];
        }else{
            $data['status']      = 0;
        }

        $data['did']            = $man['id'];
        $data['type']           = 1;
        $data['allp']           = 0;
        if($params['act_pdt']>0){
            $data['act_pdt']    = $params['act_pdt'];
        }

      //  var_dump( $data);
        $result = M('history')->insert($data);
       /// var_dump( $result); /// var_dump( $result);
        unset($data,$history);


    }








  public function bonus($member, $money_count, $time, $field){
      if($field!='b2'){
     $money=(100-$this->feeratio['tax'][0])*$money_count/100;
     }else{
        $money=$money_count;
     }
    // 获取期号
    $times_id = $this->logicTimes->getIdByTime($time);
    $where['member_id']=$member['id'];
    $where['times_id']=$times_id;

    $bonus = $this->modelBonus->getInfo($where);

    if (!$bonus) {
      $data = [
        'times_id'  => $times_id,
        'member_id' => $member['id'],
        'username'  => $member['username'],
        $field    => $money,
      ];
      return $this->modelBonus->addInfo($data, true);
    }else{
      $da=$bonus[$field]+ $money;
      return M('bonus')->where('id='.$bonus['id'])->setfield($field,$da);
    }
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
     * 获取提现列表
     */
  public function getdrawalList($where = [], $field, $order = '', $paginate = DB_LIST_ROWS)
    {
        $bankArrTemp=array('01020000'=>'中国工商银行','01030000'=>'中国农业银行','01040000'=>'中国银行','01050000'=>'中国建设银行','03010000'=>'中国交通银行','03020000'=>'中信银行','03030000'=>'光大银行','03040000'=>'华夏银行','03050000'=>'民生银行','03060000'=>'广发银行','03080000'=>'招商银行','03090000'=>'兴业银行','03100000'=>'上海浦东发展银行','03130011'=>'北京银行','03130031'=>'上海银行','03134402'=>'平安银行','03150000'=>'恒丰银行','04030000'=>'中国邮政储蓄银行');

        $data =$this->modelDraw->getList($where, $field, $order, $paginate, $join);
        $rel = [];

        $status[0]='申请中';
        $status[1]='已通过';
        $status[2]='已驳回';
        foreach($data as $v){
            $v['afternum']=$v['num']*0.8;
            $v['ctime']=date('Y-m-d H:i:s',$v['ctime']);
            $v['status']= $status[$v['status']];
            $v['username']=M('member')->where('id',$v['uid'])->value('username');
            if($v['kaihu']=='快捷'){
                $v['bank']=$bankArrTemp[$v['bank']];
            }
            $rel[] = $v;
        }
        return $rel;
    }


 /**
     * 导出提现列表
     */
public function exportdrawalList($where = [], $field = '*', $order = '')
    {
        $list = $this->getdrawalList($where, $field, $order, false);
        $titles = "编号,账号,姓名,银行卡账号,银行,开户行,申请金额,应发金额,时间,状态";
        $keys   = "id,username,name,card,bank,kaihu,num,afternum,ctime,status";
        action_log('导出', '导出提现列表');
        export_excel($titles, $keys, $list, '提现列表');
    }
    







     /**
     * 获取充值表
     */
  public function getchargeList($where = [], $field, $order = '', $paginate = DB_LIST_ROWS)
    {

        $where['uid']=['>',0];
        $where['action_type']=['=',50];
        $list=$this->logicshop->history($where);
      
        $rel = [];
         $status[0]='申请中';
        $status[1]='已通过';
        $status[2]='已驳回';
        foreach($list as $v){
            $v['afternum']=$v['epoints']*0.8;
            $v['ctime']=date('Y-m-d H:i:s',$v['pdt']);
            $v['username']=$v['user_id'];
            $v['name']=$v['user_id'];
            $v['num']=$v['epoints'];
             $v['num']=$v['epoints'];
             $v['status']= $status[$v['status']];
            $rel[] = $v;
        }
        return $rel;
    }



 /**
     * 导出充值列表
     */
public function exportchargeList($where = [], $field = '*', $order = '')
    {
        $list = $this->getchargeList($where, $field, $order, false);
        $titles = "编号,账号,姓名,申请金额,应发金额,时间,状态";
        $keys   = "id,username,name,num,afternum,ctime,status";
        action_log('导出', '导出充值列表');
        export_excel($titles, $keys, $list, '充值列表');
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
 
}
