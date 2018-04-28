<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23 0023
 * Time: 10:40
 */

namespace app\admin\Controller;


use think\Controller;
use app\admin\model\Lunbo as LunboModel;
class Lunbo extends Controller
{
    public function index()
    {
        $model=new LunboModel();
        $data=$model->selectM();
        $this->assign('data',$data);
        return view();
    }
//   文件上传
    public function uploadAjax()
    {
        $file=request()->file('image');
        $info=$file->move("./static/uploads/lunbo");
        if($info){
            echo $info->getSaveName();// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
        }else{
            echo $file->getError();// 上传失败获取错误信息
        }
    }
//    添加
    public function add()
    {
        $data=request()->post();
//       验证
        $validate=\think\Loader::validate('Lunbo');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $model=new LunboModel();
        $res=$model->addM($data);
        if($res){
            $this->success('添加成功','index');
        }else{
            $this->error('添加失败');
        }
    }
//    删除
    public function del($id){
        $model=new LunboModel();
        $data=$model->selectM($id);
        unlink("./static/uploads/{$data['img']}");
        $res=$model->delM($id);
        if($res){
            $this->success('删除成功',url('index'));
        }else{
            $this->error('删除失败');
        }
    }
//    修改
    public function updates($id)
    {   $model=new LunboModel();
        if(request()->isPost()){
                $data=request()->post();
                if(!$data['img']){
                    $data['img']=$data['old_img'];
                }else{
                    unlink("./static/uploads/lunbo/{$data['old_img']}");
                }
                unset($data['old_img']);
                $res=$model->updateM($data,$id);
                if($res){
                    $this->success('修改成功',url('index'));
                }else{
                    $this->error('修改失败');
                }
        }else{
            $data=$model->selectM($id);
            $this->assign('data',$data);
            return view();
        }
    }
//    排序
    public function sorts(){
        $data=request()->post();
        $model=new LunboModel();
        $res=$model->updateM($data,$data['id']);
        if($res){
           return 1;
        }else{
           return 0;
        }
    }
}