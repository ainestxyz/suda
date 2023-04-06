@extends('view_path::component.modal',['modal_size'=>'md'])



@section('content')
<form class="handle-ajaxform" role="form" method="POST" action="{{ admin_url('media/setting/save') }}">
    @csrf

    <div class="modal-body">
    <div class="container-fluid">
            <div class="mb-3{{ $errors->has('medium[width]') ? ' has-error' : '' }}">
                  
                <label for="medium[width]">
                    缩略大图
                    <span class="help-block">
                        系统默认 500px
                    </span>
                </label>

                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">宽度</span>
                            <input type="number" name="medium[width]" class="form-control input-sm" value="{{ $setting['size']['medium']['width'] }}" id="medium_width" placeholder="宽度">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">高度</span>
                            <input type="number" name="medium[height]" class="form-control input-sm" value="{{ $setting['size']['medium']['height'] }}" id="medium_height" placeholder="高度">
                        </div>
                    </div>
                </div>

                
                
                    
  
              </div>
  
              <div class="mb-3{{ $errors->has('small[width]') ? ' has-error' : '' }}">
                    
                  <label for="small[width]">
                        缩略小图
                        <span class="help-block">
                            系统默认 200px
                        </span>
                  </label>
  
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">宽度</span>
                            <input type="number" name="small[width]" class="form-control input-sm" value="{{ $setting['size']['small']['width'] }}" id="small_width" placeholder="宽度">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">高度</span>
                            <input type="number" name="small[height]" class="form-control input-sm" value="{{ $setting['size']['small']['height'] }}" id="small_height" placeholder="高度">
                        </div>
                    </div>
                </div>

              </div>

            <div class="mb-3{{ $errors->has('crop') ? ' has-error' : '' }}">
                
                <label for="crop">
                    强制宽高
                </label>

                <div class="form-check form-check-inline">
                    <input type="checkbox" value="1" name="crop" @if(isset($setting['crop']) && $setting['crop']==1) checked @endif>
                    <label class="form-check-label" for="crop">{{ __('suda_lang::press.yes') }}</label>
                </div>
                
                <span class="help-block">
                    默认按照原图宽高比例生成缩略图<br>
                    选择强制后，图片缩略图将会自动切图按照宽高存储
                </span>
                
                
            </div>

              <div class="mb-3{{ $errors->has('images') ? ' has-error' : '' }}">
                    
                    <label for="images">
                        默认图
                    </label>
    
                    <div class="col-sm-6 pl-0">
                        @if(isset($media))
                        @uploadBox('media',1,1,$media)
                        @else
                        @uploadBox('media',1,1)
                        @endif
                    </div>
                   
                    
    
             </div>
    </div>
</div>

    <div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">{{ __('suda_lang::press.btn.cancel') }}</span></button>
    <button type="submit" class="btn btn-primary">{{ __('suda_lang::press.submit_save') }}</button>
</div>

</form>

<script>
    
    jQuery(function(){
        
        $('.handle-ajaxform').ajaxform();

        $.mediabox({
            box_url: "{{ admin_url('medias/load-modal/') }}",
            modal_url: "{{ admin_url('medias/modal/') }}",
            upload_url: "{{ admin_url('medias/upload/image/') }}",
            remove_url: "{{ admin_url('medias/remove/image/') }}"
        });
    });
    
</script>

@endsection

