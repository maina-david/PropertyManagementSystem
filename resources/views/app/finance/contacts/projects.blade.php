<div class="card mt-3">
   <div class="card-header"><i class="fal fa-tasks"></i> Projects</div>
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Project</th>
               <th>Date started</th>
               <th>End date</th>
               <th>Progress</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Project</th>
               <th>Date started</th>
               <th>End date</th>
               <th>Progress</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            @foreach ($projects as $crt => $v)
               <tr role="row" class="odd">
                  <td>{{ $crt+1 }}</td>
                  <td>{!! $v->project_name !!}</td>
                  <td>{!! date('F jS, Y', strtotime($v->start_date)) !!}</td>
                  <td>{!! date('F jS, Y', strtotime($v->end_date)) !!}</td>
                  <td>{!! $v->progress !!}</td>
                  <td><span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! Wingu::status($v->statusID)->name !!}</span></td>
                  <td><a href="{!! route('project.show',$v->id) !!}" class="btn btn-sm btn-pink" target="_blank"><i class="fas fa-eye"></i> view</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
