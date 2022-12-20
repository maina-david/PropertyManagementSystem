@if(Auth::user()->langID == "")
   {!!  App::setLocale(Helper::language(Auth::user()->langID)->short ) !!}
@else
   {!!  App::setLocale(Helper::language({!! Helper::settings()->language_id !!})->short ) !!}
@endif