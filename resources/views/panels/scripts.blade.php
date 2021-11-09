{{-- Vendor Scripts --}}
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}
@livewireScripts

<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="{{ asset('js/scripts/favicon/favico-0.3.10.min.js') }}"></script>

<script>
        const title = document.title;
        let Counter = Number(document.getElementById('notification_count').textContent);

        //Favicon method
        let favicon=new Favico({
            animation:'none',
            bgColor : 'black',
            textColor : '#fff',
        });
        function CheckCounterStatement() {
            // If there is no notification = don't show a counter
            if ( Counter <= 0) {
                document.title = title;
                //Favicon Reset
                favicon.reset();
                //Reset the counter
                Counter = 0;
            } else {
                document.title = '(' + Counter + ') ' + title;
                //Favicon

                //Reset
                favicon=new Favico({
                    animation:'none',
                    bgColor : 'black',
                    textColor : '#fff',
                });

                favicon.badge(Counter);
            }
        }

        // Once the page load up
        CheckCounterStatement();

        function changeTitle() {
            Counter++;
            CheckCounterStatement();
        }

        //MarkAsRead
        function changeTitle2() {
            Counter--;
            CheckCounterStatement();
        }

        //MarkAllAsRead
        $("#markAllAsRead").on('click', function () {
            Counter = 0;
            CheckCounterStatement();
        });

        Echo.private('App.Models.User.' + {{ auth()->id() }})
            .notification((notification) => {
                changeTitle();

                document.getElementById('notification').muted = false;
                document.getElementById('notification').play();
            });

</script>
@if($configData['blankPage'] === false)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
{{-- page script --}}
@yield('page-script')
{{-- page script --}}