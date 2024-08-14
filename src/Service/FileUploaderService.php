<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderService
{
    private string $targetDirectory;
    private SluggerInterface $slugger;

    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    /**
     * @param UploadedFile $file
     * @param string|null $targetDirectory
     * @return string
     */
    public function upload(UploadedFile $file, ?string $targetDirectory): string
    {
        $directory = $targetDirectory ?? $this->getTargetDirectory();

        $n = explode('/', $directory);

        //$originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($n[count($n) - 1]);
        $fileName = $safeFilename.'-'.uniqid("", true).'.'.$file->guessExtension();

        try {
            $file->move($directory, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    /**
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    /**
     * @param string $fileName
     * @param string|null $targetDirectory
     * @return void
     */
    public function remove(string $fileName, ?string $targetDirectory): void
    {
        $directory = $targetDirectory ?? $this->getTargetDirectory();

        unlink($directory.'/'.$fileName);

    }

}