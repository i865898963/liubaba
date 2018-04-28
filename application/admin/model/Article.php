<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24 0024
 * Time: 21:07
 */

namespace app\admin\model;

use app\admin\Controller\Author;
use think\Model;
use think\Controller;
class Article extends Model
{
    protected  static function init(){
        Article::event('before_insert',function($Articlemodel){
            if($_FILES['img']['tmp_name']){
                  $file=request()->file('img');

                  $info=$file->move("./static/uploads/article");
                  if($info){
                      $Articlemodel['img']=$info->getSaveName();
                
                  }else{
                    echo 0;
                    die();
                 
                  }
              }else{
                echo 0;
                die();
            }
        });
    }


    //  查询
    public function selectM($id=''){
        if($id){
            $data=$this->find($id);
        }else{
            $data=$this->select();

        }
        return $data;
    }
//连表查询
    public function guanlianM()
    {
            $data=$this->alias('a')->join('colum b','a.columid=b.id')->join('author c','c.id=a.authorid')->field('a.*,b.name colum,c.name')->paginate(2);
            return $data;
    }
//    删除图片
    public function  delA($id){
        $data=$this->find($id);
        unlink("./static/uploads/article/{$data['img']}");
        $res=$this::destroy($id);
        return $res;
    }
}