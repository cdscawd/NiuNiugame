<?php
namespace Admin\Model;
use Think\Model;

class RoomModel extends PublicModel {
	/* 用户模型自动验证 */
	protected $_validate = array(
		array('zc_title','require','房名必须填写',self::MUST_VALIDATE),
		array('zc_title','1,100','房名在1~100个字符',self::MUST_VALIDATE,'length'),
	);

	/* 用户模型自动完成 */
	protected $_auto = array(
		array('zl_visible', '1', self::MODEL_INSERT),
		array('zn_cdate', NOW_TIME, self::MODEL_INSERT),
		array('zn_mdate', NOW_TIME, self::MODEL_BOTH),	
	);		
	
    /** 初始化*/
    public function __construct() {
		parent::__construct();
		$this->pc_os_label =  "zc_title";//数据表显示标题字段
        $this->pc_index_list =  "RoomCard/index";//ajax返回首页

    }

	//列表页
    public function lqList($firstRow = 0, $listRows = 20, $page_config=array('field'=>'*','where'=>' 1 ','order'=>'`id` DESC')) {
		$list = $this->field($page_config["field"])->where($page_config["where"])->order($page_config["order"])->limit("$firstRow , $listRows")->select();	
		foreach ($list as $lnKey => $laValue) {
			$list[$lnKey]['title'] = $laValue["zc_title"];
			if($laValue["zc_image"]){
				$list[$lnKey]['image'] = $laValue["zc_image"];
			}else{
				$list[$lnKey]['image'] = NO_PICTURE_ADMIN;
			}
			$list[$lnKey]['zn_cat_id_label'] = $laValue['zn_cat_id'] == 1 ? C("ROOM_TYPE")[1] : C("ROOM_TYPE")[2];;
			$list[$lnKey]['visible_label'] = $laValue['zl_visible'] == 1 ? C("USE_STATUS")[1] : C("USE_STATUS")[0];
			$list[$lnKey]['visible_button'] = $laValue['zl_visible'] == 1 ?  C("ICONS_ARRAY")['unapprove']: C("ICONS_ARRAY")['approve'];
			$list[$lnKey]['no'] = $firstRow+$lnKey+1;
        }
        return $list;
    }

	//数据保存
	protected function _before_write(&$data){}	
	public function lqSubmit(){return $this->lqCommonSave();}

	//确保tag|有效性
	protected function str_replace_tag($value){return str_replace("｜","|",$value);}
	
	//确保keyword|有效性
	protected function str_replace_keyword($value){return str_replace("，",",",$value);}	


    //更改-是非首页 
    public function setProperty() {
		$lcop=I("get.tcop",'is_index');
		$data=array();
        $data["id"] = I("get.tnid",'0','int');
		if($lcop=='is_index'){
			$data['zl_is_index'] = I("get.vlaue",'0','int') == 1 ? 0 : 1;
			$op_data= array("status" => $data['zl_is_index'], "txt" => $data['zl_is_index'] == 1 ? "是首页" : "非首页" ) ;			
		}elseif($lcop=='is_good'){
			$data['zl_is_good'] = I("get.vlaue",'0','int') == 1 ? 0 : 1;
			$op_data= array("status" => $data['zl_is_good'], "txt" => $data['zl_is_good'] == 1 ? "是精品" : "非精品" ) ;			
		}else{
			return array('status' => 0, 'msg' => L("ALERT_ARRAY")["dataOut"]);
		}
		$data['zn_mdate'] =NOW_TIME ;
        if ($this->save($data)) {
			$this->lqAdminLog($data["id"]);//写入日志
            return array('status' => 1, 'msg' => C("ALERT_ARRAY")["success"], 'data' =>$op_data );
        } else {
            return array('status' => 0, 'msg' => C("ALERT_ARRAY")["fail"]);
        }
    }	

}

?>
