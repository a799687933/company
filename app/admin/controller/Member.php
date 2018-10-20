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
use think\Db;
use app\admin\logic\Member as  LogicMember;
/**
 * 会员控制器
 */
class Member extends AdminBase
{

    /**
     * 会员授权
     */
    public function memberAuth()
    {
        
        IS_POST && $this->jump($this->logicMember->addToGroup($this->param));
        
        // 所有的权限组
        $group_list = $this->logicAuthGroup->getAuthGroupList(['member_id' => MEMBER_ID]);
        
        // 会员当前权限组
        $member_group_list = $this->logicAuthGroupAccess->getMemberGroupInfo($this->param['id']);

        // 选择权限组
        $list = $this->logicAuthGroup->selectAuthGroupList($group_list, $member_group_list);
        
        $this->assign('list', $list);
        
        $this->assign('id', $this->param['id']);
        
        return $this->fetch('member_auth');
    }
    
    /**
     * 会员列表
     */
   public function memberList()
    {
       
         
     
         $is_agent=$this->feeratio['is_agent'];
         $list=$this->logicMember->getMemberList($where);
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
     * 会员导出
     */
    public function exportMemberList()
    {
        
        $where = $this->logicMember->getWhere($this->param);
        
        $this->logicMember->exportMemberList($where);
    }
    /**
     * 提现导出
     */

   public function exportdrawalList()
    {
        
        $where = $this->logicMember->getWhere($this->param);
        
        $this->logicMember->exportdrawalList($where);
    }
    

 /**
     * 充值导出
     */

   public function exportchargeList()
    {
        
        $where = $this->logicMember->getWhere($this->param);
        
        $this->logicMember->exportchargeList($where);
    }
    










    /**
     * 会员添加
     */
  


    public function activate(){
      $param=$this->request->param();
      $man= M('member')->where('id='.$param['id'])->find();
     if($man['cpzj']>$this->user['b0']){
      return $this->error('激活失败,金额不足');
     }


      $menus=new  LogicMember($this->feeratio);
      $this->logicMember->rw_bonus_dec($this->user,21,$man['cpzj'],$man);
     //  $menus->recoway($man);
    //  $menus->juncway($man);
     // $menus->agent_center($man);
    
     //激活状态
      M('member')->where('id='.$param['id'])->setInc('is_pay');
       return $this->success('激活成功');
     }








    /**
     * 会员编辑
     */
    public function memberEdit()
    {
        
        IS_POST && $this->jump($this->logicMember->memberEdit($this->param));
        
        $info = $this->logicMember->getMemberInfo(['id' => $this->param['id']]);
        
        $this->assign('info', $info);
        
        return $this->fetch('member_edit');
    }
    
    /**
     * 会员删除
     */
    public function memberDel($id = 0)
    {
         Db::name('member')->where('id='.$id )->delete();
         return $this->success('成功！');
    }
     // 清空数据库
    public function clean(){
        Db::name('member')->where('id>1')->delete();
       // Db::name('shop')->delete(true);
        Db::name('shop_car')->delete(true);
        Db::name('shop_order')->delete(true);
        Db::name('history')->delete(true);
        Db::name('bonus')->delete(true);
        Db::name('times')->delete(true);
        Db::name('draw')->delete(true);
        
         Db::name('auth_group_access')->delete(true);
        $member=$this->user;
       // $member=array_remove($member,'id');
        for ($i = 0; $i <= 22; $i++) { 
            $bx = 'b'.$i;
             $member[$bx] = 0;
        }

         $member['re_nums']=666;
         $member['b0']=100000;
         $member['ad_bag']=0;
         $member['cpzj']=10000;
         $member['b1']=0;
         $member['is_agent']=0;
         $member['zone_a']=0;
         $member['zone_b']=0;
         $member['zone_c']=0;
         $member['l']=0;
         $member['r']=0;
         $member['is_agent']=2;
        Db::name('member')->where('id>=1')->update($member);
        return $this->success('清空数据库成功！', 'index/index');
    }

}
