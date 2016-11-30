<?php  
header('content-type:text/html;charset=utf-8');
// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
// Array
// (
//     [pic] => Array
//         (
//             [name] => 20160802233121_34E2h.jpeg
//             [type] => image/jpeg
//             [tmp_name] => C:\Windows\Temp\phpCB98.tmp
//             [error] => 0
//             [size] => 97587
//         )

// )
// 设置PHP内存为不限
ini_set("memory_limit",-1);

$method = $_POST['method'];
$method($_FILES,$_POST['pix'],$_POST['fontSize']);

function change_mode_1($arr,$radio,$fontSize){
	$info = $_FILES['pic'];
	//$type = $info['type'];
	$filename = rand(0,100).$info['name'];
	$src = './images/'.$filename;
	if (move_uploaded_file($info['tmp_name'], $src)) {
		
	}else{
		die('文件上传失败！');
	}
	//获取图片信息
	$info = getimagesize($src);
	// echo "<pre>";
	// print_r($info);
	// echo "</pre>";
	// Array
	// 	(
	// 	    [0] => 580
	// 	    [1] => 433
	// 	    [2] => 3
	// 	    [3] => width="580" height="433"
	// 	    [bits] => 8
	// 	    [mime] => image/png
	// 	)
	//从图片创建画布
	$createFun = str_replace('/', 'createfrom', $info['mime']);
	$img = $createFun($src);
	//创建新画布
	$imgNew = imagecreatetruecolor($info[0], $info[1]);
	$white = imagecolorallocate($imgNew, 255,255,255);
	imagefill($imgNew,0,0,$white);	
	//重采样
	imagecopyresampled($imgNew, $img, 0, 0, 0, 0, $info[0], $info[1], $info[0], $info[1]);
	// //测试输出
	// header('content-type:'.$info['mime']);
	// $output = str_replace('/', '', $info['mime']);
	// $output($imgNew);
	// die();
	//创建字符新画布
	$imgFont = imagecreatetruecolor($info[0]*$fontSize/$radio+10, $info[1]*$fontSize/$radio+10);
	$color = imagecolorallocate($imgFont, 255,255,255);	
	imagefill($imgFont,0,0,$color);
	$fontSrc = "./images/gangbishouxie20.ttf";
	//设定随机取字符数组
		$arr = array_merge(range('a', 'z'),range('A','Z'),range(0, 9));
		shuffle($arr);
		$num = 1;
	for ($i=0,$x=0; $i < $info[0]; $i=$i+$radio,$x = $x+$fontSize) { 
		for ($j=0,$y=0; $j < $info[1]; $j=$j+$radio,$y = $y+$fontSize) { 
			$rgb = imagecolorat($imgNew, $i, $j);
			//echo $rgb."<br>";
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			//echo $r."/".$g."/".$b."<br>";
			$fontColor = imagecolorallocate($imgFont, $r,$g,$b);
			//随机取一个字符	
			$arr_index = array_rand($arr,$num);
			$fuhao = $arr[$arr_index];	
			//浅色用空格
			// if ($r>180 && $g>180 && $b>180) {
			// 		$fuhao = " ";
			// 	}	
			//指定颜色字符写入字符画布
			imagettftext($imgFont, $fontSize, 0, $x, $y, $fontColor, $fontSrc, $fuhao);
		}
	}
	//header('content-type:'.$info['mime']);
	$output = str_replace('/', '', $info['mime']);
	//删除上传文件
	unlink($src);
	//转换后图片保存名字
	$newName = iconv('utf-8','gbk','./images/F'.$filename);
	$output($imgFont,$newName);
	//销毁画布
	imagedestroy($imgFont);
	imagedestroy($img);
	imagedestroy($imgNew);
	die('操作成功！');
}

function change_mode_2($arr,$radio,$fontSize){
	$info = $_FILES['pic'];
	//$type = $info['type'];
	$filename = rand(0,100).$info['name'];
	$src = './images/'.$filename;
	if (move_uploaded_file($info['tmp_name'], $src)) {
		
	}else{
		die('文件上传失败！');
	}
	//获取图片信息
	$info = getimagesize($src);
	// echo "<pre>";
	// print_r($info);
	// echo "</pre>";
	// Array
	// 	(
	// 	    [0] => 580
	// 	    [1] => 433
	// 	    [2] => 3
	// 	    [3] => width="580" height="433"
	// 	    [bits] => 8
	// 	    [mime] => image/png
	// 	)
	//从图片创建画布
	$createFun = str_replace('/', 'createfrom', $info['mime']);
	$img = $createFun($src);
	//创建新画布
	$imgNew = imagecreatetruecolor($info[0], $info[1]);
	$white = imagecolorallocate($imgNew, 255,255,255);
	imagefill($imgNew,0,0,$white);	
	//重采样
	imagecopyresampled($imgNew, $img, 0, 0, 0, 0, $info[0], $info[1], $info[0], $info[1]);
	// //测试输出
	// header('content-type:'.$info['mime']);
	// $output = str_replace('/', '', $info['mime']);
	// $output($imgNew);
	// die();
	//创建字符新画布
	$imgFont = imagecreatetruecolor($info[0]*$fontSize/$radio+10, $info[1]*$fontSize/$radio+10);
	$color = imagecolorallocate($imgFont, 255,255,255);
	$black = imagecolorallocate($imgFont, 0,0,0);		
	imagefill($imgFont,0,0,$color);
	$fontSrc = "./images/gangbishouxie20.ttf";
	//设定灰度字符组(70个字符)
		$arr = "$@B%8&WM#*oahkbdpqwmZO0QLCJUYXzcvunxrjft/\|()1{}[]?-_+~<>i!lI;:,\"^`'. ";
	for ($i=0,$x=0; $i < $info[0]; $i=$i+$radio,$x = $x+$fontSize) { 
		for ($j=0,$y=0; $j < $info[1]; $j=$j+$radio,$y = $y+$fontSize) { 
			$rgb = imagecolorat($imgNew, $i, $j);
			//echo $rgb."<br>";
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			//echo $r."/".$g."/".$b."<br>";
			$length = strlen($arr);
			//计算灰度
			$gray = intval(0.2126 * $r + 0.7152 * $g + 0.0722 * $b);
			//将256个灰度映射在70个字符上，所得值为步进值	
			$unit = (256.0 + 1)/$length;
			//取灰度$gray对应的字符
    		$sign = $arr[intval($gray/$unit)];	
			//指定字符写入字符画布
			imagettftext($imgFont, $fontSize, 0, $x, $y, $black, $fontSrc, $sign);
		}
	}
	//header('content-type:'.$info['mime']);
	$output = str_replace('/', '', $info['mime']);
	//删除上传文件
	unlink($src);
	//转换后图片保存名字
	$newName = iconv('utf-8','gbk','./images/F'.$filename);
	$output($imgFont,$newName);
	//销毁画布
	imagedestroy($imgFont);
	imagedestroy($img);
	imagedestroy($imgNew);
	die('操作成功！');
}
//颜色+灰度
function change_mode_3($arr,$radio,$fontSize){
	$info = $_FILES['pic'];
	//$type = $info['type'];
	$filename = rand(0,100).$info['name'];
	$src = './images/'.$filename;
	if (move_uploaded_file($info['tmp_name'], $src)) {
		
	}else{
		die('文件上传失败！');
	}
	//获取图片信息
	$info = getimagesize($src);
	// echo "<pre>";
	// print_r($info);
	// echo "</pre>";
	// Array
	// 	(
	// 	    [0] => 580
	// 	    [1] => 433
	// 	    [2] => 3
	// 	    [3] => width="580" height="433"
	// 	    [bits] => 8
	// 	    [mime] => image/png
	// 	)
	//从图片创建画布
	$createFun = str_replace('/', 'createfrom', $info['mime']);
	$img = $createFun($src);
	//创建新画布
	$imgNew = imagecreatetruecolor($info[0], $info[1]);
	$white = imagecolorallocate($imgNew, 255,255,255);
	imagefill($imgNew,0,0,$white);	
	//重采样
	imagecopyresampled($imgNew, $img, 0, 0, 0, 0, $info[0], $info[1], $info[0], $info[1]);
	// //测试输出
	// header('content-type:'.$info['mime']);
	// $output = str_replace('/', '', $info['mime']);
	// $output($imgNew);
	// die();
	//创建字符新画布
	$imgFont = imagecreatetruecolor($info[0]*$fontSize/$radio+10, $info[1]*$fontSize/$radio+10);
	$color = imagecolorallocate($imgFont, 255,255,255);	
	imagefill($imgFont,0,0,$color);
	$fontSrc = "./images/gangbishouxie20.ttf";
	//设定灰度字符数组
		$arr = "$@B%8&WM#*oahkbdpqwmZO0QLCJUYXzcvunxrjft/\|()1{}[]?-_+~<>i!lI;:,\"^`'. ";
	for ($i=0,$x=0; $i < $info[0]; $i=$i+$radio,$x = $x+$fontSize) { 
		for ($j=0,$y=0; $j < $info[1]; $j=$j+$radio,$y = $y+$fontSize) { 
			$rgb = imagecolorat($imgNew, $i, $j);
			//echo $rgb."<br>";
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			//echo $r."/".$g."/".$b."<br>";
			$fontColor = imagecolorallocate($imgFont, $r,$g,$b);
			$length = strlen($arr);
			//计算灰度
			$gray = intval(0.2126 * $r + 0.7152 * $g + 0.0722 * $b);
			//将256个灰度映射在70个字符上，所得值为步进值	
			$unit = (256.0 + 1)/$length;
			//取灰度$gray对应的字符
    		$sign = $arr[intval($gray/$unit)];	
			//指定颜色字符写入字符画布
			imagettftext($imgFont, $fontSize, 0, $x, $y, $fontColor, $fontSrc, $sign);
		}
	}
	//header('content-type:'.$info['mime']);
	$output = str_replace('/', '', $info['mime']);
	//删除上传文件
	unlink($src);
	//转换后图片保存名字
	$newName = iconv('utf-8','gbk','./images/F'.$filename);
	$output($imgFont,$newName);
	//销毁画布
	imagedestroy($imgFont);
	imagedestroy($img);
	imagedestroy($imgNew);
	die('操作成功！');
}

?>
