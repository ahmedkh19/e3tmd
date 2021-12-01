<div>

    <!-- Sender -->
    <div class="chat">
        <div class="chat-avatar">
            <span class="avatar box-shadow-1 cursor-pointer">
                                            <?php $avatar = \App\Models\User::find( auth()->id() )->avatar ? \App\Models\User::find( auth()->id() )->avatar: 'user.jpg'; ?>

              <img
                      src="{{ asset('uploads/images/avatars/' . $avatar)  }}"
                      alt="avatar"
                      height="36"
                      width="36"
              />
            </span>
        </div>
        <div class="chat-body">
            <div class="chat-content">
                <p>{{ $message->body }}</p>
            </div>
        </div>
    </div>

</div>
