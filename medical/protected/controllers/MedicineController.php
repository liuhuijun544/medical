<?php

class MedicineController extends Controller
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
	
	//药品列表
	public function actionIndex()
	{
		$this->pageTitle = "明保國醫館_药品列表";
		
		$search = array();
		if ($_REQUEST['search']){
			$search['mname'] = $_REQUEST['search']['mname'];
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
		if ($_REQUEST['mname']){
			$c->addCondition("name like '%{$_REQUEST['mname']}%' or spell like '%{$_REQUEST['mname']}%'");
		}
		$c->offset = ($page-1)*$limit;
		$c->limit = $limit;
		$c->order = "created_at desc";
		
		$medicine = Medicine::model()->findAll($c);
		
		$result['count'] = count($medicine);
		
		if ($medicine){
			foreach ($medicine as $item){
				$operation = '<a class="layui-btn layui-btn-mini" lay-event="edit"  id="'.$item->id.'">编辑</a>
  							<a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del"  id="'.$item->id.'">删除</a></div>';
				$tmp['operation'] = $operation;
				$tmp['id'] = $item->id;
				$tmp['name'] = $item->name;
				$tmp['spell'] = $item->spell;
				$tmp['price'] = $item->price;
				$tmp['created_at'] = $item->created_at?date("Y-m-d H:i:s",$item->created_at):'';
				$tmp['desc'] = $item->desc;
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
		$this->pageTitle = "明保國醫館_药品新增";
		
		$this->render("form",array("type"=>"add"));
	}
	
	public function actionUpdate()
	{
		$this->pageTitle = "明保國醫館_药品修改";
		
		$id = intval($_REQUEST['id']);
		$medicine = Medicine::model()->findByPk($id);
		$this->render("form",array("type"=>"edit","medicine"=>$medicine));
	}
	
	public function actionDel()
	{
		$id = intval($_REQUEST['id']);
		if ($id<=0){
			echo "参数错误";
		}else{
			$result = Medicine::model()->deleteByPk($id);
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
			$name = $data['medicine'];
			$spell = $data['spell'];
			$price = $data['price'];
			$desc = $data['desc'];
			
			if (!$name || !$spell || !$price) throw new Exception("必填项信息不能为空");
			
			if ($type == "edit"){
				$id = intval($data['id']);
				$medicine = Medicine::model()->findByPk($id);
				if (!$id || !$medicine) throw new Exception("找不到对应药品信息");
				$medicine->name = $name;
				$medicine->spell = $spell;
				$medicine->price = $price;
				$medicine->desc = $desc;
				if (!$medicine->update()) throw new Exception("更新失败");
			}else{
				$medicine = new Medicine();
				$medicine->name = $name;
				$medicine->spell = $spell;
				$medicine->price = $price;
				$medicine->desc = $desc;
				$medicine->created_at = time();
				if (!$medicine->insert()) throw new Exception("插入数据失败");
			}
			echo 1;//成功
		}catch (Exception $e){
			echo $e->getMessage();
		}
	}
}