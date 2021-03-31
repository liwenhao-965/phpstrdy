
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title>js计算器</title>
<style>
.head{
width: 300px;
height: 420px;
position: absolute;
left:50%;
right: 50%;
margin-left: -150px;
}
.xianshiping{
height: 100px;
border: 1px solid #dddddd; 
}
.jianpan{
height: 320px;
display: flex;
flex-wrap: wrap;
align-content: center;
border: 1px solid #dddddd; 
}
.xiaogezi{
height: 50px;
width: 50px;
border: 1px solid #dddddd; 
margin-left: 15px;
margin-top: 8px;
}
input{
width:50px;
height: 50px;
}
#inputchuang{
width: 280px;
height: 30px;
margin-top: 10px;
margin-left: 6px;
}
.outchuang{
    width: 284px;
height: 30px;
border: 2px solid #dddddd; 
margin-left:7px;
margin-top:2px;
}
#submita{
    margin-top:275px;
    margin-left:220px;
}

</style>

</head>
<body>
<div class="head">
<div class="xianshiping">
<form method = "POST" action = "index111.php">
<input type="text" value="" id="inputchuang" name = "typea">
<div class="outchuang">


<?php
  $num = isset($_POST['typea'])?$_POST['typea']:0;
   echo panduan($num);
   //echo eval(return ,"$num")
//判断是否有括号来进行计算
   function panduan ($mysumname){
      $sum1 = str_split($mysumname);
      $zhongzhuan = "";
      $finally = 0;
      while(true){
          $num=substr_count($mysumname,"(");
          if($num==0){
              $finishnum=noBrackets($mysumname);
              return $finishnum;
          }
          
          if($num>0){
              $mysumname=Brackets($mysumname);
          }
      }
      // for($x = 0;$x <count($sum1);$x++){
      //     echo $sum1[$x]."<br>";
      //     if($sum1[$x] == "("  ){
      //         $zhongzhuan = test($mysumname);
      //         $finally = test2($zhongzhuan);
              
      //     }else{
      //         $finally = test2($mysumname);
      // }
  
          // return $finally;
  
  
  }
   
   function noBrackets ($sum){
      //1先把获取到的字符串存进数组里面，根据加减乘除对加减乘除号左右的元素组成新的数组
       $arr = array();
       $finishsum = 0;
       $num = "";
       $sum1 = str_split($sum);
       for($x = 0;$x <count($sum1);$x++){
           if($sum1[$x] == "*" ||$sum1[$x] == "/"||$sum1[$x] == "+"||$sum1[$x] == "-" ){
               //遍历判断是否是运算符，如果不是，先把元素相连的数字放在一个新数组里面，再把运算符单独放在一个元素位置上。
              array_push($arr, $num);
              array_push($arr,$sum1[$x]);
              $num ="";
           }else{
               $num .= $sum1[$x];
           }
           if($x == count($sum1)-1){
               array_push($arr,$num);
           }
       }
      //2进入第二轮，数字和数字再一个元素位上，开始进行优先级计算，乘除法优先。
      $arr2=array();
      $count=0;
      for ($i=0;$i<count($arr);$i++){
          if ($arr[$i]=="*"){
              $arr[$i+1]=$arr[$i-1]*$arr[$i+1];
              array_pop($arr2);
              array_push($arr2,$arr[$i+1]);
              $count=1;
          }elseif($arr[$i]=="/"){
              $arr[$i+1]=$arr[$i-1]/$arr[$i+1];
              array_pop($arr2);
              array_push($arr2,$arr[$i+1]);
              $count=1;
          }else{
              if ($count!==1){
                  array_push($arr2,$arr[$i]);
              }else{
                  $count=0;
              }
          }
      }
  
      //3进入第三轮，开始加减法运算，采用叠加，数组后一位数等于前两位的和，数组最后一位就是等于整个式子 的结果；
      if(count($arr2)>1){
          //加减法计算
          for ($i=0;$i<count($arr2);$i++){
              if ($arr2[$i]=="+"){
                  $arr2[$i+1]=$arr2[$i-1]+$arr2[$i+1];
              }elseif($arr2[$i]=="-"){
                  $arr2[$i+1]=$arr2[$i-1]-$arr2[$i+1];
              }
              if ($i==count($arr2)-2){
                  $finishsum=$arr2[$i+1];
              }
          }
      }else{
          $finishsum=$arr2[count($arr2)-1];
      }
  
      return $finishsum;
  
  }
   //计算括号的表达式；
   function Brackets($mystr){
       $str=$mystr;
       $num1=strrpos($str,"(");
       $first= substr( $str, 0, $num1 );//最后一个(之前的字符串;
       $str2=strrchr($str,"(");//最后一个(之后的字符串;
       $num2=strpos($str2,")");//第一个)出现的位置
       $senterstr= substr( $str2, 0, $num2+1 );//第一个)之前的字符串，也是要计算的字符串;
       $endstr= substr( $str2, $num2+1, strlen($str2)-$num2 );//第一个)之后的字符串;
       //将要计算的字符串去除括号
       $pieces = explode("(", $senterstr);
       $pieces2 = explode(")", $pieces[1]);
       //调用计算不带括号式子的计算方法
       $sum=noBrackets($pieces2[0]);
       $sumstr=$first.$sum.$endstr;
       return $sumstr;
   }
   
   ?>
</div>
<input type="submit" value="=" id="submita">
</form>
</div>
<div class="jianpan">
<div class="xiaogezi">
<input type="button" value="1" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="2" onclick="inputEvent(this)"> 
</div>
<div class="xiaogezi">
<input type="button" value="3" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="AC" onclick="inputClear(this)">
</div>
<div class="xiaogezi">
<input type="button" value="4" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="5" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="6" onclick="inputEvent(this)"> 
</div>
<div class="xiaogezi">
<input type="button" value="+" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="7" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="8" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="9" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="-" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="(" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value=")" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="*" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="/" onclick="inputEvent(this)"> 
</div>
<div class="xiaogezi">
<input type="button" value="" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="" onclick="inputEvent(this)">
</div>
<div class="xiaogezi">
<input type="button" value="." onclick="inputEvent(this)">
</div>
<!-- <div class="xiaogezi">
<input type="submit" value="=" onclick="inputEvent(this)">
</div> -->

</div>
</div>
<script type="text/javascript">
var val = 0;
function inputEvent(e){
val = e.value;
var xsval = document.getElementById('inputchuang');
xsval.value += val;
}



function inputClear(){
var xsval = document.getElementById('inputchuang');
xsval.value = "";
}
</script>

</body>
</html>

