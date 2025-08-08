<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PolicyController extends Controller
{
    public function aszf() {
        return inertia("Aszf/Index");
    }

    public function privacy() {
        return $this->download("adatkezelesi_tajekoztato.pdf");
    }

    private function download(string $filename) {
        if (!Storage::disk('public')->exists($filename)) {
            abort(404, 'File not found.');
        }

        // Inline megjelenítés letöltés helyett
        return response()->file(
            Storage::disk('public')->path($filename),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]
        );
    }

    private function onlyDownloadFile(string $filename) {
        if (!Storage::disk('public')->exists($filename)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filename, $filename, [
            'Content-Type' => 'application/pdf'
        ]);
    }
}