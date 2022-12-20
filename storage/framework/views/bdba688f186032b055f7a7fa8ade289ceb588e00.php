<?php $__env->startSection('title','Balance'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      .swv-typo-h1{font-weight:300;font-size:72px;line-height:81px;letter-spacing:-2px}.swv-typo-h2{font-weight:300;font-size:42px;line-height:54px;letter-spacing:-1.5px}.swv-typo-h3{font-weight:700;font-size:42px;line-height:44px;letter-spacing:0}.swv-typo-h4{font-weight:700;font-size:28px;line-height:32px;letter-spacing:0}.swv-typo-h5,.timeoff-balance-griditem .big-dot-box .remain-days .daysleft{font-weight:500;font-size:26px;line-height:32px;letter-spacing:0}.swv-typo-h6{font-weight:400;font-size:20px;line-height:28px;letter-spacing:0}.swv-typo-h7{font-weight:400;font-size:18px;line-height:26px;letter-spacing:0}.swv-typo-heading{font-weight:500;font-size:16px;line-height:24px;letter-spacing:0}.swv-typo-subheading,.timeoff-balance-griditem .text-box .name{font-weight:500;font-size:13px;line-height:16px;letter-spacing:.5px;text-transform:uppercase}.swv-typo-body1{font-weight:300;font-size:28px;line-height:32px;letter-spacing:0}.swv-typo-body2{font-weight:300;font-size:18px;line-height:26px;letter-spacing:0}.swv-typo-body3{font-weight:300;font-size:16px;line-height:24px;letter-spacing:0}.swv-typo-body4,.timeoff-balance-griditem .text-box .used{font-weight:300;font-size:14px;line-height:20px;letter-spacing:0}.swv-typo-body5{font-weight:300;font-size:12px;line-height:16px;letter-spacing:0}.swv-typo-button-large{font-weight:300;font-size:20px;line-height:28px;letter-spacing:.6px}.swv-typo-button,.timeoff-balance-griditem .big-dot-box .blur-box .title{font-weight:400;font-size:14px;line-height:20px;letter-spacing:.4px}.swv-typo-label{font-weight:400;font-size:14px;line-height:20px;letter-spacing:.4px}.swv-typo-caption,.timeoff-balance-griditem .big-dot-box .remain-days .available{font-weight:400;font-size:12px;line-height:16px;letter-spacing:.2px}.swv--layer-base{background-color:#F9FAFB}.swv--layer-flat{background-color:#FFFFFF}.swv--layer-raised{background-color:#FFFFFF;box-shadow:rgba(63,63,68,0.05) 0 0 0 1px,rgba(63,63,68,0.15) 0 1px 3px 0}.swv--layer-raised-subdued{background-color:#F4F5F8;box-shadow:rgba(244,245,248,0.05) 0 0 0 1px,rgba(63,63,68,0.15) 0 1px 3px 0}.swv--layer-overlay{background-color:#FFFFFF;box-shadow:rgba(33,37,54,0.1) 0 0 0 1px,rgba(33,37,54,0.12) 0 1px 3px 0,rgba(69,74,91,0.08) 0 2px 8px 0}.swv--layer-nav{background-color:#FFFFFF;box-shadow:rgba(33,37,54,0.04) 0 0 0 1px,rgba(33,37,54,0.12) 0 1px 3px 0,rgba(69,74,91,0.08) 0 2px 10px 0}.swv--layer-popout,.timeoff-balance-griditem:hover:not(.readonly) .big-dot-box .big-dot{background-color:#FFFFFF;box-shadow:rgba(33,37,54,0.1) 0 0 0 1px,rgba(33,37,54,0.12) 0 1px 6px 0,rgba(69,74,91,0.08) 0 2px 12px 0}.swv--border-default{border-radius:3px}.swv--card{background-color:#FFFFFF;border-radius:4px;-webkit-box-shadow:rgba(63,63,68,0.05) 0 0 0 1px,rgba(63,63,68,0.15) 0 1px 3px 0;box-shadow:rgba(63,63,68,0.05) 0 0 0 1px,rgba(63,63,68,0.15) 0 1px 3px 0}.timeoff-balance-griditem{padding:10px 0}.timeoff-balance-griditem .big-dot-box{position:relative;height:110px}.timeoff-balance-griditem .big-dot-box .big-dot{position:absolute;width:110px;height:inherit;border-radius:50%;left:50%;transform:translateX(-50%)}.timeoff-balance-griditem .big-dot-box .blur-box{position:absolute;display:none;width:110px;height:inherit;border-radius:50%;left:50%;transform:translateX(-50%);background-color:rgba(69,74,91,0.9)}.timeoff-balance-griditem .big-dot-box .blur-box .title{color:#FFFFFF;position:absolute;top:50%;left:0;right:0;transform:translateY(-50%);text-align:center}.timeoff-balance-griditem .big-dot-box .remain-days{position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);text-align:center}.timeoff-balance-griditem .big-dot-box .remain-days .daysleft{color:#FFFFFF}.timeoff-balance-griditem .big-dot-box .remain-days .available{color:#FFFFFF}.timeoff-balance-griditem .text-box{height:48px;margin:20px auto 0}.timeoff-balance-griditem .text-box .name{color:#636C81;max-height:48px;overflow:hidden;text-align:center;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical}.timeoff-balance-griditem .text-box .used{margin-top:4px;color:#212536}.timeoff-balance-griditem .text-box .used .total{color:#919AAB}.timeoff-balance-griditem .item-content{padding:20px 15px;border-radius:2px}.timeoff-balance-griditem .item-content .name{margin:5px 0}.timeoff-balance-griditem .item-content .remain-days{margin:10px 0 0;font-size:16px}.timeoff-balance-griditem .item-content .total-days{margin:0;font-weight:200;font-size:14px}.timeoff-balance-griditem .item-content .edit-icon{margin-top:-15px}.timeoff-balance-griditem.readonly{margin:10px 0 0}.timeoff-balance-griditem.readonly .item-content{padding:10px 15px;border-radius:2px}.timeoff-balance-griditem.readonly .item-content .name{font-weight:400;font-size:20px;margin:5px 0}.timeoff-balance-griditem.readonly .item-content .remain-days{margin:10px 0 0;font-size:16px}.timeoff-balance-griditem.readonly .item-content .total-days{margin:0;font-weight:200;font-size:14px}.timeoff-balance-griditem.readonly .item-content .edit-icon{margin-top:-15px}.timeoff-balance-griditem:hover:not(.readonly){cursor:pointer}.timeoff-balance-griditem:hover:not(.readonly) .big-dot-box .big-dot{-webkit-filter:blur(1px);-moz-filter:blur(1px);-o-filter:blur(1px);-ms-filter:blur(1px);filter:blur(1px)}.timeoff-balance-griditem:hover:not(.readonly) .blur-box{display:block}
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('backend.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?> 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Leave</li>
         <li class="breadcrumb-item active">Balance</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Balance</h1>
		<?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-9">
            <div class="mb-3">
               <label for="">Employee</label>
               <select name="" id="" class="form-control multiselect">
                  <option value="">Choose Employee</option>
                  <option value="">Griffin kisia</option>
               </select>
            </div>

            <div class="card">
               <div class="card-body">
                  <h5>Balance summary</h4>
                  <div class="row">
                     <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="timeoff-balance-griditem ">
                           <div class="big-dot-box">
                              <div class="big-dot" style="background-color: rgb(74, 73, 202);">
                                 <div class="remain-days">
                                    <div class="daysleft">18</div>
                                    <div class="available">available</div>
                                 </div>
                              </div>
                              <div class="blur-box"><div class="title">Edit balance</div></div>
                           </div>
                           <div class="text-box"><div class="name">Sick Leave</div></div>
                        </div>
                     </div>
                     <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="timeoff-balance-griditem ">
                           <div class="big-dot-box">
                              <div class="big-dot" style="background-color: rgb(74, 73, 202);">
                                 <div class="remain-days">
                                    <div class="daysleft">28</div>
                                    <div class="available">Available</div>
                                 </div>
                              </div>
                              <div class="blur-box"><div class="title">Edit balance</div></div>
                           </div>
                           <div class="text-box"><div class="name">Study Leave</div></div>
                        </div>
                     </div>
                     <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="timeoff-balance-griditem ">
                           <div class="big-dot-box">
                              <div class="big-dot" style="background-color: rgb(74, 73, 202);">
                                 <div class="remain-days">
                                    <div class="daysleft">12</div>
                                    <div class="available">available</div>
                                 </div>
                              </div>
                              <div class="blur-box"><div class="title">Edit balance</div></div>
                           </div>
                           <div class="text-box"><div class="name">Paternity</div></div>
                        </div>
                     </div>
                     <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="timeoff-balance-griditem ">
                           <div class="big-dot-box">
                              <div class="big-dot" style="background-color: rgb(74, 73, 202);">
                                 <div class="remain-days">
                                    <div class="daysleft">5</div>
                                    <div class="available">available</div>
                                 </div>
                              </div>
                              <div class="blur-box"><div class="title">Edit balance</div></div>
                           </div>
                           <div class="text-box"><div class="name">Sabbatical leave</div></div>
                        </div>
                     </div>
                     <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="timeoff-balance-griditem ">
                           <div class="big-dot-box">
                              <div class="big-dot" style="background-color: rgb(74, 73, 202);">
                                 <div class="remain-days">
                                    <div class="daysleft">14</div>
                                    <div class="available">available</div>
                                 </div>
                              </div>
                              <div class="blur-box"><div class="title">Edit balance</div></div>
                           </div>
                           <div class="text-box"><div class="name">Special Leave</div></div>
                        </div>
                     </div>
                     <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="timeoff-balance-griditem ">
                           <div class="big-dot-box">
                              <div class="big-dot" style="background-color: rgb(74, 73, 202);">
                                 <div class="remain-days">
                                    <div class="daysleft">10</div>
                                    <div class="available">available</div>
                                 </div>
                              </div>
                              <div class="blur-box"><div class="title">Edit balance</div></div>
                           </div>
                           <div class="text-box"><div class="name">Leave of Absence</div></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/leave/balance.blade.php ENDPATH**/ ?>