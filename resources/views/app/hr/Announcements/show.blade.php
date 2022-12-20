@extends('layouts.main-template')
{{-- page header --}}
@section('title','Announcements')
{{-- page styles --}}
@section('stylesheet')
	{!!Html::style('resources/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')!!}
	{!!Html::style('resources/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')!!}
	{!!Html::style('resources/assets/plugins/datatables-responsive/css/datatables.responsive.css')!!}
	<style type="text/css" media="screen">
		td.v-align-middle.semi-bold.sorting_1 {
            border: none;
        }

		hr {
		    margin-top: 20px;
		    margin-bottom: 20px;
		    border: 0;
		    border-top: 1px solid #FFFFFF;
		}
		a {
		    color: #82b440;
		    text-decoration: none;
		}
		.blog-comment::before,
		.blog-comment::after,
		.blog-comment-form::before,
		.blog-comment-form::after{
		    content: "";
			display: table;
			clear: both;
		}

		.blog-comment{
		    padding-left: 15%;
			padding-right: 15%;
		}

		.blog-comment ul{
			list-style-type: none;
			padding: 0;
		}

		.blog-comment img{
			opacity: 1;
			filter: Alpha(opacity=100);
			-webkit-border-radius: 4px;
			   -moz-border-radius: 4px;
			  	 -o-border-radius: 4px;
					border-radius: 4px;
		}

		.blog-comment img.avatar {
			position: relative;
			float: left;
			margin-left: 0;
			margin-top: 0;
			width: 65px;
			height: 65px;
		}

		.blog-comment .post-comments{
			border: 1px solid #eee;
		    margin-bottom: 20px;
		    margin-left: 85px;
			margin-right: 0px;
		    padding: 10px 20px;
		    position: relative;
		    -webkit-border-radius: 4px;
		       -moz-border-radius: 4px;
		       	 -o-border-radius: 4px;
		    		border-radius: 4px;
			background: #fff;
			color: #6b6e80;
			position: relative;
		}

		.blog-comment .meta {
			font-size: 13px;
			color: #aaaaaa;
			padding-bottom: 8px;
			margin-bottom: 10px !important;
			border-bottom: 1px solid #eee;
		}

		.blog-comment ul.comments ul{
			list-style-type: none;
			padding: 0;
			margin-left: 85px;
		}

		.blog-comment-form{
			padding-left: 15%;
			padding-right: 15%;
			padding-top: 40px;
		}

		.blog-comment h3,
		.blog-comment-form h3{
			margin-bottom: 40px;
			font-size: 26px;
			line-height: 30px;
			font-weight: 800;
		}
	</style>
@endsection

{{-- dashboad menu --}}
@section('main-menu')
	@include('Limitless.Human-resource.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div class="content "> 
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
				<div class="inner" style="transform: translateY(0px); opacity: 1;">					 
					<ul class="breadcrumb">
						<li><a href="#">Human Resource</a></li>
						<li><a href="#" class="active">Announcements</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<div class="container-fluid container-fixed-lg bg-white"> 
			<div class="panel panel-transparent">	
				<div class="panel-heading">
					<button class="btn btn-primary pull-right" data-target="#addannouncement" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Announcement</button>
					<div class="clearfix"></div>
				</div>			
				<div class="panel-body">
					<div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
						<div>
							<table class="table table-hover demo-table-search table-responsive-block dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">								
								<tbody>									
									<tr role="row" class="odd">
										<td class="v-align-middle semi-bold sorting_1">
											<img width="60" height="60" alt="" class="img-circle FL" src="https://people.zoho.com/people/images/user.png">
										</td>
										<td class="v-align-middle semi-bold sorting_1">
											<p><b>Announcement title</b></p>
											<p>Mercy Mwende Kinyua  - 30-Mar-2017 11:03 PM</p>
											<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere </p>
											<br>
										</td>
									</tr>
									<tr class="announcement-action">
										<td class="v-align-middle semi-bold sorting_1"></td>
										<td colspan="" rowspan="" headers="">
											<a type="" class="btn btn-info" data-target="#editannouncement" data-toggle="modal">Edit</a>
											<a type="" class="btn btn-danger">Delete</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>						
					</div>
					<div class="container bootstrap snippet">  	
					    <div class="blog-comment">
							<h3 class="text-success"><i class="fa fa-comments" aria-hidden="true"></i>  1 Comment(s)</h3>
			                <hr/>
							<ul class="comments">
							<li class="clearfix">
							  <img src="http://bootdey.com/img/Content/user_1.jpg" class="avatar" alt="">
							  <div class="post-comments">
							      <p class="meta">Dec 18, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Reply</small></a></i></p>
							      <p>
							          Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							          Etiam a sapien odio, sit amet
							      </p>
							  </div>
							</li>
							<li class="clearfix">
							  <img src="http://bootdey.com/img/Content/user_2.jpg" class="avatar" alt="">
							  <div class="post-comments">
							      <p class="meta">Dec 19, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Reply</small></a></i></p>
							      <p>
							          Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							          Etiam a sapien odio, sit amet
							      </p>
							  </div>
							
							  <ul class="comments">
							      <li class="clearfix">
							          <img src="http://bootdey.com/img/Content/user_3.jpg" class="avatar" alt="">
							          <div class="post-comments">
							              <p class="meta">Dec 20, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Reply</small></a></i></p>
							              <p>
							                  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							                  Etiam a sapien odio, sit amet
							              </p>
							          </div>
							      </li>
							  </ul>
							</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	@include('Limitless.Models.Announcement.create')
	@include('Limitless.Models.Announcement.edit')
	
<br>
@endsection
{{-- page scripts --}}
@section('script')


@endsection