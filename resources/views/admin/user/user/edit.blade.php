@extends('view_path::component.modal')



@section('content')
<form class="form-horizontal handle-ajaxform" role="form" method="POST" action="{{ admin_url('user/save') }}">
    
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $user->id }}">
    
    <div class="modal-body">
        <div class="container-fluid">
            
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                
                <label for="name">
                    {{ trans('suda_lang::press.username') }}
                </label>
            
                <input type="text" name="name" class="form-control" id="inputName" placeholder="英文数字下划线" value="{{ $user->name }}">
                @if ($errors->has('name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            
            </div>
            
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                
                <label for="email">
                    {{ trans('suda_lang::press.email') }}
                </label>
                
                <input type="text" name="email" class="form-control" id="inputEmail" placeholder="请输入邮箱（选填）" value="{{ $user->email }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            
            </div>
        
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                
                <label for="password">
                    {{ trans('suda_lang::auth.password') }}
                </label>
                
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="请输入密码">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ trans('suda_lang::press.submit_save') }}</button>
    </div>

</form>

<script>
    
    jQuery(document).ready(function(){
        $('.handle-ajaxform').ajaxform();
    });
    
</script>

@endsection
