<!DOCTYPE html>
<html lang="en">
<head>
    
    @include('partials.styles')

    @yield('stylesheets')

</head>

<body class="hold-transition skin-blue sidebar-mini">	
		
		<div class="wrapper">

			@include('layouts.header')
			<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

				@yield('content')

			</div>
      <!-- /.content-wrapper -->

			@include('layouts.footer')

		</div><!-- /wrapper -->	

	<!--   Core JS Files   -->
	@include('partials.scripts')

	@yield('scripts')

	<script type="text/javascript">
		$(document).ready(function() {
			// Javascript method's body can be found in assets/js/demos.js
			demo.initDashboardPageCharts();
			demo.initVectorMap();
		});
	</script>

	<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });


    $('.datepicker').attr('placeholder', 'MM/DD/YYYY');
    $('.datepicker').datepicker({
    	format: 'mm/dd/yyyy',
	    autoclose: true
	  })
	  
    </script>

  <script type="text/javascript">
  jQuery(document).ready(function ($) {
    $('.my-news-ticker').AcmeTicker({
      type:'marquee',/*horizontal/horizontal/Marquee/type*/
      direction: 'left',/*up/down/left/right*/
      speed:0.05,/*true/false/number*/ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
      controls: {
        prev: $('.acme-news-ticker-prev'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
        toggle: $('.acme-news-ticker-pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
        next: $('.acme-news-ticker-next')/*Can be used for horizontal/horizontal/marquee/typewriter*/
      }
    });
  })
</script>
<script>
    function Copy() {
    //getting text from P tag
    var copyText = document.getElementById("copy");  
    // creating textarea of html
    var input = document.createElement("textarea");
    //adding p tag text to textarea 
    input.value = copyText.textContent;
    document.body.appendChild(input);
    input.select();
    document.execCommand("Copy");
    // removing textarea after copy
    input.remove();
    alert('This number copied to clipboard='+input.value);
  }
  </script>

</body>
</html>