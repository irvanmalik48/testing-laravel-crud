<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index(): JsonResponse
    {
        $pasien = DB::table('pasien')
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedPasien = $pasien->map(fn ($pasien) => $this->formatPasien($pasien));

        return response()->json([
            'status' => 'success',
            'message' => '[GET-ALL] Operation successful.',
            'data' => $formattedPasien
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $isBulk = array_is_list($request->all());

        if ($isBulk) {
            $rules = [
                '*.nama' => 'required|string|max:255',
                '*.tanggal_lahir' => 'required|date',
            ];
        } else {
            $rules = [
                'nama' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
            ];
        }

        $validated = $request->validate($rules);

        $inputs = $isBulk ? $validated : [$validated];
        
        $now = now();
        $recordsToInsert = [];
        $formattedResponse = [];

        foreach ($inputs as $input) {
            $id = (string) Str::uuid();
            
            $row = [
                'id' => $id,
                'nama' => $input['nama'],
                'tanggal_lahir' => $input['tanggal_lahir'],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $recordsToInsert[] = $row;
            
            $formattedResponse[] = $this->formatPasien((object)$row);
        }

        DB::table('pasien')->insert($recordsToInsert);

        return response()->json([
            'status' => 'success',
            'message' => $isBulk ? '[CREATE-BULK] ' . count($inputs) . ' entries created. Operation successful.' : '[CREATE-SINGLE] Operation successful.',
            'data' => $isBulk ? $formattedResponse : $formattedResponse[0]
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $pasien = DB::table('pasien')->where('id', $id)->first();

        if (!$pasien) {
            return response()->json([
                'status' => 'error',
                'message' => '[ERR] Entry not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '[GET] Operation successful.',
            'data' => $this->formatPasien($pasien)
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
        ]);

        $exists = DB::table('pasien')->where('id', $id)->exists();

        if (!$exists) {
            return response()->json([
                'status' => 'error',
                'message' => '[ERR] Entry not found.'
            ], 404);
        }

        $validated['updated_at'] = now();

        DB::table('pasien')
            ->where('id', $id)
            ->update($validated);

        $updatedPasien = DB::table('pasien')->where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'message' => '[UPDATE] Operation successful.',
            'data' => $this->formatPasien($updatedPasien)
        ], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $deleted = DB::table('pasien')->where('id', $id)->delete();

        if ($deleted === 0) {
            return response()->json([
                'status' => 'error',
                'message' => '[ERR] Entry not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '[DELETE] Operation successful.'
        ], 200);
    }

    private function formatPasien(object $pasien): array
    {
        return [
            'id' => $pasien->id,
            'nama' => $pasien->nama,
            'tanggal_lahir' => Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d'),
            'created_at' => Carbon::parse($pasien->created_at)->toIso8601String(),
            'updated_at' => Carbon::parse($pasien->updated_at)->toIso8601String(),
        ];
    }
}