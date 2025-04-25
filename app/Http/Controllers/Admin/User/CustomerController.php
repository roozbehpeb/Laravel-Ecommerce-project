<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\User\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('user_type', 0)->get();
        return view('admin.user.customer.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request, ImageService $imageService,  User $user)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'customers');
            $result = $imageService->createIndexAndSave($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.customer.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result['indexArray'][$result['currentImage']];
        }

        $inputs['user_type'] = 0;
        $inputs['password'] = Hash::make($request->password);
        $customer = User::create($inputs);
        return redirect()->route('admin.user.customer.index')->with('swal-success', 'مشتری سایت شما با موفقیت ثبت شد');
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
    public function edit(User $customer)
    {
        return view('admin.user.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, User $customer, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('profile_photo_path')) {
            if (!empty($customer->profile_photo_path)) {
                $imageService->deleteDirectoryAndFiles(dirname($customer->profile_photo_path));
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'customers');
            $result = $imageService->createIndexAndSave($request->file('profile_photo_path'));

            if ($result === false) {
                return redirect()->route('admin.user.admin-user.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }

            $inputs['profile_photo_path'] = $result['indexArray'][$result['currentImage']];
        }


        $customer->update($inputs);
        return redirect()->route('admin.user.customer.index')->with('swal-success', 'کاربر سایت شما با موفقیت ویرایش شد');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        $result = $customer->forceDelete();
        return redirect()->route('admin.user.customer.index')->with('swal-success', 'مشتری سایت شما با موفقیت حذف شد');
    }


    public function status(User $customer)
    {
        $customer->status = $customer->status == 0 ? 1 : 0;
        $result = $customer->save();
        if ($result) {
            if ($customer->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function activation(User $customer)
    {
        $customer->activation = $customer->activation == 0 ? 1 : 0;
        $result = $customer->save();
        if ($result) {
            if ($customer->activation == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
