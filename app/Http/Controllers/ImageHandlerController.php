<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageHandlerController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Validate the image file
            $request->validate([
                'file' => 'required|image|mimes:jpeg,jpg,png'
            ]);

            // Store the file in 'uploads' directory of the 'public' disk
            $path = $file->store('uploads', 'public');

            // Return the correct URL of the uploaded file
            return response()->json([
                'link' => asset('storage/app' . $path)
            ]);
        }

        return response()->json(['error' => 'File not uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $imagePath = str_replace(asset('storage'), '', $request->image); // Extract relative path
        $filePath = public_path('storage' . $imagePath); // Build full file path

        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
            return response()->json(['success' => 'Image deleted successfully']);
        }

        return response()->json(['error' => 'Image not found'], 404);
    }
}
