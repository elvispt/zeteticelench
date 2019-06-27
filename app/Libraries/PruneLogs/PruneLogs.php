<?php

namespace App\Libraries\PruneLogs;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PruneLogs
{
    protected $storageDisk = 'log';

    public function __construct(string $storageDisk = 'log')
    {
        $this->storageDisk = $storageDisk;
    }

    /**
     * Obtains the file list to be deleted.
     *
     * @param int $daysOld Files older than the number of days defined here.
     * @return Collection Returns all files older than $daysOld
     */
    public function filesToBeDeleted($daysOld = 2): Collection
    {
        $timeBoundary = Carbon::now()->subtract("$daysOld Days");
        $files = Storage::disk($this->storageDisk)->listContents();
        return (new Collection($files))
            ->filter(static function (array $file) {
                return $file['extension'] === 'log';
            })
            ->filter(static function (array $file) use ($timeBoundary) {
                $lastUpdated = Carbon::createFromTimestamp($file['timestamp']);
                return $lastUpdated->lessThan($timeBoundary);
            })
            ->values();
    }

    /**
     * Deletes the provided file paths from disk.
     *
     * @param Collection $files The files metadata.
     * @return bool Returns true on success, false otherwise.
     */
    public function deleteFiles(Collection $files): bool
    {
        $filePathsToDelete = $files
            ->map(function ($file) {
                return $file['path'];
            })
            ->values()
            ->toArray();
        return Storage::disk($this->storageDisk)->delete($filePathsToDelete);
    }
}
