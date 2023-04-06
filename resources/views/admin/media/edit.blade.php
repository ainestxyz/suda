@extends('view_path::component.modal')



@section('content')
<style>
.edit-media{
    max-height:300px;
    margin: 0 auto;
    display: block;
}
</style>
<form role="form" method="POST" action="{{ admin_url('media/update') }}" class="handle-ajaxform">
    @csrf
    <input type="hidden" name="id" value="{{ $media->id }}">
    <div class="modal-body">
    <div class="container-fluid">
        <div class="col-12 suda_page_body">
            
            <div class="mb-3">
            <label for="inputName" class="control-label">
                {{ __('suda_lang::press.medias.image') }}
            </label>

            <div class="row">
                <div class="col col-sm-6">
                    {!! suda_image($media,['size'=>'large','imageClass'=>'edit-media edit-media-'.$media->id],false) !!}
                </div>
                <div class="col col-sm-4">
                    {!! suda_image($media,['size'=>'medium','imageClass'=>'edit-media edit-media-'.$media->id],false) !!}
                </div>
                <div class="col col-sm-2">
                    {!! suda_image($media,['size'=>'small','imageClass'=>'edit-media edit-media-'.$media->id],false) !!}
                </div>
            </div>
                
            </div>
        
            <div class="mb-3{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="inputName" class="control-label">
                    {{ __('suda_lang::press.name') }}
                </label>

                <input type="text" name="name" class="form-control" value="{{ $media->name }}" id="inputName" placeholder="{{ __('suda_lang::press.name') }}">
            </div>
            
            <div class="mb-3{{ $errors->has('keyword') ? ' has-error' : '' }}" >
                <label for="slug" >
                    {{ __('suda_lang::press.tags.tag') }}
                </label>
                <x-suda::select-tag name="keyword[]" taxonomy="media_tag" max=5 :tags="$tags" :link="admin_url('tags/search/json')" />
            </div>

        </div>
    </div>
</div>

    <div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">{{ __('suda_lang::press.btn.cancel') }}</span></button>
    <button type="submit" class="btn btn-primary">{{ __('suda_lang::press.submit_save') }}</button>
</div>

</form>

@stack('scripts')

<script>
    
    jQuery(function(){
        $('.handle-ajaxform').ajaxform();
    });
    
</script>

@endsection

