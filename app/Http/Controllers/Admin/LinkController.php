<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libs\QueryWhere;
use App\Models\Log;
use App\Models\Link;
use App\Models\Category;
use App\Repositories\LinkRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use function Couchbase\defaultDecoder;

class LinkController extends Controller
{
    protected $module_name = 'link';
    /**
     * @var LinkRepository
     */
    private $repository;

    public function __construct(LinkRepository $repository)
    {
        View::share('MODULE_NAME', $this->module_name);//模块名称

        $this->repository = $repository;
    }

    /**
     * 查询链接
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (!check_admin_auth($this->module_name . '_' . __FUNCTION__)) {
            return auth_error_return();
        }
        if (request()->wantsJson()) {
//            $limit = $request->input ('limit', 15);
//            QueryWhere::defaultOrderBy ('links.sort', 'ASC')->setRequest ($request->all ());
//            $M = $this->repository->makeModel ()->select ('links.*');
//            QueryWhere::eq ($M, 'links.category_id');
//            QueryWhere::like ($M, 'links.title');
//            QueryWhere::like ($M, 'links.url');
//            QueryWhere::like ($M, 'links.description');
//            QueryWhere::orderBy ($M);
//            $M     = $M->paginate ($limit);
//            $count = $M->total ();
//            $data  = $M->items ();
//            foreach ($data as $key => $item) {
//                $data[ $key ]['category_name'] = Category::where ('id', $item->category_id)->value ('name');
//            }
//            $result = [
//                'count' => $count,
//                'data'  => $data
//            ];
//
//            return ajax_success_result ('成功', $result);
            $limit = $request->input('limit', 15);
            $links = Link::leftJoin('categories', 'categories.id', '=', 'category_id')->select('links.*', 'categories.name AS category_name', 'categories.sort AS category_sort')->orderBy('category_sort')->orderBy('sort');
            if (array_get($request, 'searchParams')) {
                $arr = json_decode(array_get($request, 'searchParams', []), true);
                $searchParams=[];
                if (is_array($arr)) {
                    foreach ($arr as $key => $val) {
                        $searchParams[$key] = $val;
                    }
                }
                $category_id = $searchParams['category_id'];
                $title = $searchParams['title'];
                $url = $searchParams['url'];
                $description = $searchParams['description'];
                if ($category_id) {
                    $links->where('category_id', $category_id);
                }
                if ($title) {
                    $links->where('title', 'like', "%$title%");
                }
                if ($url) {
                    $links->where('url', 'like', "%$url%");
                }
                if ($description) {
                    $links->where('links.description', 'like', "%$description%");
                }
            }
            $links = $links->paginate($limit);
            $count = $links->total();
            $data = $links->items();
            $links = [
                'count' => $count,
                'data' => $data
            ];
            return ajax_success_result('成功', $links);

        } else {
            $links = $this->repository->makeModel();

            $categories = Category::orderBy('sort', 'asc')->get();

            return view('admin.' . $this->module_name . '.index', compact('links', 'categories'));
        }
    }

    /**
     * 添加链接
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!check_admin_auth($this->module_name . '_create')) {
            return auth_error_return();
        }
        $_method = 'POST';
        $categories = Category::orderBy('sort', 'asc')->get();
        $link = new Link();
        return view('admin.' . $this->module_name . '.add', compact('link', 'categories', '_method'));
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
            'Link.category_id' => 'required',
            'Link.title' => 'required',
            'Link.url' => 'required',
            'Link.sort' => 'required',
            'Link.flag' => 'required',
        ], [], [
            'Link.category_id' => '所属分类',
            'Link.title' => '链接名称',
            'Link.url' => 'url',
            'Link.sort' => '排序',
            'Link.flag' => '私有',
        ]);

        if (!check_admin_auth($this->module_name . '_create')) {
            return auth_error_return();
        }
        $input = $request->input('Link');
        try {
            $title = trim($input['title']);
            $link = Link::where('title', $title)->first();
            if ($link) {
                return ajax_error_result('链接名称[' . $title . ']已经存在');
            }
            $link = Link::create([
                'category_id' => (int)$input['category_id'],
                'title' => $input['title'],
                'url' => $input['url'],
                'description' => $input['description'],
                'sort' => $input['sort'],
                'flag' => $input['flag'],
            ]);

            if ($link) {
                Log::createLog(Log::EDIT_TYPE, '添加链接', $link->toArray(), $link->id, Link::class);
                return ajax_success_result('添加成功');
            } else {
                return ajax_error_result('添加失败');
            }
        } catch (BusinessException $e) {
            return ajax_error_result($e->getMessage());
        }
    }

    /**
     * 修改链接
     *
     * @param \App\Models\Link $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        if (!check_admin_auth($this->module_name . ' edit')) {
            return auth_error_return();
        }
        $_method = 'PUT';
//        $categories = Category::all();
        $categories = Category::orderBy('sort', 'asc')->get();


        return view('admin.' . $this->module_name . '.add', compact('link', '_method', 'categories'));
    }

    /**
     * 提交修改
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\link $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        $request->validate([
            'Link.category_id' => 'required',
            'Link.title' => 'required',
            'Link.url' => 'required',
            'Link.sort' => 'required',
            'Link.flag' => 'required',
        ], [], [
            'Link.category_id' => '所属分类',
            'Link.title' => '链接名称',
            'Link.url' => 'url',
            'Link.sort' => '排序',
            'Link.flag' => '私有',
        ]);

        if (!check_admin_auth($this->module_name . '_create')) {
            return auth_error_return();
        }
        $input = $request->input('Link');
        try {
            $title = trim($input['title']);
            $check = Link::where('title', $title)->where('id', '<>', $link->id)->first();
            if ($check) {
                return ajax_error_result('链接名称[' . $title . ']已经存在，无需重复添加');
            }
            $link->fill([
                'category_id' => (int)$input['category_id'],
                'title' => $input['title'],
                'url' => $input['url'],
                'description' => $input['description'],
                'sort' => $input['sort'],
                'flag' => $input['flag'],
            ]);
            $link->save();
            if ($link) {
                Log::createLog(Log::EDIT_TYPE, '修改链接', $link->toArray(), $link->id, Link::class);
                return ajax_success_result('更新成功');
            } else {
                return ajax_error_result('更新失败');
            }
        } catch (BusinessException $e) {
            return ajax_error_result($e->getMessage());
        }
    }

    /**
     * 查看链接
     *
     * @param \App\Models\Link $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        if (!check_admin_auth($this->module_name . ' show')) {
            return auth_error_return();
        }
        $link->category = Category::where('id', $link->category_id)->value('name');
        return view('admin.' . $this->module_name . '.show', compact('link'));
    }

    /**
     * 删除链接
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
            $log_title = '删除链接[' . ($item->category->title ?? '') . '->' . $item->title . ']记录';
//            $check     = $this->repository->allowDelete ($item->id);
            $ret = Link::destroy($item->id);
            if ($ret) {
                Log::createLog(Log::DELETE_TYPE, $log_title, $item, $item->id, Link::class);
                $num++;
            }
        }
        DB::commit();
        return ajax_success_result('成功删除' . $num . '条记录');
    }


}
