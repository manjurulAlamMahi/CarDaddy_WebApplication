<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

abstract class Controller
{
    public static function fileUpload($file, $folder)
    {
        try {
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $targetPath = public_path('uploads/' . $folder);

            if (!File::exists($targetPath)) {
                File::makeDirectory($targetPath, 0777, true, true);
            }

            $file->move($targetPath, $fileName);

            return 'uploads/' . $folder . '/' . $fileName;

        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            return null;
        }
    }

    public function generateUniqueSlug($name, $modelClass)
    {
        $slug = Str::slug($name);
        $count = $modelClass::where('slug', 'LIKE', "$slug%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function generateCode($prefix, $model)
    {
        $code = "000001";
        $model = '\\App\\Models\\' . $model;
        $usesSoftDeletes = in_array(
            'Illuminate\Database\Eloquent\SoftDeletes',
            class_uses($model)
        );
        $num_rows = $usesSoftDeletes ? $model::withTrashed()->count() : $model::count();

        if ($num_rows != 0) {
            $newCode = $num_rows + 1;
            $zeros = ['0', '00', '000', '0000', '00000'];
            $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        }
        return $prefix . $code;
    }
}
