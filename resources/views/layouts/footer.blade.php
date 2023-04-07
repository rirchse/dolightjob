<style type="text/css">
.social-icons{margin-bottom: 0;margin-top: -10px}
  .social-icons ul li{display: inline-block;font-size: 25px}
</style>
<footer class="main-footer">
    <strong>Copyright &copy; <script> document.write(new Date().getFullYear()) </script> <a href="{{ url('/') }}">
      {{ config('app.name', '') }}</a>.</strong> All rights reserved.
      <div class="pull-right social-icons">
        <ul class="nav">
          <li><a target="_blank" href="https://www.youtube.com/channel/UC54uPc0r5wR9VHn5fTBLw9w?sub_confirmation=1" style="color:#e00"><i class="fa fa-youtube"></i></a></li>
          <li><a target="_blank" href="https://www.facebook.com/dolightjob" style="color:blue"><i class="fa fa-facebook"></i></a></li>
          <li><a target="_blank" href="#" style="color:#1D9BF0"><i class="fa fa-twitter"></i></a></li>
          <li><a target="_blank" href="#" style="color:#F1855E"><i class="fa fa-instagram"></i></a></li>
        </ul>
      </div>
</footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

  <script type="text/javascript">
  function markRead(elm)
  {
  	$.ajax({
      type : 'GET',
      url : '/message/'+elm.id+'/read',
      success: function(data){
        if(data.status == 'ok'){
            // alert(data.msg);
            window.location.href = elm.getAttribute('href');
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        // console.log(job_title);
        // alert(xhr.status);
        // alert(thrownError);
      }
    });

  }

  //onupload image preview
  image.onchange = evt => {
    const [file] = image.files
    if (file) {
      preview.src = URL.createObjectURL(file)
    }
  }
  </script>

  <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.my-news-ticker').AcmeTicker({
            type:'typewriter',/*horizontal/horizontal/Marquee/type*/
            direction: 'right',/*up/down/left/right*/
            speed:50,/*true/false/number*/ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
            controls: {
                prev: $('.acme-news-ticker-prev'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
                toggle: $('.acme-news-ticker-pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
                next: $('.acme-news-ticker-next')/*Can be used for horizontal/horizontal/marquee/typewriter*/
            }
        });
    })

</script>