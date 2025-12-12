<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\PHAddress;

use Auth;

class AddressController extends Controller
{
    public function getCountries(Request $request)
    {
        $countries = Country::orderByRaw("name = 'Philippines' DESC")->orderBy('name')->get();
        $countries = $countries->pluck('name');
        return response()->json(['validated' => true, 'countriesList' => $countries], 200);
    }

    public function getAddressDetail(Request $request)
    {
        if(!($request->has('type') && $request->has('value')))
        {
            return response()->json(['error' => 'Unauthorized 1'], 401);
        }
        $type = $request->input('type');
        $value = $request->input('value');
        $addrTypes = ['region', 'province', 'city_town', 'area'];

        if(!in_array($type, $addrTypes))
        {
            return response()->json(['error' => 'Unauthorized 2'], 401);
        }

        $searchType = '';
        switch($type)
        {
            case 'region':
                $searchType = 'country';
            break;
            case 'province':
                $searchType = 'region';
            break;
            case 'city_town':
                $searchType = 'province';
            break;  
            case 'area':
                $searchType = 'city_town';
            break;
            case 'zip':
                $searchType = 'area';
            break;

        }

        $addrList = PHAddress::where($searchType, $value)->orderBy($type, 'asc')->distinct()->pluck($type);

        return response()->json(['validated' => true, 'addrList' => $addrList], 200);
    }
}
