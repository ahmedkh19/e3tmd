<div>
    <li class="nav-item dropdown dropdown-notification mr-25">
        <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell ficon"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span id="notification_count" class="badge badge-pill badge-danger badge-up">{{ $unReadNotificationsCount }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
            <li class="dropdown-menu-header">

                <div class="dropdown-header d-flex">
                    <h4 class="notification-title mb-0 mr-auto">@lang('data.Notifications')</h4>
                    @if ( $unReadNotificationsCount >= 1)
                        <div class="badge badge-pill badge-light-primary">{{ $unReadNotificationsCount }} @lang('data.New')</div>
                    @else
                        <div class="badge badge-pill badge-light-primary">@lang('data.No new')</div>

                    @endif
                </div>

            </li>

            <li class="scrollable-container media-list " id="scrollable" style="overflow-y:auto">
                @forelse($unReadNotifications as $notification)
                    <a class="d-flex pr-3" wire:click="markAsRead('{{ $notification->id }}')" href="@if ($notification->data['link']){{$notification->data['link']}}@else javascript:void(0); @endif">
                        <div class="media d-flex align-items-start position-relative">
                            <div class="media-left">
                                <div class="avatar"><img src="@if ($notification->user_id === 1){{asset('images/portrait/small/avatar-s-3.jpg')}}@else{{asset('images/logo/favicon.ico')}}@endif" alt="avatar" width="32" height="32"></div>
                            </div>
                            <div class="media-body">
                                <p class="media-heading"> {{ $notification->data['message'] }} </p>
                            </div>
                            <a onclick="changeTitle2()" class="notificationOnClick" href="javascript:void(0);" wire:click="markAsRead('{{ $notification->id }}')" style="position: absolute;float: right;right: 15px;top: 20px;color: red;">X</a>

                        </div>
                    </a>
                @empty
                    <div style="color:#e82323; padding:20px; font-weight: bold" class="dropdown-item text-center">
                        @lang('data.No notifications')
                    </div>
                @endforelse

            </li>
            <li class="dropdown-menu-footer" style="position: fixed; bottom: 0px; right: 0; left: 0px; z-index: 100">
                <a id="markAllAsRead" wire:click="markAllAsRead()" class="btn btn-primary btn-block" href="javascript:void(0)">@lang('data.Mark all notifications')</a>
            </li>

        </ul>
    </li>
    <audio id="notification" src="{{ asset('audio/notification.mpeg') }}" muted></audio>

</div>
