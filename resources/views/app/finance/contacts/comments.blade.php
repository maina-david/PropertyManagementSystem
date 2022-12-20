<div class="row">
   <!-- begin timeline -->
	<ul class="timeline">
		<li>
			<!-- begin timeline-icon -->
			<div class="timeline-icon">
				<a href="javascript:;">&nbsp;</a>
			</div>
			<!-- end timeline-icon -->
			<!-- begin timeline-body -->
			<div class="timeline-body">
				<form action="{!! route('finance.customers.comments.post') !!}" method="post">
					@csrf
					<input type="hidden" value="{!! $customerID !!}" name="customerID">
					<div class="form-group mb-5 mt-4">
						<textarea name="comment" rows="8" cols="80" class="form-control"></textarea>
						<button type="submit" class="btn btn-success submit float-right mt-3">Add Comment</button>
						<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none float-right mt-3" alt="" width="15%" style="display: none">
					</div>
				</form>				
			</div>
			<!-- begin timeline-body -->
		</li>
		@foreach($comments as $comment)
			<li>
				<!-- begin timeline-time -->
				<div class="timeline-time">
					<span class="date">{!! date('d F, Y', strtotime($comment->created_at)) !!}</span>
					<span class="time">{!! date('h:i a', strtotime($comment->created_at)) !!}</span>
				</div>
				<!-- end timeline-time -->
				<!-- begin timeline-icon -->
				<div class="timeline-icon">
					<a href="javascript:;">&nbsp;</a>
				</div>
				<!-- end timeline-icon -->
				<!-- begin timeline-body -->
				<div class="timeline-body">
					<div class="card">
						<div class="card-body">
							<p>{!! $comment->comment !!}</p>
						</div>
						<div class="card-footer">
							<a href="{!! route('finance.customers.comments.delete', $comment->id) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> delete</a>
						</div>
					</div>
				</div>
				<!-- end timeline-body -->				
			</li>	
		@endforeach
			
	</ul>
	<!-- end timeline -->
</div>
