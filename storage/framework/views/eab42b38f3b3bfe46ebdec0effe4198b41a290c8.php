
<!-- ================== native functions ================== -->
<script src="<?php echo asset('assets/js/app.js'); ?>"></script>

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo asset('assets/plugins/jquery/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js'); ?>"></script>
<!--[if lt IE 9]>
   <script src="<?php echo asset('assetsowserjs/html5shiv.js'); ?>"></script>
   <script src="<?php echo asset('assetsowserjs/respond.min.js'); ?>"></script>
   <script src="<?php echo asset('assetsowserjs/excanvas.min.js'); ?>"></script>
<![endif]-->
<script src="<?php echo asset('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
<script src="<?php echo asset('assets/js/theme/default.min.js'); ?>"></script>
<script src="<?php echo asset('assets/js/apps.min.js'); ?>"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- responsive tables -->
<script src="<?php echo asset('assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo asset('assets/js/demo/table-manage-default.demo.min.js'); ?>"></script>
<!-- ================== END BASE JS ================== -->

<!-- bootstrap-datepicker -->
<link href="<?php echo asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css'); ?>" rel="stylesheet">
<script src="<?php echo asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js'); ?>"></script>

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



<!-- select 2 -->
<link href="<?php echo asset('assets/plugins/select2/dist/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo asset('assets/plugins/select2/dist/js/select2.min.js'); ?>"></script>
<script>
   $('.multiselect').select2({
      width: '100%'
   });
</script>
<script src="<?php echo asset('assets/js/demo/form-plugins.demo.min.js'); ?>"></script>




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
<link href="<?php echo asset('assets/plugins/dropzone/dropzone.css'); ?>" rel="stylesheet" />
<script src="<?php echo asset('assets/plugins/dropzone/dropzone.js'); ?>"></script>
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


<script src="<?php echo asset('assets/plugins/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
<script>
   var editor_config = {
      path_absolute : '/',
      selector: 'textarea.my-editor',
      relative_urls: true,
      convert_urls: false,
      plugins: [
         "advlist autolink lists link image charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code fullscreen",
         "insertdatetime media nonbreaking save table directionality",
         "emoticons template paste textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
   };
   tinymce.init(editor_config);
</script>

<!-- sweet alert delete -->
<script src="<?php echo asset('assets/plugins/bootstrap-sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?php echo asset('assets/js/demo/ui-modal-notification.demo.min.js'); ?>"></script>

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
<script src="<?php echo asset('assets/plugins/jQuery-slimScroll/jquery.slimscroll.min.js'); ?>"></script>
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


<script type="text/javascript">
   // var uploadField = document.getElementById("file");

   // uploadField.onchange = function() {
   // if(this.files[0].size > 2500000){
   //     alert("File is too big!");
   //     this.value = "";
   //    };
   // };
</script>


<script type="text/javascript">
   // $('input#files').change(function(){
   //    var imageSizeArr = 0;
   //    var imageArr = document.getElementById('files');
   //    var imageCount = imageArr.files.length;
   //    var imageToBig = false;
   //    for (var i = 0; i < imageArr.files.length; i++){
   //      var imageSize = imageArr.files[i].size;
   //      var imageName = imageArr.files[i].name;
   //      if (imageSize > 5000000){
   //          var imageSizeArr = 1;
   //      }
   //      if (imageSizeArr == 1){
   //          console.log(imageName+': file too big\n');
   //          imageToBig = true;
   //      }
   //      else if (imageSizeArr == 0){
   //          console.log(imageName+': file ok\n');
   //      }
   //    }
   //    if(imageToBig){
   //       //give an alert that at least one image is to big
   //       window.alert("At least one of your files is too large to process, see the console for exact file details.");
   //       this.value = "";
   //    }
   // });
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
<script src="<?php echo asset('assets/plugins/multi-select/js/jquery.multi-select.js'); ?>" type="text/javascript"></script>

<!-- ================== clipboard ================== -->

<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.12/clipboard.min.js"></script>

<!-- x-editable (bootstrap 3) -->
<link href="<?php echo asset('assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css'); ?>" rel="stylesheet">
<script src="<?php echo asset('assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js'); ?>"></script>

<!-- ================== toastr ================== -->
<link href="<?php echo asset('assets/plugins/toastr/build/toastr.css'); ?>" rel="stylesheet"/>
<script src="<?php echo asset('assets/plugins/toastr/build/toastr.min.js'); ?>"></script>
<?php if(Session::has('success')): ?>
   <script>
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
      toastr.success('<?php echo Session::get('success'); ?>');
   </script>
<?php endif; ?>

<?php if(Session::has('error')): ?>
   <script>
		toastr.options =
		{
			"closeButton": true,
			"progressBar" : true
		}
      toastr.error('<?php echo Session::get('error'); ?>');
   </script>
<?php endif; ?>

<?php if(Session::has('warning')): ?>
   <script>
		toastr.options =
		{
			"closeButton": true,
			"progressBar" : true
		}
      toastr.warning('<?php echo Session::get('warning'); ?>');
   </script>
<?php endif; ?>

<!-- ================== lazy load ================== -->
<script src="<?php echo asset('assets/plugins/lazy-load/jquery.lazyload.min.js'); ?>"></script>
<script>
   $(document).ready(function(){
      $('img').lazyload();
   })
</script>

<?php echo \Livewire\Livewire::scripts(); ?>


<!-- ================== clonedata ================== -->
<script src="<?php echo asset('assets/js/cloneData.js'); ?>"></script>


<!-- geocomplete -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOjtWqBh6q9HQS5UHoanGsMD30LGSWZtU&libraries=places"></script>
<script src="<?php echo asset('assets/plugins/geocomplete/jquery.geocomplete.js'); ?>"></script>

<script>
   window.onbeforeunload = function() {
      if (data_needs_saving()) {
         return "Are you sure you want to leave ?";
      } else {
         return;
      }
   };
</script>

<script src="<?php echo asset('assets/plugins/isotope-layout/dist/isotope.pkgd.min.js'); ?>" type="a4fa74d6c7c0c2d9928dd7e0-text/javascript"></script>
<script src="<?php echo asset('assets/plugins/lightbox2/js/lightbox.min.js'); ?>"></script>
<script src="<?php echo asset('assets/js/demo/gallery.demo.js'); ?>"></script>

<?php echo $__env->yieldContent('scripts'); ?>
<?php echo $__env->yieldContent('script2'); ?>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/partials/_footer.blade.php ENDPATH**/ ?>