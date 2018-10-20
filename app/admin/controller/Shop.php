<?php
namespace app\admin\controller;
use think\Db;
use app\common\model\ShopCategory;
use app\admin\service\GoodsService;
class Shop extends AdminBase{


    public function order_list(){
        $param=$this->request->param();
        $list=$this->logicShop->order_list($where,$param);
        $this->assign('man', session('member_info'));
        $this->assign('list',$list);
         if($param['code']){
           $where['code'] =$param['code'];
      if (M('shop_order')->where($where)->count() == 0) {
          return $this->error('订单不存在！！');
      }
      M('shop_order')->where($where)->delete();
      return $this->success('订单删除成功！', 'admin/shop/order_list');
        }
        return $this->fetch('order_list');
    }


    public function order_list_b(){

        $status = $this->request->param('status');
        $start = $this->request->param('start');
        $end = $this->request->param('end');
        $word = $this->request->param('word');
        $status= $this->request->param('status');
      
        //$where = ['uid', '=', session('member_info')['id']];
        if(session('member_info')['id']<=1){
             $where=['uid'=>['>',0]];
        }else{
        $where=['uid'=>['=',session('member_info')['id']]];
        }

        if ($status && $status != '') {
          $where=['a.status'=>['=',$status]];
        }

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
        $list=$this->logicShop->order_list($where);
        $this->assign('man', session('member_info'));
        $this->assign('list',$list);

        return $this->fetch('order_list');
    }

 
}
