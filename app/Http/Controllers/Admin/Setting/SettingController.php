<?php

namespace App\Http\Controllers\admin\setting;

use Illuminate\Http\Request;
use App\Models\Setting\Setting;
use Database\Seeders\SettingSeeder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Http\Services\Image\ImageService;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        if($setting == null){
            $setting = new SettingSeeder();
            $setting->run();
            $setting = Setting::first();
        }
        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Setting $setting)
    {

        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting, ImageService $imageService)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('logo')) {
            if (!empty($setting->logo)) {
                $imageService->deleteImage($setting->logo);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('logo');
            $result = $imageService->save($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.setting.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        }

        if ($request->hasFile('icon')) {
            if (!empty($setting->icon)) {
                $imageService->deleteImage($setting->icon);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('icon');
            $result = $imageService->save($request->file('icon'));
            if ($result === false) {
                return redirect()->route('admin.setting.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['icon'] = $result;
        }


        $setting->update($inputs);

        return redirect()->route('admin.setting.index')->with('swal-success', 'تنظیمات با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
