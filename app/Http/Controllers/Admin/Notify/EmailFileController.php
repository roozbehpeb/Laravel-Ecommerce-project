<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Models\Notify\Email;
use Illuminate\Http\Request;
use App\Models\Notify\EmailFile;
use App\Http\Controllers\Controller;
use App\Http\Services\File\FileService;
use App\Http\Requests\Admin\Notify\EmailFileRequest;

class EmailFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Email $email)
    {

        return view('admin.notify.email-file.index', compact('email'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Email $email)
    {
        return view('admin.notify.email-file.create', compact('email'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailFileRequest $request, Email $email, FileService $fileService)
    {
        $inputs = $request->all();

        if ($request->hasFile('file')) {
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            if ($request->access == 0) {
                $result = $fileService->moveToPublic($request->file('file'));
            } else {
                $result = $fileService->moveToStorage($request->file('file'));
            }
            $fileFormat = $fileService->getFileFormat();
        }
        if ($result === false) {
            return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-error', 'آپلود فایل با خطا مواجه شد');
        }
        $inputs['public_mail_id'] = $email->id;
        $inputs['file_path'] = $result;
        $inputs['file_size'] = $fileSize;
        $inputs['file_type'] = $fileFormat;
        $inputs['original_name'] = substr($request->file('file')->getClientOriginalName(), 0, 40) . '....';
        $file = EmailFile::create($inputs);
        return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-success', 'فایل جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailFile $file, Email $email)
    {
        return view('admin.notify.email-file.edit', compact('file', 'email'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmailFileRequest $request, EmailFile $file, FileService $fileService)
    {
        $inputs = $request->all();
        if ($request->hasFile('file')) {
            if (!empty($file->file_path)) {
                if ($file->access == 0) {
                    $fileService->deleteFile($file->file_path);
                } else {
                    $fileService->deleteFile($file->file_path, true);
                }
            }
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();

            if ($file->access == 0) {
                $result = $fileService->moveToPublic($request->file('file'));
            } else {
                $result = $fileService->moveToStorage($request->file('file'));
            }

            $fileFormat = $fileService->getFileFormat();
            if ($result === false) {
                return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-error', 'آپلود فایل با خطا مواجه شد');
            }
            $inputs['file_path'] = $result;
            $inputs['file_size'] = $fileSize;
            $inputs['file_type'] = $fileFormat;
            $inputs['original_name'] = $request->file('file')->getClientOriginalName();
        }
        $file->update($inputs);
        return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-success', 'فایل  شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailFile $file)
    {
        $file->delete();
        return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-success', 'فایل  شما با موفقیت حذف شد');
    }
    public function status(EmailFile $file)
    {
        $file->status = $file->status == 0 ? 1 : 0;
        $result = $file->save();
        if ($result) {
            if ($file->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function download(EmailFile $file)
    {
        if($file->status == 0) {
            return redirect()->route('admin.notify.email-file.index', $file->email->id)
                ->with('toast-error', 'دانلود این فایل غیرفعال است');
        }

        $filePath = $file->access == 0
            ? public_path($file->file_path)
            : storage_path($file->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $file->original_name);
        }

        return redirect()->route('admin.notify.email-file.index', $file->email->id)
            ->with('toast-error', 'فایل مورد نظر یافت نشد');
    }
}
