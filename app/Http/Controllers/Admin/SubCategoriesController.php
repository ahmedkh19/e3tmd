<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
class SubCategoriesController extends Controller
{

    public function index()
    {
        return view('content.sub_categories.index');
    }

    public function create()
    {
        $categories = Category::parent()->orderBy('id','DESC') -> get();
        return view('content.sub_categories.create',compact('categories'));
    }

    public function ajax(Request $request)
    {
            // inner join categories c2 on c.parent_id = c2.id
            $categories = Category::
                join('categories as c2', 'categories.parent_id', '=' , 'c2.id')
               ->select('categories.id as id','categories.slug as sub_slug',  'c2.slug as parent_slug' , 'categories.is_active as is_active')
               ->get();
            return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $action_btn = '<a href="'. route('sub_categories.edit', $row->id) .'" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Edit") . '</a> <a href="'. route('sub_categories.destroy', $row->id) .'" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Delete") . '</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        return false;
    }


    public function store(SubCategoryRequest $request)
    {

         try {

            DB::beginTransaction();

            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::create($request->except('_token'));

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
                return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);
            }
            DB::commit();
            return redirect()->back()->with(['success' => __('data.Added successfully')]);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later')]);
        }

    }


    public function edit($id)
    {


        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->back()->with(['error' => __('data.This category does not exist')]);

        $categories = Category::parent()->orderBy('id','DESC') -> get();


        return view('content.sub_categories.edit', compact('category','categories'));

    }


    public function update($id, SubCategoryRequest $request)
    {
        try {

            $category = Category::find($id);

            if (!$category)
                return redirect()->back()->with(['error' => __('data.This category does not exist')]);

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
                return redirect()->route('sub_categories.index')->with(['error' => __('data.This category does not exist')]);

            $category->delete();

            return redirect()->route('sub_categories.index')->with(['success' => __('data.Deleted successfully')]);

        } catch (\Exception $ex) {
            return redirect()->route('sub_categories.index')->with(['error' => __('data.An error occurred, please try again later')]);
        }
    }
}
