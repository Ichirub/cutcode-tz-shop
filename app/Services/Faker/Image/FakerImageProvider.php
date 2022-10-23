<?php

declare(strict_types=1);

namespace App\Services\Faker\Image;

use Faker\Provider\Base;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @TODO Rewrite if image exists in toDir
 */
class FakerImageProvider extends Base
{
    public const IMAGES_EXTENSIONS = [
        'jpg',
        'jpeg',
        'gif',
        'png'
    ];

    public function loadRandImageFromTo(
        string $fromDir,
        string $toDir,
        bool $needGenerateName = false,
        int $nameLength = 8
    ): string {
        $image = $this->getRandImage(File::allFiles($fromDir));

        if (null === $image) {
            return '';
        }

        $this->createDirs($toDir);

        $name = $needGenerateName
            ? $this->generateName($image->getExtension(), $nameLength)
            : $image->getFilename();
        $imageToPath = $toDir . DIRECTORY_SEPARATOR . $name;

        return $this->copyImage($image->getRealPath(), $imageToPath) ? $name : '';
    }

    protected function getRandImage(array $files): ?SplFileInfo
    {
        if (count($files) < 1) {
            return null;
        }

        $file = null;

        while (count($files)) {
            $randKey = array_rand($files);
            /** @var SplFileInfo $randomFile */
            $randomFile = $files[$randKey];

            if ($randomFile->isFile() && $this->isImage($randomFile->getExtension())) {
                $file = $randomFile;
                break;
            }

            unset($files[$randKey]);
        }

        return $file;
    }

    protected function createDirs(string $path): void
    {
        if (File::exists($path)) {
            return;
        }

        File::makeDirectory($path, 0755, true);
    }

    protected function copyImage(string $imageFromPath, string $imageToPath): bool
    {
        return File::copy(
            $imageFromPath,
            $imageToPath
        );
    }

    protected function generateName(string $ext, int $length): string
    {
        return Str::random($length) . '.' . $ext;
    }

    protected function isImage(string $ext): bool
    {
        return in_array(self::toLower($ext), self::IMAGES_EXTENSIONS);
    }
}
