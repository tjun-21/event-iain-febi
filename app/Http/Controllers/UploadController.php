<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload image for Summernote editor
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            ]);

            if ($request->hasFile('file')) {
                $image = $request->file('file');

                // Generate unique filename
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store in public/uploads/images directory
                $path = $image->storeAs('uploads/images', $filename, 'public');

                // Generate URL
                $url = Storage::url($path);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'path' => $path
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors()['file'] ?? ['Unknown validation error'])
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded image
     */
    public function deleteImage(Request $request)
    {
        try {
            $request->validate([
                'path' => 'required|string'
            ]);

            $path = $request->input('path');

            // Security check - ensure path is within uploads directory
            if (!Str::startsWith($path, 'uploads/')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file path'
                ], 400);
            }

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);

                return response()->json([
                    'success' => true,
                    'message' => 'File deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
