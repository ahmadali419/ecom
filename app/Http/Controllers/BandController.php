<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\BandPriceMapping;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BandController extends Controller
{
    public function index()
    {
        $dt = [];
        return view('bands.list', $dt);
    }

    public function getList(Request $request)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $userType = auth()->user()->type;
        $userRoleIds = getRole();
        $sql = Band::select('*');
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'id') {
                    $sql->where($col, $search);
                }
                if ($col == 'name') {
                    $sql->where($col, 'like', '%' . $search . '%');
                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $sql->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $sql->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $sql->orderBy("id", "desc");
        }
        $iTotalRecords = $sql->count();
        $sql->skip($start);
        $sql->take($length);
        $bandData = $sql->get();
        $data = [];
        foreach ($bandData as $bandObj) {
            $action = "";
            $action .= '<a href="' . route('getBandById', ['id' => $bandObj->id]) . '" class="btn btn-sm btn-clean btn-icon" data-id="' . $bandObj->id . '" title="Edit">
                        <i class="la la-edit"></i>
                    </a>';
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $bandObj->id . '" title="Delete">
                    <i class="la la-trash"></i>
                </a>';
            $data[] = [
                "id" => $bandObj->id,
                "name" => $bandObj->name,
                "created_at" => Carbon::create($bandObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function add()
    {
        $dt = ['totalTblCol' => 0,
            'totalTblRow' => 0,
            'contract_id'=>''];
        return view('bands.save', $dt);
    }

    public function store(Request $request)
    {
        $validate = true;
        $id = $request->id;
        $validateInput = $request->all();
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($validateInput, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $allMsg = [];
            foreach ($errors->all() as $message) {
                $allMsg[] = $message;
            }
            $return['status'] = 'error';
            $return['message'] = collect($allMsg)->implode('<br />');
            $validate = false;
        } else {
            if (!empty($id)) {
                $bandData = Band::find($id);
            } else {
                $bandData = new Band;
            }
            $bandData->name = $request->name;
            $query = $bandData->save();
            $bandId  = $bandData->id;
            if (!empty($bandId)) {
                $price = $request->price;
                $lengthArr = $request->length;
                $widthArr = $request->width;
                $priceArr = [];
                foreach($price as $length => $widthArrLoop) {
                    $lengthValue = $lengthArr[$length];
                    foreach($widthArrLoop as $width => $price) {
                        $widthValue = $widthArr[$width];
                        $priceArr[] = [
                            'band_id' => $bandId,
                            'length' => $lengthValue,
                            'width' => $widthValue,
                            'price' => $price
                        ];
                    }
                }
//                foreach($price as $pricekey => $priceObj) {
//                    $lengthob= $length[$pricekey];
//                    foreach($width as $widthKey => $widthObj)
//                    {
//                        $priceArr[] = ['band_id' => $bandId, 'length' => $lengthob, 'width' => $widthObj, 'price' => $price[$pricekey][$widthKey]];
//                    }
//                }
                BandPriceMapping::where('band_id', $bandId)->delete();
                BandPriceMapping::insert($priceArr);
            }
            $return = [
                'status' => 'error',
                'message' => 'Band not added successfully!',
            ];
            if ($query) {
                $return = [
                    'status' => 'success',
                    'message' => 'Band added successfully!',
                ];
            }
            return response()->json($return);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = Band::find($id);
        $priceMapping = BandPriceMapping::where('band_id', $id);
        if ($res) {
            $res->delete();
            $priceMapping->update(array('deleted_at' => DB::raw('NOW()')));
            return response()->json(['status' => 'success', 'message' => 'Band is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Band not deleted ']);
        }
    }

    public function getBandById($id)
    {
        $brandData = getbands(true, $id);
        $bandPricingMapping = BandPriceMapping::where('band_id', $id)->get();
        $priceArr = [];
        if (!($bandPricingMapping->isEmpty())) {
            foreach ($bandPricingMapping as $k => $priceObj) {
                if($k == 0) {
                    $priceArr['btn']['length'] = [];
                    $priceArr['L/W']['length'] = [];
                }
                $priceArr['btn'][$priceObj->width] = [];
                $priceArr['L/W'][$priceObj->width] = [];
                if(!isset($priceArr[$priceObj->length])) {
                    $priceArr[$priceObj->length]['length'] = [];
                }
                $priceArr[$priceObj->length][$priceObj->width] = [
                    'id' => $priceObj->id,
                    'price' => $priceObj->price
                ];
            }
        }
        foreach($priceArr as $length => $widthArr) {
            if($length !== "btn") {
                if($length != "L/W") {
                    $priceArr[$length]['btn'] = [];
                }
            }
        }
        $totalTblCol = 1;
        $totalTblRow = 1;
        if(!empty($priceArr)) {
            end($priceArr["btn"]);
            $totalTblCol = number_format((int)key($priceArr["btn"]), 0, '', '');
            end($priceArr);
            $totalTblRow = number_format((float)key($priceArr), 0, '', '');
            $priceArr["btn"]["btn"] = [];
            $priceArr["L/W"]["btn"] = [];
            $totalTblCol++;
            $totalTblRow++;
        }
        $dt = [
            'brandData' => $brandData,
            'totalTblCol' => $totalTblCol,
            'totalTblRow' => $totalTblRow,
            'priceArr' => $priceArr,
        ];
        return view('bands.save', $dt);
    }
}
