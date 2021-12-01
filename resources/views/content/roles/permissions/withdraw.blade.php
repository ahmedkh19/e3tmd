<td>@lang('data.Withdraw')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="28"
               type="checkbox" class="custom-control-input"
               id="withdraw-list"
               @isset ($rolePermissions)
               @if( in_array(28, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="withdraw-list"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="29"
               type="checkbox" class="custom-control-input"
               id="withdraw-create"
               @isset ($rolePermissions)
               @if( in_array(29, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="withdraw-create"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="30"
               type="checkbox" class="custom-control-input"
               id="withdraw-edit"
               @isset ($rolePermissions)
               @if( in_array(30, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="withdraw-edit"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="31"
               type="checkbox" class="custom-control-input"
               id="withdraw-delete"
               @isset ($rolePermissions)
               @if( in_array(31, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="withdraw-delete"></label>
    </div>
</td>
