<div id="sidebar" class="sidebar">
   @php  $module = 'Content Management' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('backend.partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub">
            <a href="{!! route('cms.dashboard') !!}">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a> 
         </li>
         <li class="has-sub {{ Nav::isResource('proposal') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fas fa-file-signature"></i>
               <span>Proposals</span>
            </a>
            <ul class="sub-menu">
               <li class="#"><a href="{!! route('cms.proposal.index') !!}">All Proposals</a></li>
               <li class="#"><a href="{!! route('cms.proposal.create') !!}">Add Proposals</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('knowledgebase') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fas fa-book-reader"></i>
               <span> Knowledge Base</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('cms.knowledgebase.index') }}"><a href="{!! route('cms.knowledgebase.index') !!}">All Article</a></li>
               <li class="{{ Nav::isRoute('cms.knowledgebase.create') }}"><a href="{!! route('cms.knowledgebase.create') !!}">Add Article</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('groups') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fas fa-layer-group"></i>
               <span>Groups</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('cms.groups.index') }}"><a href="{!! route('cms.groups.index') !!}">All Groups</a></li>
               <li class="{{ Nav::isRoute('cms.groups.index') }}"><a href="{!! route('cms.groups.index') !!}">Add Groups</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('website') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fas fa-desktop"></i>
               <span>Web site content</span>
            </a>
            <ul class="sub-menu">
               <li class="has-sub {{ Nav::isResource('page') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                    Pages
                  </a>
                  <ul class="sub-menu">
                     <li class="{{ Nav::isResource('page') }}"><a href="{!! route('cms.page.index') !!}">All pages</a></li>
                     <li><a href="{!! route('cms.page.new') !!}">Add page</a></li>
                  </ul>
               </li>
               <li class="has-sub {{ Nav::isResource('posts') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Posts
                  </a>
                  <ul class="sub-menu">                     
                     <li class="{{ Nav::isResource('posts') }}"><a href="{!! route('cms.posts.index') !!}">All Posts</a></li>
                     <li><a href="{!! route('cms.posts.create') !!}">Add post</a></li>
                  </ul>
               </li>
               <li class="has-sub {{ Nav::isResource('slider') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Slider
                  </a>
                  <ul class="sub-menu">                     
                     <li class="{{ Nav::isResource('slider') }}"><a href="{!! route('cms.slider.index') !!}">All Sliders</a></li>
                     <li class="{{ Nav::isResource('create') }}"><a href="{!! route('cms.slider.create') !!}">Add Slider</a></li>
                  </ul>
               </li>
               <li class="has-sub {{ Nav::isResource('category') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Posts Category
                  </a>
                  <ul class="sub-menu">                     
                     <li><a href="{!! route('cms.post.category.index') !!}">All Categories</a></li>
                     <li><a href="{!! route('cms.post.category.create') !!}">Add Category</a></li>
                  </ul>
               </li>
               <li class="has-sub {{ Nav::isResource('tags') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Posts Tags
                  </a>
                  <ul class="sub-menu">                     
                     <li><a href="{!! route('cms.post.tags.index') !!}">All Tags</a></li>
                     <li><a href="{!! route('cms.post.tags.index') !!}">Add Tag</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
