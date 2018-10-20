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
use app\admin\logic\Member;

/**
 * 文章控制器
 */
class Shopadmin extends AdminBase
{
   

 public function charge(){

        $user = input('get.user');
        $type = input('type');
        $status = input('status');
        $pageParam=['query'=>[]];
        $where='';

        if(is_numeric($type)){
            $pageParam['query']['type']=$type;
            if($where){
                $where .= " type = '$type'";
            }else{
                $where .= " type = '$type'";
            }
        }

        if(is_numeric($status)){
            $pageParam['query']['status']=$status;
            if($where){
                $where .= " status = '$status'";
            }else{
                $where .= " status = '$status'";
            }
        }

        if($user){
            $uid=Db::name('member')->where('username',$user)->value('id');
            if(!$uid){
                $this->error($user.'没有记录');
            }
            $pageParam['query']['user']=$user;
            if($where){
                $where .= " and uid = $uid";
            }else{
                $where = " uid = $uid";
            }
        }

        $re_id=session('member_info')['id'];
        $variable=M('member')->where("re_id=".$re_id)->select();
        foreach ($variable as $key => $value) {
            $b_re_id[$key]=$value[id];
        }
         $where['uid']=['>',0];
         $where['action_type']=['=',50];
        $list=$this->logicshop->history($where,5);
       $this->assign('type_arr',$this->feeratio['type_name']); 
        $rel = [];
        foreach($list as $v){

            $v['afternum']=$v['epoints']*0.8;
            $v['ctime']=date('Y-m-d H:i:s',$v['pdt']);
            $v['username']=$v['user_id'];
            $v['name']=$v['user_id'];
            $v['num']=$v['epoints'];
             $v['num']=$v['epoints'];
            $rel[] = $v;
        }

        $this->assign('page',$list);
        $this->assign('data',$rel);
        return $this->fetch('shopadmin/charge');
    }




 public function charge_insert(){

    $params = $this->request->param();
    $id =input('id');
    $status = input('status');
    $text = input('text');

    if($params['type']){
     M('history')->where("id=".$id)->setField('status',2);
     M('history')->where("id=".$id)->setField('text', $text);
    $this->success('驳回成功');
    }
   if(!$params['type']){
    M('history')->where("id=".$id)->setField('status',1);
    $his=M('history')->where("id=".$id)->find();
    M('member')->where("id=".$his['uid'])->setInc('b0',$his['epoints']);
    $this->success('通过成功');
    }
 }





public function task(){

        $user = input('get.user');
        $type = input('type');
        $status = input('status');
        $pageParam=['query'=>[]];
        $where='';

        if(is_numeric($type)){
            $pageParam['query']['type']=$type;
            if($where){
                $where .= " type = '$type'";
            }else{
                $where .= " type = '$type'";
            }
        }

        if(is_numeric($status)){
            $pageParam['query']['status']=$status;
            if($where){
                $where .= " status = '$status'";
            }else{
                $where .= " status = '$status'";
            }
        }

        if($user){
            $uid=Db::name('member')->where('username',$user)->value('id');
            if(!$uid){
                $this->error($user.'没有记录');
            }
            $pageParam['query']['user']=$user;
            if($where){
                $where .= " and uid = $uid";
            }else{
                $where = " uid = $uid";
            }
        }

        $re_id=session('member_info')['id'];
        $variable=M('member')->where("re_id=".$re_id)->select();
        foreach ($variable as $key => $value) {
            $b_re_id[$key]=$value[id];
        }
         $where['uid']=['>',0];
         $where['action_type']=['=',61];
        $list=$this->logicshop->history($where,5);
       $this->assign('type_arr',$this->feeratio['type_name']); 
        $rel = [];


        foreach($list as $v){
            $v['afternum']=$v['epoints'];
            $v['ctime']=date('Y-m-d H:i:s',$v['pdt']);
            $v['username']=$v['user_id'];
            $v['name']=$v['user_id'];
            $v['num']=$v['epoints'];
            $v['num']=$v['epoints'];
            $rel[] = $v;
        }

        $this->assign('page',$list);
        $this->assign('data',$rel);
        return $this->fetch();
    }


public function task_insert(){

    $params = $this->request->param();
    $id =input('id');
    $status = input('status');
    $text = input('text');

    if($params['type']){
     M('history')->where("id=".$id)->setField('status',2);
     M('history')->where("id=".$id)->setField('text', $text);
    $this->success('驳回成功');
    }
      $re= M('history')->where("id=".$id)->find();
       if(!$params['type']){
        $r=$this->feeratio;
        $member=new  Member($r);
            $today = strtotime(date("Y-m-d"),time());
            $today_end = strtotime(date("Y-m-d"),time())+3600*24;
            $where['uid']=$re['uid'];
            $where['action_type']=61;
            $where['pdt']=array('between',array($today,$today_end));
            $where['task_type']='task';
            $where['status']='1';


            //任务一领了么
           $today_submit=M('history')->where($where)->find();
            $where['task_type']='task2';
           $today_submit2=M('history')->where($where)->find();

                if($today_submit2||$today_submit){
                $his=M('history')->where("id=".$id)->find();
                $man=M('member')->where("id=".$his['uid'])->find();
                $member->recoway($man);
               }
            M('history')->where("id=".$id)->setField('status',1);    
          $this->success('通过成功');
        }
 }
















     public function drawal(){

        $user = input('get.user');
        $type = input('type');
        $status = input('status');
        $pageParam=['query'=>[]];
        $where='';

        if(is_numeric($type)){
            $pageParam['query']['type']=$type;
            if($where){
                $where .= " type = '$type'";
            }else{
                $where .= " type = '$type'";
            }
        }

        if(is_numeric($status)){
            $pageParam['query']['status']=$status;
            if($where){
                $where .= " status = '$status'";
            }else{
                $where .= " status = '$status'";
            }
        }

        if($user){
            $uid=Db::name('member')->where('username',$user)->value('id');
            if(!$uid){
                $this->error($user.'没有记录');
            }
            $pageParam['query']['user']=$user;
            if($where){
                $where .= " and uid = $uid";
            }else{
                $where = " uid = $uid";
            }
        }


        $bankArrTemp=array('01020000'=>'中国工商银行','01030000'=>'中国农业银行','01040000'=>'中国银行','01050000'=>'中国建设银行','03010000'=>'中国交通银行','03020000'=>'中信银行','03030000'=>'光大银行','03040000'=>'华夏银行','03050000'=>'民生银行','03060000'=>'广发银行','03080000'=>'招商银行','03090000'=>'兴业银行','03100000'=>'上海浦东发展银行','03130011'=>'北京银行','03130031'=>'上海银行','03134402'=>'平安银行','03150000'=>'恒丰银行','04030000'=>'中国邮政储蓄银行');


        $data = Db::name('draw')->where($where)->order('id desc')->paginate(20,false,$pageParam);

        $rel = [];
        foreach($data as $v){

            $v['afternum']=$v['num']*0.8;
            $v['ctime']=date('Y-m-d H:i:s',$v['ctime']);
            $v['username']=Db::name('member')->where('id',$v['uid'])->value('username');
            if($v['kaihu']=='快捷'){
                $v['bank']=$bankArrTemp[$v['bank']];
            }
            $rel[] = $v;
        }

        $this->assign('page',$data);
        $this->assign('data',$rel);
        return $this->fetch('shopadmin/drawal');
    }


public function insert(){

  $params = $this->request->param();
    $id =input('id');
    $status = input('status');
    $text = input('text');

    if($params['type']){
     M('draw')->where("id=".$id)->setInc('status',2);
     M('draw')->where("id=".$id)->setField('text', $text);
    $this->success('驳回成功');
    }
   if(!$params['type']){
    M('draw')->where("id=".$id)->setInc('status',1);
    $his=M('draw')->where("id=".$id)->find();
    //M('drawal')->where("id=".$his['uid'])->setInc('b0',$his['epoints']);
    $this->success('通过成功');
    }
 }















    public function detail(){

        $id =input('id');
        $data = Db::name('draw')->where(['id'=>$id])->find();
        $data['username']=Db::name('member')->where('id',$data['uid'])->value('username');
        $data['ctime']=date('Y-m-d H:i:s',$data['ctime']);

       // $bankinfo = DB::name('banks')->where('uid',$data['uid'])->order('id desc')->find();

        // $bankArrTemp=array('01020000'=>'中国工商银行','01030000'=>'中国农业银行','01040000'=>'中国银行','01050000'=>'中国建设银行','03010000'=>'中国交通银行','03020000'=>'中信银行','03030000'=>'光大银行','03040000'=>'华夏银行','03050000'=>'民生银行','03060000'=>'广发银行','03080000'=>'招商银行','03090000'=>'兴业银行','03100000'=>'上海浦东发展银行','03130011'=>'北京银行','03130031'=>'上海银行','03134402'=>'平安银行','03150000'=>'恒丰银行','04030000'=>'中国邮政储蓄银行');

        // if($data['type']==1){
        //     $data['bank']=$bankArrTemp[$data['bank']];
        //     $data['afternum']=(intval(floor(($data['num'] * 100) * 0.8015))-300)/100;
        // }else{
        //     $data['afternum']=$data['num']*0.8;
        // }

        // $data['custid']=$bankinfo['custid'];
        // if($bankinfo['isjb']==0&&$bankinfo['status']==1){
        //     $data['bk']='已绑卡';
        // }else{
        //     $data['bk']='未绑卡';
        // }

        $this->assign('data',$data);
        return $this->fetch();
    }

 
    /**
     * 文章列表
     */
    public function shopList()
    {
        
        $where = $this->logicShop->getWhere($this->param);
       
        $this->assign('list', $this->logicShop->getShopList($where, 'a.*,m.nickname,c.name as category_name', 'a.create_time desc'));
        
        return $this->fetch('shop_list');
    }
    
    /**
     * 文章添加
     */
    public function shopAdd()
    {
        
        $this->shopCommon();
        
        return $this->fetch('shop_edit');
    }
    
    /**
     * 文章编辑
     */
    public function shopEdit()
    {
        
        $this->shopCommon();
        
        $info = $this->logicShop->getShopInfo(['a.id' => $this->param['id']], 'a.*,m.nickname,c.name as category_name');
        
        !empty($info) && $info['img_ids_array'] = str2arr($info['img_ids']);
      

       // $info['cost']=html_entity_decode($info['cost']);
        $this->assign('info', $info);
        
        return $this->fetch('shop_edit');
    }
    
    /**
     * 文章添加与编辑通用方法
     */
    public function shopCommon()
    {
        
        IS_POST && $this->jump($this->logicShop->shopEdit($this->param));
        
        $this->assign('shop_category_list', $this->logicShop->getShopCategoryList([], 'id,name', '', false));
    }
    
    /**
     * 文章分类添加
     */
    public function shopCategoryAdd()
    {
        
        IS_POST && $this->jump($this->logicShop->shopCategoryEdit($this->param));
        
        return $this->fetch('shop_category_edit');
    }
    
    /**
     * 文章分类编辑
     */
    public function shopCategoryEdit()
    {
        
        IS_POST && $this->jump($this->logicShop->shopCategoryEdit($this->param));


        
        $info = $this->logicShop->getShopCategoryInfo(['id' => $this->param['id']]);
        
        $this->assign('info', $info);
        
        return $this->fetch('shop_category_edit');
    }
    
    /**
     * 文章分类列表
     */
    public function shopCategoryList()
    {
        
        $this->assign('list', $this->logicShop->getShopCategoryList());
       
        return $this->fetch('shop_category_list');
    }
    
    /**
     * 文章分类删除
     */
    public function shopCategoryDel($id = 0)
    {
        
        $this->jump($this->logicShop->ShopCategoryDel(['id' => $id]));
    }
    
    /**
     * 数据状态设置
     */
    public function setStatus()
    {
        
        $this->jump($this->logicAdminBase->setStatus('Shop', $this->param));
    }


}
