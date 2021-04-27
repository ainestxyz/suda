@extends('view_path::layouts.default')



@section('content')
<div class="container-fluid">
    
    <div class="row suda-row dashboard dashboard-theme">
        <div class="page-heading">
            <h1 class="page-title">
                后台模板管理<span class="help-block">控制面板风格</span>
            </h1>

            <div class="btn-toolbar ml-auto" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">

                    <button type="button" href="{{ admin_url('style/dashboard.layout') }}" class="pop-modal btn btn-sm btn-light mr-2">
                        设置风格
                    </button>

                    <button type="button" href="{{ admin_url('theme/updatecache/admin') }}" class="modal-action btn btn-sm btn-light">
                        更新模板缓存
                    </button>

                </div>
            </div>

        </div>
        
        
        <div class="col-12 suda_page_body">
            
            @if(isset($themes))

            <div class="card card-theme mb-3 border-0 bg-transparent" style="box-shadow:none;">
                
                <div class="card-body" >
                    

                    @if(isset($theme) && is_array($theme))

                    <div class="row">

                        <div class="col-sm-3 ">
                            <div class="theme-info theme-info-using">
                                <div class="screenshot">
                                    @if(isset($theme['screenshot']))
                                    <img src="{{ asset($theme['screenshot']) }}">
                                    @endif
                                </div>
                                <div class="text-center">
                                    <i class="ion-compass text-primary"></i>正在使用
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-sm-6">
                            <div class="theme-support">
                                <p><strong>主题:&nbsp;&nbsp;</strong>{{ $theme['name'] }} <b>v{{ $theme['version'] }}</b></p>
                                <p><strong>描述:&nbsp;&nbsp;</strong>{{ $theme['description'] }}</p>
                                <p><strong>作者:&nbsp;&nbsp;</strong><a target="_blank" href="{{ $theme['author_url'] }}">{{ $theme['author'] }}<i class="ion-arrow-redo-circle-outline"></i></a></p>
                                <p><strong>支持:&nbsp;&nbsp;</strong><a target="_blank" href="{{ $theme['theme_url'] }}">开发者网站<i class="ion-arrow-redo-circle-outline"></i></a></p>
                            </div>
                        </div>
                    
                    </div>

                    @endif
                
                </div>
            
            </div>

            @endif

            <div class="card">
                <div class="card-header bg-white">
                    风格列表
                </div>
                <div class="card-body">

                    @if(isset($themes) && !empty($themes))

                        <div class="row">

                            @foreach($themes as $kk=>$theme)
                        
                                @if( $current_theme != $kk )
                            
                            
                                <form class="col-sm-3 form-ajax" action="{{ admin_url('style/dashboard/save') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="app_name" value="admin">

                                    <div class="theme-info">
                                        <div class="screenshot">
                                            <div class="screenshot-cover"></div>
                                            @if(isset($theme['screenshot']))
                                            <img src="{{ asset($theme['screenshot']) }}" class="mw-100">
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            @if(isset($theme['name'])) {{ $theme['name'] }} @else unkown @endif
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-light btn-sm">启用</button>
                                            <a href="{{ admin_url('style/preview/'.$kk) }}" target="_blank" class="btn btn-light btn-sm">预览</a>
                                            <input type="hidden" name="theme_name" value="{{ $kk }}">
                                        </div>
                                    </div>
                                </form>
                            
                            
                                @endif
                    
                            @endforeach
                    
                        </div>
                        
                    
    
                    @else
    
                        暂无风格主题
    
                    @endif

                </div>
            </div>
            
        </div>
        
    </div>
    
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    
    $('.modal-action').suda_ajax({
        type:'POST',
        confirm:false,
    });
});
</script>

@endpush