<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
        {
            return response()->json(Diagnosis::select('id', 'name', 'description', 'slug', 'pathogene' ,'image_url')->get());
        }

        // public function show($slug)
        // {
        //     $diagnosis = Diagnosis::where('slug', $slug)->first();
        
        //     if (!$diagnosis) {
        //         return response()->json(['error' => 'Diagnostic not found'], 404);
        //     }
        
        //     return response()->json($diagnosis);
        // }

    public function show($id)
    {
    $diagnosis = Diagnosis::find($id);

    if (!$diagnosis) {
        return response()->json(['message' => 'Disease not found'], 404);
    }

    return response()->json($diagnosis);
}
}
