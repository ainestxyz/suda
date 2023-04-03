<select class="x-suda-select-category form-control" name="{{ $name }}" @if($type=='multiple') multiple="multiple" @endif placeholder="{{ $placeholder }}">
    <option value="0"> - 无上级分类 - </option>
    @if($cates)

        @if(isset($selected))
            @php
                if(!is_array($selected)){
                    $selected = (array)$selected;
                }
            
            @endphp
        @else
        @php
            $selected = [];
        @endphp
        @endif
        
        @if(!isset($exclude))
        @php
            $exclude = [];
        @endphp
        @endif
        
    @foreach ($cates as $cate)

    @if(!in_array($cate->id,$exclude) && !in_array($cate->parent,$exclude))
    <option value="{{ $cate->id }}" @if(in_array($cate->id,$selected)) selected @endif>
    {{ $cate->term->name }}
    </option>
    @endif

    @if($cate->children && !in_array($cate->id,$exclude))

        @include('view_suda::taxonomy.category.options',['cates'=>$cate->children,'child'=>$child+1,'select'=>$selected,'exclude'=>$exclude])
        
    @endif

    @endforeach
    @endif

</select>

@pushOnce('scripts')
<script type="text/javascript">
    jQuery(function(){
        $('select.x-suda-select-category').selectCategory();
    })
</script>
@endpushOnce