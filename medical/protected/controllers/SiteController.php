<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
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

	/**
	 * 药方列表
	 */
	public function actionIndex()
	{
		$this->pageTitle = '明保國醫館_药方列表';
		//获取药品名称
		$medicine = Medicine::getList();
		
		//搜索数组定义
		$search = array();
		if ($_REQUEST['search']){
			$search['username'] = $_REQUEST['search']['username'];
			$search['medicine'] = $_REQUEST['search']['medicine'];
			$search['start'] = $_REQUEST['search']['start'];
			$search['end'] = $_REQUEST['search']['end'];
		}
		$this->render('index',array('medicine'=>$medicine,'search'=>$search));
	}
	
	/**
	 * 接口，获取药方列表数据
	 */
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
		
		//查询
		$model = PrescriptionView::model();
		$c=New CDbCriteria();
		
		//查询总价
		$c_new = new CDbCriteria();
		$c_new->select = "sum(totalMoney) as total_money";
		//搜索条件
		if ($_REQUEST['username']){
			$c->addCondition("pname like '%{$_REQUEST['username']}%'");
// 			$c->compare("pname", $_REQUEST['username']);
			$c_new->join = "left join patient p on (t.patient_id = p.id)";
			$c_new->addCondition("p.name like '%{$_REQUEST['username']}%'");
		}
		if ($_REQUEST['medicine']){
			$me = intval($_REQUEST['medicine']);
			$c->addCondition("mid ={$me}");
			$c_new->join = "left join prescription_detail pd on (t.id = pd.prescription_id)";
			$c_new->addCondition("pd.medicine_id ={$me}");
		}
		if ($_REQUEST['start']){
			$start = strtotime($_REQUEST['start']);
			$c->addCondition("created_at >={$start}");
			$c_new->addCondition("created_at >={$start}");
		}
		if ($_REQUEST['end']){
			$end = strtotime($_REQUEST['end'])+24*3600-1;
			$c->addCondition("created_at < {$end}");
			$c_new->addCondition("created_at < {$end}");
		}
		//获取查询条件内的开单总价格
		$count_money = Prescription::model()->find($c_new);
		//通过条件获取数据和总数
		$c_count = clone $c;
		$c_count->select = "count(id) as count_num,sum(weight) as count_weight,sum(amount) as count_amount,sum(total) as count_total";
		$all = PrescriptionView::model()->find($c_count);
		$result['count'] = $all->count_num;
		$result['count_money'] = $count_money->total_money?$count_money->total_money:0;
		$result['count_weight'] = $all->count_weight?$all->count_weight:0;
		$result['count_amount'] = $all->count_amount?$all->count_amount:0;
		$result['count_total'] = $all->count_total?$all->count_total:0;
		
		
		$c->offset = ($page-1)*$limit;
		$c->limit = $limit;
		$c->order = "created_at desc, main_id";
		$detail= $model->findAll($c);
		if ($detail){
			$main_id = 0;
			foreach ($detail as $item){
				if ($item->main_id != $main_id){//不同的表示不是同一张药方
// 					echo $item->main_id."------".$main_id."</br>";
					$main_id = $item->main_id;
					$operation = '<div><a class="layui-btn layui-btn-mini" lay-event="detail" id="'.$item->main_id.'">查看</a>
  							<a class="layui-btn layui-btn-mini" lay-event="edit"  id="'.$item->main_id.'">编辑</a>
  							<a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del"  id="'.$item->main_id.'">删除</a></div>';
					$tmp['id'] = $item->id;
					$tmp['operation'] = $operation;
					$tmp['username'] = $item->pname;
					$tmp['sex'] = $item->sex==1?"男":($item->sex==2?"女":"未知");
					$tmp['age'] = $item->age;
					$tmp['address'] = $item->address;
					$tmp['etiology'] = $item->etiology;
					$tmp['medicine'] = $item->mname;
					$tmp['weight'] = $item->weight;
					$tmp['amount'] = $item->amount;
					$tmp['way'] = $item->way;
					$tmp['main_id'] = $item->main_id;
					$tmp['price'] = $item->pdprice;
					$tmp['total'] = $item->total;
					$tmp['totalMoney'] = $item->totalMoney;
					array_push($result['data'], $tmp);
				}else{//表示是同一张药方，相同信息不用展示
					$tmp['operation'] = '';
					$tmp['id'] = $item->id;
					$tmp['medicine'] = $item->mname;
					$tmp['weight'] = $item->weight;
					$tmp['amount'] = $item->amount;
					$tmp['way'] = $item->way;
					$tmp['main_id'] = $item->main_id;
					$tmp['price'] = $item->pdprice;
					$tmp['total'] = $item->total;
					$tmp['totalMoney'] = $item->totalMoney;
					array_push($result['data'], $tmp);
				}
			}
		}
		
		echo json_encode($result);
	}
	
	/**
	 * 删除操作
	 */
	public function actionDel()
	{
		$main_id = intval($_REQUEST['mainId']);
		if ($main_id<=0){
			echo "参数错误";
		}else{
			//添加事物
			$transaction=Yii::app()->db->beginTransaction();
			try {
				//找到对应主表和详情表数据，删除
				Prescription::model()->deleteByPk($main_id);
				
				PrescriptionDetail::model()->deleteAll("prescription_id = {$main_id}");
				
				echo "1";
				$transaction->commit();
			}catch (Exception $e){
				echo "操作失败";
				$transaction->rollBack();//事务回滚
			}
		}
	}
	
	
	/**
	 * 开药方
	 */
	public function actionAdd()
	{
		$this->pageTitle = '明保國醫館_开单页面';
		
		$msg = $_REQUEST['msg'];
		//获取药名
		$array_medicine = Medicine::getList();
		$this->render('add',array("array_medicine"=>$array_medicine,"msg"=>$msg));
	}
	/**
	 * 提交结果处理
	 */
	public function actionAddPost()
	{	
		//post过来的数据接收
		$patientName = $_REQUEST['patientName'];
		$patinetType = $_REQUEST['patinetType'];//
		$sex = $_REQUEST['sex'];
		$age = $_REQUEST['age'];
		$address = $_REQUEST['address'];
		$etiology = $_REQUEST['etiology'];
		$totalMoney = $_REQUEST['totalMoney'];
		$way = $_REQUEST['way'];
		$medicine = $_REQUEST['medicine'];
		$weight= $_REQUEST['weight'];
		$amount = $_REQUEST['amount'];
		$price = $_REQUEST['price'];
		$total = $_REQUEST['total'];
		
		//逻辑处理-添加事物
		$transaction=Yii::app()->db->beginTransaction();
		try {
			//第一步、判断病人是否已存在，存在直接用，不存在需要入库;获取到病人的id
			$patient = Patient::model()->find("name = :name and sex = :sex and age = :age",array(":name"=>$patientName,":sex"=>$sex,":age"=>$age));
			if (!$patient){
				$patient = new Patient();
				$patient->name = $patientName;
				$patient->sex = $sex;
				$patient->age = $age;
				$patient->address = $address?$address:"";
				$patient->created_at = time();
				if(!$patient->insert()){
					throw new Exception("新增病人信息失败");
				}
			}
			$patientId = $patient->id;
			
			//第二步、插入药方表的主表
			$prescription = new Prescription();
			$prescription->patient_id = $patientId;
			$prescription->etiology = $etiology;
			$prescription->created_at = time();
			$prescription->way = $way?$way:"";
			$prescription->totalMoney = $totalMoney;
			if (!$prescription->insert()){
				throw new Exception("插入药品主表失败");
			}
			
			//第三部、插入具体的明细,根据药名来，有药名才能插入
			$med = Medicine::model()->findAll();
			$medicine_array = array();
			foreach ($med as $item){
				$medicine_array[$item->id] = $item->name;
			}
			
			
			
			$pId = $prescription->id;
			
			$a = 0;
			for ($i=0;$i<count($medicine);$i++){
				if (!$medicine[$i] && !$weight[$i] && !$amount[$i] && !$price[$i] && !$total[$i]){
					$a ++;
					continue;
				}
				if (!$weight[$i] || !$amount[$i] || !$price[$i] ||!$total[$i]){
					throw new Exception("药品明细信息不完整");
				}
				$prescription_detail = new PrescriptionDetail();
				$prescription_detail->prescription_id = $pId;
				$prescription_detail->medicine_id = intval($medicine[$i]);
				$prescription_detail->medicine_name = $medicine_array[$medicine[$i]];
				$prescription_detail->weight = $weight[$i];
				$prescription_detail->amount = $amount[$i];
				$prescription_detail->price = $price[$i];
				$prescription_detail->total = $total[$i];
				if (!$prescription_detail->insert()) {
					throw new Exception("药品明细插入失败");
				}
			}
			if ($a == count($medicine)){
				throw new Exception("药品明细不能为空");
			}
			//完成,事物提交
			$transaction->commit();
			$this->redirect(Yii::app()->createUrl("site/index"));//成功跳转到这里
		}catch (Exception $e){
			$transaction->rollBack();//事务回滚
			$this->redirect(Yii::app()->createUrl("site/add",array("msg"=>$e->getMessage())));
		}
	}
	
	/**
	 * 查看药方
	 */
	public function actionCheck()
	{
		$this->pageTitle = '明保國醫館_查看药方';
		$id = intval($_REQUEST['id']);
		//根据主表id，查询出视图的所有数据
		
		$prescription = PrescriptionView::model()->findAll("main_id = {$id}");
		
		//找到对应的历史药方
		if ($prescription[0]){
			$pId = intval($prescription[0]->pid);
			$main_id = intval($prescription[0]->main_id);
// 			$scription = Prescription::model()->with("detail")->findAll("t.patient_id = {$pId} and t.id <>{$main_id} order by created_at desc");
			$c = new CDbCriteria();
			$c->with = "detail";
			$c->addCondition("t.patient_id = :pid and t.id<>:main_id");
			$c->params = array(":pid"=>$pId,":main_id"=>$main_id);
			$c->order = "created_at desc";
			$scription = Prescription::model()->findAll($c);
		}
		
		$this->render("check",array("prescription"=>$prescription,"scription"=>$scription));
	}
	
	/**
	 * 药方修改
	 */
	public function actionUpdate()
	{
		$this->pageTitle = '明保國醫館_修改药方';
		$id = intval($_REQUEST['id']);
		$msg = $_REQUEST['msg'];
		
		$array_medicine = Medicine::getList();
		//根据主表id，查询出视图的所有数据
		$prescription = PrescriptionView::model()->findAll("main_id = {$id}");
		
		$this->render("update",array("prescription"=>$prescription,"array_medicine"=>$array_medicine,"msg"=>$msg));
	}
	
	public function actionUpdatePost()
	{
		
		//post过来的数据接收
		$patientName = $_REQUEST['patientName'];
		$patinetType = $_REQUEST['patinetType'];//
		$sex = $_REQUEST['sex'];
		$age = $_REQUEST['age'];
		$address = $_REQUEST['address'];
		$main_id = intval($_REQUEST['main_id']);
		$etiology = $_REQUEST['etiology'];
		$totalMoney = $_REQUEST['totalMoney'];
		$way = $_REQUEST['way'];
		$detail_id = $_REQUEST['detail_id'];
		$medicine = $_REQUEST['medicine'];
		$weight= $_REQUEST['weight'];
		$amount = $_REQUEST['amount'];
		$price = $_REQUEST['price'];
		$total = $_REQUEST['total'];
		
		//逻辑处理-添加事物
		$transaction=Yii::app()->db->beginTransaction();
		try {
			//第一步、判断病人是否已存在，存在直接用，不存在需要入库;获取到病人的id
			$patient = Patient::model()->find("name = :name and sex = :sex and age = :age",array(":name"=>$patientName,":sex"=>$sex,":age"=>$age));
			if (!$patient){
				$patient = new Patient();
				$patient->name = $patientName;
				$patient->sex = $sex;
				$patient->age = $age;
				$patient->address = $address?$address:"";
				$patient->created_at = time();
				if(!$patient->insert()){
					throw new Exception("新增病人信息失败");
				}
			}
			$patientId = $patient->id;
			
			//第二步、更新主表信息
			$prescription = Prescription::model()->findByPk($main_id);
			if (!$prescription) throw new Exception("找不到药品主表信息");
			$prescription->patient_id = $patientId;
			$prescription->etiology = $etiology;
			$prescription->way = $way?$way:"";
			$prescription->totalMoney = $totalMoney;
			if (!$prescription->update()){
				throw new Exception("修改药品主表失败");
			}
			//第三步、更新明细
			$med = Medicine::model()->findAll();
			$medicine_array = array();
			foreach ($med as $item){
				$medicine_array[$item->id] = $item->name;
			}
			
			if (!is_array($medicine) || count($medicine)==0) {
				throw new Exception("找不到对应的药品相关信息");
			}
			//完全删除旧的明细，新的明细新增
			$i = PrescriptionDetail::model()->deleteAll("prescription_id = :main_id",array(":main_id"=>$main_id));
			if (!$i) throw new Exception("旧明细删除失败");
			for ($i=0;$i<count($medicine);$i++){
				//如果不存在就新增
				if (!$medicine[$i] && !$weight[$i] && !$amount[$i] && !$price[$i] && !$total[$i]) continue;
				$prescription_detail = new PrescriptionDetail();
				$prescription_detail->prescription_id = $main_id;
				$prescription_detail->medicine_id = intval($medicine[$i]);
				$prescription_detail->medicine_name = $medicine_array[$medicine[$i]];
				$prescription_detail->weight = $weight[$i];
				$prescription_detail->amount = $amount[$i];
				$prescription_detail->price = $price[$i];
				$prescription_detail->total = $total[$i];
				if (!$prescription_detail->insert()) {
					throw new Exception("药品明细更新失败");
				}
			}
			//更新完成
			$transaction->commit();
			$this->redirect(Yii::app()->createUrl("site/index"));//成功跳转到这里
		}catch (Exception $e){
			$transaction->rollBack();//事务回滚
			$this->redirect(Yii::app()->createUrl("site/update",array("id"=>$main_id,"msg"=>$e->getMessage())));
		}
	}
	
	
	//根据药品id搜索价格
	public function actionSearchMedicine()
	{
		$id = intval($_REQUEST['id']);
		if ($id){
			$medicine = Medicine::model()->findByPk($id);
			echo $medicine?$medicine->price:"";
		}
	}
	
	//病人名字搜索
	public function actionSearchPatient()
	{
		if (isset($_REQUEST['name'])){
			$name = $_REQUEST['name'];
		}else{
			$name = "无结果";
		}
		$patient = Patient::model()->findAll("name like '%{$name}%' order by created_at desc  limit 15");
		
		$this->renderPartial("_searchPatient",array("patient"=>$patient));
	}
	

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}