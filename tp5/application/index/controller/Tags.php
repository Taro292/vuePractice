<?php

namespace app\index\controller;

use think\controller;
use app\common\model\Tags as TagsModel;

class Tags extends controller
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
}
