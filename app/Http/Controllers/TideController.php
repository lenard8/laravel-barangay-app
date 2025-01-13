<?php

namespace App\Http\Controllers;

use App\Models\Tide;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTideRequest;
use App\Http\Requests\UpdateTideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Validator;
class TideController extends Controller
{

    public function inserttide(Request $request)
    {
        $fields = $request->validate([
            'year' => 'required|integer|min:1900|max:' . date('Y'), // Validate year
            'month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December', // Validate month name
            'day' => 'required|integer|min:1|max:31',
            'time' => 'required|string', 
            'meter' => 'required|numeric', 
            'feet' => 'required|numeric',
        ]);
    
        // Create the tide record
        $tide = Tide::create($fields);
    
        // Return the created record
        return response()->json($tide, 201);
    }

    public function viewtide()
    {
        // Fetch all records from the residence table
        $tides = Tide::all();
 
        // Return the records in JSON format
        return response()->json($tides);
    }

    public function updatetide(Request $request, $id)
    {
        // Validate incoming data
        $fields = $request->validate([
            'year' => 'required|integer|min:1900|max:' . date('Y'), // Validate year
            'month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December', // Validate month name
            'day' => 'required|integer|min:1|max:31', 
            'time' => 'required|string',
            'meter' => 'required|numeric', 
            'feet' => 'required|numeric',
        ]);
    
        // Find the tide record
        $tide = Tide::find($id);
    
        // If not found, return an error
        if (!$tide) {
            return response()->json(['message' => 'Tide not found'], 404);
        }
    
        // Update the record
        $tide->update($fields);
    
        // Return the updated record
        return response()->json($tide);
    }
    
    public function deletetide($id)
    {
        // Find the tide record
        $tide = Tide::find($id);
    
        // If not found, return an error
        if (!$tide) {
            return response()->json(['message' => 'Tide not found'], 404);
        }
    
        // Delete the record
        $tide->delete();
    
        // Return a success message
        return response()->json(['message' => 'Tide deleted successfully']);
    }

    public function importdata(Request $request)
    {
        // Validate the uploaded files
        $validated = $request->validate([
            'files.*' => 'required|file|mimes:csv,txt|max:2048', // Adjust file types and size as needed
        ]);
    
        $importedFiles = 0;
        $importedRecords = 0;
        $errors = [];
    
        foreach ($request->file('files') as $file) {
            if ($file->isValid()) {
                try {
                    $fileName = time() . '-' . $file->getClientOriginalName();
                    $filePath = 'csv_files/' . $fileName;
    
                    // Store the file in the storage/app/public/csv_files directory
                    Storage::disk('public')->put($filePath, file_get_contents($file));
    
                    // Log the stored file path for debugging
                    Log::info('Stored file path: ' . Storage::disk('public')->path($filePath));
    
                    // Check if file exists in the storage
                    if (Storage::disk('public')->exists($filePath)) {
                        // Read the file content and convert CSV to an array
                        $data = array_map('str_getcsv', file(Storage::disk('public')->path($filePath)));
    
                        // Remove the header row if it exists
                        $header = array_shift($data);
    
                        // Fetch data from the database for validation or comparison
                        $existingData = DB::table('tides')->get(); // Fetch data here
    
                        // Begin a database transaction
                        DB::beginTransaction();
    
                        try {
                            // Process the data and insert into the tides table
                            foreach ($data as $row) {
                                // You can validate or compare data against $existingData here
                                $tideData = [
                                    'year' => $row[0],
                                    'month' => $row[1],
                                    'day' => $row[2],
                                    'time' => $row[3],
                                    'meter' => $row[4],
                                    'feet' => $row[5]
                                ];
    
                                Tide::create($tideData);
                                $importedRecords++;
                            }
    
                            // Commit the transaction
                            DB::commit();
                            $importedFiles++;
                        } catch (\Exception $e) {
                            // Rollback the transaction if an error occurs
                            DB::rollBack();
                            throw $e;
                        }
                    } else {
                        $errors[] = "File not found after upload: " . $file->getClientOriginalName();
                    }
                } catch (\Exception $e) {
                    // Log the error
                    Log::error('Error processing file: ' . $e->getMessage());
                    $errors[] = "Error processing file " . $file->getClientOriginalName() . ": " . $e->getMessage();
                }
            } else {
                $errors[] = "Invalid file: " . $file->getClientOriginalName();
            }
        }
    
        if (count($errors) > 0) {
            return response()->json([
                'message' => 'Some files could not be imported',
                'imported_files' => $importedFiles,
                'imported_records' => $importedRecords,
                'errors' => $errors
            ], 400);
        }
    
        return response()->json([
            'message' => 'All files imported successfully',
            'imported_files' => $importedFiles,
            'imported_records' => $importedRecords
        ]);
    }  

}
