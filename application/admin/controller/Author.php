<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24 0024
 * Time: 20:50
 */

namespace app\admin\Controller;

use think\Controller;
use app\admin\model\Author as AuthorModel;
class Author  extends Controller
{
    public function index()
    {
        $model=new AuthorModel();
        $data=$model->selectM();
        $this->assign('data',$data);
        return view();
    }
}