<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24 0024
 * Time: 21:07
 */

namespace app\admin\Controller;

use think\Controller;
use app\admin\model\Colum as ColumModel;
use app\admin\model\Author as AuthorModel;
use app\admin\model\Article as ArticleModel;
class Article  extends Controller
{
     public function index(){
         $Articlemodel=new ArticleModel();
         $data=$Articlemodel->guanlianM();
         $page=$data->render();

         $this->assign([
             'data'=>$data,
             'page'=>$page,
         ]);
         return view();
     }
//     文章详情展示
    public function detail($id)
    {
        $Articlemodel=new ArticleModel();
        $data=$Articlemodel->selectM($id);
        $this->assign('data',$data);
        return view();
    }
//添加文章
     public function add(){
        if(request()->isPost()){
                $data=request()->post();
//              if($_FILES['img']['tmp_name']){
//                  $file=request()->file('img');
//                  $info=$file->move("./static/uploads/article");
//                  if($info){
//                      $data['img']=$info->getSaveName();
//                  }else{
//                      $this->error($file->getError());
//                  }
//              }
              $data['time']=time();
              $Articlemodel=new ArticleModel();
              $res=$Articlemodel->save($data);
              if($res){
                    $this->success('添加成功！',url('index'));
              }else{
                    $this->error('添加失败');
              }
        }else{
            $Colummodel=new ColumModel();
            $data=$Colummodel->coltree();
            $Authormodel=new AuthorModel();
            $author=$Authormodel->selectM();
            $this->assign([
                'dat'=>$data,
                'author'=>$author,
            ]);
            return view();
        }

     }
//    删除
     public function del($id){
            $Articlemodel=new ArticleModel();
            $res=$Articlemodel->delA($id);
            if($res){
                $this->success('删除成功！',url('index'));
            }else{
                $this->error('删除失败！');
            }
     }
//修改
    public function  update($id){
        $Articlemodel=new ArticleModel();
        $Colummodel=new ColumModel();
        $Authormodel=new AuthorModel();
        if(request()->isPost()){
            $data=request()->post();
            if($_FILES['img']['tmp_name']){
                  $file=request()->file('img');
                  $info=$file->move("./static/uploads/article");
                  if($info){
                      unlink("./static/uploads/article/{$data['img']}");
                      $data['img']=$info->getSaveName();
                  }else{
                      $this->error($file->getError());
                  }
              }
             $data['time']=time();
           
            $res=$Articlemodel->save($data,$id);
            if($res){
                $this->success('修改成功！',url('index'));
            }else{
                $this->error('修改失败!');
            }
        }else{
            $author=$Authormodel->selectM();
            $data=$Articlemodel->selectM($id);
            $colum=$Colummodel->coltree();

            $this->assign([
                'data'=>$data,
                'colum'=>$colum,
                'author'=>$author,
            ]);
            return view();
        }
    }

}