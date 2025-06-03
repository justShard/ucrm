<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFilesRequest;
use App\Http\Requests\UpdateFilesRequest;
use App\Models\Files;
use App\Http\Resources\FilesResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FilesController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(FilesResource::collection(Files::all()));
    }

    public function store(StoreFilesRequest $request): JsonResponse
    {
        $file = Files::create($request->validated());
        return response()->json(FilesResource::make($file), 201);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $file = Files::findOrFail($id);
            return response()->json(FilesResource::make($file));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Файл не знайдено'], 404);
        }
    }

    public function update(UpdateFilesRequest $request, int $id): JsonResponse
    {
        try {
            $file = Files::findOrFail($id);
            $file->update($request->validated());
            return response()->json(FilesResource::make($file));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Файл не знайдено'], 404);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $file = Files::findOrFail($id);
            $file->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Файл не знайдено'], 404);
        }
    }

    public function complete(Request $request, int $id): JsonResponse
    {
        try {
            $file = Files::findOrFail($id);

            $validated = $request->validate([
                'file_path'     => 'sometimes|required|string',
                'file_type'     => 'sometimes|required|string',
                'hash'          => 'sometimes|required|string',
                'size'          => 'sometimes|required|integer',
                'date_created'  => 'sometimes|required|date',
                'employee_id'   => 'sometimes|required|integer|exists:employee,employee_id',
            ]);

            $file->update($validated);

            return response()->json(FilesResource::make($file));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Файл не знайдено'], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Помилка при оновленні файлу',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
