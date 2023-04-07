<!DOCTYPE html>
<html>
<style>
body, html {
  height: 100%;
  margin: 0;
}

.bgimg {
  background-image: url('{{asset('/homes/nature.jpg')}}');
  height: 100%;
  background-position: center;
  background-size: cover;
  position: relative;
  color: white;
  font-family: "Courier New", Courier, monospace;
  font-size: 25px;

}

.bottomleft {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
}

.middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

hr {
  margin: auto;
  width: 40%;
}
.row{
  clear: both;
  display: table;
  width: 100%
}
.topleft, .top-right{
  float: left;
}
.topleft{
  width: 20%;
  text-align: center;
  margin-top: 15px
}
.top-right{
  display: table;
  width: 80%;
  text-align: right;
}
.nav{
  float: right;
  max-width: 400px;
  margin-right: 25px
}
.nav li{float: left;list-style:none; display: table-cell;}
.nav li a{display: block;padding: 5px 15px; text-transform: uppercase;text-decoration: none;border: 1px solid #fff;margin-left: 15px; color: #fff;background: rgba(0, 0, 0, 0.2);font-weight: bold}
.btn{
  padding: 10px 25px;
  border: 1px solid;
  background: #0ad;
}
.middle a{text-decoration: none;color: #fff}
</style>
<body>

<div class="bgimg">
  <div class="row">
    <div class="topleft">
      {{-- <p>DoLightJob</p> --}}
      <img src="/img/logo.png" width=200>
    </div>
    <div class="top-right">
      <ul class="nav">
        <li><a href="/login">Login</a></li>
        <li><a href="/signup">Sign up</a></li>
      </ul>
    </div>
  </div>
  <div class="middle">
    {{-- <h1 style="color:#2B8BCE">DO LIGHT JOB</h1> --}}
    <hr>
    <a class="btn btn-success" href="/signup">GET STARTED</a>
    <!-- <p id="demo" style="font-size:30px"></p> -->
  </div>
  <div class="bottomleft">
    <p style="text-align:center;color:#006">Design & Developed by: <a style="color:#55f;text-decoration:none;" traget="_blank" href="http://chalanbeel.com/">Chalan Beel Technology</a> </p>
  </div>
</div>

<script>
// Set the date we're counting down to
var countDownDate = new Date("Jul 30, 2021 15:37:25").getTime();

// Update the count down every 1 second
var countdownfunction = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();
  
  // Find the distance between now an the count down date
  var distance = countDownDate - now;
  
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
  
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(countdownfunction);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<!-- web chat -->
<script src="//code.tidio.co/qtad67qy4ntpnse3laghu8tovvhesvnt.js" async></script>

</body>
</html>
