<html>
    <title>Press Spacebar</title>
    <head>
        <link href="gbm.css" rel="stylesheet" type="text/css" media="screen"/>
    </head>
<body>       
    <canvas id="canvas_black_fill" width="400" height="400"></canvas>
    <canvas id="canvas_white_fill" width="200" height="200"></canvas>
    <div id="controls">
        <button onclick="start()" class="btn">Start</button> 
        <button onclick="stop()" class="btn">Stop</button> 
        <span id="pixel_change_estimate"></span>
    </div>
    <div id="fill_progress" style="height: 10px;"></div>
<script type="text/javascript">
    
// Pressing spacebar starts the random generation process.    
    
document.onkeydown = function(e) {
    e = e || window.event;
    if (e.keyCode === 32) { 
    start();}
};

var visual=document.getElementById("canvas_black_fill");
var vtx=visual.getContext("2d"); 
vtx.strokeStyle="#111";
vtx.beginPath();
vtx.lineWidth="1"; 
vtx.moveTo(200,200);

function rand(min,max){
    return Math.floor(Math.random()*(max-min+1)+min);
    }

function draw_black_square(){ 
    vtx.lineTo(rand(0,400),rand(0,400));
    vtx.stroke();
    }

var intervalHandle = new Array();  

function start(){  
    intervalHandle.push(setInterval('draw_black_square()',10));
    intervalHandle.push(setInterval('get_color_fill_estimate()',1000));
    }

function stop(){
    for(i=0;i<intervalHandle.length;i++){
        clearInterval(intervalHandle[i]);
        }
    intervalhandle.length=0;
    }

var top_offset=0;

function get_color_fill_estimate(){
    top_offset+=6;
    var counter=0;
    fill_block=document.createElement('div');
    for(i=0;i<200;i++){
        var canvasData=vtx.getImageData(i,i,200,200);    
        if(canvasData.data[0]===17){ // 17 for determining RGB ('R' color  of 17 is light-black)
            counter+=1;
            document.getElementById('pixel_change_estimate').innerHTML="&nbsp;&nbsp;&nbsp; Fill Estimate at "+ Math.round(counter/200*100,3)+'%';
            gradient_color=200-counter;
            fill_block.style.backgroundColor= 'rgb(' + [gradient_color,gradient_color,gradient_color].join(',') + ')';
        }}
     fill_block.style.width=counter+"px";
     fill_block.style.border='1px solid #111';
     fill_block.style.height="5px";
     fill_block.style.position="absolute";
     fill_block.style.top=220+top_offset+"px";
     fill_block.style.left="500px";
     document.body.insertBefore(fill_block,document.getElementById('fill_progress'));
     }
     
</script>

<?php 

function Gaussian(){
      $sum = 0;
      $randmax=9999;
      for ($i = 0; $i < 12; $i++) {
          $sum += rand(0, $randmax) / $randmax;
      }
      return $sum; 
             }
          
$visual_white=array();

for($i=0;$i<100;$i++){
    $visual_white[$i]=Gaussian();
    $visual_white[$i]=round($visual_white[$i]*10,0);                   
}

echo '<script type="text/javascript">'
        . 'var c=document.getElementById("canvas_white_fill");'
        . 'var ctx=c.getContext("2d");'
        . 'ctx.beginPath();'
        . 'ctx.lineWidth="1";'
        . 'ctx.strokeStyle="#ffffff";'
        . 'ctx.moveTo(0,0);';

foreach($visual_white as $i){
   echo 'ctx.lineTo('.rand(0,200).','.rand(0,200).');';
}
echo 'ctx.stroke();</script>';
 
?>
</body>
</html>
