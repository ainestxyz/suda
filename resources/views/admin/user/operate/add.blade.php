@extends('view_path::component.modal')

@section('content')

<form class="handle-ajaxform" role="form" method="POST" action="{{ admin_url('manage/operates/save') }}"  autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="organization_id" value="1">
    <div class="modal-body">
        
        <div class="container-fluid">
            
              <div id="organization_group" class="form-group{{ $errors->has('organization_id') ? ' has-error' : '' }}">

                <label for="organization_id" >
                    {{ trans('suda_lang::press.organization') }}
                </label>
        
                <select class="select-category form-control" name="category[]" multiple="multiple" placeholder="请选择部门">
                    @if($categories)
                    
                    @include('view_suda::taxonomy.category_options',['cates'=>$categories,'child'=>0])
                    
                    @endif
                </select>
      
              </div>
      
              <div id="role_group" class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
        
                <label for="role_id" >
                    {{ trans('suda_lang::press.role') }}
                </label>
        
                <select id="role_id" name="role_id" class="form-control" placeholder="{{ trans('suda_lang::press.select_placeholder',['column'=>trans('suda_lang::press.role')]) }}">
                    <option value="">{{ trans('suda_lang::press.select_placeholder',['column'=>trans('suda_lang::press.role')]) }}</option>
                    @foreach ($roles as $k=>$role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
      
              </div>
      
      
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
        
      
              <label for="username" >
                  {{ trans('suda_lang::press.username') }}
              </label>
      
              <input type="text" name="username" class="form-control" id="inputName" placeholder="{{ __('suda_lang::auth.username_rule') }}" value="" autocomplete="false">
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
      
            </div>
    
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        
              <label for="password" >
                  {{ trans('suda_lang::auth.password') }}
              </label>
      
              <input type="password" name="password" class="form-control" id="inputName" placeholder="{{ trans('suda_lang::auth.password') }}" value="" autocomplete="new-password">
                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
      
            </div>
    
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
        
              <label for="phone" >
                  {{ trans('suda_lang::press.telephone') }}
              </label>
      
              <input type="text" name="phone" class="form-control" id="inputName" placeholder="{{ trans('suda_lang::press.telephone') }}" value="">
                  @if ($errors->has('phone'))
                      <span class="help-block">
                          <strong>{{ $errors->first('phone') }}</strong>
                      </span>
                  @endif
      
            </div>
    
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        
              <label for="email" >
                  {{ trans('suda_lang::press.email') }}
              </label>
      
              <input type="text" name="email" class="form-control" id="inputName" placeholder="{{ trans('suda_lang::press.email') }}">
                  @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
      
            </div>

            @if($soperate->superadmin==1)
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="superadmin" placeholder="是" value="1" >
                    <label class="form-check-label" for="superadmin">启用超级管理员</label>
                </div>
            </div>
            @else
            {{-- 不能添加编辑管理员 --}}
            @endif

            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" name="enable" placeholder="是" value="1" >
                    <label class="form-check-label" for="enable">{{ trans('suda_lang::press.enable') }}</label>
                </div>
            </div>
            
        </div>
        
    </div>
    
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ __('suda_lang::press.submit_save') }}</button>
    </div>

</form>

<script>
    
    jQuery(document).ready(function(){
        
        $('.handle-ajaxform').ajaxform();
        
        $('input[name="superadmin"]').on('change',function(e){
            e.preventDefault();
            if($(this).prop('checked')==true){
                $('#organization_group').hide();
                $('#role_group').hide();
            }else{
                $('#organization_group').show();
                $('#role_group').show();
            }
        });

        $('select.select-category').selectCategory('multiple');

    });
    
</script>
    
@endsection
