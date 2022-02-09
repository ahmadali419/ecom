<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Charge;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Str;
class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('charges.list');
    }





    public function getList(Request $request) {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $userId = auth()->user()->id;
        $charges = DB::table('charges');
        $charges->where('deleted_at', NULL);

        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {

                if ($col == 'Name') {
                    $col1='name';
                    $charges->where($col1, 'like','%' . $search . '%');
                }

            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $charges->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $charges->orderBy("name", "desc");
        }
        $iTotalRecords = $charges->count();
        $charges->skip($start);
        $charges->take($length);
        $chargesData = $charges->get();
        $data = [];
        $i=1;
        foreach ($chargesData as $chargesObj) {
            $action = "";

            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="' . $chargesObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';


            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $chargesObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';

            $data[] = [
                "Sr" => $i,
                "Name" => $chargesObj->name,
                "Created At" => Carbon::create($chargesObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "action" => $action
            ];
            $i++;
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



     
    public function store(Request $request)
    {
        $id = $request->id;
        $charge = new Charge();
        if($id > 0) {
            $charge = Charge::findOrFail($id);
        }
        $charge->name = $request->name;
        $charge->slug = Str::slug($request->name, '-');
        $charge->created_by = Auth::user()->id;
        $query = $charge->save();
        $return = [
            'status' => 'error',
            'message' => 'Charges is not save successfully',
        ];
        if($query) {
            $return = [
                'status' => 'success',
                'message' => 'Charges is save successfully',
            ];
        }
        return response()->json($return);
    }

    public function getChargeById(Request $request) {
        $id = $request->id;
        $charges = Charge::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $charges
        ];
        if(empty($charges)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        //echo $id;exit;
        $res = Charge::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success','message' => 'Charges is deleted successfully']);
        } else {
            return response()->json(['status' => 'error','message' => 'Charges not deleted ']);
        }
    }
}
