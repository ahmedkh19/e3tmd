<td>@lang('data.Products')</td>
<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="17"
               type="checkbox" class="custom-control-input"
               id="product-list"
               @isset ($rolePermissions)
               @if( in_array(17, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="product-list"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="18"
               type="checkbox" class="custom-control-input"
               id="product-create"
               @isset ($rolePermissions)
               @if( in_array(18, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="product-create"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="19"
               type="checkbox" class="custom-control-input"
               id="product-edit"
               @isset ($rolePermissions)
               @if( in_array(19, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="product-edit"></label>
    </div>
</td>

<td>
    <div class="custom-control custom-checkbox">
        <input name="permission[]"
               value="20"
               type="checkbox" class="custom-control-input"
               id="product-delete"
               @isset ($rolePermissions)
               @if( in_array(20, $rolePermissions) )
               checked
                @endif
                @endisset
        />
        <label class="custom-control-label" for="product-delete"></label>
    </div>
</td>
