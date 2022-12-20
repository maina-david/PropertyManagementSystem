<ul class="nav nav-tabs">
    <li class="{{ Request::is('crm/contact/'.$contact->id.'/view') ? 'active' : '' }}"><a href="{{ url('crm/contact/'.$contact->id.'/view') }}">Description</a></li>
    @if ($contact->contact_type == 'Organization')
    	<li class="{{ Request::is('crm/contact/'.$contact->id.'/contact-persons') ? 'active' : '' }}"><a href="{{ url('crm/contact/'.$contact->id.'/contact-persons') }}">Contact persons</a></li>
    @endif    
    <li class="{{ Request::is('crm/contact/'.$contact->id.'/notes') ? 'active' : '' }}"><a href="{{ url('crm/contact/'.$contact->id.'/notes') }}">Notes</a></li>
</ul>