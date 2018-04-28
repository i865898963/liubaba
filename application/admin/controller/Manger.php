<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/21 0021
 * Time: 19:21
 */

namespace app\admin\Controller;
use think\Controller;
use think\Request;
use app\admin\model\Manger as MangerModel;
class Manger extends Controller
{
    public function index()
    {
        $search=request()->get('search');
        $map['username']=array("like","%$search%");
        $data=db('Manger')->where($map)->order('id')->select();
        $count=db('Manger')->where($map)->count();
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }

    /**
     * 添加
     * @return int|mixed
     * @param string $name 用户名
     * @param string $pwd  密码
     */
    public function add_ajax(){

        $data=request()->post('str');
        parse_str($data,$arr);
        $model=new MangerModel();

        //验证
        $validate=\think\Loader::validate('Manger');
        if(!$validate->scene('add')->check($arr)){
            return $arr=['error'=>$validate->getError(),'code'=>'1'];
        }else{
            $res=$model->addM($arr);
            if($res){
                //获取插入的id
                $arr['id']=$model->id;
                $arr['lastlogin']=0;
                $this->assign('dat',$arr);
                return $this->fetch();
            }
        }

    }
//    删除
    public function del_ajax(Request $request){
        $id=$this->request->post('id');
        $model=new MangerModel();
        $res=$model->delM($id);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

//    查找
    public function find_ajax(Request $request)
    {
        $id = request()->post('id');
        $data = db('Manger')->find($id);
        $this->assign('dat', $data);
        return view();
    }

//   修改
     public function update_ajax(Request $request){
        $data=request()->post('str');
        parse_str($data,$arr);
        $model=new MangerModel();
        $res=$model->editM($arr);
        if($res){
            $data=db('Manger')->find($arr['id']);
            $this->assign('dat',$data);
            return $this->fetch();
        }else{
            return 0;
        }
     }
//批量删除
    public function delAllAjax(){
         $data=request()->post('str');
         $model=new MangerModel();
         $res=$model->delM($data);
         return $res;
    }
//    修改状态
    public function statusAjax()
    {
        $data=request()->post();
        $res=db('Manger')->where('id',$data['id'])->update(['status'=>$data['status']]);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
}