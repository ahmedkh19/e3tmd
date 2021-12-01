<td>@lang('data.Settings')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="32"
               type="checkbox" class="custom-control-input"
               id="settings-list"
               @isset ($rolePermissions)
               @if( in_array(32, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="settings-list"></label>
    </div>
</td>
