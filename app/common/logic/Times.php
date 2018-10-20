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

namespace app\Common\logic;


class Times extends LogicBase 
{

    public function getIdByTime($time)
    {
        $date = date('Y-m-d', $time);

         $da['date']=$date;
        $times = $this->modelTimes->getInfo( $da);
        if ($times) {
            return $times['id'];
        }else{
            return $this->modelTimes->addInfo($da, true);
        }
    }
}
