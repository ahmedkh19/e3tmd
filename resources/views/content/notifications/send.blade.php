@extends('layouts/contentLayoutMaster')

@section('title', __('data.Send notification'))
@section('page-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

  <style>
    .parDivClass{
      max-height:200px;
      overflow:auto;
      margin-top: 10px;
      border-radius: 5px;
      padding: 5px;
    }
    .borderSc{
      border:1px solid gray;
    }
    .parDivClass option{
      padding:4px 9px;
    }

    .parDivClass option:hover{
      background-color:#7367f0;
      cursor: pointer;
    }
    #SelectedUser{
      background: #283046;
      border-color: #7367f0;
      overflow: auto;
      max-height: 200px;
      min-height: 80px;
      display: flex;
      flex-wrap: wrap;
    }
    #SelectedUser input{
      background: rgba(115, 103, 240, 0.12) ;
      color: #7367f0 ;
      border:none;
      outline:none;
      margin:5px;
    }
    .SecParent{
      position: relative;
      width: fit-content;

    }
    .deleteX{
      position:absolute;
      right:12px;
      top:5px;
      color:#fff;
    }
    .deleteX:hover{
      color:red;
      cursor: pointer;
    }
  </style>

@endsection

@section('content')

  <section id="basic-horizontal-layouts">
    <div class="row">
      <div class="col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">@lang('data.Send notification')</h4>
          </div>
          <div class="card-body">
            @include('content.alerts.success')
            @include('content.alerts.errors')
            <form id="userSearchForm" class="form form-horizontal" enctype="multipart/form-data" action="{{ route('send_notification.store') }}" method="POST">
              @csrf
              <div class="row">

                <div class="col-12">

                  <!-- yasser-->
                  <div class="col-12">
                    <div class="form-group row">
                      <div class="col-sm-3 col-form-label">
                        <label class="form-label" for="description">@lang('data.Users')</label>
                      </div>
                      <div class="col-sm-9">
                        <input id="userInput2" multiple placeholder="User Name" type="text" name="" list="Users" class="UsersInput form-control" />
                        <p id="UsersMess" class="text-danger"></p>
                          <div id="SelectedUser" type="text" name="" class="form-control" ></div>
                          <input type="hidden" id="final_users" name="final_users" value="">
                          <div id="Users" ></div>
                      </div>
                      @error("users")
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group row">
                      <div class="col-sm-3 col-form-label">
                        <label for="message">@lang('data.Message')</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea id="message" class="form-control" name="message" placeholder="@lang('data.Message')" >{{ old('message') }}</textarea>
                        @error("message")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                    </div>
                  </div>



                  <div class="col-12">
                    <div class="form-group row">
                      <div class="col-sm-3 col-form-label">
                        <label for="link">@lang('data.Link') (@lang('data.Optional'))</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" value="{{old('link')}}" id="link" class="form-control" name="link" placeholder="@lang('data.Link')" >
                        @error("link")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-9 offset-sm-3">
                    <button type="submit" id="submitButton" class="btn btn-primary mr-1">@lang('data.Send')</button>
                    <button type="reset" class="btn btn-outline-secondary">@lang('data.Reset')</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
@section('vendor-script')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui-calendar/0.0.8/calendar.min.js" integrity="sha512-PAbeCLn5ujGnnJa8R+Fjg3p6Dl66qXuXmmDcpfqq0uSUGZ+Qv+wogDou7uBna+f7g+F6Bm5T+Q1oSwpjxZJ3Xw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>

  <script>
    let data = [],
            idCheck = [],
            parDiv,
            parDivGroup,
            parDivArray ,
            deleteXGroup,
            //  NameCounter = 0,
            deleteXArray;
    let List = document.getElementById('Users');
    let SelectedUser = document.getElementById('SelectedUser');
    let UsersMess = document.getElementById('UsersMess');

    SelectedUser.classList.add('d-none')

    let UsersInput = document.querySelector('.UsersInput')
    UsersInput.addEventListener('keyup',()=>{
      if(parDiv){parDiv.remove()}

      if(UsersInput.value.length >= 3){
        UsersMess.textContent = ``
        data = []
        parDiv = document.createElement("div");
        parDiv.setAttribute("class", "parDivClass borderSc");
        List.appendChild(parDiv);
        const API_URL = `/api/search-users/${UsersInput.value}`;
        const XHR = new XMLHttpRequest()
        XHR.open(`GET`, API_URL)
        XHR.send()

        //checking
        XHR.onreadystatechange = ()=>{
          if(XHR.readyState === 4 && XHR.status === 200){
            UsersMess.textContent = ``

            data = JSON.parse(XHR.response)
            console.log(data)
            data.forEach(element => {
              let option = document.createElement("option");
              option.textContent  = element.username
              option.setAttribute("id", element.id);
              parDiv.appendChild(option);
            });
            parDivGroup = document.querySelectorAll('.parDivClass option')
            parDivArray = Array.from(parDivGroup)


            parDivArray.forEach(element => {
              element.addEventListener('click',()=>{
                if(deleteXArray  ){
                  if(idCheck.includes(element.id)){
                    UsersMess.textContent = `هذا المستخدم تم تحدبده مسبقاً`

                  }else{
                    element.remove()
                    UsersInput.value = '';
                    idCheck.push(element.id)
                    SelectedUser.classList.remove('d-none')
                    // NameCounter ++
                    let SecParent = document.createElement("div");
                    let chosse = document.createElement("input");
                    let deleteX = document.createElement("span");
                    chosse.textContent  = `disabled`
                    chosse.setAttribute("value", element.textContent);
                    chosse.setAttribute("disabled", `disabled`);
                    chosse.setAttribute("name", `users[]`);
                    chosse.setAttribute("class", `users`);
                    chosse.setAttribute("id", element.id);
                    SecParent.setAttribute("class", `SecParent`);

                    SelectedUser.appendChild(SecParent);
                    SecParent.appendChild(chosse);

                    deleteX.textContent  = `x`
                    deleteX.setAttribute("class", `deleteX`);
                    SecParent.appendChild(deleteX);
                    deleteXGroup = document.querySelectorAll('.SecParent')
                    deleteXArray = Array.from(deleteXGroup)

                    if(parDiv.children.length === 0){
                      parDiv.classList.remove('borderSc')
                    }else{
                      parDiv.classList.add('borderSc')
                    }

                    deleteXArray.forEach(element => {
                      element.children[1].addEventListener('click',()=>{
                        for( var i = 0; i < idCheck.length; i++){

                          if ( idCheck[i] === element.children[0].id) {
                            idCheck.splice(i, 1);
                            i--;
                          }
                        }

                        element.remove()
                        if(SelectedUser.children.length === 0){
                          SelectedUser.classList.add('d-none')
                        }else{
                          SelectedUser.classList.remove('d-none')
                        }
                      })
                    })

                  }


                }else{
                  element.remove()
                  UsersInput.value = '';
                  idCheck.push(element.id)
                  SelectedUser.classList.remove('d-none')
                  // NameCounter ++
                  let SecParent = document.createElement("div");
                  let chosse = document.createElement("input");
                  let deleteX = document.createElement("span");
                  //chosse.textContent  = `disabled`
                  chosse.setAttribute("value", element.textContent);
                  chosse.setAttribute("disabled", `disabled`);
                  chosse.setAttribute("name", `users[]`);
                  chosse.setAttribute("class", `users`);
                  chosse.setAttribute("id", element.id);
                  SecParent.setAttribute("class", `SecParent`);

                  SelectedUser.appendChild(SecParent);
                  SecParent.appendChild(chosse);

                  deleteX.textContent  = `x`
                  deleteX.setAttribute("class", `deleteX`);
                  SecParent.appendChild(deleteX);
                  deleteXGroup = document.querySelectorAll('.SecParent')
                  deleteXArray = Array.from(deleteXGroup)

                  if(parDiv.children.length === 0){
                    parDiv.classList.remove('borderSc')
                  }else{
                    parDiv.classList.add('borderSc')
                  }

                  deleteXArray.forEach(element => {
                    element.children[1].addEventListener('click',()=>{
                      for( var i = 0; i < idCheck.length; i++){

                        if ( idCheck[i] === element.children[0].id) {
                          idCheck.splice(i, 1);
                          i--;
                        }
                      }
                      element.remove()
                      if(SelectedUser.children.length === 0){
                        SelectedUser.classList.add('d-none')
                      }else{
                        SelectedUser.classList.remove('d-none')
                      }
                    })
                  })



                }


              })

            });
            if(data.length === 0){
              parDiv.remove()
              UsersMess.textContent = `...لا يوجد مقترحات لعرضها`
            }
          }else{
            console.log('error');

          }
        }

      }else{
        UsersMess.textContent = `يجب علي الأقل إدخال تلاثة أحرف`
      }

    })

  </script>

  <script>
    //By ahmed khan

    $('#userSearchForm').submit(function(event) {

      event.preventDefault(); //this will prevent the default submit

      let users = $(".users");
      let userInput = $("#final_users");
      for(var i = 0; i < users.length; i++){

          userInput.val( userInput.val() + $(users[i]).attr('id') + ','  );

      }

      $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
    })

  </script>
@endsection