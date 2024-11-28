<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResidenceRequest;
use App\Http\Requests\UpdateResidenceRequest;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
   // Insert a new residence record
   public function insertresident(Request $request)
   {
       $fields = $request->validate([
           'firstname' => 'required|string|max:255',
           'lastname' => 'required|string|max:255',
           'middlename' => 'nullable|string|max:255',
           'gender' => 'required|in:male,female,other',
           'date_of_birth' => 'required|date',
           'civil_status' => 'required|string|max:255',
           'occupation' => 'nullable|string|max:255',
           'home_address' => 'required|string',
           'email_address' => 'nullable|email|max:255',
           'mobile_number' => 'nullable|string|max:15',
           'is_senior_citizen_or_pwd' => 'required|boolean',
           'relationship_to_head_of_household' => 'nullable|string|max:255',
           'number_of_household_members' => 'required|integer|min:1',
       ]);

       // Create the residence record
       $residence = Residence::create($fields);

       // Return the created record
       return response()->json($residence, 201);
   }

   // View all residence records
   public function viewresident()
   {
       // Fetch all records from the residence table
       $residences = Residence::all();

       // Return the records in JSON format
       return response()->json($residences);
   }

   // Update a residence record
   public function updateresident(Request $request, $id)
   {
       // Validate incoming data
       $fields = $request->validate([
           'firstname' => 'required|string|max:255',
           'lastname' => 'required|string|max:255',
           'middlename' => 'nullable|string|max:255',
           'gender' => 'required|in:male,female,other',
           'date_of_birth' => 'required|date',
           'civil_status' => 'required|string|max:255',
           'occupation' => 'nullable|string|max:255',
           'home_address' => 'required|string',
           'email_address' => 'nullable|email|max:255',
           'mobile_number' => 'nullable|string|max:15',
           'is_senior_citizen_or_pwd' => 'required|boolean',
           'relationship_to_head_of_household' => 'nullable|string|max:255',
           'number_of_household_members' => 'required|integer|min:1',
       ]);

       // Find the residence record
       $residence = Residence::find($id);

       // If not found, return an error
       if (!$residence) {
           return response()->json(['message' => 'Residence not found'], 404);
       }

       // Update the record
       $residence->update($fields);

       // Return the updated record
       return response()->json($residence);
   }

   // Delete a residence record
   public function deleteresident($id)
   {
       // Find the residence record
       $residence = Residence::find($id);

       // If not found, return an error
       if (!$residence) {
           return response()->json(['message' => 'Residence not found'], 404);
       }

       // Delete the record
       $residence->delete();

       // Return a success message
       return response()->json(['message' => 'Residence deleted successfully']);
   }
}
