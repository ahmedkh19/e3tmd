<td>@lang('data.Users')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="5"
               type="checkbox" class="custom-control-input"
               id="user-list"
               @isset ($rolePermissions)
               @if( in_array(5, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="user-list"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="6"
               type="checkbox" class="custom-control-input"
               id="user-create"
               @isset ($rolePermissions)
               @if( in_array(6, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="user-create"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="7"
               type="checkbox" class="custom-control-input"
               id="user-edit"
               @isset ($rolePermissions)
               @if( in_array(7, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="user-edit"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="8"
               type="checkbox" class="custom-control-input"
               id="user-delete"
               @isset ($rolePermissions)
               @if( in_array(8, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="user-delete"></label>
    </div>
</td>
