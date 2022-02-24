<?php
/**
 * ProfileController.php
 * description
 * date 2017-11-06 10:23:31
 * author suda <hello@suda.gtd.xyz>
 * @copyright GTD. All Rights Reserved.
 */

namespace Gtd\Suda\Http\Controllers\Admin\User;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;

use Gtd\Suda\Http\Controllers\Media\ImageController;
use Gtd\Suda\Http\Controllers\Media\MediaController;
use Gtd\Suda\Models\Media;

use Gtd\Suda\Http\Controllers\Admin\DashboardController;
use Gtd\Suda\Models\Operate;

use Gtd\Suda\Traits\AvatarTrait;

class ProfileController extends DashboardController
{
    use AvatarTrait;

    public $table = 'operates';
    public $view_in_suda = true;
    
    public function showProfile(){
        
        $this->title(__('suda_lang::auth.accountInfo'));

        $this->setData('extendFile','view_path::layouts.default');
        if($this->user->user_role == 2){
            $this->setData('extendFile','view_path::layouts.default_noside');
        }

        $this->setData('extend_breadcrumbs',[
            [
                'slug'=>'user.profile',
                'title'=>'编辑资料',
                'url'=>'profile',
                'route'=>'',
            ]
        ]);
        
        return $this->display('user.profile');    
    }
    
    
    //验证账户数据
    protected function profileValidator(array $data)
    {
        $roles = [
            'username'  => 'required|unique:'.$this->table.'|min:2|max:64',
            'email'     => 'required|email|unique:'.$this->table.'|min:2|max:64',
            'phone'     => 'required|unique:'.$this->table.'|min:11|max:64',
        ];
        
        
        if(array_key_exists('user_id',$data)){
            
            $roles = [
                'username' => [
                    'required',
                    Rule::unique($this->table)->ignore($data['user_id'], 'id'),
                    'min:2',
                    'max:64'
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique($this->table)->ignore($data['user_id'], 'id'),
                    'min:2',
                    'max:64'
                ],
                'phone' => [
                    'required',
                    'unique:'.$this->table.',id,'.$data['user_id'],
                    'min:11',
                    'max:64'
                ],
            ];
            
        }
        
        $messages = [
            'username.required'=>trans('suda_lang::press.input_placeholder',['column'=>trans('suda_lang::press.username')]),
            'name.unique'=>'用户名已经被占用',
            'email.required'=>'请输入邮箱',
            'email.unique'=>'邮箱已经被占用',
            'phone.required'=>'请输入手机号',
            'phone.unique'=>'手机号已经被占用'
        ];
        
        return Validator::make($data, $roles,$messages);
    }
    
    //保存资料信息
    public function saveProfile(Request $request,HasherContract $hasher){
        $this->hasher = $hasher;
        
        //if($this->user->id==1){
        //    $url = '';
        //    return $this->responseAjax('fail','无法重置超级管理员账户',$url);
        //}
        
        $this->profileValidator($request->all())->validate();
        
        $user_id = intval($request->user_id);
        
        $operate_exist = Operate::where('id','<>',$user_id)->where('username','=',$request->username)->first();
        
        $enable = 0;
        if($request->has('enable') && $request->enable=='on'){
            $enable = 1;
        }
        
        if($user_id){
            Operate::where('id',$user_id)->update([
                'username'  =>$request->username,
                'email'     =>$request->email,
                'phone'     =>$request->phone,
            ]);
        }else{
            $operateModel = new Operate;
            $operateModel->username = $request->username;
            $operateModel->email = $request->email;
            $operateModel->phone = $request->phone;
            $operateModel->save();
            
            $user_id = $operateModel->id;
        }
        
        $user = Operate::where('id',$user_id)->with('avatar')->first();
        $this->uploadCroppie($request->avatar,'operate',$user);
        
        return redirect(admin_url('profile'))->with('status', ['code'=>'success','msg'=>'资料已更新','delay'=>3000]);

    }
    
    
    //修改邮箱
    public function editEmail(){
        return $this->display('user.profile');
    }
    
    //保存邮箱
    public function saveEmail(){
        
    }
    
    //修改密码
    public function editPassword(){
        $this->title(__('修改密码'));

        $this->setData('extendFile','view_path::layouts.default');
        if($this->user->user_role==2){
            $this->setData('extendFile','view_path::layouts.default_noside');
        }

        $this->setData('extend_breadcrumbs',[
            [
                'slug'=>'user.profile.password',
                'title'=>'设置密码',
                'url'=>'profile/password',
                'route'=>'',
            ]
        ]);
        
        return $this->display('user.profile.password');
    }
    
    //保存密码
    public function savePassword(Request $request,HasherContract $hasher){
        $this->hasher = $hasher;
        
        // if($this->user->id==1){
        //     $url = '';
        //     return $this->responseAjax('fail','无法重置超级管理员账户',$url);
        // }
        
        if($request->old_password) {
            $roles = [
                'new_password' => 'required|min:6|max:64',
                'new_password_confirm' => 'required|min:6|max:64',
            ];
            $messages = [
                'new_password.required'=>'请输入新密码',
                'new_password_confirm.required'=>'请确认输入的新密码',
                'min'=>'密码长度不能少于6位',
                'max'=>'密码长度不能多于64位',
            ];
            
            $response_msg = '';
            $ajax_result = $this->ajaxValidator($request->all(),$roles,$messages,$response_msg);
            
        } else {
            $url = '';
            return $this->responseAjax('fail','输入当前密码才能重置新密码',$url);
        }
        
        if($request->new_password != $request->new_password_confirm){
            $url = '';
            return $this->responseAjax('fail','新密码需输入一致',$url);
        }
        
        //$2y$10$ULYyyNl.lRAdfFtEl6lfS.QXes5dIoVrnqxbTMdtMj0BL2fzEk7dK
        
        if(!$response_msg) {
            $operateModel = new Operate;
            $password_link = config('sudaconf.password_link','zp');

            $result = $this->hasher->check($request->old_password.$password_link.$this->user->salt, $this->user->password);
            
            if($result){
                $password_link = config('sudaconf.password_link','zp');

                $update_data = [];
                $update_data['salt'] = Str::random(6);
                $update_data['password'] = bcrypt($request->new_password.$password_link.$update_data['salt']);
                $update_data['remember_token'] = Str::random(60);
                
                $operateModel->where('id',$this->user->id)->update($update_data);
                
                $url = 'profile/password';
                return $this->responseAjax('success','保存成功',$url);
            }else{
                $url = '';
                return $this->responseAjax('fail','当前密码输入错误',$url);
            }
            
        } else {
            return $this->responseAjax('fail',$response_msg,'');
        }
        
    }
    
    
    //已经作废
    public function uploadAvatarTo(Request $request){
        
        $mediaHandler = new MediaController;
        
        $result = $mediaHandler->doUpload($request,$this->user,['user_type'=>'operate']);
        
        
        //处理头像关系
        
        $data = json_decode($result->content(),true);
        
        if(array_key_exists('media_id',$data) && !empty($data['media_id'])){
            
            //#1 移除旧头像的关系
            $operate = Operate::where('id',$this->user->id)->with('avatar')->first();
            if($operate->avatar && $operate->avatar->media_id != $data['media_id']){
                $operate->removeMediatable($operate->avatar->media_id,'avatar');
            }

            //#2 保存新的头像关系
            $operate->createMediatables($data['media_id'],'avatar');
            
        }
        
        return $result;
        
    }
    
}
