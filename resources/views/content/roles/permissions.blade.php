<div class="col-12">
  <div class="table-responsive border rounded mt-1">
    <h6 class="py-1 mx-1 mb-0 font-medium-2">
      <i data-feather="lock" class="font-medium-3 mr-25"></i>
      <span class="align-middle">@lang('data.Permission')</span>
    </h6>
    <table class="table table-striped table-borderless">
      <thead class="thead-light">
      <tr>
        <th>@lang('data.Name')</th>
        <th>@lang('data.Read')</th>
        <th>@lang('data.Create')</th>
        <th>@lang('data.Edit')</th>
        <th>@lang('data.Delete')</th>
      </tr>
      </thead>
      <tbody>

      <tr>
        @include('content.roles.permissions.roles')
      </tr>

      <tr>
        @include('content.roles.permissions.users')
      </tr>

      <tr>
        @include('content.roles.permissions.main_categories')
      </tr>

      <tr>
        @include('content.roles.permissions.sub_categories')
      </tr>

      <tr>
        @include('content.roles.permissions.products')
      </tr>

      <tr>
        @include('content.roles.permissions.withdraw')
      </tr>

      <tr>
        @include('content.roles.permissions.middleman')
      </tr>

      <tr>
        @include('content.roles.permissions.notifications')
      </tr>
      <tr>
        @include('content.roles.permissions.settings')
      </tr>
      </tbody>
    </table>
  </div>
</div>
