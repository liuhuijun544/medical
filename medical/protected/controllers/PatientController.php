<?php

class PatientController extends Controller
{
	public function actions()
	{
		return array(
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha'=>array(
						'class'=>'CCaptchaAction',
						'backColor'=>0xFFFFFF,
				),
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page'=>array(
						'class'=>'CViewAction',
				),
		);
	}
	
	//病人列表
	public function actionIndex()
	{
		$this->pageTitle = "明保國醫館_病人列表";
		
		$search = array();
		if ($_REQUEST['search']){
			$search['name'] = $_REQUEST['search']['name'];
		}
		$this->render("index",array("search"=>$search));
	}
	
	public function actionGetList()
	{
		$page = intval($_REQUEST['page'])?intval($_REQUEST['page']):1;
		$limit = intval($_REQUEST['limit'])?intval($_REQUEST['limit']):1;
		
		//接口返回数据
		$result = array();
		$result['code'] = 0;//接口状态
		$result['msg'] = '暂无数据';//失败消息
		$result['count'] = 0;
		$result['data'] = array();//数据
		
		$c = new CDbCriteria();
		if ($_REQUEST['name']){
			$c->addCondition("name like '%{$_REQUEST['name']}%'");
		}
		$c->offset = ($page-1)*$limit;
		$c->limit = $limit;
		$c->order = "created_at desc";
		
		$patient = Patient::model()->findAll($c);
		
		$result['count'] = count($patient);
		
		if ($patient){
			foreach ($patient as $item){
				$operation = '<a class="layui-btn layui-btn-mini" lay-event="detail"  id="'.$item->id.'">查看</a>
							<a class="layui-btn layui-btn-mini" lay-event="edit"  id="'.$item->id.'">编辑</a>
  							<a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del"  id="'.$item->id.'">删除</a></div>';
				$tmp['operation'] = $operation;
				$tmp['id'] = $item->id;
				$tmp['name'] = $item->name;
				$tmp['sex'] = $item->sex==1?"男":($item->sex==2?"女":"未知");
				$tmp['age'] = $item->age;
				$tmp['created_at'] = $item->created_at?date("Y-m-d H:i:s",$item->created_at):'';
				$tmp['address'] = $item->address;
				array_push($result['data'], $tmp);
			}
		}
		
		echo json_encode($result);
	}
	
	/**
	 * 药品新增
	 */
	public function actionAdd()
	{
		$this->pageTitle = "明保國醫館_病人新增";
		
		$this->render("form",array("type"=>"add"));
	}
	
	public function actionUpdate()
	{
		$this->pageTitle = "明保國醫館_病人修改";
		
		$id = intval($_REQUEST['id']);
		$patient = Patient::model()->findByPk($id);
		$this->render("form",array("type"=>"edit","patient"=>$patient));
	}
	
	public function actionDel()
	{
		$id = intval($_REQUEST['id']);
		if ($id<=0){
			echo "参数错误";
		}else{
			$result = Patient::model()->deleteByPk($id);
			if ($result) echo 1;
			else echo "删除失败";
		}
	}
	
	/**
	 * 新增修改
	 */
	public function actionPostAjax(){
		$data = $_REQUEST['data'];
		try {
			if (!is_array($data)) throw new Exception("未接受到数据");
			
			$type = $data['type']?$data['type']:'add';
			$name = $data['name'];
			$sex = $data['sex'];
			$age = $data['age'];
			$address = $data['address'];
			
			if (!$name || !$sex|| !$age) throw new Exception("必填项信息不能为空");
			
			if ($type == "edit"){
				$id = intval($data['id']);
				$patient = Patient::model()->findByPk($id);
				if (!$id || !$patient) throw new Exception("找不到对应病人信息");
				$patient->name = $name;
				$patient->sex = $sex;
				$patient->age = $age;
				$patient->address = $address;
				if (!$patient->update()) throw new Exception("更新失败");
			}else{
				$patient= new Patient();
				$patient->name = $name;
				$patient->sex = $sex;
				$patient->age = $age;
				$patient->address = $address;
				$patient->created_at = time();
				if (!$patient->insert()) throw new Exception("插入数据失败");
			}
			echo 1;//成功
		}catch (Exception $e){
			echo $e->getMessage();
		}
	}
	
	/**
	 * 查看
	 */
	public function actionCheck()
	{
		$this->pageTitle = "明保國醫館_查看病人信息";
		$id = intval($_REQUEST['id']);
		
		//获取病人信息
		$patient = Patient::model()->findByPk($id);
		
		//获取之前所有药方
		$c = new CDbCriteria();
		$c->with = "detail";
		$c->addCondition("t.patient_id = :pid");
		$c->params = array(":pid"=>$id);
		$c->order = "created_at desc";
		$scription = Prescription::model()->findAll($c);
		
		$this->render("check",array("patient"=>$patient,"scription"=>$scription));
	}
}