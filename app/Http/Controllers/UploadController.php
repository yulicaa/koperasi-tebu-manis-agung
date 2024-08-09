<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Responses\BaseResponse;
use App\Models\Upload;
use Str;
use Exception;

class UploadController extends Controller
{
    public function uploadPhoto(Request $request, $parentId)
    {
        $validator = Validator::make($request->all(), [
            'fileInput.*' => 'image|mimes:jpeg,png,jpg|max:1024', // Max size: 1MB
        ]);

        if ($validator->fails()) {
            return BaseResponse::errorResponse($validator->errors()->first());
        }
        try {
            $files = $request->file('fileInput');

            if (is_array($files)) {
                foreach ($files as $file) {
                    $this->saveUpload($file, $parentId);
                }
            } else {
                $this->saveUpload($files, $parentId);
            }
        } catch (Exception $e) {

            return BaseResponse::errorResponse($e->getMessage());
        }

        return BaseResponse::successResponse("Success Upload Photo!");
    }

    public function saveUpload($file, $parent)
    {
        $fileSavedName = $file->getClientOriginalName();
        $fileName = pathinfo($fileSavedName, PATHINFO_FILENAME);
        $fileType = $file->getClientOriginalExtension();
        $file->storeAs('uploads', $fileSavedName, 'public');

        $newUpload = Upload::create([
            'id' => Str::uuid(),
            'parent_id' => $parent,
            'file_name' => $fileName,
            'file_type' => $fileType
        ]);
        $newUpload->save();
    }

    public function deleteUploadById($idUpload)
    {
        try {
            $upload = Upload::findOrFail($idUpload);

            $this->deleteToStorage($upload);
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return BaseResponse::errorResponse($e->getMessage());
        }
        session()->flash('success', 'Success Delete Photo!');
        return BaseResponse::successResponse("Success Delete Photo!");
    }

    public function deleteUpload($idParent)
    {
        try {
            $uploads = Upload::where('parent_id', $idParent)->get();

            foreach ($uploads as $upload) {
                $this->deleteToStorage($upload);
            }
        } catch (Exception $e) {
            return BaseResponse::errorResponse($e->getMessage());
        }
        return BaseResponse::successResponse("Success Delete File!");
    }

    public function deleteToStorage($upload)
    {
        Storage::disk('public')->delete('uploads/' . $upload->file_name);
        $upload->delete();
    }

    private function getStoragePath($fileType, $fileName)
    {
        if (in_array(strtolower($fileType), ['png', 'jpg', 'jpeg', 'gif'])) {
            return 'uploads/images/' . $fileName;
        } else {
            return 'uploads/files/' . $fileName;
        }
    }

}
