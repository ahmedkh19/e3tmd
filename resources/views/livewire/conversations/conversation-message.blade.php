<div>
    <!-- Receiver -->
    <div class="chat chat-left">
        <div class="chat-avatar">
            <span class="avatar box-shadow-1 cursor-pointer">
                            <?php $avatar = $message->user->avatar ? $message->user->avatar: 'user.jpg'; ?>

              <img src="{{ asset('uploads/images/avatars/' . $avatar) }}" alt="avatar" height="36" width="36" />
            </span>
        </div>
        <div class="chat-body">
            <div class="chat-content">
                <p>{{ $message->body }}</p>
            </div>
        </div>
        <p class="small text-muted"><small> {{ $message->user->name }} </small></p>

    </div>

</div>
