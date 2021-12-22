<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use App\Services\GoogleSheet;


class SampleController extends Controller
{


    public function index()
    {

        $googlesheet = new GoogleSheet();
        $data = $googlesheet->readGoogleSheet();
        $keys = 0;
        while ($keys <= 8) {
            unset($data[$keys]);
            $keys++;
        }
        $views = array();

        $tab_id = '';

        foreach ($data as $key => $value) {
            $count = count($value);
            if ($count == 20) {
                if ($tab_id != $value[19] & $tab_id!=''){
                    $sample = new Sample();
                    $sample->tab_id = $tab_id;
                    $sample->fuel_summ = $fuel_summ;
                    $sample->save();
                    $tab_id ='';
                    $fuel_summ=0;
                }
                $tab_id =$value[19];
                $fuel_summ = (int)$value[13];

            }
            if ($count == 15) {

                $fuel_summ = $fuel_summ+(int)$value[13];
            }
            $views['fuels'][] = array(
                $tab_id => $fuel_summ,
            );
        }
        return view('sample', $views);
    }
}
