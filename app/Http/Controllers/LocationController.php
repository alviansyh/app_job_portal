<?php

namespace App\Http\Controllers;

use App\Models\Area;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getAreaOption(Request $request)
    {
        $area = Area::whereCountryId($request->country_id)->get();
        $val = __('app.select_a_area');
        //Get the cities from country
        $option = "<option value=''>{$val}</option>";
        if ($area->count()) {
            foreach ($area as $area) {
                $option .= "<option value='{$area->id}'>{$area->area_name}</option>";
            }
        }

        return ['success' => true, 'area_options' => $option];
    }
}
