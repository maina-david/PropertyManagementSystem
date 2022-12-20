<div>
   <div class="row mb-3">
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter customer name, email address or phonenumber">
      </div>
      <div class="col-md-4">
         <label for="">Items Per</label>
         <select wire:model="perPage" class="form-control">`
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">Customers List</h4>
      </div>
      <div class="panel-body">
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%"><input type="checkbox" name="" id=""></th>
                  <th width="5">Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phonenumber</th>
                  <th>Category</th>
                  <th width="12%">Date created</th>
                  <th width="10%">Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th><input type="checkbox" name="" id=""></th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phonenumber</th>
                  <th>Category</th>
                  <th>Date created</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               @foreach ($contacts as $contact)
                  @if($contact->businessID == Auth::user()->businessID)
                     <tr {{-- class="success" --}}>
                        <td><input type="checkbox" name="" id=""></td>
                        <td>
                           @if($contact->image == "")
                              <img src="https://ui-avatars.com/api/?name={!! $contact->customer_name !!}&rounded=true&size=32" alt="">
                           @else
                              <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$contact->business_code.'/customer/'. $contact->customer_code.'/images/'.$contact->image) !!}">
                           @endif
                        </td>
                        <td>
                           @if($contact->contact_type == 'Individual') 
                              {!! $contact->salutation !!} {!! $contact->customer_name !!}
                           @else 
                              {!! $contact->customer_name !!}
                           @endif
                        </td>
                        <td>{!! $contact->email !!}</td>
                        <td>{!! $contact->primary_phone_number !!}</td>
                        <td>
                           @foreach (Finance::client_category($contact->customerID) as $category)
                                 <span class="badge badge-primary">{!! $category->name !!}</span>
                           @endforeach
                        </td>
                        <td>{!! date('d F, Y', strtotime($contact->created_at)) !!}</td>
                        <td>
                           <a href="{{ route('pos.contact.edit', $contact->customerID) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('pos.contact.delete', $contact->customerID) !!}" class="btn btn-sm btn-danger delete"><i class="fal fa-trash-alt"></i></a>
                        </td>
                     </tr>
                  @endif
               @endforeach
            </tbody>
         </table>
         {!! $contacts->links() !!}
      </div>
   </div>
</div>
