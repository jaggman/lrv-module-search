<?php namespace Modules\Search\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Search\Models\Log;
use DB;

class SearchController extends Controller {
	
	public function getIndex()
	{
		return view('search::index');
	}
        
        public function getState(){
            //$state = \DB::connection('search')->table('trace_log')->get();
            return view('search::state', [
                //'state'=>$state,
            ]);
            //var_dump($state);
        }
	
        public function postState(){
            $state = Log::max('id');
            /*return view('search::state', [
                'state'=>$state,
            ]);*/
            echo $state;
            //var_dump($state);
        }
        
        public function getGraf(){
            return view('search::graf', [
                //'state'=>$state,
                //'data'=>json_encode($state)
            ]);
            //echo json_encode($state);
            //return response()->json($state);
        }
        
        public function postGraf(\Request $request){
            $pop = $request::get('pop');
            
            $state = Log::select(DB::connection('search')->raw("`time_s`, count(`id`) `cnt`, sum(`time`) `time`, sum(`size`)/1024 `size`, `actionId` `action`"))
                    ->groupBy('time_s')
                    ->groupBy('action')
                    //->latest('id')
                    //->limit(10)
                    ->where('time_s', ">=", $pop ? $pop : DB::connection('search')->raw('NOW()-150'))
                    ->get();
            $states = [];
            foreach($state as $sts)
                $states[] = $sts;
            $pop = array_pop($states);
            $pop = $pop['time_s'];
            return response()->json(['state'=>$states,'pop'=>$pop]);
        }
        
        public function getStat(){
            return view('search::stat', [
                'stat'=>Log::stat(),
            ]);
        }
        
}