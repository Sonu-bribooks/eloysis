<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadHelper
{
    /**
     * Upload File
     */
    public static function upload(
        UploadedFile $file,
        string $folder = 'assets/uploads'
    ): string {

        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs(
            $folder,
            $fileName,
            'public'
        );
    }

    /**
     * Replace Existing File
     */
    public static function replace(
        UploadedFile $file,
        ?string $oldFile,
        string $folder = 'uploads'
    ): string {

        self::delete($oldFile);

        return self::upload(
            $file,
            $folder
        );
    }

    /**
     * Delete File
     */
    public static function delete(
        ?string $path
    ): bool {

        if (
            empty($path) ||
            !Storage::disk('public')->exists($path)
        ) {

            return false;

        }

        return Storage::disk('public')->delete($path);
    }

    /**
     * File URL
     */
    public static function url(
        ?string $path
    ): string {

        if (
            empty($path) ||
            !Storage::disk('public')->exists($path)
        ) {

            return asset(
                'assets/uploads/profile/default-avatar.jpg'
            );

        }

        // return Storage::url($path);
        return asset('storage/' . $path);
    }
}