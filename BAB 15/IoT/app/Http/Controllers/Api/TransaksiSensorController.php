<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TransaksiSensor;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiSensorResource;

class TransaksiSensorController extends Controller
{
    /**
     * Tampilkan daftar data sensor (dengan pagination).
     */
    public function index()
    {
        $transaksiSensors = TransaksiSensor::latest()->paginate(5);
        return TransaksiSensorResource::collection($transaksiSensors);
    }

    /**
     * Simpan data sensor yang baru dikirim dari IoT device.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'nilai1' => 'required|numeric',  // <--- Perbaikan: dari integer ke numeric
            'nilai2' => 'required|numeric',  // <--- Perbaikan: dari integer ke numeric
        ]);

        $transaksiSensor = TransaksiSensor::create($validatedData);

        return new TransaksiSensorResource($transaksiSensor);
    }

    /**
     * Tampilkan data sensor berdasarkan ID.
     */
    public function show($id)
    {
        $transaksiSensor = TransaksiSensor::findOrFail($id);
        return new TransaksiSensorResource($transaksiSensor);
    }

    /**
     * Perbarui data sensor.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_sensor' => 'required|string|max:255',
            'nilai1' => 'required|numeric',  // Tetap numeric
            'nilai2' => 'required|numeric',  // Tetap numeric
        ]);

        $transaksiSensor = TransaksiSensor::findOrFail($id);
        $transaksiSensor->update($validatedData);

        return new TransaksiSensorResource($transaksiSensor);
    }

    /**
     * Hapus data sensor.
     */
    public function destroy($id)
    {
        $transaksiSensor = TransaksiSensor::findOrFail($id);
        $transaksiSensor->delete();

        return response()->json(['message' => 'Deleted successfully'], 204);
    }
}
