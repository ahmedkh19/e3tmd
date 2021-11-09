@extends('layouts/contentLayoutMaster')

@section('title', __('data.Sub categories'))
@section('content')

  <section id="basic-horizontal-layouts">
    <div class="row">
      <div class="col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">@lang('data.Add sub category')</h4>
          </div>
          <div class="card-body">
            @include('content.alerts.success')
            @include('content.alerts.errors')
            <form class="form form-horizontal" action="{{ route('sub_categories.store') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <div class="col-sm-3 col-form-label">
                      <label for="name">@lang('data.Category name')</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" id="name" class="form-control" name="name" placeholder="@lang('data.Category name')" />
                      @error("name")
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group row">
                    <div class="col-sm-3 col-form-label">
                      <label for="name">@lang('data.The main category')</label>
                    </div>
                    <div class="col-sm-9">
                      <select name="parent_id" class="select2 form-control">
                        <option disabled="disabled" selected="selected">{{__('data.Select the main category')}}</option>
                          @if($categories && $categories -> count() > 0)
                            @foreach($categories as $category)
                              <option
                                      value="{{$category -> id }}">{{$category -> slug}} ( {{$category->name}} )</option>
                            @endforeach
                          @endif
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group row">
                    <div class="col-sm-3 col-form-label">
                      <label for="is_active">@lang('data.Category status')</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="checkbox" name="is_active" id="is_active" />
                      @error("is_active")
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-sm-9 offset-sm-3">
                  <button type="submit" class="btn btn-primary mr-1">@lang('data.Submit')</button>
                  <button type="reset" class="btn btn-outline-secondary">@lang('data.Reset')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
