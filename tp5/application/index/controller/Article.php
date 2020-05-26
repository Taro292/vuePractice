<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\Article as ArticleModel;
use app\common\model\User as UserModel;
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Credentials:false');
class Article extends Controller
{   
    public function article(){
        return $this->fetch();
    }
    // 文章搜索（标题）
    public function searchArticle()
    {
        // 判断请求
        if (request()->isPost()) {
            $title = input('post.title'); //标题
            $id = input('post.id'); // id
            $article = model('article'); //文章表
            $user = model('user');//用户表
            // 查询的数据（多条）
            if($title){
                $data = $article->where('title', 'like', $title)->order('id', 'desc')->select();
            }
            if($id){
                $data = $article-> where('id',$id)->find();
                $user=$user->where('id',$data['user_id'])->find();
                $data['avatar']=$user['avatar'];
            }
            if ($article) {
                return json(['msg' => '获取文章成功', 'code' => 1,'data'=>$data]);
            } else {
                return json(['msg' => '暂无数据', 'code' => 0]);
            }
        }
    }
    // 获取文章列表
    public function getArticleList(){
        if(request()->isPost()){
            $article=model('article');
            $data=$article->allowField(true)->order('id','desc')->select();
            if($data){
                return json(['msg'=>$data,'code'=>1]);
            }else{
                return json(['msg'=>'暂无文章信息','code'=>0]);
            }
        }
    }
    // 添加文章
    public function addArticle()
    {
        // 判断请求
        if (request()->isPost()) {
            $title = input('post.title'); //标题
            // $abstract = input('post.abstract'); //摘要
            $user_id = input('post.user_id'); //发布者id
            $author = input('post.author'); //作者
            $content = input('post.content'); //显示类型
            $imgs = input('post.imgs'); //图片
            $tags=input('post.tags/a'); //文章标签
            $article=model('article');//文章表
            $tag=implode(',',$tags);
            // $article['abstract']=$abstract;
            $article['title']=$title;
            $article['user_id']=$user_id;
            $article['author']=$author;
            $article['content']=$content;
            $article['imgs']=$imgs;
            $article['tags']=$tag;
            if($article->save()){
                return json(['msg'=>'发布成功','code'=>1,'data'=>$tag]);
            }
            else{
                return json(['msg'=>'添加文章失败','code'=>0]);
            }
        }
    }
    // 删除文章
    public function delArticle(){
        if(request()->isPost()){
            $id=input('post.id');//文章id
            $article=model('article');//文章表
            $data=$article->where('id',$id)->delete();//删除
            if($data){
                return json(['msg'=>'删除文章成功','code'=>1]);
            }else{
                return json(['msg'=>'删除文章失败','code'=>0]);
            }
        }
    }
}
