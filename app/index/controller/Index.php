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
class Index extends IndexBase
{
    
    // 首页
    public function index($cid = 0)
    {
       
      // 关闭布局
        $this->view->engine->layout(false);
       

        if($this->request->param()['category_id']<=0){
        $where = $this->logicShop->getWhere($this->param);}else{
        $where['category_id']=$this->request->param()['category_id'];}
        $params['selling'] = 1;

        $list= $this->logicShop->getShopList($where, 'a.*,m.nickname,c.name as category_name', 'a.create_time desc',12,'price asc');

         $lists=$list;
         foreach ($list as $key => $value) {
            if($value['price']<1000){
            unset($lists[$key]);
            }
          }
        $this->assign('list', $lists);
        $this->assign('banner1', config('banner1'));
        $this->assign('banner2', config('banner2'));
        $this->assign('banner3', config('banner3'));
        $this->assign('banner', explode(",",config('banner')));
         $this->assign('banner_url', $this->feeratio['banner_url']);
      //$this->_messagesAdd();
        return $this->fetch('index');
    }
    
   // 案例
    public function case_detail(){
        // 关闭布局
         $this->view->engine->layout(false);
         $this->assign('category', M('ShopCategory')->where('status=0')->select());
        if($this->request->param()['category_id']<=0){
        $where = $this->logicShop->getWhere($this->param);}else{
        $where['category_id']=$this->request->param()['category_id'];}
        //$params['selling'] = 1;
        $list= $this->logicShop->getShopList($where, 'a.*,m.nickname,c.name as category_name', 'a.create_time desc',1002,'price asc');

          foreach ($list as $key => $value) {
            if($value['price']>=1000){
              $value['price']= $value['price']-1000;  
            } 
              $lis[$key]= json_decode(json_encode($value),TRUE);
          } 
           array_multisort(array_column($lis,'price'),SORT_ASC,$lis);
         // var_dump($lis);die;
          $this->assign('lis', $lis);
          $this->assign('list', $list);
          $this->assign('case_banner', config('case_banner'));
          $this->assign('mobile_case_banner', config('mobile_case_banner'));
        return $this->fetch();
    }
    
 


public function service(){
        // 关闭布局
        $this->view->engine->layout(false);
         $this->assign('service_banner', config('service_banner'));
          $this->assign('mobile_service_banner', config('mobile_service_banner'));
            return $this->fetch();
        }
    


 public function about(){
    // 关闭布局
        $this->view->engine->layout(false);
        $this->assign('about_banner', config('about_banner'));
          $this->assign('mobile_about_banner', config('mobile_about_banner'));
        return $this->fetch();
    }



   public function details(){
        // 关闭布局
        $this->view->engine->layout(false);
        $this->assign('category', M('ShopCategory')->where('status=0')->select());
        //dump(M('ShopCategory')->where('status=0')->select());
        if($this->request->param()['category_id']<=0){
        $where = $this->logicShop->getWhere($this->param);}else{
        $where['category_id']=$this->request->param()['category_id'];}
        //$params['selling'] = 1;
        $list= $this->logicShop->getShopList($where, 'a.*,m.nickname,c.name as category_name', 'a.create_time desc',6);
        // var_dump($where,$list);
        $this->assign('list', $list);
         $info = $this->logicShop->getShopInfo(['a.id' => $this->param['id']], 'a.*,m.nickname,c.name as category_name');
        !empty($info) && $info['img_ids_array'] = str2arr($info['img_ids']);
        $ordernum[0]=0;
        session('member_info') &&$ordernum[0]=M('shop_car')->where('uid='.session('member_info')['id'])->count();
        $this->assign('info', $info);
        $this->assign('ordernum',$ordernum);
            return $this->fetch();
        }



public function messagesAdd($UserID='0',$Title='',$Msg=''){
        //var_dump($params);die;


        $params=$this->request->param();
      //var_dump($params);die;
        $member = M('member');
        $Users = M('Msg');
        $where = array();
        $ID =100000;
        $Msg='姓名：'.$params['name'].' ，
        电话：'.$params['phone'].'
        邮箱：'.$params['mail'].'
        内容：'.$params['content'].'';
        $Title='访客留言';
        $UserID='100000';

        // //收件人
        // $where1 = array();
        // $where1['user_id'] = $UserID;
        // if($UserID == '公司'){
        //  $gsrs = M('member')->where('id=1')->field('user_id')->find();
        //  $where1['user_id'] = $gsrs['user_id'];
        // }
        

        // $vo = $member->where($where1)->find();
        if (!$params['content']){
            $this->error('不能空提交');
            exit;
         }
        // if($ID>1){
        //  if($ID == $vo['id']){
        //      $this->error('不能给自已发邮件！');
        //      exit;
        //  }
        // }

         //$this->error('别提交了,烦');
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
        $nowdate = strtotime(date('c'));
        $vo=M('member')->find();
        $vo2=M('member')->find();
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
     
        
        if ($rs1){
            //提交事务
          
            $this->success('留言成功！');
            exit;
        }else{
            //事务回滚：
          
            $this->error('操作失败');
           
        }
    }












































 public function show(){
        $info = $this->logicShop->getShopInfo(['a.id' => $this->param['id']], 'a.*,m.nickname,c.name as category_name');
        !empty($info) && $info['img_ids_array'] = str2arr($info['img_ids']);
        $ordernum[0]=0;
        session('member_info') &&$ordernum[0]=M('shop_car')->where('uid='.session('member_info')['id'])->count();
        $this->assign('info', $info);
        $this->assign('ordernum',$ordernum);
        return $this->fetch();
    }

 public function cart_add(){
     !session('member_info') && $this->redirect('admin/login/login');
    $this->jump($this->logicShop->car_add($this->param));
    }
/**
     * 会员添加
     */
    public function member_add()
    {
        
        $menus=new  Member;

        $index=100;//前台标记
    


        IS_POST && $this->jump($menus->memberAdd($this->param),$index);
        $this->assign('cpzj',$this->feeratio['cpzj']);
        $this->assign('treeplace',$this->feeratio['treeplace']);
        
            $re_id=(int)input('param.RID');
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
        $this->assign('rand',rand(1,2099998889));
        return $this->fetch('member_add');
    }


  //首页产品
    public function indexjson(){

       
       $data =$this->logicShop->getShopList($where, 'a.*,m.nickname,c.name as category_name', 'a.create_time desc',$this->request->param()[page]);
     //  var_dump($data[0]);
        if($data[0]){
            foreach($data as $v){
                    $v['url']='/index/index/show/id/'.$v['id'].'.html';
                    $v['cover']=M('picture')->where('id='.$v['cover_id'])->find()['path'];
                $rel[] = $v;
            }
            return json(['data'=>$rel,'code'=>1,'msg'=>'success']);
        }else{
            return json(['data'=>'','code'=>0,'msg'=>'没有数据']);
        }

    }



}