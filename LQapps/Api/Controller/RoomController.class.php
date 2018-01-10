<?php
/*
项目：狸想家【建誉集团】
开发日期始于：20161108
作者:国雾院theone(438675036@qq.com)、狸想家精英团队
说明:会员中心
家装:hd(home-decoration)
*****************************************************************************
(1) 返回内容为json格式，采用UTF-8编码。
(2) 信息内容中含有时间字段的，字段值为urlEncode格式。
(3) 返回内容{"status":0,"msg":"操作提示","data":"回调数据","url":"回调响应地址","note":"备注"};
(4) 用户请求加权文档，统一传入uid,token两值。
*****************************************************************************
*/

namespace Api\Controller;

use Think\Controller;

defined('in_lqweb') or exit('Access Invalid!');

class RoomController extends PublicController
{
    protected $room;
    /** 初始化*/
    public function __construct()
    {

        parent::__construct();
        $this->room = D('Room');
        //免死金牌
        $action_no_login_array = array('get-openid', 'wx-return-openid', 'login', 'wx-login', 'openid-login');
        if (in_array(ACTION_NAME, $action_no_login_array)) {

        } else {
            self::apiCheckToken();//用户认证
        }
    }
    public function createRoom()
    {
        //nikename作为房间名
        $_POST['zc_title'] = $this->login_member_info['nikename'];
        //生成房间编号
        $_POST['zc_number'] = $_SESSION['zc_number'];
        $flag=  $this->room->createRoom($_POST);
        if($flag){
            unset($_SESSION['zc_number']);
            $redata = array('msg'=>'创建成功','status'=>1,'data'=>$_POST);
            $this->ajaxReturn($redata);
        }else{
            $redata = array('msg'=>'创建失败,缺少参数','status'=>0);
            $this->ajaxReturn($redata);
        }
    }
    //获取房间号
    public function getRoorNumber(){
        $id = $this->login_member_info['member_id'];
        $zc_number = create_room_code($id);
        $_SESSION['zc_number'] = $zc_number;
        if($zc_number){
            $this->ajaxReturn(array('msg'=>'请求成功','status'=>1,'data'=>$zc_number));
        }else{
            $this->ajaxReturn(array('msg'=>'请求失败','status'=>0));
        }
    }

    //房间列表
    public  function getRoomList(){
        $list=$this->room->getData($_POST);
        if(!$list){
            $this->ajaxReturn(array('msg'=>'数据为空','status'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'请求成功','status'=>1,'data'=>$list));
        }
    }
}