<?php

namespace app\admin\logic;

/**
 * 财务明细
 */
class Finance extends AdminBase{

    




    public function getBonusList($date, $username){
        $where = [];

        if ($date && false !== strtotime($date)) {
            $date = date('Y-m-d', strtotime($date));

            $whe['date']=$date;
            $times = $this->modelTimes->getInfo( $whe);
            if ($times) {
                $where['b.times_id'] = $times['id'];
            }else{
                $where['b.times_id'] = 0;
            }
        }
        if ($username) {
            $where['b.username'] = $username;
        }

        $join = [['times t', 'b.times_id=t.id']];

        $field = 'b.times_id,t.date,sum(b.b0) as b0,sum(b.b1) as b1,sum(b.b2) as b2,sum(b.b3) as b3,sum(b.b4) as b4,sum(b.b5) as b5,sum(b.b6) as b6';

       // 
        $list = $this->modelBonus
            ->alias('b')
            ->field($field)
            ->where($where)
            ->join($join)
            ->group('b.times_id')
            ->order('b.times_id desc')
            ->paginate(DB_LIST_ROWS, false, ['query' => request()->param()]);

//var_dump($list[0]);die;

        $field = 'sum(b.b0) as b0,sum(b.b1) as b1,sum(b.b2) as b2,sum(b.b3) as b3,sum(b.b4) as b4,sum(b.b5) as b5,sum(b.b6) as b6';
        $sum = $this->modelBonus
            ->alias('b')
            ->field($field)
            ->where($where)
            ->join($join)
            ->find();




        return compact('list', 'sum');
    }






    public function getBonusList2($times_id, $username){
        $wher['id'] = $times_id;
        $times = $this->modelTimes->getInfo($wher);
        if (!$times) {
            return false;
        }

        $date = $times['date'];
        $where ['times_id']= $times_id;
        if ($username) {
            $where['username'] = $username;
        }
 
        $list = $this->modelBonus->getList($where, '*', 'create_time desc');

        $field = 'sum(b0) as b0,sum(b1) as b1,sum(b2) as b2,sum(b3) as b3,sum(b4) as b4,sum(b5) as b5,sum(b6) as b6';

        $sum = $this->modelBonus->getInfo($where, $field);

        return compact('list', 'sum', 'date');
    }

    public function getBonusList3($times_id, $username){
        if (!$username) {
            return false;
        }
        $who['id']=$times_id;
        $times = $this->modelTimes->getInfo($who);
        if (!$times) {
            return false;
        }
           $where['user_id']= $username;
           $where ['action_type']= ['in', [1,2,3,4,5,6,11]];
            $where ['pdt']= [['>=', strtotime($times['date'])], ['<=', strtotime($times['date'].' 23:59:59')], 'and'];
        $list = $this->modelHistory->getList($where, '*', 'pdt desc');

        return $list;
    }


    public function getHistoryList($type, $start, $end, $username, $type_arr){
        $where = [];

        if ($type && array_key_exists($type, $type_arr)) {
            $where ['action_type'] =$type;
        }
       $this->setDateWhere($where, $start, $end, 'pdt');
        if ($username) {
            $where['user_id'] = ['=', $username];
        }
        return $this->modelHistory->getList($where, '*', 'pdt desc');
    }

}
