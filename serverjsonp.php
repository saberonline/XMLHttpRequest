<?php
//设置页面内容是html编码格式是utf-8
//header("Content-Type: text/plain;charset=utf-8"); 


// ***************start XHR2****************

// header('Access-Control-Allow-Origin:*');
// header('Access-Control-Allow-Methods:POST,GET');
// header('Access-Control-Allow-Credentials:true'); 

//*****************end XHR2********************



header("Content-Type: application/json;charset=utf-8"); 
//header("Content-Type: text/xml;charset=utf-8"); 
//header("Content-Type: text/html;charset=utf-8"); 
//header("Content-Type: application/javascript;charset=utf-8"); 


$staff = array
	(
		array("name" => "洪七", "number" => "101", "sex" => "男", "job" => "总经理"),
		array("name" => "郭靖", "number" => "102", "sex" => "男", "job" => "开发工程师"),
		array("name" => "黄蓉", "number" => "103", "sex" => "女", "job" => "产品经理")
	);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	search();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
	create();
}

function search(){




	//JSONP只支持get请求，而且JSONP返回的是一个数组
	// 变动
	$jsonp = $_GET["callback"];//获取到callback,因为在前端给jsonp参数取的名字叫callback任意名都可以，只要和前端命名一致
	// end 变动







	if (!isset($_GET["number"]) || empty($_GET["number"])) {
		echo $jsonp . '({"success":false,"msg":"参数错误"})';//对返回值做改造,jsonp方式返回值需要用括号把我们要返回的json对象用括号括起来，前面加上获取到的参数的值
		return;
	}
	

	global $staff;
	

	$number = $_GET["number"];
	$result = $jsonp . '({"success":false,"msg":"没有找到员工。"})';//对返回值做改造,jsonp方式返回值需要用括号把我们要返回的json对象用括号括起来，前面加上获取到的参数的值
	
	

	foreach ($staff as $value) {
		if ($value["number"] == $number) {
			$result = $jsonp . '({"success":true,"msg":"找到员工：员工编号：' . $value["number"] .
							'，员工姓名：' . $value["name"] . 
							'，员工性别：' . $value["sex"] . 
							'，员工职位：' . $value["job"] . '"})';//对返回值做改造,jsonp方式返回值需要用括号把我们要返回的json对象用括号括起来，前面加上获取到的参数的值
			break;
		}
	}
    echo $result;
}







function create(){
	if (!isset($_POST["name"]) || empty($_POST["name"])
		|| !isset($_POST["number"]) || empty($_POST["number"])
		|| !isset($_POST["sex"]) || empty($_POST["sex"])
		|| !isset($_POST["job"]) || empty($_POST["job"])) {
		echo '{"success":false,"msg":"参数错误，员工信息填写不全"}';
		return;
	}
	
	
	echo '{"success":true,"msg":"员工：' . $_POST["name"] . ' 信息保存成功！"}';
}

?>