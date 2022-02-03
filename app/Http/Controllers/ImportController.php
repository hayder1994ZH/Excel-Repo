<?php

namespace App\Http\Controllers;

use SimpleXLSX;
use App\Models\Import;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function excel(){
      set_time_limit(4000000);
      $file = file('data1A1.txt'); # read file into array
      $count = count($file);
      $i = 1;
      if($count > 0) # file is not empty
      {
          for($s = 0 ;$s <= $count ; $s++ )
          {
              $elt = explode(',',$file[$s]);
              $import = new Import();
                  $import->id1 =  isset($elt[0]) ? $elt[0] : null;    
                  $import->id2 =isset($elt[1]) ? $elt[1] : null; 
                  $import->first_name =  isset($elt[2]) ? $elt[2] : null;   
                  $import->middle_name = isset($elt[3]) ? $elt[3] : null;    
                  $import->sex = (strlen(isset($elt[4]) ? $elt[4] : null) < 1000 || $elt[4] == null) ?  (isset($elt[4]) ? $elt[4] : null): 'null';    
                  $import->facebook_url = (strlen(isset($elt[5]) ? $elt[5] : null) < 1000 || (isset($elt[5]) ? $elt[5] : null) == null) ? (isset($elt[5]) ? $elt[5] : null): 'null';    
                  $import->last_name =(strlen(isset($elt[6]) ? $elt[6] : null) < 1000 ||  (isset($elt[6]) ? $elt[6] : null) == null) ?  (isset($elt[6]) ? $elt[6] : null): 'null';   
                  $import->education = (strlen(isset($elt[7]) ? $elt[7] : null) < 1000 ||  (isset($elt[7]) ? $elt[7] : null) == null) ?  (isset($elt[7]) ? $elt[7] : null): 'null';    
                  $import->job1 = (strlen(isset($elt[8]) ? $elt[8] : null) < 1000 ||  (isset($elt[8]) ? $elt[8] : null) == null) ?  (isset($elt[8]) ? $elt[8] : null): 'null';    
                  $import->location = (strlen(isset($elt[9]) ? $elt[9] : null) < 1000 || (isset($elt[9]) ? $elt[9] : null) == null) ?  (isset($elt[9]) ? $elt[9] : null): 'null';    
                  $import->city = (strlen(isset($elt[10]) ? $elt[10] : null) < 1000 || (isset($elt[10]) ? $elt[10] : null) == null) ? (isset($elt[10]) ? $elt[10] : null): 'null';    
                  $import->last_city = (strlen(isset($elt[11]) ? $elt[11] : null) < 1000 || (isset($elt[11]) ? $elt[11] : null) == null) ?  (isset($elt[11]) ? $elt[11] : null): 'null';;    
                  $import->current_job = (strlen(isset($elt[12]) ? $elt[12] : null) < 1000 || (isset($elt[12]) ? $elt[12] : null) == null) ?  (isset($elt[12]) ? $elt[12] : null): 'null';    
                  $import->date1 = (strlen(isset($elt[13]) ? $elt[13] : null) < 1000 || (isset($elt[13]) ? $elt[13] : null)== null) ?  (isset($elt[13]) ? $elt[13] : null): 'null';       
                  $import->save();
              $i++;
          }

      }
      return 'import successfully -- ' . $i;

    }

// $i = 0;
//         //  $xlsx = SimpleXLSX::parse('userData.xlsx');
//          if ( $xlsx = SimpleXLSX::parse('Book13.xlsx') ) {
//         // return count($xlsx->rows());
//             foreach ($xlsx->rows() as $elt) {
//                 $import = new Import();
//                 $import->id1 = $elt[0] ;    
//                 $import->id2 = $elt[1] ; 
//                 $import->first_name = $elt[2] ;    
//                 $import->middle_name = $elt[3] ;    
//                 $import->sex = $elt[4] ;    
//                 $import->facebook_url = $elt[5] ;    
//                 $import->last_name = $elt[6] ;    
//                 $import->education = $elt[7] ;    
//                 $import->job1 = $elt[8] ;    
//                 $import->location = $elt[9] ;    
//                 $import->city = $elt[10] ;    
//                 $import->last_city = $elt[11] ;    
//                 $import->current_job = $elt[12] ;    
//                 $import->date1 = $elt[13] ;       
//                 $import->save();   
//             $i++;
//             }
//             return 'import successfully -- ' . $i;
        
//           } else {
//             echo SimpleXLSX::parseError();
//           }
//     }

    
     //All users data
     public function getList(Request $request)
     {
      set_time_limit(4000);
       
        //parameters
        $take = $request->take;
        $skip = $request->skip * $take;
        $name = $request->name;

        //Processing
        $result = Import::Where('facebook_url', 'like', '%'.$name.'%')
                          ->orWhere('id2', 'like', '%'.$name.'%')
                          ->orWhere('middle_name', 'like', '%'.$name.'%')
                          ->orWhere('sex', 'like', '%'.$name.'%')
                          ->orWhere('first_name', 'like', '%'.$name.'%')
                          ->orWhere('last_name', 'like', '%'.$name.'%')
                          ->orWhere('current_job', 'like', '%'.$name.'%')
                          ->orWhere('job1', 'like', '%'.$name.'%')
                          ->orWhere('education', 'like', '%'.$name.'%')
                          ->orWhere('location', 'like', '%'.$name.'%')
                          ->orWhere('last_city', 'like', '%'.$name.'%')
                          ->orWhere('city', 'like', '%'.$name.'%')
                          ->orWhere('date1', 'like', '%'.$name.'%')
                          ->orWhere('date2', 'like', '%'.$name.'%')
                          ->orWhere('date2', 'like', '%'.$name.'%')
                          ->orWhere('date3', 'like', '%'.$name.'%');


        $resp = [
            'items' => $result->take(10)->get(),
        ];

        //Response
        return $resp;
     }
}
