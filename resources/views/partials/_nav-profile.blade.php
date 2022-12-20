<ul class="nav">
   <li class="nav-profile">
      <a href="javascript:;" data-toggle="nav-profile">
         <div class="cover with-shadow"></div>
         <div class="image">
            <img src="https://ui-avatars.com/api/?name={!! Auth::user()->name !!}&rounded=true&size=70" alt="{!!Auth::user()->name !!}">
         </div>
         <div class="info">
            {!! $module !!}
         </div>
      </a>
   </li>
</ul>
