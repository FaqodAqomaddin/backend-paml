<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function getData()
    {
        try {
            $motor = Motor::all()->map(function ($motorcycle) {
                if ($motorcycle->gambar) {
                    
                    $motorcycle->gambar = url('storage/' . substr($motorcycle->gambar, 7));
                }
                return  $motorcycle;
            });
            return response()->json(['data' => $motor], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addData(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'plat_nomer' => 'required|unique:motor',
                'harga' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi gambar
            ]);
    
            $path = $request->file('gambar')->store('public/images');
    
            $motor = new Motor([
                'nama' => $request->get('nama'),
                'plat_nomer' => $request->get('plat_nomer'),
                'harga' => $request->get('harga'),
                'deskripsi' => $request->get('deskripsi'),
                'gambar' => $path
            ]);
    
            $motor->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Data Motor berhasil ditambahkan',
                'data' => $motor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function updateData(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'plat_nomer' => 'required|unique:motor,plat_nomer,' . $id,
                'harga' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $motor = Motor::findOrFail($id);

            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('public/images');
                $motor->gambar = $path;
            }

            $motor->nama = $request->get('nama');
            $motor->plat_nomer = $request->get('plat_nomer');
            $motor->harga = $request->get('harga');
            $motor->deskripsi = $request->get('deskripsi');

            $motor->save();

            return response()->json([
                'message' => 'Data Motor berhasil diperbarui',
                'motor' => $motor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteData($id)
    {
        try {
            $motor = Motor::findOrFail($id);
            $motor->delete();

            return response()->json([
                'message' => 'Data Motor berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataById($id)
    {
        try {
            $motor = Motor::findOrFail($id);
            // Ubah path gambar menjadi URL jika ada
            if ($motor->gambar) {
                $motor->gambar = url('storage/' . substr($motor->gambar, 7));
            }
            return response()->json(['data' => $motor], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
