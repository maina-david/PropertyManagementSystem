<div class="tab-pane" id="contact-person">
	<div class="row">
		<div class="col-md-12">
			
            <p><b>Add Contact person</b></p>
            <table class="table table-bordered contact_persons">
                <tr>
                    <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                    <th>#</th>
                    <th>Salutation</th>		                                        
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Work Phone</th>
                    <th>Mobile</th>
                    <th>Skype ID</th>
                    <th>Designation</th>
                    <th>Department</th> 
                </tr>
                <tr>
                    <td><input type='checkbox' class='case'/></td>
                    <td><span id='snum'>1.</span></td> 
                    <td><select id='cn_salutation' class='form-control' name='cn_salutation[]'><option value='' selected='selected'>Choose Salutation</option><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option></select></td>
                    <td><input class='form-control' type='text' id='cn_first_name' name='cn_first_name[]'></td>
                    <td><input class='form-control' type='text' id='cn_last_name' name='cn_last_name[]'></td>
                    <td><input class='form-control' type='text' id='email_address' name='email_address[]'></td>
                    <td><input class='form-control' type='text' id='cn_work_phone' name='cn_work_phone[]'></td>
                    <td><input class='form-control' type='text' id='cn_mobile' name='cn_mobile[]'></td>
                    <td><input class='form-control' type='text' id='cn_skype' name='cn_skype[]'></td>
                    <td><input class='form-control' type='text' id='cn_desgination' name='cn_desgination[]'> </td>
                    <td><input class='form-control' type='text' id='cn_department' name='cn_department[]'></td>
                </tr>
            </table>
            <button type="button" class='btn btn-danger delete_contact_persons'>- Delete</button>
            <button type="button" class='btn btn-success addmore_contact_persons'>+ Add More</button>                            
		</div> 
	</div>
</div>