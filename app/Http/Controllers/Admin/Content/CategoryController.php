<?php

namespace App\Http\Controllers\Admin\Content;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Content\PostCategory;
use App\Http\Requests\Admin\Content\PostCategoryRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postcategories = PostCategory::orderBy('created_at', 'DESC')->simplepaginate(15);
        return view('admin.content.category.index', compact('postcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.content.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCategoryRequest $request)
    {

        // Get all inputs from the request
        $inputs = $request->all();

        // Remove '_token' from the inputs array
        $inputs = collect($inputs)->except('_token')->toArray();

        // Modify or add any additional fields you need
        $inputs['slug'] = str_replace(' ', '-', $inputs['name']) . '-' . Str::random(5);
        $inputs['image'] = 'image';

        // Create the PostCategory instance
        $postCategory = PostCategory::create($inputs);

        //Redirect to the appropriate route after creation
        //return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی جدید شما با موفقیت ثبت شد')->with('toast-success', 'دسته بندی جدید با موفقیت ثبت شد')->with('alert-section-success', 'دسته بندی جدید با موفقیت ثبت شد');

        return redirect()->route('admin.content.category.index')->with('toast-success', 'دسته بندی جدید با موفقیت ثبت شد');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PostCategory $PostCategory)
    {
        return view('admin.content.category.edit', compact('PostCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostCategoryRequest $request, PostCategory $PostCategory)
    {
        // Get all inputs from the request
        $inputs = $request->all();

        $inputs['image'] = 'image';

        // Update the PostCategory instance
        $PostCategory->update($inputs);

        // Redirect to the appropriate route after update
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCategory $PostCategory)
    {

        $result = $PostCategory->delete();
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی شما با موفقیت حذف شد');
    }






    public function status(PostCategory $PostCategory)
    {

        $PostCategory->status = $PostCategory->status == 0 ? 1 : 0;
        $result = $PostCategory->save();
        if ($result) {
            if ($PostCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
