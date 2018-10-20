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
 * 统计分析控制器
 */
class Statistic extends AdminBase
{
    
    /**
     * 后台会员权限等级树结构
     */
    public function memberTree()
    {
        
        $data = $this->logicStatistic->getMemberTree();
        
        $this->assign('data', json_encode($data));
        
        return $this->fetch('member_tree');
    }
   





    /**
     * 访客浏览器与操作系统统计
     */
    public function performerFacility()
    {
        
        $data = $this->logicStatistic->performerFacility();
        
        $this->assign('browser_list',       json_encode($data['browser_list']));
        $this->assign('browser_name_data',  json_encode($data['browser_name_data']));
        $this->assign('system_list',        json_encode($data['system_list']));
        $this->assign('system_name_data',   json_encode($data['system_name_data']));
        
        return $this->fetch('performer_facility');
    }
    
    /**
     * 执行速度
     */
    public function exeSpeed()
    {
        
        $data = $this->logicStatistic->exeSpeed();
        
        $this->assign('data', $data);
        
        return $this->fetch('exe_speed');
    }
    
    /**
     * 会员增长
     */
    public function memberGrowth()
    {
        
        $data = $this->logicStatistic->memberGrowth();
        
        $this->assign('data', json_encode($data));
        
        return $this->fetch('member_growth');
    }

   public function historyList(){
        $type       = $this->request->param('type', 0, 'intval');
        $start      = $this->request->param('start', '');
        $end        = $this->request->param('end', '');
        $username   = $this->request->param('username', '');
        $type_arr   =$this->feeratio['type_name'];
        $this->assign('type_arr', $type_arr);
        foreach ($type_arr as $ky => $val) {$neslit[]=$ky; }
        $this->assign('neslit',$neslit);  
        $this->assign('type_arr',$this->feeratio['type_name']); 
        $list=$this->logicFinance->getHistoryList($type, $start, $end, $username, $type_arr);
        $this->assign('list',$list);
        
        return $this->fetch('history_list');
    }



















//会员级别颜色
    function ji_Color(){
        $Color = array();
        $Color['1'] = "#E6E8FA";
        $Color['2'] = "#5CACEE";//"#E6E6FA";//"#DDA0DD";
        $Color['3'] = "#D9D919";
        $Color['4'] = "#FF5555";//"#FFFF00";
        $Color['5'] = "#9BCD9B";
        $Color['6'] = "#FFFF00";
        return $Color;
    }
    
    //会员级别颜色
    function ji_Color_B(){
        $Color = array();
        $Color['1'] = "#D9D919";
        $Color['2'] = "#5CACEE";//"#E6E6FA";//"#DDA0DD";
        $Color['3'] = "#D9D919";
        $Color['4'] = "#FF5555";//"#FFFF00";
        $Color['5'] = "#9BCD9B";
//      $Color['6'] = "#7F7F7F";
//      $Color['7'] = "#FFFF00";
        return $Color;
    }

    function AC_Color(){
        $HYJJ="";
        $this->_levelConfirm($HYJJ);
        $Color = array();
        $Color['1'] = $HYJJ[1];
        $Color['2'] = $HYJJ[2];
        $Color['3'] = $HYJJ[3];
        $Color['4'] = $HYJJ[4];
        $Color['5'] = $HYJJ[5];
        $Color['6'] = $HYJJ[6];
//      $Color['7'] = "#0066FF";
        return $Color;
    }

    //开通 未开通 报单中心
    function Mi_Cheng(){
        $Color['0']  = '未激活会员';
        $Color['1']  = '正式会员';
        //$Color['2']  = '报单中心';//'报单中心';
        return $Color;
    }

    function kd_Color(){
        $Color['0']    = '#C0C0C0';
        $Color['1']    = '#88b781';
        $Color['2']    = '#0066FF
';
        return $Color;
    }



   //  三轨图
    public function Tree3(){
        //$new_man=M('member')->where('user_id=1')->find();
        //$this->jiandan($new_man['p_path'],$new_man['treepalce']);

       // $this->_checkUser();
        $ji_c = $this->ji_Color();  //级别颜色
        $kd_c = $this->kd_Color();  //是否开通
        $mi_c = $this->Mi_Cheng();  //级别名称
        //var_dump($_SESSION['id']);
        if($_SESSION['id']==null){
        $_SESSION['id']=session('member_info')['id'];
        }

        $id = $_SESSION['id'];
        $member_rs = M('member') -> field('*') -> find($id);
        $voo=$this->feeratio['str5'][$member_rs['u_level']];//会员级别
        $nowday = strtotime(date('Y-m-d'));
       
        //$next_level=61+$member_rs['u_level'];
        //$next_l=$this->feeratio['str'.$next_level];
        //var_dump($this->feeratio['str'.$next_level]);

       // if($member_rs['monthly_card']<=0){$xtime='到期时间：暂无';  }
       //  if($member_rs['username']<=0){$user_name="姓名：暂无";  }
        $member   =  M ("member");
        $id  = session('member_info')['id'];
        $myid = $_SESSION['id'];
        $UID = (int)input('param.ID');
        if (empty($UID)) $UID = $id;

            $UserID=$_POST['UserID'];
            if (!empty($UserID)){
            if (strlen($UserID)>10 ){ $this->error( "错误操作！"); exit;  }
            
            $where = "p_path like '%,". $UID .",%' and user_id='". $UserID ."' ";

            $rs = $member ->where($where)->field('*')->find();
             
            exit;
            if($rs==false){
                $this->error('没有该用户1!');
                exit();
            }else{
                $UID = $rs['id'];
            }
        }


        $_SESSION['id'] = $UID;
        $where =array();
        $where['id'] = $UID;
        $field ='*';
        $rs = $member ->where($where)->field($field)->find();
        if (!$rs){
            $this->error('没有该用户!');
            exit();
        }else{

            
            $ID         = $rs['id'];
            $UserID     = $rs['user_id'];
            $NickName   = $rs['nickname'];
            $TreePlace  = $rs['treeplace'];   //区分左右 0为左边,1为右边
            $FatherID   = $rs['father_id'];    //安置人ID
            $isPay      = $rs['is_pay'];          //是否为正式(开通时为正式)
            $uLevel     = $rs['u_level'];      //级别
            $pPath      = $rs['p_path'];       //自已的路径
            $pLevel     = $rs['p_level'];     //层数(数字)
            $L          = $rs['zone_a'];
            $R          = $rs['zone_b'];
            $LR         = $rs['zone_c'];
//$xtime='到期时间'.date('Y-m-d h:i:s',$rs['monthly_card']);
          // $a=M('member')->where('id='.$rs['re_id'])->find();
                $re_name='直推:<br>'.$rs['re_uid'];
            // $SpareL         = $rs['shangqi_l'];
            // $SpareR         = $rs['shangqi_r'];
            // $SpareLR            = $rs['shangqi_lr'];
            // $benqiL         = $rs['benqi_l'];
            // $benqiR         = $rs['benqi_r'];
            // $benqiLR            = $rs['benqi_lr'];
            // 
           // dump($myid);die;
        }
        
        if($myid==$ID)$FatherID=$myid;
        if ($isPay>1) $isPay=1;
        if($rs['is_agent'] > 1){
            $isPay = 2;    //报单中心颜色
        }

        //显示层数
        $uLev = (int)input('param.uLev');        //$Lev 记录显示层数
        if (is_numeric($uLev) == false) $uLev = $_SESSION['uLev3'];
        if (is_numeric($uLev) == false) $uLev = 2;
        if ($uLev < 2 || $uLev > 11)    $uLev = 2;
        $_SESSION['uLev3']=$uLev;
        for ($i=1;$i<=$uLev;$i++){
            $Nums=$Nums+pow(3,$i);
        }
        global $TreeArray;
        $TreeArray=array();

        for ($i=0;$i<=$Nums;$i++){
            $TreeArray[$i]="<table border='0' cellpadding='0' cellspacing='1' class='tu_box'><tr><td class='tu_ko' style='background:#acbbc2;color:#fff;border:none'> 未开通 </td></tr></table>";
        }


    
      $is_agent=$this->feeratio['is_agent'];


        $bj = "style='background:". $kd_c[$isPay] ."';";  //表格背景色
        $StTab = "<table border='0' style='background:". $kd_c[$isPay] ."';' cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none". $ji_c[$uLevel] .";font-weight:bold;' class='ta_content'>";
        $MyYJ = "</td></tr>";
        
        //$MyYJ .= "<tr><td class='tu_l' $bj>$SpareL</td><td class='tu_z' $bj>$SpareR</td><td class='tu_r' $bj>$SpareLR</td></tr>";
        //$MyYJ .= "<tr><td class='tu_l' $bj>$benqiL</td><td class='tu_z' $bj>$benqiR</td><td class='tu_r' $bj>$benqiLR</td></tr>";
        //$MyYJ .= "<tr><td class='tu_l' $bj>$SpareL</td><td class='tu_z' $bj>余</td><td class='tu_r' $bj>$SpareR</td></tr>";
        //$MyYJ .= "<tr><td class='tu_l' $bj>$benqiL</td><td class='tu_z' $bj>新</td><td class='tu_r' $bj>$benqiR</td></tr>";
        

        $ZiJi   = $StTab."<a href='#' style='color:#fff'>".$UserID ."</a>". $MyYJ;
        // $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."'; cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>".$rs['username'] ."</a>". "</table>";
         $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."'; cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff;'>".$is_agent[$rs[is_agent]]."</a>". "</table>";
        // $ZiJi  .= "<table border='0' cellpadding='0' cellspacing='1' class='tu_box'>"."<tr style='background:". $kd_c[$isPay] ."';><td style='border:none'><a href='#' style='color:#fff'>".$re_name."</a>". "</td></tr></table>";

        $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>总业绩</a>". "</table>";
        // $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>".$xtime."</a>". "</table>";
       $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>". $rs['zone_a'] ."|". $rs['zone_c'] ."</a>". "</table>";
       $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>当前业绩</a>". "</table>";
        // $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>".$xtime."</a>". "</table>";
       $ZiJi   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>". $rs['l'] ."|". $rs['r'] ."</a>". "</table>";


       // $ZiJi .= "<tr><td  class='tu_l' style='border:none;color:#fff' $bj>$L/$next_l[0]|$R/$next_l[1]|$LR/$next_l[2]</td></tr>";

        $Str4C0 = "<table  border='0' cellpadding='0' cellspacing='1' class='tu_box'><tr><td class='tu_ko'>";
        $Str4C1 = "<a href='". __ROOT__ ."/index/member_add/TPL/";
        $Str4C4 = "</td></tr></table>";

        if ($isPay>0){
            $i=pow(3,$uLev);
            $j=($i+1)/2;
            $TreeArray['1']=$Str4C0.$Str4C1."0/RID/". $ID ."/FID/".$ID."' target='_self'>点击注册</a>".$Str4C4;
            $TreeArray[$j]=$Str4C0.$Str4C1."1/RID/". $ID ."/FID/".$ID."' target='_self'>点击注册</a>".$Str4C4;
          
            $TreeArray[$i]=$Str4C0.$Str4C1."2/RID/". $ID ."/FID/".$ID."' target='_self'>点击注册</a>".$Str4C4;
        }else{
//          $TreeArray['1']=$Str4C0.$Str4C1."0/RID/". $ID ."/FID/".$ID."' target='_self'>点击注册</a>".$Str4C4;
            //$TreeArray[$j]=$Str4C0.$Str4C1."1/FID/".$ID."' target='_self'>点击注册</a>".$Str4C4;
            //$TreeArray[$i]=$Str4C0.$Str4C1."2/FID/".$ID."' target='_self'>点击注册</a>".$Str4
        }

        $wop = '';
        $TreeArray['0']=$ZiJi;

       $this->Tree3_MtKass($UID,0,$pLevel,$uLev,$Str4C0,$Str4C1,$Str4C4,$TreeArray,$Nums);
        $this->Tree3_showTree($uLev,$TreeArray,$wop);

        //$fee_rs = M('fee')->field('s10')->find();
        $Level = explode('|',$fee_rs['s10']);
        $this->assign('Level',$Level);
        $this->assign('ColorUA',$ji_c);
        $this->assign('TU_Color',$kd_c);
        $this->assign('TU_MiCheng',$mi_c);
        $this->assign('UID',$UID);
        $this->assign('uLev',$uLev);
        $this->assign('FatherID',$FatherID);
        $this->assign('wop',$wop);
       
        $find=M('member')->where('id>0')->order('id desc')->limit(2)->select();

        $this->assign('find', $find);
        //var_dump($find);
        $this->assign('id', $_SESSION['think']['member_auth']['member_id']);
        return $this->fetch('Tree3');
    }  // end function

    //  三轨图---生成下层会员内容
    private function Tree3_MtKass($FatherID,$iL,$pLevel,$uLev,$Str4C0,$Str4C1,$Str4C4,&$TreeArray,$Nums){
        //$ji_c = $this->ji_Color();  //级别颜色
        $kd_c = $this->kd_Color();  //是否开通
        //$mi_c = $this->Mi_Cheng();  //级别名称

        if (!empty($FatherID)){
            //  var_dump($FatherID,$uLev,$pLevel);die;
            $member = M('member');
            $where = array();
            $where = "father_id=". $FatherID ." and p_level-". $pLevel ."<=". $uLev ." AND treeplace<3";
            $rss =M('member')->where($where)->field('*')->order("treeplace asc")->select();
        
            foreach($rss as $rs){
                
                if ($rs['treeplace']==0){
                    $k=$iL+1;
                }elseif($rs['treeplace']==1){
                    $i=($pLevel+$uLev)-$rs['p_level']+1;
                    $j=pow(3,$i);
                    $k=($j+1)/2+$iL;
                }else{
                    $i=($pLevel+$uLev)-$rs['p_level']+1;
                    $j=pow(3,$i);
                    $k=$j+$iL;
                }

                $i=($pLevel+$uLev)-$rs['p_level'];
                $Uo=$k+1;   //  1线
                $To=pow(3,$i)+$k;  //  3线
                $Yo=($Uo+$To)/2;   //  2线

                $Rid        = $rs['id'];
                $UserID     = $rs['user_id'];
                $NickName   = $rs['nickname'];
                $TreePlace  = $rs['treeplace'];   //区分左右 0为左边,1为右边
                $FatherID   = $rs['father_id'];    //安置人ID
                $isPay      = $rs['is_pay'];          //是否为正式(开通时为正式)
                $uLevel     = $rs['u_level'];      //级别
                $upLevel    = $rs['p_level'];
                $user_name=$rs['username'];

               // $a=M('member')->where('id='.$rs['re_id'])->find();
                $re_name='直推:<br>'.$rs['re_uid'];
                      //层数(数字)
                $L          = $rs['zone_a'];
                $R          = $rs['zone_b'];
                $LR         = $rs['zone_c'];
               
                // $voo=$this->feeratio['str5'][$rs['u_level']];//会员级别
                // $nowday = strtotime(date('Y-m-d'));
                // $xtime='到期时间'.date('Y-m-d h:i:s',$rs['monthly_card']);
                // $next_level=61+$rs['u_level'];
                // $next_l=$this->feeratio['str'.$next_level];
                // if($rs['monthly_card']<=0){$xtime='到期时间：暂无';  }
                if($rs['username']<=0){$user_name="姓名：暂无";  }

                // $SpareL     = $rs['shangqi_l'];
                // $SpareR     = $rs['shangqi_r'];
                // $SpareLR    = $rs['shangqi_lr'];
                // $benqiL     = $rs['benqi_l'];
                // $benqiR     = $rs['benqi_r'];
                // $benqiLR    = $rs['benqi_lr'];


                if ($isPay>1) $isPay=1;
                if($rs['is_agent'] > 1){
                    $isPay = 2;    //报单中心颜色
                }
             $is_agent=$this->feeratio['is_agent'];
                $bj = "style='background:". $kd_c[$isPay] ."';";  //表格背景色
                $StTab = "<table border='0' cellpadding='0' style='background:". $kd_c[$isPay] ."';' cellspacing='1' class='tu_box'><tr><td colspan='3' style='background:". $ji_c[$uLevel] .";font-weight:bold;border:none'>";
                $MyYJ  = "</td></tr>";
                
                //$MyYJ .= "<tr><td class='tu_l' $bj>$SpareL</td><td class='tu_z' $bj>$SpareR</td><td class='tu_r' $bj>$SpareLR</td></tr>";
                //$MyYJ .= "<tr><td class='tu_l' $bj>$benqiL</td><td class='tu_z' $bj>$benqiR</td><td class='tu_r' $bj>$benqiLR</td></tr>";
                
               $MyYJ .= "</table>";
               // $MyYJ   .= "<table border='0' cellpadding='0' cellspacing='1' class='tu_box'>"."<tr style='background:". $kd_c[$isPay] ."';><td style='border:none'><a href='#' style='color:#fff;'>".$rs['username']."</a>". "</td></tr></table>";
                  $MyYJ   .= "<table border='0' cellpadding='0' cellspacing='1' class='tu_box'>"."<tr style='background:". $kd_c[$isPay] ."';><td style='border:none'><a href='#' style='color:#fff'>".$is_agent[$rs[is_agent]]."</a>". "</td></tr></table>";
               // $MyYJ   .= "<table border='0' cellpadding='0' cellspacing='1' class='tu_box'>"."<tr style='background:". $kd_c[$isPay] ."';><td style='border:none'><a href='#' style='color:#fff;border:none'>".$re_name."</a>". "</td></tr></table>";
            
             $MyYJ   .= "<table border='0' cellpadding='0' cellspacing='1' class='tu_box'><tr style='background:". $kd_c[$isPay] ."';><td style='border:none'>"."<a href='#' style='color:#fff'>总业绩</a>". "</td></tr></table>";
               // $MyYJ   .= "<table border='0' cellpadding='0' cellspacing='1' class='tu_box'><tr style='background:". $kd_c[$isPay] ."';><td style='border:none'>"."<a href='#' style='color:#fff'>".$xtime."</a>". "</td></tr></table>";
              $MyYJ   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>". $rs['zone_a'] ."|". $rs['zone_c'] ."</a>". "</table>";
              $MyYJ   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>当前业绩</a>". "</table>";
              $MyYJ   .= "<table border='0' style='background:". $kd_c[$isPay] ."';cellpadding='0' cellspacing='1' class='tu_box'><tr><td colspan='3' style='border:none'>"."<a href='#' style='color:#fff'>". $rs['l'] ."|". $rs['r'] ."</a>". "</table>";




                $Str=$StTab."<a href='".__ROOT__."/statistic/Tree3/ID/".$Rid."' style='color:#fff'>".$UserID."</a>".$MyYJ;
                $Str4C2="/RID/". $Rid ."/FID/".$Rid."' target='_self'>点击注册</a>";

                if ($isPay > 0){
                    if ($Yo<=$Nums+1 && $i>0){
                        $TreeArray[$Uo]=$Str4C0.$Str4C1."0".$Str4C2.$Str4C4;
                        $TreeArray[$Yo]=$Str4C0.$Str4C1."1".$Str4C2.$Str4C4;
                     
                        $TreeArray[$To]=$Str4C0.$Str4C1."2".$Str4C2.$Str4C4;}
                   
                }else{
                    if ($Yo<=$Nums+1 && $i>0){
//                  $TreeArray[$Uo]=$Str4C0.$Str4C1."0".$Str4C2.$Str4C4;
                    //$TreeArray[$Yo]=$Str4C0.$Str4C1."1".$Str4C2.$Str4C4;
                    //$TreeArray[$To]=$Str4C0.$Str4C1."2".$Str4C2.$Str4C4;
                    }
                }
                $TreeArray[$k]=$Str;
                if ($upLevel < $pLevel + $uLev){
                    $this->Tree3_MtKass($Rid,$k,$pLevel,$uLev,$Str4C0,$Str4C1,$Str4C4,$TreeArray,$Nums);
                }
            }  //end for
        }  //end if
    }  //end function

    // 三轨图----生成表格内容
    private function Tree3_showTree($uLev,$TreeArray,&$wop){
        for ($i=1;$i<=$uLev;$i++){
            $Nums=$Nums+pow(3,$i);
        }
        $arr=array();
        global $arrs;
        $arrs=array();
        for ($i=0;$i<=$Nums;$i++){
            $arr[$i]=$TreeArray[$i];
        }
        $arrs[0][0]=$arr;
        for ($i=1;$i<=$uLev;$i++){
            for ($u = 1 ; $u <= pow(3,($i-1)) ; $u++){
                $yyyo=$arrs[$i-1][$u-1];
                $ta=array();
                $tar=count($yyyo);
                for ($ti=0 ; $ti<$tar ; $ti++){
                    $ta[$ti] = $yyyo[$ti+1];
                }
                $to=floor($tar/3)-1;
                $tarr1=array();
                $tarr2=array();
                $tarr3=array();
                for ($tj=0 ; $tj<=$to ; $tj++){
                    $tarr1[$tj] = $ta[$tj];
                     $tarr2[$tj] = $ta[$to+$tj+1];
                    $tarr3[$tj] = $ta[2*$to+$tj+2];
                }
                $sq=($u-1)*3;
                $arrs[$i][$sq] = $tarr1;
                // $arrs[$i][$sq+1] = $tarr2;//取消注释变成三轨道
                $arrs[$i][$sq+2] = $tarr3;
            }
        }
        $wid = '33%';
        $lhe = 30;
        $tps = __ROOT__.'/public/Images/tree/';

      
     
        $strL = "<img src='".$tps."t_tree_bottom_l.gif' height='".$lhe."'><img src='".$tps."t_tree_line.gif' width='".$wid."' height='".$lhe."'><img src='".$tps."t_tree_mid.gif' height='".$lhe."' alt='顶层'><img src='".$tps."t_tree_line.gif' width='".$wid."' height='".$lhe."'><img src='".$tps."t_tree_bottom_r.gif' height='".$lhe."'>";
   
       

        $wop="";
        for ($i = 0  ;  $i <= $uLev  ;  $i++){
            $wop.="<table width='100%' border='0' cellpadding='1' cellspacing='1'>";
            for ($t = 0  ;  $t <= 1  ;  $t++){
                if ($t != 1 or $i != $uLev){
                    $wop.="<tr align='center'>";
                    $oop= pow(3,$i)-1;
                    for ($j = 0  ;  $j <= $oop ;  $j++){
                        $eop=100/pow(3,$i);
                        if ($t==1){
                            $wop.="<td class='borderno' width='". $eop ."%' valign='top'>";
                          if($j!=1){
                            $wop.=$strL;}//去掉这个判断，变成三轨道的线
                        }else{
                            $bcxx=$arrs[$i][$j][0];
                            $rp=$i+1;
                            $wop.="<td class='borderlrt'  width='". $eop ."%' valign='top' title='第" . $rp . "层'>";
                            $wop.=$strW;
                            $wop.=$bcxx;
                            $wop.="</td>";
                        }
                        $wop.="</td>";
                    }
                    $wop.="</tr>";
                }
            }
            $wop.="</table>";
        }
        $wop.="</td></tr></table>";
    }



}
