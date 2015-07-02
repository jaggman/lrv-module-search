<?php namespace Modules\Search\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class SearchController extends Controller {
	
	public function getIndex()
	{
		return view('search::index');
	}
        
        public function getState(){
            $state = \DB::connection('search')->table('trace_log')->get();
            return view('search::state', [
                //'state'=>$state,
            ]);
            //var_dump($state);
        }
	
        public function postState(){
            $state = \DB::connection('search')->table('trace_log')->max('id');
            /*return view('search::state', [
                'state'=>$state,
            ]);*/
            echo $state;
            //var_dump($state);
        }
	
}