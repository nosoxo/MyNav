<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libs\QueryWhere;
use App\Models\Log;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    protected $module_name = 'category';
    /**
     * @var CategoryRepository
     */
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        View::share('MODULE_NAME', $this->module_name);//模块名称

        $this->repository = $repository;
    }

    /**
     * 查询分类
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (!check_admin_auth($this->module_name . '_' . __FUNCTION__)) {
            return auth_error_return();
        }
        if (request()->wantsJson()) {
            $limit = $request->input('limit', 15);
            QueryWhere::defaultOrderBy('categories.sort', 'ASC')->setRequest($request->all());
            $M = $this->repository->makeModel()->select('categories.*');
            QueryWhere::like($M, 'categories.name');
            QueryWhere::like($M, 'categories.description');
            QueryWhere::orderBy($M);
            $M = $M->paginate($limit);
            $count = $M->total();
            $data = $M->items();
            $result = [
                'count' => $count,
                'data' => $data
            ];
            return ajax_success_result('成功', $result);

        } else {
            $categories = $this->repository->makeModel();

//            $categories = Category::all();

            return view('admin.' . $this->module_name . '.index', compact('categories'));
        }
    }

    /**
     * 添加分类
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!check_admin_auth($this->module_name . '_create')) {
            return auth_error_return();
        }
        $_method = 'POST';
        $categories = new Category();
        return view('admin.' . $this->module_name . '.add', compact('categories', '_method'));
    }

    /**
     * 提交添加
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Category.name' => 'required',
            'Category.sort' => 'required',
            'Category.flag' => 'required',
        ], [], [
            'Category.name' => '分类名称',
            'Category.sort' => '排序',
            'Category.flag' => '私有',
        ]);

        if (!check_admin_auth($this->module_name . '_create')) {
            return auth_error_return();
        }
        $input = $request->input('Category');
        try {
            $name = trim($input['name']);
            $category = Category::where('name', $name)->first();
            if ($category) {
                return ajax_error_result('分类名称[' . $name . ']已经存在');
            }
            $category = Category::create([
                'name' => $input['name'],
                'description' => $input['description'],
                'sort' => $input['sort'],
                'flag' => $input['flag'],
            ]);

            if ($category) {
                Log::createLog(Log::EDIT_TYPE, '添加分类', $category->toArray(), $category->id, Category::class);
                return ajax_success_result('添加成功');
            } else {
                return ajax_error_result('添加失败');
            }
        } catch (BusinessException $e) {
            return ajax_error_result($e->getMessage());
        }
    }

    /**
     * 更新分类
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (!check_admin_auth($this->module_name . ' edit')) {
            return auth_error_return();
        }
        $_method = 'PUT';
        return view('admin.' . $this->module_name . '.add', compact('category', '_method'));
    }

    /**
     * 提交更新
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'Category.name' => 'required',
            'Category.sort' => 'required',
            'Category.flag' => 'required',
        ], [], [
            'Category.name' => '分类名称',
            'Category.sort' => '排序',
            'Category.flag' => '私有',
        ]);

        if (!check_admin_auth($this->module_name . '_create')) {
            return auth_error_return();
        }
        $input = $request->input('Category');
        try {
            $name = trim($input['name']);
            $check = Category::where('name', $name)->where('id', '<>', $category->id)->first();
            if ($check) {
                return ajax_error_result('分类名称[' . $name . ']已经存在，无需重复添加');
            }
            $category->fill([
                'name' => $input['name'],
                'description' => $input['description'],
                'sort' => $input['sort'],
                'flag' => $input['flag'],
            ]);
            $category->save();
            if ($category) {
                Log::createLog(Log::EDIT_TYPE, '修改分类', $category->toArray(), $category->id, Category::class);
                return ajax_success_result('更新成功');
            } else {
                return ajax_error_result('更新失败');
            }
        } catch (BusinessException $e) {
            return ajax_error_result($e->getMessage());
        }
    }

    /**
     * 查看分类明细
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (!check_admin_auth($this->module_name . ' show')) {
            return auth_error_return();
        }
        return view('admin.' . $this->module_name . '.show', compact('category'));
    }

    /**
     * 删除分类
     *
     * @return \Illuminate\Http\Response
     * @throws BusinessException
     */
    public function destroy($id, Request $request)
    {
        if (!check_admin_auth($this->module_name . '_delete')) {
            return auth_error_return();
        }
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            $ids[] = $id;
        }
        DB::beginTransaction();
        $ids = (array)$ids;
        $M = $this->repository->makeModel();
        $lists = $M->whereIn('id', $ids)->get();
        $num = 0;
        foreach ($lists as $item) {
            $log_title = '删除分类[' . ($item->category->title ?? '') . '->' . $item->name . ']记录';
//            $check     = $this->repository->allowDelete ($item->id);
            $ret = Category::destroy($item->id);
            if ($ret) {
                Log::createLog(Log::DELETE_TYPE, $log_title, $item, $item->id, Category::class);
                $num++;
            }
        }
        DB::commit();
        return ajax_success_result('成功删除' . $num . '条记录');
    }
}
