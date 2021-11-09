<td>@lang('data.Main categories')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="9"
               type="checkbox" class="custom-control-input"
               id="main_category-list"
                @isset ($rolePermissions)
                    @if( in_array(9, $rolePermissions) )
                        checked
                        @endif
                    @endisset
        />
        <label class="custom-control-label" for="main_category-list"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="10"
               type="checkbox" class="custom-control-input"
               id="main_category-create"
               @isset ($rolePermissions)
               @if( in_array(10, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="main_category-create"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="11"
               type="checkbox" class="custom-control-input"
               id="main_category-edit"
               @isset ($rolePermissions)
               @if( in_array(11, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="main_category-edit"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="12"
               type="checkbox" class="custom-control-input"
               id="main_category-delete"
               @isset ($rolePermissions)
               @if( in_array(12, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="main_category-delete"></label>
    </div>
</td>
