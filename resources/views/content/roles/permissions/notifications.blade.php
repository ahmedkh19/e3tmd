<td>@lang('data.Notifications')</td>
<td>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="21"
               type="checkbox" class="custom-control-input"
               id="send_notification-send"
               @isset ($rolePermissions)
               @if( in_array(21, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="send_notification-send"></label>
    </div>
</td>