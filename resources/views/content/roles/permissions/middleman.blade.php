<td>@lang('data.Middleman')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="22"
               type="checkbox" class="custom-control-input"
               id="middleman-list"
                @isset ($rolePermissions)
                    @if( in_array(22, $rolePermissions) )
                        checked
                        @endif
                    @endisset
        />
        <label class="custom-control-label" for="middleman-list"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="23"
               type="checkbox" class="custom-control-input"
               id="middleman-add"
               @isset ($rolePermissions)
               @if( in_array(23, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="middleman-add"></label>
    </div>
</td>
