<div>
    <!-- Submit Chat form -->
    <form class="chat-app-form"
          x-data="conversationReplyState()"
          wire:submit.prevent="reply"
          action="#"
          enctype="multipart/form-data"
            {{--          onsubmit="enterChat();">--}}
    >
        <div class="input-group input-group-merge mr-1 form-send-message">
            <input type="text"
                   wire:model="body"
                   x-on:keydown.enter="submit"
                   class="form-control message"
                   placeholder="Type your message or use speech to text"
            />

        </div>
        <button type="submit" class="btn btn-primary send"
                x-ref="submit"
        >
            <i data-feather="send" class="d-lg-none"></i>
            <span class="d-none d-lg-block">Send</span>
        </button>
    </form>
    <!--/ Submit Chat form -->

    <script type="application/javascript">
        function conversationReplyState() {
            return {
                attach () {
                    document.getElementById('file_upload_id').click();
                },
                submit () {
                    this.$refs.submit.click()
                }
            }
        }
    </script>
</div>
