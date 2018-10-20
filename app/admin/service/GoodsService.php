<?php
namespace app\admin\service;
use app\admin\model\ShopGoods;
use think\Db;
class GoodsService{

	public function goods_list($params){
		$goods = new ShopGoods();
		$where = [];
		$order = 'time';
		$az = 'desc';
		$limit = 10;
		if (isset($params['word']) && $params['word']) {
			//$where[] = ['g.name', 'like', '%'.$params['word'].'%'];
			$where=['g.name'=>['=',$params['name']]];
		}
		if (isset($params['category_id']) && $params['category_id']) {
			//$where[] = ['g.category_id', '=', $params['category_id']];
			$where=['g.category_id'=>['=',$params['category_id']]];
		}
		if (isset($params['selling']) && $params['selling'] != '') {
			//$where[] = ['g.selling', '=', $params['selling']];
			$where=['g.selling'=>['=',$params['selling']]];
		}


		if (isset($params['limit']) && $params['limit']) {
			$limit = $params['limit'];
		}
		if (isset($params['order']) && $params['order']) {
			$order = $params['order'];
		}
		if (isset($params['az']) && $params['az']) {
			$az = $params['az'] == 'desc' ? 'desc' : 'asc';
		}
        return $goods->alias('g')
            ->field('g.*,c.name as category_name')
            ->where($where)
            ->join('shop_category c','g.category_id=c.id')
            ->order('g.'.$order.' '.$az)
            ->paginate($limit, false, ['query' => request()->param()]);
	}
}