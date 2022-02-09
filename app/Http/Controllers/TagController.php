<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.list');
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
        $charges = DB::table('tags');
        $charges->where('deleted_at', NULL);

        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {
                if ($col == 'sr') {
                    $col1 ='id';
                    $charges->where($col1, $search);
                }
                if ($col == 'Name') {
                    $col2='name';
                    $charges->where($col2, 'like','%' . $search . '%');
                }

                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $charges->whereBetween('created_at', [$dateFrom, $dateTo]);
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
                "id" => $i,
                "Name" => $chargesObj->name,
                "created_at" => Carbon::create($chargesObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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

    public function store(Request $request)
    {

        $id = $request->id;
        $tag = new Tag();
        if($id > 0) {
            $tag = Tag::findOrFail($id);
        }
        $tag->name = $request->name;
        $tag->created_by = Auth::user()->id;
        $query = $tag->save();
        $return = [
            'status' => 'error',
            'message' => 'Tag is not save successfully',
        ];
        if($query) {
            $return = [
                'status' => 'success',
                'message' => 'Tag is save successfully',
            ];
        }
        return response()->json($return);
    }

    public function getTagById(Request $request) {
        $id = $request->id;
        $tags = Tag::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $tags
        ];
        if(empty($tags)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        //echo $id;exit;
        $res = Tag::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success','message' => 'Tag is deleted successfully']);
        } else {
            return response()->json(['status' => 'error','message' => 'Tag not deleted ']);
        }
    }

    public function getProductByTag($id)
    {
        $result = getProductByCategory(-1,-1,$id);
        $dt = ['products'=>$result];
        return view('web.category_products.index',$dt);
    }



}
