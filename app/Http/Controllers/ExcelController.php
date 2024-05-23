<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
            'category' => 'required|string',
            'filename' => 'required|string',
        ]);

        try {
            $file = $request->file('file');
            $category = $request->input('category');
            $filenameWithExtension = $request->input('filename');

            // Save the file
            $path = $file->storeAs('uploads', $filenameWithExtension);

            Log::info('File uploaded successfully: ' . $path);

            // Process the file as needed...

            return response()->json(['success' => true, 'filepath' => $path], 200);
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
