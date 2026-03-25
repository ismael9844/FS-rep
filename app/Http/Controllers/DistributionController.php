<?php

namespace App\Http\Controllers;
use App\Models\Distribution;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        return Distribution::with(['user', 'donation'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'user_id' => 'required|exists:users,id',
            'quantity_distributed' => 'required|integer|min:1',
            'distribution_date' => 'required|date',
            'status' => 'in:pending,delivered,canceled',
            'notes' => 'nullable|string'
        ]);

        $distribution = Distribution::create($data);
        return response()->json($distribution, 201);
    }

    public function show($id)
    {
        $distribution = Distribution::with(['user', 'donation'])->findOrFail($id);
        return response()->json($distribution);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'quantity_distributed' => 'integer|min:1',
            'distribution_date' => 'date',
            'status' => 'in:pending,delivered,canceled',
            'notes' => 'nullable|string'
        ]);

        $distribution = Distribution::findOrFail($id);
        $distribution->update($data);

        return response()->json($distribution);
    }

    public function destroy($id)
    {
        $distribution = Distribution::findOrFail($id);
        $distribution->delete();

        return response()->json(['message' => 'Distribution deleted']);
    }
}
