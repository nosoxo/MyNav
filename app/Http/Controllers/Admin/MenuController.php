<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Enums\MenuTypeEnum;
use App\Enums\MySqlEnum;
use App\Http\Controllers\Controller;
use App\Libs\QueryWhere;
use App\Models\Log;
use App\Models\Menu;
use App\Models\MenuRead;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MenuController extends Controller
{
    protected $module_name = 'menu';
    /**
     * @var MenuRepository
     */
    private $repository;

    public function __construct (MenuRepository $repository)
    {
        View::share ('MODULE_NAME', $this->module_name);//模块名称

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        if (!check_admin_auth ($this->module_name . '_' . __FUNCTION__)) {
            return auth_error_return ();
        }
        if (request ()->wantsJson ()) {
            QueryWhere::setRequest ($request->all ());
            $M = $this->repository->makeModel ()->select ('menus.*');
            QueryWhere::like ($M, 'menu_name');
            QueryWhere::like ($M, 'auth_name');
            QueryWhere::eq ($M, 'status');
            QueryWhere::eq ($M, 'type');
            QueryWhere::like ($M, 'href');
            QueryWhere::like ($M, 'title');
            QueryWhere::orderBy ($M, 'menus.sort', 'ASC');
            $list = $M->get ();
            foreach ($list as $key => $item) {
                if ($request->input ('title') || $request->input ('status') != '') {
                    //进行了搜索，不进行上下级显示
                    $list[ $key ]['pid'] = 0;
                }
                $list[ $key ]['status']     = MenuStatusEnum::toHtml ($item->status);
                $list[ $key ]['type']       = MenuTypeEnum::toHtml ($item->type);
                $list[ $key ]['_view_auth'] = true;
                $list[ $key ]['_edit_url']  = url ('admin/menu/' . $item->id . '/edit');
            }
            $result = [
                'code'  => 0,
                'count' => count ($list),
                'data'  => $list,
            ];

            return response ()->json ($result);

        } else {
            $menu = $this->repository->makeModel ();

            return view ('admin.' . $this->module_name . '.index', compact ('menu'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        if (!check_admin_auth ($this->module_name . '_' . __FUNCTION__)) {
            return auth_error_return ();
        }
        $menu        = $this->repository->makeModel ();
        $_method     = 'POST';
        $menus       = Menu::orderBy ('sort', 'asc')->get ();
        $menus       = $menus->toArray ();
        $menuPidList = list_to_tree ($menus);
        $maxSort     = Menu::max ('sort');
        $menu->sort  = $maxSort ? $maxSort + 1 : 99;

        return view ('admin.' . $this->module_name . '.add', compact ('menu', '_method', 'menuPidList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
        $request->validate ([
            'Menu.title'  => 'required',
            'Menu.status' => 'required',
            'Menu.sort'   => 'integer|between:' . MySqlEnum::SMALLINT_MIN . ',' . MySqlEnum::SMALLINT_MAX
        ], [], [
            'Menu.title'  => '菜单名称',
            'Menu.status' => '状态',
            'Menu.sort'   => '排序'
        ]);
        if (!check_admin_auth ($this->module_name . ' edit')) {
            return auth_error_return ();
        }
        $input = $request->input ('Menu');
        $input = $this->formatRequestInput (__FUNCTION__, $input);
        try {
            $input['type'] = MenuTypeEnum::MENU;
            $input['uuid'] = get_uuid ();
            $menu          = $this->repository->create ($input);
            if ($menu) {
                Log::createLog (Log::EDIT_TYPE, '添加菜单', $menu->toArray (), $menu->id, Menu::class);

                return ajax_success_result ('添加成功');
            } else {
                return ajax_success_result ('添加失败');
            }

        } catch (BusinessException $e) {
            return ajax_error_result ($e->getMessage ());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function show (Menu $menu)
    {
        if (!check_admin_auth ($this->module_name . ' show')) {
            return auth_error_return ();
        }

        return view ('admin.' . $this->module_name . '.show', compact ('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit (Menu $menu)
    {
        if (!check_admin_auth ($this->module_name . '_' . __FUNCTION__)) {
            return auth_error_return ();
        }
        $_method     = 'PUT';
        $menus       = Menu::orderBy ('sort', 'asc')->get ();
        $menus       = $menus->toArray ();
        $menuPidList = list_to_tree ($menus);

        return view ('admin.' . $this->module_name . '.add', compact ('menu', '_method', 'menuPidList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu         $menu
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, Menu $menu)
    {
        $request->validate ([
            'Menu.title'  => 'required',
            'Menu.status' => 'required',
            'Menu.sort'   => 'integer|between:' . MySqlEnum::SMALLINT_MIN . ',' . MySqlEnum::SMALLINT_MAX
        ], [], [
            'Menu.title'  => '菜单名称',
            'Menu.status' => '状态',
            'Menu.sort'   => '排序'
        ]);
        if (!check_admin_auth ($this->module_name . ' edit')) {
            return auth_error_return ();
        }
        $input = $request->input ('Menu');
        $input = $this->formatRequestInput (__FUNCTION__, $input);
        try {
            $menu = $this->repository->update ($input, $menu->id);
            if ($menu) {
                Log::createLog (Log::EDIT_TYPE, '修改菜单', $menu->toArray (), $menu->id, Menu::class);

                return ajax_success_result ('更新成功');
            } else {
                return ajax_success_result ('更新失败');
            }

        } catch (BusinessException $e) {
            return ajax_error_result ($e->getMessage ());
        }
    }

    private function formatRequestInput (string $__FUNCTION__, $input)
    {
        if (isset($input['pid']) && empty($input['pid'])) {
            $input['pid'] = 0;
        }
        if (isset($input['sort']) && $input['sort'] == '') {
            unset($input['sort']);
        }

        return $input;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy (Menu $menu)
    {
        //
    }
}
