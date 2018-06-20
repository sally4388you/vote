<?php

$param = (isset($_GET['lang'])) ? $_GET['lang'] : ((isset($_SESSION['lang'])) ? $_SESSION['lang']  : 'en');
$_SESSION['lang'] = $param;
$lang = $_SESSION['lang'];

$app = array(
	'zh_CN' => array(
		'login' => '登陆',
		'lang' => 'English',
		'checkLastTime' => '【查看上期投票情况】',
		'title' => '华中科技大学投票系统',
		'checkResult' => '查看所有投票结果',
		'vote' => '投  票',
		'nominee' => '华中科技大学候选人物',
		'ammount' => '票',
		'voteSystem' => '投票系统',
		'account' => '个人学号',
		'id' => '身份证后6位',
		'name' => '姓名的第一个字',
		'loginMessage' => '点击登陆进入投票系统进行活动投票',
		'copy' => '学工处网络应用研发中心 NADC',
		'welcome' => '欢迎登录',
		'logout' => '退出登陆',
		'back' => '返回首页',
		'postTime' => '发布时间：',
		'summary' => '统计结果',
		'voteFail' => '投票失败',
		'voteEnd' => '投票已结束',
		'voteNotBegin' => '投票还未开始',

		'titleManage' => '投票管理系统',
		'copyTitle' => '版 权 声 明',
		'feedback' => '反馈',
		'setting' => '设置',
		'add_prog' => '添加项目',
		'prog_name' => '项目名称',
		'prog_eng' => '项目拼音缩写',
		'stu_id' => '学号',
		'stu_name' => '姓名',
		'stu_school' => '院系',
		'stu_votes' => '票数',
		'stu_pic' => '图片',
		'stu_intro' => '简介',
		'upload_candid' => '导入候选人',
		'attention' => '注意',
		'attention_msg1' => '导入的excel文件必须在office2007以上,表格中时间的类型必须调整为日期',
		'attention_msg2' => '为了保证投票页面加载不至于过慢，请将导入图片尺寸：宽*高改为200像素*267像素',
		'attention_msg3' => '导入图片必须为jpg格式,图片名称以学生学号命名',
		'add_btn' => '添 加',
		'cancel_btn' => '取 消',
		'info' => '信 息',
		'upload_excel' => '选择要导入的excel文件',
		'upload_pic' => '选择要导入的图片文件',
		'upload' => '上传',
		'year' => '年',
		'export' => '导出投票结果',
		'template' => '下载表格模板',
		'check_btn' => '查看',
		'vote_id' => '投票学号',
		'vote_time' => '投票时间',
		'vote_status' => '状态',
		'submit' => '修改',
		'return_btn' => '返回',
		'return_msg' => '确定返回?',

		'first_page' => '首页',
		'last_page' => '上一页',
		'next_page' => '下一页',
		'last_page' => '末页',
		'total_page' => '页',
	),
	'en' => array(
		'login' => 'Login',
		'lang' => '中文',
		'checkLastTime' => '[Check Vote Last Time]',
		'title' => 'HUST Vote System',
		'checkResult' => 'Check Summary of Election Results',
		'vote' => 'Vote',
		'nominee' => 'Election Nominee',
		'ammount' => 'votes',
		'voteSystem' => 'Voting System',
		'account' => 'Student Account',
		'id' => 'Last 6 Numbers of ID',
		'name' => 'First Character of Your Name',
		'loginMessage' => 'Login to Vote',
		'copy' => 'Network Application Development Center NADC',
		'welcome' => 'Welcome',
		'logout' => 'Logout',
		'back' => 'Back',
		'postTime' => 'Post Time',
		'summary' => 'Summary of Election Results',
		'voteFail' => 'Voting failed',
		'voteEnd' => 'Voting is already ended',
		'voteNotBegin' => 'Voting is not started yet',

		'titleManage' => 'Management System for Voting Hust',
		'copyTitle' => 'Copyright ',
		'feedback' => 'Feedback',
		'setting' => 'Setting',
		'add_prog' => 'Create a program',
		'prog_name' => 'Name of the Program',
		'prog_eng' => 'Abbreviation of the Program',
		'stu_id' => 'Student ID',
		'stu_name' => 'Student Name',
		'stu_school' => 'Faculty',
		'stu_votes' => 'Votes',
		'stu_pic' => 'Photo',
		'stu_intro' => 'Introduction',
		'upload_candid' => 'Upload Nominees',
		'attention' => '**',
		'attention_msg1' => 'The version of excel files must be over office2007. The type of time must be date.',
		'attention_msg2' => 'The size of photos is subject to 200px * 267px.',
		'attention_msg3' => 'The type of photos must be jpg. Name photos with student ID.',
		'add_btn' => 'Add',
		'cancel_btn' => 'Cancel',
		'info' => 'Info',
		'upload_excel' => 'Choose excel file',
		'upload_pic' => 'Choose photo file',
		'upload' => 'Upload',
		'year' => '',
		'export' => 'Export Election Results',
		'template' => 'Download the Template',
		'check_btn' => 'Detail',
		'vote_id' => 'Voting Student ID',
		'vote_time' => 'Voting Time',
		'vote_status' => 'Voting Status',
		'submit' => 'Submit',
		'return_btn' => 'Return',
		'return_msg' => 'Are you sure to return to the previous page?',

		'first_page' => 'First Page',
		'last_page' => 'Last Page',
		'next_page' => 'Next Page',
		'last_page' => 'Last Page',
		'total_page' => 'In Total',
	)
);


?>