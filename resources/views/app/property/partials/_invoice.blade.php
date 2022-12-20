@section('scripts')
   <script src="{!! url('/') !!}/public/app/plugins/ckeditor/4/standard/ckeditor.js"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
   <script>
      //adds extra table rows
      var i=$('table tr').length;
      var no = 0; 

      $(document).ready(function(){
         var x = 1;
         $(".addmore").click(function () {
            $("#table tbody tr:first").clone().find("input").each(function () {
            $(this).val('').attr({
               'id': function (_, id) {
                  return id + x
               }
            });
            }).end().appendTo("table");
            x++;
         }); 
      });

      /* === INVOICE === */
      $(document).on('change', '.solsoCloneSelect2','.changesNo', function() {
         inputPrice = $(this).closest('tr').find("[name='price[]']");
         $.ajax({
            url: "{{ URL::route('finance.ajax.product.price') }}",
            type: 'post',
            dataType: 'json',
            data: { product: $(this).val(),"_token": $('#token').val() },
            success:function(data) {
               inputPrice.val(data['selling_price']);
            }
         });
      });

      $(document).on('keypress', ".addNewRow", function(e){
         var keyCode = e.which ? e.which : e.keyCode;
         if(keyCode == 9 ) addNewRow();
      });

      var readonly = $('#readonly').val();

      //to check all checkboxes
      $(document).on('change','#check_all',function(){
         $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
      });

      //deletes the selected table rows
      $(".delete").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('#check_all').prop("checked", false);
         calculateTotal();
      });

      $(document).on('click','.add_icon',function(){
         var add_icon_id = $(this).attr('id');
         var add_icon_arr = add_icon_id.split("_");
         var icon_id = add_icon_arr[add_icon_arr.length-1];
         addNewRow(icon_id);
      });

      //price change
      $(document).on('keyup','.changesNo',function(){
         id_arr = $(this).attr('id');
         id = id_arr.split("_");

         quantity = $('#quantity_'+id[1]).val();
         price = $('#price_'+id[1]).val();
         discount = $('#discount_'+id[1]).val();
         taxRate = $('#tax_'+id[1]).val();
         tax = taxRate/100;
         
         //if(quantity != "" && price != "")
         amount = price * quantity;
         AmountAfterDiscount = amount - discount;
         TaxValue = AmountAfterDiscount * tax;
         totalSum = TaxValue + AmountAfterDiscount;
         
         $('#mainAmount_'+id[1]).val(amount);
         $('#taxvalue_'+id[1]).val(TaxValue);
         $('#amount_'+id[1]).val(amount);
         $('#total_'+id[1]).val(AmountAfterDiscount);
         $('#sum_'+id[1]).val(totalSum);
         calculateTotal();
      });

      $(document).on('change','.onchange',function(){
         id_arr = $(this).attr('id');
         id = id_arr.split("_");

         quantity = $('#quantity_'+id[1]).val();
         price = $('#price_'+id[1]).val();
         discount = $('#discount_'+id[1]).val();
         taxRate = $('#tax_'+id[1]).val();
         tax = taxRate/100;

         amount = price * quantity;
         AmountAfterDiscount = amount - discount;
         TaxValue = AmountAfterDiscount * tax;
         totalSum = TaxValue + AmountAfterDiscount;
         
         $('#mainAmount_'+id[1]).val(amount);
         $('#taxvalue_'+id[1]).val(TaxValue);
         $('#amount_'+id[1]).val(amount);
         $('#total_'+id[1]).val(AmountAfterDiscount);
         $('#sum_'+id[1]).val(totalSum);
         calculateTotal();
      });

      //total price calculation
      function calculateTotal(){
         subTotal = 0 ;
         mainTotal = 0;
         discountTotal = 0;
         taxTotal = 0;
         sumTotal = 0;

         //main total
         $('.mainAmount').each(function(){
            if($(this).val() != '' )
            mainTotal += parseFloat($(this).val() );
            mainTotal = mainTotal;
         });
         $('#mainAmountF').val(mainTotal.toFixed(2));

         //sub total
         $('.totalLinePrice').each(function(){
            if($(this).val() != '' )
            subTotal += parseFloat($(this).val() );
            subTotal = subTotal;
         });
         $('#subTotal').val(subTotal.toFixed(2));

         //tax total
         $('.totalLineTax').each(function(){
            if($(this).val() != '' )
            taxTotal += parseFloat($(this).val());
            taxTotal = taxTotal;
         });
         $('#taxvalue').val(taxTotal.toFixed(2));

         //tax total
         $('.discount').each(function(){
            if($(this).val() != '' )
            discountTotal += parseFloat($(this).val());
            discountTotal = discountTotal;
         });
         $('#discountTotal').val(discountTotal.toFixed(2));

         //total amount
         $('.totalSum').each(function(){
            if($(this).val() != '')
            sumTotal += parseFloat($(this).val());
            sumTotal = sumTotal;
         });
         $('#InvoicetotalAmount').val(sumTotal.toFixed(2) );
      }

      //It restrict the non-numbers
      var specialKeys = new Array();
      specialKeys.push(8,46); //Backspace
      function IsNumeric(e) {
         var keyCode = e.which ? e.which : e.keyCode;
         if(keyCode == 9 )return true;
         var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
         return ret;
      }
   </script>
   <script type="text/javascript">
      $('#client_select').on('change',function(e){
         console.log(e);
         var client_id =  e.target.value;
         var url = "{{ url('/') }}"

         //ajax
         $.get(url+'/finance/retrive_client/'+client_id, function(data){
            //success data
            $('#invoice_no').empty();
            $.each(data, function(invoices, info){
               $('#invoice_no').append('<option value="'+ info.id +'">00'+ info.invoice_number +'</option>');
            });
         });
      });
      $('#taxconfig').on('change', function() {
			if(this.value == 'Exclusive') {
				$('#taxfield').hide();
			} else {
				$('#taxfield').show();
			}
		});
   </script>
   <script>
      $('#products').on('change',function(e){         
         console.log(e);
         var product =  e.target.value;
         var url = "{{ url('/') }}"
         //ajax
         $.get(url+'/subscriptions/'+product+'/plans', function(data){
            //success data
            $('#subscriptions').empty();
            $.each(data, function(subscriptions, subscription){
               $('#subscriptions').append('<option value="'+ subscription.productID +'">'+subscription.product_name+'</option>');
               $('.subscription_price').val(subscription.selling_price);
               $('#trial_days').val(subscription.trial_days);
            });
         });
      });
      $('#subscriptions').on('change',function(e){ 
         console.log(e);
         var product =  e.target.value;
         var url = "{{ url('/') }}"
         //ajax 
         $.get(url+'/subscriptions/plans/'+product+'/price', function(data){
            //success data
            $('.subscription_price').empty();
            $.each(data, function(prices, price){
               $('.subscription_price').val(price.selling_price);
            });
         });
      });
      $('#expiration_cycle').on('change', function() {
         if (this.value == 'Enter cycle') {
            $('#cycles').show();
         }else{
            $('#cycles').hide();
         }
      });
      $('#payment_status').on('change', function() {
         if (this.value == 'Yes') {
            $('#amount_paid').show();
         }else{
            $('#amount_paid').hide();
         }
      });
   </script> 
   @include('app.partials._express_scripts')
@endsection
