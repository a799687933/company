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

use think\Request;
use think\Db;
use app\admin\logic\Member;
/**
 * 前端首页控制器
 */
class User extends AdminBase
{
    // public function _initialize()
    // {    // 验证登录
    //     !session('member_info') && $this->redirect('admin/login/login');
    // }
     
    // 首页
    public function inde()
    {



         !session('member_info') && $this->redirect('admin/login/login');

     
         if($this->user['b5']>0){
        M('member')->where('id='.session('member_info')['id'])->setfield('is_agent',1);
        }else{
        M('member')->where('id='.session('member_info')['id'])->setfield('is_agent',0);
        }
 
    $ordernum[0]=M('shop_car')->where('uid='.session('member_info')['id'])->count();
    count();
    $param['status_a']=0;
    $ordernum[0]=$this->logicShop->order_list($where,$param)->count(); 
    $param['status_a']=1;
    $ordernum[1]=$this->logicShop->order_list($where,$param)->count(); 
    $param['status_a']=2;
    $ordernum[2]=$this->logicShop->order_list($where,$param)->count();  
    $param['status_a']=3;
    $ordernum[3]=$this->logicShop->order_list($where,$param)->count(); 
      //  var_dump($this->card()[card_d][substr($str , 0 , 6)]);
      $this->assign('ordernum',$ordernum);
      $this->assign('userInfo',$this->user);
      return $this->fetch('index');

    }


 public  function  card(){
    $file_path = "test.txt";
    if(file_exists($file_path)){$str = file_get_contents($file_path);}
    $str = str_replace("\r\n","<br />",$str);//将整个文件内容读入到一个字符串中
    $value['name']='card_d';
    $value['value']= $str;
    $shuzu[$value['name']] = explode("|",$value['value']);//如果有执行这个遍历
            foreach ($shuzu[$value['name']] as $key => $valu) {//取出对应规则
             if (@$arr1!=NULL) { unset( $shuzu[$value['name']]);}
             $arr2= explode('-',$valu);
              if(@$arr2[1]!=NULL){
              $shu[$value['name']][@$arr2[0]]=@$arr2[1]; unset($shuzu[$value['name']]);
              if (!@in_array("$name", @$arr1)&&@$arr1!=null) { unset( $shu[$value['name']]);}
               }       
            }
    return  array_merge($shu,$shuzu);
    }







//购物车处理
  public function car_list(){
    !session('member_info') && $this->redirect('admin/login/login');
       
       if($this->param['num']){ $this->logicShop->car_add($this->param);}
       
        $where=['g.selling'=>['=',1]];
        $where=['c.uid'=>['=',session('member_info')->id]];
        //var_dump($this->logicShop->car_list($where)[0]);
        $this->assign('lists', $this->logicShop->car_list($where));
        $info=M('member')->where('id='.session('member_info')['id'])->find();
        $info['address_d']=explode('|', $info['address']);
        $this->assign('info',$info );
       // $this->assign('list_address', ShopAddress::select());
        // 获取配送区域
        $map['uid']=$this->user['id'];
        $map['status']=1;
        $addressid  = input('address_id');
        if($addressid){
            $map['id']=$addressid;
        }
        $ordersAddressInfo = Db::name('address')->where($map)->find();
       $this->assign('ordersAddressInfo',$ordersAddressInfo);
        return $this->fetch();

    }
    
public function car_delete(){
        $params = $this->request->param();
        if (!isset($params['ids']) || !is_array($params['ids']) || count($params['ids']) == 0) {
            return $this->error('至少选择一个商品！');
        }
         $where=['uid'=>['=',session('member_info')->id]];
         $where['goods_id'] =array('in',$params['ids']);
        if (M('shop_car')->where($where)->count() == 0) {
            return $this->error('商品不存在！！');
        }
        M('shop_car')->where($where)->delete();
        return $this->success('删除成功！', 'car_list');

    }




//订单处理

 public function order_add(){

         $params = $this->request->param();

        // if(!$params['address']||!$params['mobile']||!$params['name']){ 
        //     $this->error('不能空地址');
        //     }
         if(!$params['ids']){
          $this->error('提交订单失败');
         }
        if(!$params['goods_price']){
          $this->error('提交订单失败');
         }

         foreach ($params['ids'] as  $value) {
            $params['ids']=$value;
             $this->logicShop->order_add($params);
         }
         $where=['uid'=>['=',session('member_info')->id]];
         $where['goods_id'] =array('in',$params['ids']);
          M('shop_car')->where($where)->delete();
          return $this->success('提交订单成功！','order_list');
        }

public function order_list(){
        $param=$this->request->param();
        $where['uid']= $this->user['id'];
        $list=$this->logicShop->order_list($where,$param);
        $this->assign('man', $this->user);
        $this->assign('list',$list);
        return $this->fetch('order_list');
    }



  public function order_show(){

        $params = $this->request->param();
        foreach(  $params as $k=>$v){   if( !$v )   unset($params[$k] ); }
//var_dump($params);die;
        if($params['address']){
             $a=M('shop_order')->where('code="'.$params['code'].'"')->update($params);
           if($a) {
            $this->success('修改成功');
           }else{
            $this->error('修改失败');
           }
         }


        $c['code']=$params['code'];
        $order=$this->logicShop->order_show($c);

        if (!$order  || ($order['uid'] != session('member_info')['id']&&session('member_info')['id']>1)) {
            return $this->error('订单不存在！');
        }
  
        $this->assign('order', $order);
        $this->assign('man', $this->user);
        return $this->fetch();
    }

 public function order_show2(){

        $params = $this->request->param();
        foreach(  $params as $k=>$v){   if( !$v )   unset($params[$k] ); }
//var_dump($params);die;
        if($params['address']){
             $a=M('shop_order')->where('code="'.$params['code'].'"')->update($params);
           if($a) {
            $this->success('修改成功');
           }else{
            $this->error('修改失败');
           }
         }


        $c['code']=$params['code'];
        $order=$this->logicShop->order_show($c);

        if (!$order  || ($order['uid'] != session('member_info')['id']&&session('member_info')['id']>1)) {
            return $this->error('订单不存在！');
        }
  
        $this->assign('order', $order);
        $this->assign('man', $this->user);
        return $this->fetch();
    }


 public function my_data()
    {
        //var_dump($this->feeratio);
        // 获取首页数据
        //$index_data = $this->logicAdminBase->getIndexData();
        $info=M('member')->where('id='.$this->user['id'])->find();

        $this->assign('info',$info);
        return $this->fetch();
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




public function address_del()
    {
    $para=$this->request->param();
    $params=M('member')->where('id='.session('member_info')['id'])->find();
    $info['address_d']=explode('|', $params['address']);
    $address=$this->array_remove($info['address_d'],$para['vo']);
    $params['address']=implode('|',$address) ;
    $RE=M('member')->where('id='.session('member_info')['id'])->update($params);
    if($RE){
    $this->success('修改成功');}else{
    $this->error('未修改！！');
    }
   }

// public function my_data_d()
//     {
//         $info=M('member')->where('id='.session('member_info')['id'])->find();
//         $info['address_d']=explode('|', $info['address']);
//         $this->assign('info',$info);
//         return $this->fetch();
//     }

public function array_remove($data, $key){
    if(!array_key_exists($key, $data)){
        return $data;
    }
    $keys = array_keys($data);
    $index = array_search($key, $keys);
    if($index !== FALSE){
        array_splice($data, $index, 1);
    }
    return $data;
 
}

 


      // 首页
    public function article_list($cid = 0)
    {
        
        $where = [];
        
        !empty((int)$cid) && $where['a.category_id'] = $cid;
        
        $this->assign('article_list', $this->logicArticle->getArticleList($where, 'a.*,m.nickname,c.name as category_name', 'a.create_time desc'));
        
        $this->assign('category_list', $this->logicArticle->getArticleCategoryList([], true, 'create_time asc', false));
        
        return $this->fetch();
    }
    
    // 详情
    public function details($id = 0)
    {
        
        $where = [];
        
        !empty((int)$id) && $where['a.id'] = $id;
        
        $data = $this->logicArticle->getArticleInfo($where);
        
        $data['content'] = html_entity_decode($data['content']);
        
        $this->assign('article_info', $data);
        
        $this->assign('category_list', $this->logicArticle->getArticleCategoryList([], true, 'create_time asc', false));
        
        return $this->fetch('details');
    }
































    /**
     * 我的收藏
     * @author ILsunshine
     */
    public function Collection()
    {   
        $goods = Db::name('mini_goods_collection')
                ->alias('a')
                ->join('mini_goods b','b.id= a.goods_id','LEFT')
                ->where(array('a.uid'=>$this->user['id']))
                ->field('a.*,b.name,b.price,b.standard,b.cover_path,b.sell_num')
                ->order('a.createtime desc')->paginate(10);  
        // 获取分页显示
        $page = $goods->render();         
        $this->assign('page',$page);
        $this->assign('lists',$goods);
        return $this->fetch();
    }
     /**
     * 删除收藏商品
     * @author  ILsunshine
     */
    public function delGoodsCollection(){
        $ids        = input('post.ids/a');
        $map['id']  = array('in',implode(',',$ids));
        $map['uid'] = $this->user['id'];
        $result = Db::name('mini_GoodsCollection')->where($map)->delete();
        if($result) {
            return $this->success('删除成功！',url('collection/Collection'));
        } else {
            return $this->error('删除失败！');
        } 
    }


    //个人资料
    public function userprofile()
    {
        $id = session('userinfo')['id'];
        if(Request::instance()->isGet()){
            $userInfo = Db::name('mini_users')->field('*')->where('id',$this->user['id'])->find();
            $this->assign('userInfo',$userInfo);
            return $this->fetch();
        }
        if(Request::instance()->isPost()){

            $password = input('post.password');
            $oldpassword = input('post.oldpassword');
            $password2 = input('post.password2');
            $oldpassword2 = input('post.oldpassword2');
            $nickname = input('post.nickname');
            $idcard = input('post.idcard');

            $user = Db::name('mini_users')->field('password,password2,salt')->where('id',$this->user['id'])->find();

            if(!empty($password)){

                if(comoray_md5($oldpassword,$user['salt']) == $user['password']){

                    $data['password'] = comoray_md5($password,$user['salt']);

                }else{
                    $this->error('原登录密码错误');
                    exit;
                }

            }

            if(!empty($password2)){

                if(comoray_md5($oldpassword2,$user['salt']) == $user['password2']||$user['password2']==''){

                    $data['password2'] = comoray_md5($password2,$user['salt']);

                }else{
                    $this->error('原安全密码错误');
                    exit;
                }

            }

            //身份证正则表达式(15位) 
            $isidcard1='/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/i';
            //身份证正则表达式(18位) 
            // $isIDCard2="/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/";
            // if( !preg_match($isidcard1,$idcard) ){
            //     return $this->error('请输入正确的身份证号');
            // }
            if (strlen($idcard)<6){
                return $this->error('请输入正确的身份证号');
            }
            $data['nickname'] = $nickname;
            $data['idcard'] = $idcard;

            $ret = Db::name('mini_users')->where('id',$id)->update($data);
            if($ret!==false){
                $this->success('修改成功',url('index'));
            }else{
                $this->error('修改失败');;
            }
        }
    }



 public function my_data_d() {
        $map['uid']     = $this->user['id'];
        $map['status']  = 1;  
        $addressList    = M('address')
                        ->where($map)
                        ->field('concat(province,city,county,address) as user_address')
                        ->field(true)->limit(5)
                        ->select();
        
        // 获取分页显示
        $this ->assign('addressList',$addressList);
        return $this->fetch('my_data_d');
    }

    /**
     * 编辑收货地址
     * @author  ILsunshine
     */
    public function editAddress(){

        if (Request::instance()->isPost()) {
            // 接收post数据
            $id                = input('post.id');
            $address           = input('post.address');//地址
            $province          = input('post.province');//省
            $city              = input('post.city');//市
            $county            = input('post.county');//县
            $mobile            = input('post.mobile');//手机号
            $consignee_name    = input('post.consignee_name');//收货人
        

            if(!preg_match("/^[0-9]{11}$/i",$mobile)){
                return $this->error('请输入正确的手机号');
            }
            // 实例化验证器

            // 验证数据
            $data['address']         = $address;
            $data['consignee_name']  = $consignee_name;
            $data['province']        = $province;
            $data['city']            = $city;
            $data['county']          = $county;
            $data['mobile']          = $mobile; 
            // if (!$validate->scene('address')->check($data)) {
            //     return $this->error($validate->getError());
            // }

            // 更新地址
            $map['uid']     = $this->user['id'];
            $map['id']      = $id;             
            $result      = Db::name('address')->where($map)->update($data);
            if($result){
                $this->success('编辑成功',url('my_data_d'));
            }else{
                $this->error('编辑失败');
            }   
        } else {
            $map['uid']     = $this->user['id'];
            $map['id']      = input('get.id');  
            $addressInfo  = Db::name('address')->where($map)->find(); 
            $this->assign('addressInfo',$addressInfo);

            return $this->fetch();
        }
    }





//选择地址
    public function selectAddress(){

        // 获取配送区域
        $ordersAddressLists = Db::name('address')->where(['uid'=>$this->user['id'],'status'=>1])->select();

        $this->assign('ordersAddressLists',$ordersAddressLists);

        // 如果为空，则添加新地址
        if(empty($ordersAddressLists)) {
            return $this->fetch('addaddress');
        } else {
            return $this->fetch('selectaddress');
        }

    }

















    /**
     * 新增收货地址
     * @author  ILsunshine
     */
    public function addAddress(){

        if (Request::instance()->isPost()) {
            // 接收post数据
            $address           = input('post.address');//地址
            $province          = input('post.province');//详细地址
            $city              = input('post.city');//详细地址
            $county            = input('post.county');//详细地址
            $mobile            = input('post.mobile');//手机号
            $consignee_name    = input('post.consignee_name');//收货人          


            if(!preg_match("/^[0-9]{11}$/i",$mobile)){
                return $this->error('请输入正确的手机号');
            }
            // 实例化验证器
            //$validate = Loader::validate('Address'); 
            if($province == ''){
                $this->error('输入省份不能为空');
            }
            if($city == ''){
                $this->error('输入城市不能为空');
            }

            if( $county == 'undefined'){
                $county = '';
            }

            // 验证数据
            $data['uid']             = $this->user['id'];
            $data['address']         = $address;
            $data['consignee_name']  = $consignee_name;
            $data['province']        = $province;
            $data['city']            = $city;
            $data['county']          = $county;
            $data['mobile']          = $mobile; 
            /*if (!$validate->scene('address')->check($data)) {
                return $this->error($validate->getError());
            }*/

            // 保存地址
            $map['uid']     = $this->user['id'];
            $map['status']  = 1;             
            $count          = Db::name('address')->where($map)->count();
            if($count <11){                                
                $data['uid']       = $this->user['id'];
                $data['default']   = 0;
                $getStatus         = Db::name('address')->insert($data);                     
                if($getStatus != false){
                        return $this->success('保存地址成功',url('my_data_d'),1);
                    } else {
                        return $this->error('保存失败');
                    }           
            }else{
                return $this->error('最多可保存10条数据');
            }
        } else {           
            return $this->fetch();
        }
    }
    /**
     * 删除收货地址
     * @author  ILsunshine
     */
    public function delAddress(){
        $id     = input('post.address_id');
        $result = Db::name('address')->where('id',$id)->setField('status',-1);
        if($result) {
            return $this->success('删除成功！',url('my_data_d'));
        } else {
            return $this->error('删除失败！');
        } 
    }
    /**
     * 设置收货地址
     * @author  ILsunshine
     */
    public function setDefault(){
        $id        = input('post.address_id');
        $getStatus = Db::name('address')->where('default',1)->setField('default',-1);
        $result    = Db::name('address')->where('id',$id)->setField('default',1);
        if($result&&$getStatus) {
            return $this->success('设置成功！',url('my_data_d'));
        } else {
            return $this->error('设置失败');
        } 
    }





    public function listjson(){
        $map['uid']     = $this->user['id'];
        $map['status']  = 1;  
        $data    = Db::name('mini_orders_address')
                        ->where($map)
                        ->field('concat(province,city,county,address) as user_address')
                        ->field(true)
                        ->paginate(5);             
        $count=count($data);
        if($count>0){
            return json(['data'=>$data,'code'=>1,'msg'=>'success']);
        }else{
            return json(['data'=>'','code'=>0,'msg'=>'没有数据']);
        }
        exit;
    }

    public function editjson(){
        $map['uid']     = $this->user['id'];
        $map['status']  = 1;  
        $data    = Db::name('mini_orders_address')
                        ->where($map)
                        ->field('concat(province,city,county,address) as user_address')
                        ->field(true)
                        ->paginate(5);             
        $count=count($data);
        if($count>0){
            return json(['data'=>$data,'code'=>1,'msg'=>'success']);
        }else{
            return json(['data'=>'','code'=>0,'msg'=>'没有数据']);
        }
        exit;
    }

























    //帮助列表
    public function helplist(){
        
    }


    //帮助列表
    public function helpdetail(){
        
        

    }

    //
    public function server(){

        $uid = session('userinfo')['id'];
        if(Request::instance()->isGet()){
            return $this->fetch();
        }
        if(Request::instance()->isPost()){

            $content = input('post.content');

            $data['content'] = $content;
            $data['uid'] = $uid;
            $data['ctime'] = time();

            $ret = Db::name('gbook')->insert($data);
            if($ret!==false){
                $this->success('感谢您的提交');
            }else{
                $this->error('提交失败');;
            }
        }
    }

    //经销商升级
    public function dealer(){
        return $this->fetch();
    }

    //导购升级
    public function sales(){
        return $this->fetch();
    }

    //注销
    public function logout(){
        session('userinfo',null);
        cookie('user',null);
        return $this->success('退出成功');
    }


    
    //协议
    public function xieyi(){

        return $this->fetch();

    }



}






















