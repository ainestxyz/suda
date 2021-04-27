<?php

namespace Gtd\Suda\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gtd\Suda\Traits\HasTaxonomies;
use Gtd\Suda\Traits\MediaTrait;

class Article extends Model
{
    use SoftDeletes;
    use HasTaxonomies;
    use MediaTrait;
    
    protected $table = 'articles';
    protected $fillable = [
        'display_operate_id',
        'disable'
    ];
    
    protected $appends = [
        'real_url'
    ];
    
    public function operate()
    {
        return $this->belongsTo('Gtd\Suda\Models\Operate','operate_id','id');
    }
    
    public function heroimage()
    {
        return $this->hasOne('Gtd\Suda\Models\Mediatable','mediatable_id','id')->where('mediatable_type','Gtd\Suda\Models\Article')->where('position','hero_image')->with('media');
    }
    
    public function categories(){
        return $this->morphMany('Gtd\Suda\Models\Taxable', 'taxable')->with(['taxonomy'=>function($query){
            $query->where('taxonomy','post_category')->with('term');
        }]);
    }
    
    public function tags(){
        return $this->morphMany('Gtd\Suda\Models\Taxable', 'taxable')->with(['taxonomy'=>function($query){
            $query->where('taxonomy','post_tag')->with('term');
        }]);
    }

    public function getRealUrlAttribute(){

        if(!empty($this->redirect_url)){
            return $this->redirect_url;
        }
        
        if(!empty($this->slug)){
            return url('article/'.$this->slug);
        }else{
            return url('article/'.$this->id);
        }

    }
    
    public function getSlugAttribute($value){
        
        if(!empty($value)){
            return $value;
        }else{
            return '';
        }

    }
    
    
}
