<?php

/**
 * 葫芦家+
 * ————————————————————————————————————————————————————————————————
 * public getMenuTree($perms, $pid = 0); 权限菜单列表Tree
 * public getMenuComponmentsTree($menus, $pid = 0); 生成前端需要的路由数据
 * public getSelectMenuTree($menus, $pid = 0); 兼容 ant select tree
 * —————————————————————————————————————————————————————————————————
 */


/**
 * 菜单列表树
 * @param  object  $menus 菜单源数据
 * @param  integer $pid   上级id值
 * @return array          树形列表
 * @author flaravel
 */
function getMenuTree($menus, $pid = 0)
{
    $tree = [];

    foreach ($menus as $key => $value) {

        if($pid == $value->pid){

            $value->children = getMenuTree($menus,$value->id);

            if(empty($value->children)){

                unset($value['children']);
            }

            $tree[] = $value;
        }
    }
    return $tree;
}

/**
 * 兼容 ant select tree
 * @param  object  $menus 菜单源数据
 * @param  integer $pid   上级id值
 * @return array          树形列表
 * @author flaravel
 */
function getSelectMenuTree($menus, $pid = 0)
{
    $tree = [];

    foreach ($menus as $key => $value) {
        if($pid == $value->pid){
            $data = [
                'title'      => $value->title,
                'value'      => $value->id,
            ];

            $data['children'] = getSelectMenuTree($menus,$value->id);

            if(empty($data['children'])){

                unset($data['children']);
            }
            $tree[] = $data;
        }
    }
    return $tree;
}

/**
 * 菜单
 * @param  object  $menus 菜单源数据
 * @param  integer $pid    上级id值
 * @return array         树形列表
 * @author flaravel
 */
function getMenuComponmentsTree($menus, $pid = 0)
{
    $tree = [];

    foreach ($menus as $key => $value) {
        if($pid == $value->pid){
            $data = [
                'path'      => $value->path,
                'redirect'  => $value->redirect,
                'component' => $value->component,
                'name'      => $value->name,
                'keepAlive' => false,
                'hidden'    => $value->hidden == 1 ? false : true,
                'meta'      => [
                    'title' => $value->title,
                     empty($value->icon) ? : 'icon' => $value->icon,
                    'permission' => array_column($value->roles()->get(['number'])->toArray(), 'number'),
                    'hidden_header_content' => $value->hidden_header_content == 1 ? false : true
                ],
            ];
            $data['children'] = getMenuComponmentsTree($menus,$value->id);

            if(empty($data['children'])){

                unset($data['children']);
            }

            $tree[] = $data;
        }
    }
    return $tree;
}
