<td>@lang('data.Roles')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="1"
               type="checkbox" class="custom-control-input"
               id="role-list"
               @isset ($rolePermissions)
               @if( in_array(1, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="role-list"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="2"
               type="checkbox" class="custom-control-input"
               id="role-create"
               @isset ($rolePermissions)
               @if( in_array(2, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="role-create"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="3"
               type="checkbox" class="custom-control-input"
               id="role-edit"
               @isset ($rolePermissions)
               @if( in_array(3, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="role-edit"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="4"
               type="checkbox" class="custom-control-input"
               id="role-delete"
               @isset ($rolePermissions)
               @if( in_array(4, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="role-delete"></label>
    </div>
</td>
