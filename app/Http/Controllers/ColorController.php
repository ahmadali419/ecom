<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('colores.list');
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
        $colors = DB::table('colors');
        $colors->where('deleted_at', NULL);

        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {
                if ($col == 'Name') {
                    $col1='name';
                    $colors->where($col1, 'like','%' . $search . '%');
                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $colors->whereBetween('created_at', [$dateFrom, $dateTo]);
                }

            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $colors->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $colors->orderBy("name", "desc");
        }
        $iTotalRecords = $colors->count();
        $colors->skip($start);
        $colors->take($length);
        $colorstData = $colors->get();
        $data = [];
        $i=1;
        foreach ($colorstData as $colorsObj) {
            $action = "";

            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="' . $colorsObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';


            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $colorsObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';

            $data[] = [
                "id" => $i,
                "Name" => $colorsObj->name,
                "created_at" => Carbon::create($colorsObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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
        $color = new Color();
        if($id > 0) {
            $color = Color::findOrFail($id);
        }
        $color->name = $request->name;
        $color->added_by = Auth::user()->id;
        $query = $color->save();

        $return = [
            'status' => 'error',
            'message' => 'Color is not save successfully',
        ];
        if($query) {
            $return = [
                'status' => 'success',
                'message' => 'Color is save successfully',
                'colorId' => $color->id,
            ];
        }
        return response()->json($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function getColorById(Request $request) {
        $id = $request->id;
        $color = Color::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $color
        ];
        if(empty($color)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color $color)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = Color::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success','message' => 'Colors is deleted successfully']);
        } else {
            return response()->json(['status' => 'error','message' => 'Colors not deleted ']);
        }

    }

    public function getProductByColor($id)
    {

        $result = getProductByCategory(-1,$id);
        $dt = ['products'=>$result];
        return view('web.category_products.index',$dt);
    }



}
