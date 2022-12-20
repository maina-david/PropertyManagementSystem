@foreach ($aFolder as $oFolder)
   @php
      $aMessage = $oFolder->messages()->all()->get();   
   @endphp
   @foreach($aMessage as $oMessage)
      {!! $oMessage->getSubject() !!}
   @endforeach
@endforeach