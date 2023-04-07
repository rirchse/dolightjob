
<!-- Footer -->
<footer class="col-md-12" id="footer" style="background:#000; padding:5px; bottom: 0;max-height:50px; position:fixed; bottom:0;color:#ddd; width:100%">
  <div class="copyright">
    <ul class="icons">
      <!-- <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li> -->
      {{-- <li><a target="_blank" href="https://www.facebook.com/NativeSharks-2225856404352825/" class="icon fa-facebook"><span class="label">Facebook</span></a></li> --}}
      <!-- <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li> -->
      <!-- <li><a href="#" class="icon fa-snapchat"><span class="label">Snapchat</span></a></li> -->
    </ul>
    <p style="text-align: center;">Copyright &copy; {{date('Y')}} {{config('app.name')}}. All rights reserved.</p>
  </div>
</footer>


<script type="text/javascript">
  function showPass(elm){
    if(elm.previousElementSibling.getAttribute('type') == 'password'){
      elm.previousElementSibling.setAttribute('type', 'text');
      elm.classList.add('glyphicon-eye-open');
      elm.classList.remove('glyphicon-eye-close');
    }else{
      elm.previousElementSibling.setAttribute('type', 'password');
      elm.classList.add('glyphicon-eye-close');
      elm.classList.remove('glyphicon-eye-open');
    }
  }
</script>