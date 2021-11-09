<div>

    <!-- Sender -->
    <div class="chat">
        <div class="chat-avatar">
            <span class="avatar box-shadow-1 cursor-pointer">
              <img
                      src="{{ asset('images/portrait/small/avatar-s-11.jpg') }}"
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
