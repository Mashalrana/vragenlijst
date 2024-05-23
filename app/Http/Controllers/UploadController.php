<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadExcelController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'category' => 'required|string',
        ]);

        if ($request->file('file')->isValid()) {
            $path = $request->file('file')->store('uploads');

            return response()->json(['success' => true, 'filepath' => $path]);
        }

        return response()->json(['success' => false, 'error' => 'File upload failed.']);
    }
}
