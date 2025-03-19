<?php

namespace App\Http\Controllers;

use App\Models\LeadValidation;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function getLeadValidations($leadId)
    {
        try {
            $validations = LeadValidation::getValidationsByLeadId($leadId);
            return response()->json([
                'success' => true,
                'data' => $validations
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las validaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 