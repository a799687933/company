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
use app\admin\service\GoodsService;
/**
 * 首页控制器
 */
class Index extends AdminBase
{
    
    /**
     * 首页方法
     */
    public function index()
    {
        //var_dump($this->feeratio);
        // 获取首页数据
        //$index_data = $this->logicAdminBase->getIndexData();
        $info=M('member')->where('id='.session('member_info')['id'])->find();
        $this->mr_fenhong();

        $info['u_level']=$this->feeratio['is_agent'][$info['is_agent']];
        $this->assign('info',$info);
        return $this->fetch('index');
    }

     public function info_edit()
    {
    $params=$this->request->param();
    $RE=M('member')->where('id='.session('member_info')['id'])->update($params);
    if($RE){
    $this->success('资料修改成功');}else{
    $this->error('资料未修改！！');
    }
  }


  /**
     * 会员添加
     */
       public function member_add()
    {
        
        IS_POST && $this->jump($this->logicMember->memberAdd($this->param));
        $this->assign('cpzj',$this->feeratio['cpzj']);
        $this->assign('treeplace',$this->feeratio['treeplace']);
        
            $re_id=(int)input('param.RID');
            if(!(int)input('param.RID')){$re_id=1;}
            //$agent_uid=(int)input('param.agent_uid');
            $father_id=(int)input('param.FID');
            $treeplace=(int)input('param.TPL');
            for($i=0;$i<5;$i++){
                $TPL[$i] = '';
            }
            $TPL[$treeplace] = 'selected="selected"';
         
        $re_uid=M('member')->where('id='.$re_id)->find();
        $father_uid=M('member')->where('id='.$father_id)->find();
      
        $this->assign('father_uid',$father_uid['user_id']);
        $this->assign('re_uid',$re_uid['user_id']);
        $this->assign('TPL',$TPL);
        $this->assign('rand',rand(1,999999));
        return $this->fetch('member_add');
    }
    



//每日分红
    public function mr_fenhong(){
      $nowtime = strtotime(date('Y-m-d'));
      $everyday_time = $this->feeratio['everyday_time'][0];
      $ratio=$this->feeratio['s_ratio'];
        if($everyday_time<$nowtime){
            M('config')->where('id=75')->setField('value',$nowtime);
              $list = M('member')->where('is_pay>0')->select();      
              if($list){
                      foreach ($list as $lrs) {
                      $money_count=$ratio[$lrs['cpzj']]*$lrs['cpzj']/1000;
                      $this->logicmember->rw_bonus_inc($lrs,2,$money_count,$lrs);  
                      $this->logicmember->bonus($lrs,$money_count,TIME_NOW,'b2'); 
                   } 
             }
         }
    }
















}
