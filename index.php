<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Style.css">
        <meta charset="UTF-8">
    </head>
    <body>
            <center><h1 id= "ti">Complex Manager</h1></center>
                <center><div id="input"><br><br>
            <form action="" method="post">
                <input type="text" name="reel" id="reel">+
                <input type="text" name="imaginaire" id="imaginaire">i<br>
                <input type="submit" name="calcul" class="btn" value="Calculer">
            </form>
        </div></center>


<?php
//echo deg2rad(90);
$error = 0;
if (isset($_POST['reel']) AND isset($_POST['imaginaire'])){
	$reel = (int)$_POST['reel'];
	$imaginaire = (int)$_POST['imaginaire'];
}
 
    if(isset($_POST['calcul'])){
        if(!isset($_POST['reel']) || !is_numeric($_POST['reel'])){
            echo "<script>document.getElementById('reel').setAttribute('style', 'border: 1px solid red')</script>"; $error++;}
        if(!isset($_POST['imaginaire']) || !is_numeric($_POST['imaginaire'])){
            echo "<script>document.getElementById('imaginaire').setAttribute('style', 'border: 1px solid red')</script>"; $error++;}
        if(isset($_POST['reel']) && is_numeric($_POST['reel']) && isset($_POST['imaginaire']) && is_numeric($_POST['imaginaire'])){
        
        //conjugué    
        if($_POST['imaginaire'] < 0)
            if($_POST['imaginaire'] == -1)
                $conjugue = $reel.' + i';
            else
                $conjugue = $reel.' + '.abs($imaginaire).'i';
        else if($_POST['imaginaire'] == 0)
            $conjugue = $reel;
        else if($_POST['imaginaire'] == 1)
            $conjugue = $reel.' - i';
        else {
            $conjugue = $reel.' - '.abs($imaginaire).'i';
        }
        
         
        //inverse
        /*if($_POST['imaginaire'] < 0){
            $inverse = '1/('.$reel.'-'.abs($imaginaire).'i'.')';
        }
        else{
            $inverse = '1/('.$reel.'+'.$imaginaire.'i'.')';
        }*/
        if((pow($reel, 2)) + pow($imaginaire, 2) == 0){
            $inverse = 0;
        }
        else{
            //$inverse = $reel/((pow($reel, 2)) + pow($imaginaire, 2)) - $imaginaire/((pow($reel, 2)) + pow($imaginaire, 2));
            $denominateur = pow($reel, 2) + pow($imaginaire, 2);
            //$inverse .= $reel . '/' . pow($reel, 2) + pow($imaginaire, 2) . ' - ' . $imaginaire . 'i/' . pow($reel, 2) + pow($imaginaire, 2);
        }
        
        //module
        $module = sqrt(pow($reel,2)+pow($imaginaire,2));
            
        //argument
        
        if((sqrt(pow($reel, 2) + pow($imaginaire, 2))) != 0){
            $cos_argument = $reel/(sqrt(pow($reel, 2) + pow($imaginaire, 2)));
            $argument = acos($cos_argument);
        }
        else{
            $argument = 0;
        }    
        
        //$argument = atan2($imaginaire, $reel);
        
        /*$costrigo = $reel / $module;
        $argument = deg2rad(acos($costrigo));
        $argument_radian =  M_PI/($argument).'pi';*/
        
        $forme_trigo = round($module, 4).'(cos('.round($argument, 4).')+i.sin('.round($argument, 4).'))';
        
        echo '<center><div id="op"><br>Partie réelle : '.$reel.'<br><br>';
        echo 'Partie imaginaire : '.$imaginaire.'<br><br>';
        echo 'Conjugué : '.$conjugue.'<br><br>';
        if($imaginaire != 0 && $imaginaire > 0)
            echo 'Inverse : '. $reel . '/' . $denominateur . ' - ' . $imaginaire . 'i/' . $denominateur .'<br><br>';
        else if($imaginaire == 0 && $reel != 0){
            echo 'Inverse : '. $reel . '/' . $denominateur .'<br><br>';
        }
        else if($imaginaire < 0){
            echo 'Inverse : '. $reel . '/' . $denominateur . ' + ' . abs($imaginaire) . 'i/' . $denominateur .'<br><br>';
        }
        else{
            echo 'Inverse : '. $reel . '<br><br>';
        }
        echo 'Module : '. round($module, 4) .'<br><br>';
        echo 'Argument : '.round($argument, 4) . ' [2π]' . '<br><br>';
        echo 'Forme trigo : '.$forme_trigo.'<br></div></center>';
        }
    }


if (isset($_POST['calcul']) && !$error){
echo '<br>
<center><div id="can"><canvas id="myCanvas" width="600" height="600"></canvas></div></center>
    <script>
    
    var y = document.getElementById("myCanvas");
var ctx = y.getContext("2d");
ctx.moveTo(300, 300);
ctx.strokeStyle="green";
 ctx.lineWidth=1.5;
ctx.lineTo(eval(300 + (25*' . $reel . ')), eval(300 + (25*(' . $imaginaire*-1 . '))));
ctx.stroke();
    
      function Graph(config) {
        this.canvas = document.getElementById(config.canvasId);
        this.minX = config.minX;
        this.minY = config.minY;
        this.maxX = config.maxX;
        this.maxY = config.maxY;
        this.unitsPerTick = config.unitsPerTick;

        this.axisColor = "#aaa";
        this.font = "8pt Calibri";
        this.tickSize = 5;

        this.context = this.canvas.getContext("2d");
        this.rangeX = this.maxX - this.minX;
        this.rangeY = this.maxY - this.minY;
        this.unitX = this.canvas.width / this.rangeX;
        this.unitY = this.canvas.height / this.rangeY;
        this.centerY = Math.round(Math.abs(this.minY / this.rangeY) * this.canvas.height);
        this.centerX = Math.round(Math.abs(this.minX / this.rangeX) * this.canvas.width);
        this.iteration = (this.maxX - this.minX) / 1000;
        this.scaleX = this.canvas.width / this.rangeX;
        this.scaleY = this.canvas.height / this.rangeY;

        
        this.drawXAxis();
        this.drawYAxis();
      }

      Graph.prototype.drawXAxis = function() {
        var context = this.context;
        context.save();
        context.beginPath();
        context.moveTo(0, this.centerY);
        context.lineTo(this.canvas.width, this.centerY);
        context.strokeStyle = this.axisColor;
        context.lineWidth = 2;
        context.stroke();

        // draw tick marks
        var xPosIncrement = this.unitsPerTick * this.unitX;
        var xPos, unit;
        context.font = this.font;
        context.textAlign = "center";
        context.textBaseline = "top";

        // draw left tick marks
        xPos = this.centerX - xPosIncrement;
        unit = -1 * this.unitsPerTick;
        while(xPos > 0) {
          context.moveTo(xPos, this.centerY - this.tickSize / 2);
          context.lineTo(xPos, this.centerY + this.tickSize / 2);
          context.stroke();
          context.fillText(unit, xPos, this.centerY + this.tickSize / 2 + 3);
          unit -= this.unitsPerTick;
          xPos = Math.round(xPos - xPosIncrement);
        }

        // draw right tick marks
        xPos = this.centerX + xPosIncrement;
        unit = this.unitsPerTick;
        while(xPos < this.canvas.width) {
          context.moveTo(xPos, this.centerY - this.tickSize / 2);
          context.lineTo(xPos, this.centerY + this.tickSize / 2);
          context.stroke();
          context.fillText(unit, xPos, this.centerY + this.tickSize / 2 + 3);
          unit += this.unitsPerTick;
          xPos = Math.round(xPos + xPosIncrement);
        }
        context.restore();
      };

      Graph.prototype.drawYAxis = function() {
        var context = this.context;
        context.save();
        context.beginPath();
        context.moveTo(this.centerX, 0);
        context.lineTo(this.centerX, this.canvas.height);
        context.strokeStyle = this.axisColor;
        context.lineWidth = 2;
        context.stroke();

        // draw tick marks
        var yPosIncrement = this.unitsPerTick * this.unitY;
        var yPos, unit;
        context.font = this.font;
        context.textAlign = "right";
        context.textBaseline = "middle";

        // draw top tick marks
        yPos = this.centerY - yPosIncrement;
        unit = this.unitsPerTick;
        while(yPos > 0) {
          context.moveTo(this.centerX - this.tickSize / 2, yPos);
          context.lineTo(this.centerX + this.tickSize / 2, yPos);
          context.stroke();
          context.fillText(unit, this.centerX - this.tickSize / 2 - 3, yPos);
          unit += this.unitsPerTick;
          yPos = Math.round(yPos - yPosIncrement);
        }

        // draw bottom tick marks
        yPos = this.centerY + yPosIncrement;
        unit = -1 * this.unitsPerTick;
        while(yPos < this.canvas.height) {
          context.moveTo(this.centerX - this.tickSize / 2, yPos);
          context.lineTo(this.centerX + this.tickSize / 2, yPos);
          context.stroke();
          context.fillText(unit, this.centerX - this.tickSize / 2 - 3, yPos);
          unit -= this.unitsPerTick;
          yPos = Math.round(yPos + yPosIncrement);
        }
        context.restore();
      };

      Graph.prototype.drawEquation = function(equation, color, thickness) {
        var context = this.context;
        context.save();
        context.save();
        this.transformContext();

        context.beginPath();
        context.moveTo(this.minX, equation(this.minX));

        for(var x = this.minX + this.iteration; x <= this.maxX; x += this.iteration) {
          context.lineTo(x, equation(x));
        }

        context.restore();
        context.lineJoin = "round";
        context.lineWidth = thickness;
        context.strokeStyle = color;
        context.stroke();
        context.restore();
      };

      Graph.prototype.transformContext = function() {
        var context = this.context;

        // move context to center of canvas
        this.context.translate(this.centerX, this.centerY);

        /*
         * stretch grid to fit the canvas window, and
         * invert the y scale so that that increments
         * as you move upwards
         */
        context.scale(this.scaleX, -this.scaleY);
      };
      var myGraph = new Graph({
        canvasId: "myCanvas",
        minX: -12,
        minY: -12,
        maxX: 12,
        maxY: 12,
        unitsPerTick: 1
      });
      ctx.beginPath();
      ctx.strokeStyle="red";
      ctx.moveTo(300, eval(300 + (25*(' . $imaginaire*-1 . '))));
ctx.lineTo(eval(300 + (25*' . $reel . ')), eval(300 + (25*(' . $imaginaire*-1 . '))));
 ctx.lineWidth=0.5;
      ctx.moveTo(eval(300 + (25*' . $reel. ')), 300);
ctx.lineTo(eval(300 + (25*' . $reel . ')), eval(300 + (25*(' . $imaginaire*-1 . '))));
ctx.stroke();
      
// var y = document.getElementById("myCanvas");
// var ctx = y.getContext("2d");
// ctx.moveTo(300, 300);
// ctx.strokeStyle="green";
// ctx.lineTo(eval(300 + (25*5)), eval(300 + (25*(-5))));
// ctx.stroke();
    </script>
        </body>
</html>';
}
else{
    echo     "</script>
        </body>
</html>";
}

?>