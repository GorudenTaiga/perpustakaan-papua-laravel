<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageWebpConverter
{
    /**
     * Konversi file gambar yang di-upload ke format WebP lalu simpan ke disk.
     * Mengembalikan path relatif dari file yang tersimpan.
     */
    public static function convertAndStore(UploadedFile $file, string $directory, string $disk = 'public', int $quality = 80): ?string
    {
        $mime = $file->getMimeType();

        // Hanya konversi format gambar yang didukung
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/bmp', 'image/webp'])) {
            // Bukan gambar yang didukung, simpan apa adanya
            return $file->store($directory, $disk);
        }

        // Jika sudah WebP, simpan langsung
        if ($mime === 'image/webp') {
            return $file->store($directory, $disk);
        }

        // Ambil path file — gunakan getRealPath() jika tersedia
        $filePath = $file->getRealPath() ?: $file->getPathname();
        $image = self::createImageFromFile($filePath, $mime);

        if (!$image) {
            // Gagal membuat image resource, simpan file asli
            return $file->store($directory, $disk);
        }

        // Buat nama file WebP
        $filename = Str::random(40) . '.webp';
        $path = rtrim($directory, '/') . '/' . $filename;

        // Simpan ke buffer
        ob_start();
        imagewebp($image, null, $quality);
        $webpData = ob_get_clean();
        imagedestroy($image);

        // Simpan ke disk
        Storage::disk($disk)->put($path, $webpData);

        return $path;
    }

    /**
     * Konversi file gambar yang sudah tersimpan di disk ke WebP.
     * Menghapus file asli dan mengembalikan path baru.
     */
    public static function convertExisting(string $currentPath, string $disk = 'public', int $quality = 80): string
    {
        // Jika sudah webp, skip
        if (Str::endsWith($currentPath, '.webp')) {
            return $currentPath;
        }

        $fullPath = Storage::disk($disk)->path($currentPath);

        if (!file_exists($fullPath)) {
            return $currentPath;
        }

        $mime = mime_content_type($fullPath);
        $image = self::createImageFromFile($fullPath, $mime);

        if (!$image) {
            return $currentPath;
        }

        // Buat path webp baru
        $newPath = preg_replace('/\.(jpe?g|png|gif|bmp)$/i', '.webp', $currentPath);
        if ($newPath === $currentPath) {
            $newPath = $currentPath . '.webp';
        }

        ob_start();
        imagewebp($image, null, $quality);
        $webpData = ob_get_clean();
        imagedestroy($image);

        Storage::disk($disk)->put($newPath, $webpData);

        // Hapus file asli jika path berbeda
        if ($newPath !== $currentPath) {
            Storage::disk($disk)->delete($currentPath);
        }

        return $newPath;
    }

    private static function createImageFromFile(string $filepath, string $mime): ?\GdImage
    {
        return match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($filepath) ?: null,
            'image/png' => self::createFromPngWithAlpha($filepath),
            'image/gif' => @imagecreatefromgif($filepath) ?: null,
            'image/bmp' => @imagecreatefrombmp($filepath) ?: null,
            default => null,
        };
    }

    private static function createFromPngWithAlpha(string $filepath): ?\GdImage
    {
        $image = @imagecreatefrompng($filepath);
        if (!$image) {
            return null;
        }

        // Pertahankan transparansi
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        return $image;
    }
}
