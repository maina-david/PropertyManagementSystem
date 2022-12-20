<div class="col-md-3">
   <div class="list-group">
      {{-- <a href="{!! route('hrm.payroll.settings.payday') !!}" class="list-group-item {{ Nav::isRoute('hrm.payroll.settings.payday') }}">
         Payday information
      </a> --}}
      <a href="{!! route('hrm.payroll.settings.approval') !!}" class="list-group-item {{ Nav::isRoute('hrm.payroll.settings.approval') }}">
         Approver setting
      </a>
      <a href="{!! route('hrm.payroll.settings.deduction') !!}" class="list-group-item {{ Nav::isRoute('hrm.payroll.settings.deduction') }}">
         Deductions
      </a>
      {{-- <a href="{!! route('hrm.payroll.settings.benefits') !!}" class="list-group-item {{ Nav::isRoute('hrm.payroll.settings.benefits') }}">
         Benefits
      </a> --}}
   </div>
</div>
