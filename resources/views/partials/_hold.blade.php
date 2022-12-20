
<!-- ================== native functions ================== -->
<script src="{!! url('/') !!}/backend/js/app.js"></script>

<!-- ================== BEGIN BASE JS ================== -->
<script src="{!! url('/') !!}/backend/plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="{!! url('/') !!}/backend/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="{!! url('/') !!}/backend/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
   <script src="{!! url('/') !!}/crossbrowserjs/html5shiv.js"></script>
   <script src="{!! url('/') !!}/crossbrowserjs/respond.min.js"></script>
   <script src="{!! url('/') !!}/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="{!! url('/') !!}/backend/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{!! url('/') !!}/backend/plugins/js-cookie/js.cookie.js"></script>
<script src="{!! url('/') !!}/backend/js/theme/default.min.js"></script>
<script src="{!! url('/') !!}/backend/js/apps.min.js"></script>

<!-- responsive tables -->
<script src="{!! url('/') !!}/backend/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="{!! url('/') !!}/backend/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="{!! url('/') !!}/backend/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="{!! url('/') !!}/backend/js/demo/table-manage-default.demo.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- bootstrap-datepicker -->
<link href="{!! url('/') !!}/backend/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="{!! url('/') !!}/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="{!! url('/') !!}/backend/plugins/moment/moment.min.js"></script>
<script src="{!! url('/') !!}/backend/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"></script>

<script>
   $('.datepicker-rs').datepicker({
      format: 'yyyy-mm-dd',
      startDate: 'd',
      todayHighlight: true,
   });
   $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      //startDate: '-3d'
   });
   $('.datetimepicker').datetimepicker();
</script>

{{-- <!-- bootstrap date time picker -->
<link href="{!! url('/') !!}/backend/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="{!! url('/') !!}/backend/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
   $(function () {
      $('.datetimepicker').datetimepicker();
   });
</script> --}}

<!-- select 2 -->
<link href="{!! url('/') !!}/backend/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="{!! url('/') !!}/backend/plugins/select2/dist/js/select2.min.js"></script>
<script>
   $('.multiselect').select2({
      width: '100%'
   });
</script>
<script src="{!! url('/') !!}/backend/js/demo/form-plugins.demo.min.js"></script>


{{-- <script src="{!! url('/') !!}/vendor/unisharp/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript">
   var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
   $('#lfm').filemanager('image', {prefix: route_prefix});
</script> --}}

<!-- preview uploaded image -->
<script type="text/javascript">
   $(document).ready(function() {
      if(window.File && window.FileList && window.FileReader) {
      $("#thumbnail").on("change",function(e) {
      var files = e.target.files ,
      filesLength = files.length ;
      for (var i = 0; i < filesLength ; i++) {
         var f = files[i]
         var fileReader = new FileReader();
         fileReader.onload = (function(e) {
            var file = e.target;
            $("<img></img>",{
            class : "imageThumb",
            src : e.target.result,
            title : file.name
            }).insertAfter("#thumbnail");
         });
         fileReader.readAsDataURL(f);
      }
   });
   } else { alert("Your browser doesn't support to File API") }
   });
</script>

<!--- dropzone js -->
<link href="{!! url('/') !!}/backend/plugins/dropzone/dropzone.css" rel="stylesheet" />
<script src="{!! url('/') !!}/backend/plugins/dropzone/dropzone.js"></script>
<style>
  Dropzone.options.addimages = {
    MaxFilesize:0.7,
    acceptedFile:'image/*',
    parallelUploads: 2,
    thumbnailHeight: 120,
    thumbnailWidth: 120,
    thumbnail: function(file, dataUrl) {
      if (file.previewElement) {
        file.previewElement.classList.remove("dz-file-preview");
        var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
        for (var i = 0; i < images.length; i++) {
          var thumbnailElement = images[i];
          thumbnailElement.alt = file.name;
          thumbnailElement.src = dataUrl;
        }
        setTimeout(function() { file.previewElement.classList.add("dz-image-preview"); }, 1);
      }
    }
  };
</style>

<!-- sweet alert delete -->
<script src="{!! url('/') !!}/backend/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="{!! url('/') !!}/backend/js/demo/ui-modal-notification.demo.min.js"></script>

<!-- initiate modules -->
<script>
   $(document).ready(function() {
      App.init();
      TableManageDefault.init();
      Notification.init();
      //FormPlugins.init();
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
      $("form").on("submit", function(){
         $(".submit").hide();
         $(".submit-load").show();
      });//submit
   });//document ready
</script>
<script>
    $(".delete").on("click", function(){
        return confirm("Are you sure?");
    });
</script>

<!-- slim scroll -->
<script src="{!! url('/') !!}/backend/plugins/jQuery-slimScroll/jquery.slimscroll.min.js"></script>
<script>
   $('.slimscroll').slimscroll({
      height: 'auto'
   });
</script>
<script>
   $(function() {
      $('#cycle-count').hide();
      $('#cycles-option').change(function(){
         if($('#cycles-option').val() == 'Specify') {
            $('#cycle-count').show();
         } else {
            $('#cycle-count').hide();
         }
      });
   });
</script>

{{-- validate single file --}}
<script type="text/javascript">
   var uploadField = document.getElementById("file");

   uploadField.onchange = function() {
   if(this.files[0].size > 2500000){
       alert("File is too big!");
       this.value = "";
      };
   };
</script>

{{--validate multiple files  --}}
<script type="text/javascript">
   $('input#files').change(function(){
      var imageSizeArr = 0;
      var imageArr = document.getElementById('files');
      var imageCount = imageArr.files.length;
      var imageToBig = false;
      for (var i = 0; i < imageArr.files.length; i++){
        var imageSize = imageArr.files[i].size;
        var imageName = imageArr.files[i].name;
        if (imageSize > 5000000){
            var imageSizeArr = 1;
        }
        if (imageSizeArr == 1){
            console.log(imageName+': file too big\n');
            imageToBig = true;
        }
        else if (imageSizeArr == 0){
            console.log(imageName+': file ok\n');
        }
      }
      if(imageToBig){
         //give an alert that at least one image is to big
         window.alert("At least one of your files is too large to process, see the console for exact file details.");
         this.value = "";
      }
   });
</script>

<script>
   window.onbeforeunload = function() {
      if (data_needs_saving()) {
         return "Are you sure you want to leave ?";
      } else {
         return;
      }
   };
</script>

<!-- ================== chat ================== -->
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- ================== multiselect ================== -->
<script src="{!! url('/') !!}/backend/plugins/multi-select/js/jquery.multi-select.js" type="text/javascript"></script>



@yield('scripts')
