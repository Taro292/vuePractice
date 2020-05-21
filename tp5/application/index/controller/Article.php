<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\Article as ArticleModel;

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
            $article = model('article'); //文章表
            // 查询的数据（多条）
            $data = $article->where('title', 'like', $title)->order('id', 'desc')->select();
            if ($article) {
                return json(['msg' => $data, 'code' => 1]);
            } else {
                return json(['msg' => '暂无数据', 'code' => 0]);
            }
        }
    }
    // 添加文章
    public function addArticle()
    {
        // 判断请求
        if (request()->isPost()) {
            $title = input('post.title'); //标题
            $abstract = input('post.abstract'); //摘要
            $user_id = input('post.user_id'); //发布者id
            $author = input('post.author'); //作者
            $type = input('post.type'); //显示类型
            $imgs = input('post.imgs'); //图片
            $tags = input('post.tags'); //文章标签
            $article=model('article');//文章表
            $article['abstract']=$abstract;
            $article['title']=$title;
            $article['user_id']=$user_id;
            $article['author']=$author;
            $article['type']=$type;
            $article['imgs']=$imgs;
            $article['tags']=$tags;
            if($article->save()){
                return json(['msg'=>$article,'code'=>1]);
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
