<div>
   @forelse($conversations as $conversation)
    <li class="{{ \Str::contains(request()->path(), $conversation->uuid) ? 'active' : '' }}">
            <span class="avatar"><img src="{{ asset('uploads/images/products/' . $conversation->product->main_image) }}" height="42" width="42" alt="Generic placeholder image" />
              <span class="avatar-status-offline"></span>
            </span>
            <a href="{{ route('chat.show', $conversation) }}" class="chat-info flex-grow-1">
                <h5 class="mb-0">{{ $conversation->name != '' ? $conversation->name : $conversation->users()->pluck('name')->join(', ') }}</h5>
                @if ( !empty($conversation->messages()->first()->body) )

                <p class="card-text text-truncate">
                    {{ $conversation->messages()->first()->body }}
                </p>
                @else
                    <p class="card-text text-truncate">
                        @lang('data.No messages yet')
                    </p>
                    @endif
            </a>
            <div class="chat-meta text-nowrap">
                @if ( !empty($conversation->messages()->first()->body) )
                <small class="float-right mb-25 chat-time">{{ \Carbon\Carbon::parse($conversation->messages()->first()->created_at)->format('d M') }}</small>
                @if (!auth()->user()->hasRead($conversation))
                    <span class="badge badge-danger badge-pill float-right">

                    </span>
                @endif

               @endif
            </div>
    </li>
   @empty
    <li class="no-results">
        <h6 class="mb-0">@lang('data.No Chats Found')</h6>
    </li>

   @endforelse
</div>
