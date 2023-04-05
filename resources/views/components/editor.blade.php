
@php
    $height = !isset($height)?300:intval($height);
    $content = !isset($content)?'':$content;
    $name = !isset($name)?'content':$name;
    $default_place = __('suda_lang::press.pages.content_tips');
    $placeholder = !isset($placeholder)?$default_place:$placeholder;
    $lang = config('app.locale')=='zh_CN'?'zh-CN':'en-US';
@endphp

<textarea language="{{ $lang }}" id="{{ isset($id)?$id:'summernote' }}" class="form-control" name="{{ $name }}" placeholder="{{ $placeholder }}" style="width:100%;padding:5px;" rows=5>{{ $editor_content }}</textarea>

@push('styles-head')
<link href="{{ suda_asset('editor/summernote-bs5.min.css') }}" rel="stylesheet">
@endpush


@push('scripts')

@once
<script src="{{ suda_asset('editor/summernote-bs5.min.js') }}"></script>
<script src="{{ suda_asset('editor/lang/summernote-'.$lang.'.js') }}"></script>
<script src="{{ suda_asset('js/plugins/summernote-ext-media.js') }}"></script>
<script src="{{ suda_asset('js/plugins/summernote-cleaner.js') }}"></script>
{{-- <script src="{{ suda_asset('js/plugins/summernote-image-shapes.js') }}"></script> --}}
{{-- <script src="{{ suda_asset('js/plugins/summernote-image-captionit.js') }}"></script> --}}
<script src="{{ suda_asset('/js/plugins/editor.js') }}"></script>
@endonce

<script type="text/javascript">
    $(document).ready(function(){
        suda.editor_height = {{ $height }};
        
        const elem = "{{ isset($id)?'#'.$id:'#summernote' }}";

        $.fn.sudaEditor(elem);
    })
</script>


@endpush