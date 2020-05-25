<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\Tags as TagsModel;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Credentials:false');
class Tags extends Controller
{
    // 添加标签
    public function addTags()
    {
        if (request()->isPost()) {
            $id = input('post.id'); //id
            $type = input('post.type'); //类型。暂定0：文章标签，1：用户标签
            $tagname = input('post.tagname'); //标签名
            $tags = model('tags'); //标签表
            $tags['id'] = $id;
            $tags['type'] = $type;
            $tags['tagname'] = $tagname;
            if ($tags->save()) {
                return json(['msg' => '添加标签成功', 'code' => 1, 'data' => $tags]);
            } else {
                return json(['msg' => '添加标签失败', 'code' => 0]);
            }
        }
    }
    // 获取标签
    public function getTag()
    {
        if (request()->isPost()) {
            $tags = model('tags'); //标签表
            $list = input('post.'); //所有数据
            $tagName = input('post.tagName'); //标签名
            if (!$list) {
                $data = $tags->order('id','desc')->select();
                if ($data) {
                    return json(['msg' => '获取所有标签成功', 'code' => 1, 'data' => $data]);
                } else {
                    return json(['msg' => '获取所有标签失败', 'code' => 0]);
                }
            } else {
                $data = $tags->where('tagname', 'like', $tagName)->order('id', 'desc')->select();
                if ($data) {
                    return json(['msg' => '获取标签成功', 'code' => 1, 'data' => $data]);
                } else {
                    return json(['msg' => '获取标签失败', 'code' => 0]);
                }
            }
        }
    }
}
