<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ $data['title'] }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                direction: rtl;
            }
            .card {
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                transition: 0.3s;
                width: 100%;
                text-align: center;
            }
            .card:hover {
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            }
            .container {
                padding: 2px 16px;
            }
            .row {
                background: #8a93c6;
                display: inline;
                padding: 0 10px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="card">
          <div class="container">
            <h4><b>{{__('data.Name')}} : </b><br><span class="row">{{ $data['name'] }}</span></h4>
            <h4><b>{{__('data.Email')}} : </b><br><span class="row">{{ $data['email'] }}</span></h4>
            <h4><b>{{__('data.Subject')}} : </b><br><span class="row">{{ $data['subject'] }}</span></h4>
            <h4><b>{{__('data.Message')}} : </b><br><span class="row">{{ $data['message'] }}</span></h4>
          </div>
        </div>
    </body>
</html>
