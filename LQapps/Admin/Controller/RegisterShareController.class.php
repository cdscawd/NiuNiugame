<?php // RegisterShare 会员注册分享日志 
namespace Admin\Controller;
use Think\Controller;
use LQLibs\Util\BootstrapForm as Form;//表单填充插件

class RegisterShareController extends PublicController{
	public $myTable;
	protected $myForm = array(
		//标题
		'tab_title'=>array(1=>'基本信息'),
		//通用信息
		'1'=>array(
		array('select', 'zc_type', "注册入口",1,'{"required":"1","dataType":"","dataLength":"","readonly":0,"disabled":0,"please":"请选择注册入口"}'),
		array('text', 'zc_referer_accout', "推荐人手机",1,'{"required":"1","dataType":"mobile","dataLength":"","readonly":0,"disabled":0,"maxl":11}'),
		array('text', 'zc_member_account', "被推荐人手机",1,'{"required":"1","dataType":"mobile","dataLength":"","readonly":0,"disabled":0,"maxl":11}'),
		)		
	);	
    /** 初始化*/
    public function __construct() {
		parent::__construct();
		$this->myTable = M($this->pcTable);//主表实例化
	}

    
	//列表页
    public function index() {
		//列表表单初始化****start
		$page_parameter["s"]=$this->getSafeData('s');
		$this->reSearchPara($page_parameter["s"]);//反回搜索数
		$search_content_array=array(
			'pagesize'=>urldecode(I('get.pagesize','0','int')),
			'fkeyword'=>trim(urldecode(I('get.fkeyword',$this->keywordDefault))),
			'keymode'=>urldecode(I('get.keymode','1','int')),
			'open_time'=>urldecode(I('get.open_time','0','int')),
			'time_start'=>I('get.time_start',lq_cdate(0,0,(-604800))),
			'time_end'=>I('get.time_end',lq_cdate(0,0)),
			'type'=>I('get.type',''),			
		);
		$this->assign("search_content",$search_content_array);//搜索表单赋值
		
		//sql合并
		$sqlwhere_parameter=" 1 ";//sql条件
		if($search_content_array["fkeyword"]&&$search_content_array["fkeyword"]!=$this->keywordDefault){
			if($search_content_array["keymode"]==1){
			$sqlwhere_parameter.=" and zc_referer_accout ='".$search_content_array["fkeyword"]."' ";
			}else{
			$sqlwhere_parameter.=" and (zc_referer_accout like'".$search_content_array["fkeyword"]."%' or zc_member_account like'".$search_content_array["fkeyword"]."%') ";
			}	
		}
		if($search_content_array["type"]!=''){
			if($search_content_array["type"]==1){
				$sqlwhere_parameter.=" and zc_type ='朋友圈' ";
			}elseif($search_content_array["type"]==2){
				$sqlwhere_parameter.=" and zc_type ='朋友' ";				
			}else{
				$sqlwhere_parameter.=" and zc_type ='APP' ";
			}
		}	
		
		if($search_content_array["open_time"]==1&&$search_content_array["time_start"]&&$search_content_array["time_end"]){
				$ts=strtotime($search_content_array["time_start"]." 00:00:00");
				$te=strtotime($search_content_array["time_end"]." 23:59:59");
				$sqlwhere_parameter.=" and zn_cdate >=".$ts." and zn_cdate<=".$te;	
	   }

		//首页设置
		$page_title=array('checkbox'=>'checkbox','no'=>L("LIST_NO"),'zn_cdate'=>'注册时间','zc_type'=>'注册入口','zc_referer_accout'=>'推荐人帐号','zc_member_account'=>'新注册会员帐号','os'=>L("LIST_OS"));
		$page_config = array(
				'field'=>"`id`,`zc_type`,`zn_referer_id`,`zc_referer_accout`,`zc_member_account`,`zn_cdate`",
				'where'=>$sqlwhere_parameter,
				'order'=>"id DESC",
				'title'=>$page_title,
				'thinkphpurl'=>__CONTROLLER__."/",
		);		
		if($search_content_array["pagesize"]) C("PAGESIZE",$search_content_array["pagesize"]);
		//列表表单初始化****end
		
        $count = $this->myTable->where($sqlwhere_parameter)->count();
		$page = new \LQLibs\Util\Page($count, C("PAGESIZE"), $page_parameter);//载入分页类
        $showPage = $page->admin_show();
        $this->assign("page", $showPage);
        $this->assign("list", $this->C_D->lqList($page->firstRow, $page->listRows,$page_config));
		$this->assign('empty_msg',$this->tableEmptyMsg(count($page_title)));
		$this->assign("page_config",$page_config);//列表设置赋值模板
        $this->display();
    }
	

	// 插入/添加
    public function add() {
        if (IS_POST) {
            $this->ajaxReturn($this->C_D->lqSubmit());
        } else {
			$lcdisplay='Public/common-edit';//引用模板
			
			//表单数据初始化s
			$form_array=lq_post_memory_data();//获得上次表单的记忆数据
			$form_array["id"]='';
			$form_array["zc_type_data"]=array("朋友圈"=>"朋友圈","朋友"=>"朋友","APP"=>"APP");
			$form_array["zc_referer_accout"]='13425647971';
			//$form_array["zc_member_account"]='13425647972';
			$Form=new Form($this->myForm,$form_array,$this->myTable->getCacheComment());
			$this->assign("LQFdata",$Form->createHtml());//表单数据
			//表单数据初始化s
            $this->display($lcdisplay);
        }
    }	

	// 更新/编辑
    public function edit() {
        if (IS_POST) {
            $this->ajaxReturn($this->C_D->lqSubmit());
        } else {
			$lcdisplay='edit';//引用模板
			
			//读取数据
			$data = $this->myTable->where("id=".$this->lqgetid)->find();
			if(!$data) {$this->error(C("ALERT_ARRAY")["recordNull"]);}//无记录
			$this->pagePrevNext($this->myTable,"id","zc_referer_accout");//上下页
			
			//表单数据初始化s
			$form_array=array();
			$form_array["os_record_time"]=$this->osRecordTime($data);//操作时间
			foreach ($data as $lnKey => $laValue) {
				$form_array[$lnKey]=$laValue;
			}
			$Form=new Form($this->myForm,$form_array,$this->myTable->getCacheComment());
			$this->assign("LQFdata",$Form->createHtml());//表单数据
			//表单数据初始化s

            $this->display($lcdisplay);
        }
    }

	//多记录审批 
    public function opVisibleCheckbox() {$this->ajaxReturn(array('status' => 0, 'msg' => "功能已关闭"));}		
	//更改字段值 
    public function opProperty() {$this->ajaxReturn(array('status' => 0, 'msg' => "功能已关闭"));}
}
?>