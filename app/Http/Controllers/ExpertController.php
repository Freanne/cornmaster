<?php

namespace App\Http\Controllers;
use App\Models\Expert;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index()
    {
        $experts = Expert::with('user:id,first_name,last_name,email,phone')->get();
        return response()->json($experts, 200);
    }

    public function show($id)
{
    $expert = Expert::with('user:id,first_name,last_name,email,phone')->find($id);

    if (!$expert) {
        return response()->json(['message' => 'Expert non trouvé'], 404);
    }

    return response()->json($expert, 200);
}
}
