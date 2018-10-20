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

namespace app\common\logic;

/**
 * 文章逻辑
 */
class Shop extends LogicBase
{
    

/**
     * 文章信息编辑
     */
    public function car_add($params = []){

                if (!isset($params['id'])) {
                    return $this->error('商品不存在！');
                }
                $goods = $this->modelShop->get($params['id']);

                if (!$goods || $goods->status != 1) {
                    return $this->error('商品不存在！！');
                }

                if (!isset($params['num']) || !$params['num'] || $params['num'] > $goods->num) {
                    return $this->error('商品数量出错！');
                }

                $where['uid'] = array('eq',session('member_info')->id);
                $where['goods_id'] = array('eq',$goods->id);
                $car = M('shop_car')->where($where)->find();
                
                if ($car) {
                    $data['num'] =$car['num']+$params['num'];
                    $data['time']= session('member_auth')['update_time'];
                $result=M('shop_car')->where('id='.$car['id'])->update($data);
                }else{
                    $data = [
                        'uid' => session('member_info')->id,
                        'user_id' => session('member_info')->user_id,
                        'num' => $params['num'],
                        'time' => session('member_auth')['update_time'],
                        'goods_id' => $goods->id,
                        'status' => $goods->status,
                    ];
                   $result=M('shop_car')->insert($data);
                }
             
        return $result ? [RESULT_SUCCESS, '操作成功'] : [RESULT_ERROR, $this->modelShop->getError()];
    
    }

 public function car_list($where = [],$param= []){
      
       

       $this->modelShopcar->alias('c');
       $join = [
                    [SYS_DB_PREFIX . 'shop g', 'c.goods_id = g.id'],
                ];
    $field='c.*,c.num as goods_num,g.*,g.name as goods_name,g.thumb as goods_thumb,g.price as goods_price';
    
     return  $this->modelShopcar->getList($where,$field,$order, $paginate, $join);
    }
    
    /**
     * 文章分类编辑
     */
    public function shopCategoryEdit($data = [])
    {
        
        $validate_result = $this->validateShopCategory->scene('edit')->check($data);
        
        if (!$validate_result) {
            
            return [RESULT_ERROR, $this->validateShopCategory->getError()];
        }
        
        $url = url('shopCategoryList');
        
        $result = $this->modelShopCategory->setInfo($data);

        $handle_text = empty($data['id']) ? '新增' : '编辑';

        $result && action_log($handle_text, '分类' . $handle_text . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '操作成功', $url] : [RESULT_ERROR, $this->modelShopCategory->getError()];
    }

    /**
     * 获取文章列表
     */
    public function getShopList($where = [], $field = 'a.*', $order = '',$page = '', $order = '')
    {


        $this->modelShop->alias('a');

        $join = [
                    [SYS_DB_PREFIX . 'member m', 'a.member_id = m.id'],
                    [SYS_DB_PREFIX . 'shop_category c', 'a.category_id = c.id'],
                ];

        $where['a.' . DATA_STATUS_NAME] = ['neq', DATA_DELETE];
       
        return $this->modelShop->getList($where, $field, $order,$page, $join);
    }

 public function order_list($where = [],$param= []){
      
      
        $start =  $param['start'];
        $end =  $param['end'];
        $word =  $param['word'];
        $status=  $param['status_a'];
    
        $where1 = ['uid', '=', session('member_info')['id']];
        if(session('member_info')['id']<=1){
             $where1=['uid'=>['>',0]];
        }else{
        $where1=['uid'=>['=',session('member_info')['id']]];
        }




      
       if(empty($param)){
       $where=['a.status'=>['>=',0]];
       }elseif($status==0){
       $where=['a.status'=>['<=',0]];
       }else{
        $where=['a.status'=>['=',$status]];
       }

   $where = array_merge($where,$where1);
  
        if ($start) {
            if ($end) {
                $end .= ' 23:59:59';
                $where=[ 'create_time'=>[['egt',strtotime($start)],['elt',strtotime($end)]],];

            }else{
               // $where[] = ['create_time', ['>=', strtotime($start)], ['<=', session('member_auth')['update_time']], 'and'];
                $where=[ 'create_time'=>[['egt',strtotime($start)],['elt',session('member_auth')['update_time']]],];

            }
        }else{
            if ($end) {
                $end .= ' 23:59:59';
                //$where[] = ['create_time', ['>=', 0], ['<=', strtotime($end)], 'and'];
                $where=[ 'create_time'=>[['egt',0],['elt',strtotime($end)]],];
            }
        }
        if ($word) {
            //$where[] = ['goods_name', 'like', '%'.$word.'%'];
             $where=['goods_name'=>['like','%'.$word.'%']];
        }
  
       $this->modelShoporder->alias('a');
       $join = [
                    [SYS_DB_PREFIX . 'shop p', 'a.goods_id = p.id', 'LEFT'],
                ];
                
     return  $this->modelShoporder->getList($where, 'p.*,a.*,a.status as status_a', 'a.create_time desc', 5, $join);
    }




    public function order_show($params = []){
        
         return  M('shop_order')->alias('a')->join('shop d','a.goods_id=d.id','LEFT')->field('a.*,d.*,a.num as goods_num,a.address as goods_address,a.status as status_a,a.name as username')->where($params)->find();


        }

     public function order_add($params = []){
       

    $this->modelShopcar->alias('c');
        
        $join = [
                    [SYS_DB_PREFIX . 'shop b', 'c.goods_id = b.id', 'LEFT'],
                ];
        
       // $where['m.' . DATA_STATUS_NAME] = ['neq', DATA_DELETE];
        $where=['c.uid'=>['=',session('member_info')->id]];
        $where['c.goods_id'] =array('in',$params['ids']);
        $field='c.*,b.id as goods_id,b.name as goods_name,b.num as goods_num,b.thumb as goods_thumb,b.price as goods_price';

       $list=$this->modelShopcar->getList($where, $field, $order, $paginate, $join);

       $time = session('member_auth')['update_time'];             
        foreach ($list as $vo) {
             
            $data = [
                'uid'           => session('member_info')->id,
                'user_id'       => session('member_info')->user_id,
                'num'           =>$vo['num'],
                'code'          => 'S'.date('YmdHis', $time).random_string(6, true, false, false, false),
                'create_time'   => $time,
                'pay_type'      => $params['pay_type'],
                'goods_id'      => $vo['goods_id'],
                'goods_name'    => $vo['goods_name'],
                'goods_thumb'   => $vo['goods_thumb'],
                'goods_price'   => $vo['goods_price'],
                 'address'       =>$params['address'],
                'mobile'        => $params['mobile'],
                'name'          => $params['name'],
            ];
            $money = $vo['goods_price'] * $vo['num'];
            switch ($params['pay_type']) {
                case 0:
//                  $this->logicmember->rw_bonus($my,$bnum=0,$money_count=0,$man);
                    break;
                case 1:
                 //   $this->logicmember->rw_bonus($my,$bnum=0,$money_count=0,$man);
                    break;
                case 2:
               //     $this->logicmember->rw_bonus($my,$bnum=0,$money_count=0,$man);
                    break;
               }
            }
           //var_dump($data);die;
           if($data['code']){
            $result=$this->modelShoporder->addInfo($data);
            //$this->modelMember->updateInfo(session('member_info'));
          return $result ? [RESULT_SUCCESS, '操作成功', url('order_list')] : [RESULT_ERROR, $this->modelShop->getError()];}
        }

    /**
     * 获取文章列表搜索条件
     */
    public function getWhere($data = [])
    {

        $where = [];

        !empty($data['search_data']) && $where['a.name|a.describe'] = ['like', '%'.$data['search_data'].'%'];

        return $where;
    }

    /**
     * 文章信息编辑
     */
    public function shopEdit($data = [])
    {
 
        $validate_result = $this->validateShop->scene('edit')->check($data);

        if (!$validate_result) {

            return [RESULT_ERROR, $this->validateShop->getError()];
        }

        //$url = url('admin/shopadmin/shopedit/id/'.$data['id']);

        empty($data['id']) && $data['member_id'] = MEMBER_ID;

        $data['content'] = html_entity_decode($data['content']);

        $data['price'] = (int)$data['price'];
        $data['cost'] = html_entity_decode($data['cost']);

        $data['describe'] = html_entity_decode($data['describe']);
        $result = $this->modelShop->setInfo($data);

        $handle_text = empty($data['id']) ? '新增' : '编辑';

        $result && action_log($handle_text, '产品' . $handle_text . '，name：' . $data['name']);

        return $result ? [RESULT_SUCCESS, '产品操作成功'] : [RESULT_ERROR, $this->modelShop->getError()];
    }

    /**
     * 获取文章信息
     */
    public function getShopInfo($where = [], $field = 'a.*')
    {

        $this->modelShop->alias('a');

        $join = [
                    [SYS_DB_PREFIX . 'member m', 'a.member_id = m.id'],
                    [SYS_DB_PREFIX . 'shop_category c', 'a.category_id = c.id'],
                ];

        $where['a.' . DATA_STATUS_NAME] = ['neq', DATA_DELETE];

        return $this->modelShop->getInfo($where, $field, $join);
    }

    /**
     * 获取分类信息
     */
    public function getShopCategoryInfo($where = [], $field = true)
    {

        return $this->modelShopCategory->getInfo($where, $field);
    }

    /**
     * 获取文章分类列表
     */
    public function getShopCategoryList($where = [], $field = true, $order = '', $paginate = 0)
    {
        //var_dump(get_class_methods($this->modelShopCategory));
       return $this->modelShopCategory->getList($where, $field, $order, $paginate);
      
    }

    /**
     * 文章分类删除
     */
    public function shopCategoryDel($where = [])
    {

        $result = $this->modelShopCategory->deleteInfo($where);

        $result && action_log('删除', '产品分类删除，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '产品分类删除成功'] : [RESULT_ERROR, $this->modelShopCategory->getError()];
    }

    /**
     * 文章删除
     */
    public function shopDel($where = [])
    {

        $result = $this->modelShop->deleteInfo($where);

        $result && action_log('删除', '产品删除，where：' . http_build_query($where));

        return $result ? [RESULT_SUCCESS, '产品删除成功'] : [RESULT_ERROR, $this->modelShop->getError()];
    }

    public function history($params,$page)
    {          
                 //货币流向
                 if($params['tp']){
                   $where['action_type']=$params['tp'];
                 }elseif($params['action_type']){
                   $where['action_type']=$params['action_type'];
                 }   
                $where['uid']=$params['uid'];

                if($params['epoints']){
                    $where['epoints']=$params['epoints'];
                }
                if($params['status']){
                    $where['status']=$params['status'];
                }
                if($params['task_type']){
                    $where['task_type']=$params['task_type'];
                }

               
                $sDate  = $params['S_Date'];
                $eDate  = $params['E_Date'];
                $UserID = $params['UserID'];
                if($s_Date>0){
                    $map['_string'] .= " and pdt>=".$s_Date;
                    $map['pdt']=[['>',$s_Date],['<=', $e_Date],'and'];
                }
                if($e_Date>0){
                    $e_Date = $e_Date+3600*24-1;
                    $map['pdt']=[['>',$s_Date],['<=', $e_Date],'and'];
                }
                if($ss_type>0){
                    if($ss_type==15){
                       $where['action_type']=['lt',12];
                    }else{
                        $where['action_type']=['eq',$ss_type];
                    }
                }
                if($params['UserID']){
                 $usrs =  M('member')->where('user_id="'.$UserID.'"')->field('id,user_id')->find();
                  $usid = $usrs['id'];
                  $map[ 'uid']= ['eq',$usid];
                }else{

                    $map=$params;
                }
               if(!$page){
                $page=20;
               }
              $order='id desc';
            return $this->modelhistory->getList($where, '*', $order, $page);
    }


 public function draw($params,$page)
    {          
         $where['uid']=$params['uid'];
         return $this->modeldraw->getList($where, '*', $order, $page);
    }











}
