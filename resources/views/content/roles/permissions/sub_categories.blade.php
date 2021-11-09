<td>@lang('data.Sub categories')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="13"
               type="checkbox" class="custom-control-input"
               id="sub_category-list"
               @isset ($rolePermissions)
               @if( in_array(13, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="sub_category-list"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="14"
               type="checkbox" class="custom-control-input"
               id="sub_category-create"
               @isset ($rolePermissions)
               @if( in_array(14, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="sub_category-create"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="15"
               type="checkbox" class="custom-control-input"
               id="sub_category-edit"
               @isset ($rolePermissions)
               @if( in_array(15, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="sub_category-edit"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="16"
               type="checkbox" class="custom-control-input"
               id="sub_category-delete"
               @isset ($rolePermissions)
               @if( in_array(16, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="sub_category-delete"></label>
    </div>
</td>
