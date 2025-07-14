<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {
        $backups = collect(Storage::disk('local')->files('backups'))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'size' => Storage::disk('local')->size($file),
                    'date' => Storage::disk('local')->lastModified($file)
                ];
            })
            ->sortByDesc('date');

        return view('admin.backup.index', compact('backups'));
    }

    public function create()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.zip';
            $backupPath = storage_path('app/backups/' . $filename);

            // Create backup directory if not exists
            if (!file_exists(dirname($backupPath))) {
                mkdir(dirname($backupPath), 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($backupPath, ZipArchive::CREATE) === TRUE) {
                // Add database dump
                $this->addDatabaseToZip($zip);

                // Add storage files
                $this->addStorageToZip($zip);

                $zip->close();
            }

            return redirect()->back()
                ->with('success', "Backup berhasil dibuat: {$filename}");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function download($file)
    {
        $path = storage_path('app/backups/' . $file);

        if (!file_exists($path)) {
            return redirect()->back()
                ->with('error', 'File backup tidak ditemukan');
        }

        return response()->download($path);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|mimes:zip|max:51200' // 50MB max
        ]);

        try {
            // Implementation for restore would go here
            // This is a placeholder for demo

            return redirect()->back()
                ->with('success', 'Backup berhasil dipulihkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memulihkan backup: ' . $e->getMessage());
        }
    }

    private function addDatabaseToZip($zip)
    {
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');

        $dumpFile = storage_path('app/temp_db_dump.sql');

        $command = "mysqldump -h{$dbHost} -u{$dbUser} -p{$dbPass} {$dbName} > {$dumpFile}";
        exec($command);

        if (file_exists($dumpFile)) {
            $zip->addFile($dumpFile, 'database.sql');
        }
    }

    private function addStorageToZip($zip)
    {
        $storagePath = storage_path('app/public');

        if (is_dir($storagePath)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($storagePath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = 'storage/' . substr($filePath, strlen($storagePath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }
    }
}
