<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    /**
     * التحقق من صحة الصورة
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function validateImage($file)
    {
        // التحقق من نوع الملف
        $mimeType = $file->getMimeType();
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
        
        if (!in_array($mimeType, $allowedMimeTypes)) {
            return [
                'success' => false,
                'message' => 'نوع الملف غير مسموح به. يرجى تحميل صورة بصيغة JPG أو PNG أو WebP أو GIF'
            ];
        }
        
        // التحقق من امتداد الملف
        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        if (!in_array($extension, $allowedExtensions)) {
            return [
                'success' => false,
                'message' => 'امتداد الملف غير مسموح به. يرجى تحميل صورة بصيغة JPG أو PNG أو WebP أو GIF'
            ];
        }
        
        // التحقق من حجم الملف
        if ($file->getSize() > 2048 * 1024) { // 2MB
            return [
                'success' => false,
                'message' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت'
            ];
        }
        
        return [
            'success' => true,
            'extension' => $extension
        ];
    }

    /**
     * رفع صورة واحدة
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param string|null $oldImage
     * @return array
     */
    public function uploadSingle($file, $directory, $oldImage = null)
    {
        // التحقق من الصورة
        $validation = $this->validateImage($file);
        if (!$validation['success']) {
            return $validation;
        }
        
        // حذف الصورة القديمة إذا كانت موجودة
        if ($oldImage) {
            $oldImagePath = 'storage/' . $oldImage;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        // إنشاء اسم عشوائي للملف
        $fileName = Str::random(40) . '.' . $validation['extension'];
        
        // رفع الصورة
        $file->move(public_path('storage/' . $directory), $fileName);
        
        return [
            'success' => true,
            'path' => $directory . '/' . $fileName
        ];
    }

    /**
     * رفع مجموعة من الصور
     *
     * @param array $files
     * @param string $directory
     * @return array
     */
    public function uploadMultiple($files, $directory)
    {
        $uploadedPaths = [];
        
        foreach ($files as $file) {
            // التحقق من الصورة
            $validation = $this->validateImage($file);
            if (!$validation['success']) {
                continue; // تخطي الملف غير الصالح
            }
            
            // إنشاء اسم عشوائي للملف
            $fileName = Str::random(40) . '.' . $validation['extension'];
            
            // رفع الصورة
            $file->move(public_path('storage/' . $directory), $fileName);
            
            $uploadedPaths[] = $directory . '/' . $fileName;
        }
        
        return [
            'success' => true,
            'paths' => $uploadedPaths
        ];
    }

    /**
     * حذف صورة
     *
     * @param string $imagePath
     * @return bool
     */
    public function deleteImage($imagePath)
    {
        $fullPath = public_path('storage/' . $imagePath);
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }

    /**
     * حذف مجموعة من الصور
     *
     * @param array $imagePaths
     * @return void
     */
    public function deleteMultipleImages($imagePaths)
    {
        foreach ($imagePaths as $path) {
            $this->deleteImage($path);
        }
    }
} 