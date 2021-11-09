<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\DataTables\MainCategoriesDataTable;
use Illuminate\Http\Request;
use DataTables;

class MainCategoriesController extends Controller
{

//    function __construct()
//    {
//        $this->middleware('permission:main_categories-list|main_categories-create|main_categories-edit|main_categories-delete', ['only' => ['index','show']]);
//        $this->middleware('permission:main_categories-create', ['only' => ['create','store']]);
//        $this->middleware('permission:main_categories-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:main_categories-delete', ['only' => ['destroy']]);
//    }

    public function index()
    {
      return view('content.categories.index');
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::parent()->orderBy('id','DESC')->get();
            return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $action_btn = '<a href="'. route('main_categories.edit', $row->id) .'" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Edit") . '</a> <a href="'. route('main_categories.destroy', $row->id) .'" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Delete") . '</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }

    public function create()
    {
        return view('content.categories.create');
    }

    public function store(MainCategoryRequest $request)
    {

        try {

            DB::beginTransaction();

            //validation
            $category = new Category();

            if (!$request->has('is_active'))
                $category->is_active = 0;
            else
                $category->is_active = 1;


            //save translations
            $category->name = $request->name;
            $category->save();
            if (Config('app.locale') == 'en') {
                $locale = 'ar';
            } else {
                $locale = 'en';
            }
            try {
                DB::table('category_translations')->insert([
                    'locale' => $locale,
                    'category_id' => $category->id,
                    'name' => $category->name
                ]);
            } catch (\Exception $ex){
                DB::rollback();
                return redirect()->route('main_categories.create')->with(['error' => __('data.An error occurred, please try again later')]);
            }
            DB::commit();

            return redirect()->route('main_categories.create')->with(['success' => __('data.Added successfully')]);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('main_categories.create')->with(['error' => __('data.An error occurred, please try again later')]);
        }

    }


    public function edit($id)
    {

        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('main_categories.edit')->with(['error' => __('data.This category does not exist')]);

        return view('content.categories.edit', compact('category'));

    }


    public function update($id, MainCategoryRequest $request)
    {
        try {
            //validation

            $category = Category::find($id);

            if (!$category)
                return redirect()->route('main_categories.index')->with(['error' => __('data.This category does not exist')]);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->back()->with(['success' => __('data.Updated successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('main_categories.index')->with(['error' =>  __('data.This category does not exist')]);

            $category->delete();

            return redirect()->route('main_categories.index')->with(['success' => __('data.Deleted successfully')]);

        } catch (\Exception $ex) {
            return redirect()->route('main_categories.index')->with(['error' => __('data.An error occurred, please try again later')]);
        }
    }

}
