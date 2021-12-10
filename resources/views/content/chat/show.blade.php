
@extends('layouts.contentLayoutMaster')

@section('title', 'Chat Application')

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection
@include('content.chat.app-chat-sidebar')
@section('content')
  @include('content.alerts.success')
  @include('content.alerts.errors')
<div class="body-content-overlay"></div>
<!-- Main chat area -->
<section class="chat-app-window">
  <!-- Active Chat -->
  <div class="active-chat">
    <!-- Chat Header -->
    <div class="chat-navbar">
      <header class="chat-header">
        <div class="d-flex align-items-center">
          <div class="sidebar-toggle d-block d-lg-none mr-1">
            <i data-feather="menu" class="font-medium-5"></i>
          </div>
          <div class="avatar avatar-border user-profile-toggle m-0 mr-1">
            <?php $product_image = isset($conversation->product->main_image) ? asset('uploads/images/products/' . $conversation->product->main_image): asset('/uploads/images/avatars/user.jpg' ); ?>
            <img src="{{ $product_image  }}" alt="avatar" height="36" width="36" />
          </div>
          <a style="color:#d0d2d6" href="{{ route('product.info', $conversation->product->slug) }}" class="mb-0">{{ $conversation->name != '' ? $conversation->name : $conversation->users->pluck('name')->join(', ') }}</a>
        </div>
{{--    Confirm account data / Add middle man    --}}
      @can('middleman-add')
        @if (!$conversation->product->account_email || !$conversation->product->account_password || !$conversation->product->account_email_website ||!$conversation->product->account_username)
          <!-- Button trigger modal -->
          <div class="d-flex align-items-center">
            <button style="height: 50px" type="button" class="btn btn-primary send" data-toggle="modal" data-target="#exampleModal">@lang('data.Confirm account data')</button>
          </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('data.Account data')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{route('chat.updateAccountData', $conversation->id)}}">
                      @method('PUT')
                      @csrf

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Account email')</label>
                        <input type="text" name="account_email" class="form-control">
                      </div>

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Email website link')</label>
                        <input type="text" name="account_email_website" class="form-control">
                      </div>

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Account username')</label>
                        <input type="text" name="account_username" class="form-control">
                      </div>

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Account password')</label>
                        <input type="password" name="account_password" class="form-control">
                      </div>

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Confirm password')</label>
                        <input type="password" name="account_confirm_password" class="form-control">
                      </div>

                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('data.Submit')</button>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>

          @elseif (!$conversation->middleman_invited)

          <form method="POST" action="{{route('middleman', $conversation->uuid)}}" class="d-flex align-items-center">
            @csrf
            <button id="add_middleman" type="submit" class="btn btn-primary send">@lang('data.Add middleman')</button>
          </form>


        @endif
        @endcan

        <?php
        use App\Models\PasswordEncryption;
        $EncryptionClass = new PasswordEncryption();
        ?>
{{-- Middleman : check if the account data is correct --}}
        @can('middleman-list')
          @if (!$conversation->isAccountConfirmed)
        <!-- Button trigger modal -->
          <div class="d-flex align-items-center">
            <button style="height: 50px" type="button" class="btn btn-primary send" data-toggle="modal" data-target="#exampleModal">@lang('data.Confirm account data')</button>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">@lang('data.Account data')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{route('chat.confirm', $conversation->id)}}">
                    @method('PUT')
                    @csrf

                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Account email')</label>
                      <input type="text" disabled value="{{ $conversation->product->account_email }}" name="account_email" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Email website link')</label>
                      <input type="text" disabled value="{{ $conversation->product->account_email_website }}" name="account_email_website" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Account username')</label>
                      <input type="text" disabled value="{{ $conversation->product->account_username }}" name="account_username" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Account password')</label>
                      <input type="text" disabled value="@if (!empty($conversation->product->account_password)){{ $EncryptionClass->decryptAES($conversation->product->account_password, env('AES_ENCRYPTION_KEY') ) }} @endif" name="account_password" class="form-control">
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">@lang('data.Submit')</button>
                      <a href="{{ route('chat.reject', $conversation->id) }}" class="btn btn-danger">@lang('data.Reject')</a>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
            @endif
        @endcan

        {{-- Member Show button details --}}
        @if (auth()->id() === $conversation->user_id && $conversation->product->isSold)
        <!-- Button trigger modal -->
          <div class="d-flex align-items-center">
            <button style="height: 50px" type="button" class="btn btn-primary send" data-toggle="modal" data-target="#exampleModal">@lang('data.Show details')</button>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">@lang('data.Show details')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Account email')</label>
                      <input type="text"  value="{{ $conversation->product->account_email }}" name="account_email" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Email website link')</label>
                      <input type="text"  value="{{ $conversation->product->account_email_website }}" name="account_email_website" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Account username')</label>
                      <input type="text"  value="{{ $conversation->product->account_username }}" name="account_username" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                      <label class="form-label">@lang('data.Account password')</label>
                      <input type="text"  value="@if (!empty($conversation->product->account_password)){{ $EncryptionClass->decryptAES($conversation->product->account_password, env('AES_ENCRYPTION_KEY') ) }} @endif" name="account_password" class="form-control">
                    </div>

                </div>

              </div>
            </div>
          </div>

        @endif
{{-- If the Middleman has rejected the account data --}}
        @can('middleman-add')
          @if (!$conversation->isAccountConfirmed)
          @if ($conversation->product->account_email && $conversation->product->account_password && $conversation->product->account_email_website && $conversation->product->account_username)
          <!-- Button trigger modal -->
            <div class="d-flex align-items-center">
              <button style="height: 50px" type="button" class="btn btn-primary send" data-toggle="modal" data-target="#exampleModal">@lang('data.Confirm account data')</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('data.Account data')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{route('chat.updateAccountData2', $conversation->id)}}">
                      @method('PUT')
                      @csrf

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Account email')</label>
                        <input type="text" value="{{ $conversation->product->account_email }}" name="account_email" class="form-control">
                      </div>

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Email website link')</label>
                        <input type="text" value="{{ $conversation->product->account_email_website }}" name="account_email_website" class="form-control">
                      </div>

                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Account username')</label>
                        <input type="text" value="{{ $conversation->product->account_username }}" name="account_username" class="form-control">
                      </div>
                      <div class="form-group col-md-12">
                        <label class="form-label">@lang('data.Account password')</label>
                        <input type="text" value="@if (!empty($conversation->product->account_password)){{ $EncryptionClass->decryptAES($conversation->product->account_password, env('AES_ENCRYPTION_KEY') ) }} @endif" name="account_password" class="form-control">
                      </div>

                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('data.Submit')</button>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>
            @endif
            @endif
        @endcan

        @if ($conversation->user_id === auth()->id() && $conversation->isAccountConfirmed && $conversation->middleman_invited && !$conversation->product->isSold)
        <!-- Button trigger modal -->
          <div class="d-flex align-items-center">
            <button style="height: 50px" type="button" id="BuyNowButton" class="btn btn-primary send">@lang('data.Buy now')</button>
          </div>
        @endif

      </header>
    </div>
    <!--/ Chat Header -->

    <!-- User Chat messages -->
    <div class="user-chats">
      <div class="chats">
        <livewire:conversations.conversation-messages :conversation="$conversation"
                                                      :messages="$conversation->messages" />
      </div>
    </div>
    <!-- Submit Chat form -->
    <livewire:conversations.conversation-reply
            :conversation="$conversation"
            :messages="$conversation->messages"
    />

  </div>
  <!--/ Active Chat -->
</section>
<!--/ Main chat area -->


@endsection

@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/app-chat.js')) }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
          $("#BuyNowButton").on('click', function () {

            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-primary send',
                cancelButton: 'btn btn-danger'
              },
              buttonsStyling: true
            })

            swalWithBootstrapButtons.fire({
              title: "{{__('data.Are you sure?')}}",
              text: "{{ $conversation->product->price  }}$ {{__('data.USD will be deducted from your account')}}",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: "{{__('data.Yes, I confirm')}}",
              cancelButtonText: "{{__('data.No, cancel!')}}",
              reverseButtons: true,
              showLoaderOnConfirm: true,
              preConfirm: () => {
                @php
                  $customer_id = auth()->id();
                  $vendor_id = $conversation->product->user_id;
                  $product_id = $conversation->product->id;
                  $total = $conversation->product->price;
                  $EncryptionClass = new PasswordEncryption();
                  //Payment Encryption

                  $customer_id = $EncryptionClass->encryptAES($customer_id, env('AES_ENCRYPTION_KEY'));
                  $vendor_id = $EncryptionClass->encryptAES($vendor_id, env('AES_ENCRYPTION_KEY'));
                  $product_id = $EncryptionClass->encryptAES($product_id, env('AES_ENCRYPTION_KEY'));
                  $total = $EncryptionClass->encryptAES($total, env('AES_ENCRYPTION_KEY'));

                @endphp
                return fetch(`/api/create_payment/{{$customer_id}},{{$vendor_id}},{{$product_id}},{{$total}}`)
                        .then(response => {
                          if (!response.ok) {
                            console.log(response);
                            throw response.status
                          }
                          return response.json()
                        })
                        .catch(status => {
                          let errorMsg = '';
                          if (status === 300)
                            errorMsg = "{{__('data.There is not enough balance to buy')}}"
                          else if (status === 600)
                            errorMsg = "{{__('data.You have already purchased the product')}}"
                          else
                            errorMsg = "{{__('data.An error occurred, please try again later')}}"

                          Swal.showValidationMessage(
                                  "{{__('data.Error')}} : " + errorMsg
                          )
                        })
              },
            }).then((result) => {
              if (result.isConfirmed) {
                swalWithBootstrapButtons.fire(
                        "{{__('data.Payment completed successfully!')}}",
                        "{{ $conversation->product->price }}$ {{__('data.has been discounted successfully!')}}",
                        'success'
                )
              }
            })

          });
        </script>
@endsection
