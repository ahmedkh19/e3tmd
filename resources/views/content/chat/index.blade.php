
@extends('layouts.contentLayoutMaster')

@section('title', 'Chat Application')

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection
@include('content.chat.app-chat-sidebar')
@section('content')
<div class="body-content-overlay"></div>
<!-- Main chat area -->
<section class="chat-app-window">
  <!-- To load Conversation -->
  <div class="start-chat-area">
    <div class="mb-1 start-chat-icon">
      <i data-feather="message-square"></i>
    </div>
    <h4 class="sidebar-toggle start-chat-text">@lang('data.Start Conversation')</h4>
  </div>
  <!--/ To load Conversation -->

</section>
<!--/ Main chat area -->

<!-- User Chat profile right area -->
<div class="user-profile-sidebar">
  <header class="user-profile-header">
    <span class="close-icon">
      <i data-feather="x"></i>
    </span>
    <!-- User Profile image with name -->
    <div class="header-profile-sidebar">
      <div class="avatar box-shadow-1 avatar-border avatar-xl">
        <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="user_avatar" height="70" width="70" />
      </div>
      <h4 class="chat-user-name">Kristopher Candy</h4>
      <span class="user-post">UI/UX Designer 👩🏻‍💻</span>
    </div>
    <!--/ User Profile image with name -->
  </header>
  <div class="user-profile-sidebar-area">
    <!-- About User -->
    <h6 class="section-label mb-1">About</h6>
    <p>Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop.</p>
    <!-- About User -->
    <!-- User's personal information -->
    <div class="personal-info">
      <h6 class="section-label mb-1 mt-3">Personal Information</h6>
      <ul class="list-unstyled">
        <li class="mb-1">
          <i data-feather="mail" class="font-medium-2 mr-50"></i>
          <span class="align-middle">kristycandy@email.com</span>
        </li>
        <li class="mb-1">
          <i data-feather="phone-call" class="font-medium-2 mr-50"></i>
          <span class="align-middle">+1(123) 456 - 7890</span>
        </li>
        <li>
          <i data-feather="clock" class="font-medium-2 mr-50"></i>
          <span class="align-middle">Mon - Fri 10AM - 8PM</span>
        </li>
      </ul>
    </div>
    <!--/ User's personal information -->

    <!-- User's Links -->
    <div class="more-options">
      <h6 class="section-label mb-1 mt-3">Options</h6>
      <ul class="list-unstyled">
        <li class="cursor-pointer mb-1">
          <i data-feather="tag" class="font-medium-2 mr-50"></i>
          <span class="align-middle">Add Tag</span>
        </li>
        <li class="cursor-pointer mb-1">
          <i data-feather="star" class="font-medium-2 mr-50"></i>
          <span class="align-middle">Important Contact</span>
        </li>
        <li class="cursor-pointer mb-1">
          <i data-feather="image" class="font-medium-2 mr-50"></i>
          <span class="align-middle">Shared Media</span>
        </li>
        <li class="cursor-pointer mb-1">
          <i data-feather="trash" class="font-medium-2 mr-50"></i>
          <span class="align-middle">Delete Contact</span>
        </li>
        <li class="cursor-pointer">
          <i data-feather="slash" class="font-medium-2 mr-50"></i>
          <span class="align-middle">Block Contact</span>
        </li>
      </ul>
    </div>
    <!--/ User's Links -->
  </div>
</div>
<!--/ User Chat profile right area -->
@endsection

@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/app-chat.js')) }}"></script>
@endsection
