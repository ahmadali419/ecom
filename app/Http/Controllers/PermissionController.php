<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index() {
        $categories = getCategory(true,-1,'permission','',true);
        $dt = [
            'categories' => $categories
        ];
        return view('permissions.list', $dt);
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

        $permission = DB::table('permissions');
        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];

            if($search != "") {
                if ($col == 'id') {
                    $permission->where($col, $search);
                }
                if ($col == 'category_id') {
                    $permission->where($col, $search);
                }
                if ($col == 'name') {
                    $permission->where($col, 'like','%' . $search . '%');
                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $permission->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $permission->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $permission->orderBy("id", "desc");
        }
        $iTotalRecords = $permission->count();
        $permission->skip($start);
        $permission->take($length);
        $permissionData = $permission->get();
        $data = [];
        foreach ($permissionData as $permissionObj) {
            $categoryName = "";
            if($permissionObj->category_id != "") {
                $category = Category::find($permissionObj->category_id);
                $categoryName = $category->name;
            }
            $action = "";
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="'.$permissionObj->id.'" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="'.$permissionObj->id.'" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';
            $data[] = [
                "id" => $permissionObj->id,
                "category_id" => $categoryName,
                "name" => $permissionObj->name,
                "created_at" => Carbon::create($permissionObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function store(Request $request) {
        $id = $request->id;
        $permission = new Permission();
        if($id > 0) {
            $permission = Permission::findOrFail($id);
        }
        $permission->category_id = $request->category_id;
        $permission->name = $request->name;
        $query = $permission->save();
        $return = [
            'status' => 'error',
            'message' => 'Data is not save successfully',
        ];
        if($query) {
            $return = [
                'status' => 'success',
                'message' => 'Permission is save successfully',
            ];
        }
        return response()->json($return);
    }

    public function getPermissionById(Request $request) {
        $id = $request->id;
        $permission = Permission::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $permission
        ];
        if(empty($permission)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $checkPermission = new Permission();
        $res = $checkPermission->checkPermissionAssigned($id);
        if ($res) {
            DB::table('permissions')
                ->where('id', $id)
                ->delete();
            return response()->json(['status' => 'success','message' => 'Permission is deleted successfully']);
        } else {
            return response()->json(['status' => 'error','message' => 'Permission not deleted beacuse it is assigned']);
        }
    }

    public function getPermissionByRoleId(Request $request) {
        $roleId = $request->role_id;
        $permisionIds = DB::table('role_has_permissions')->where('role_id', $roleId)->pluck('permission_id')->toArray();
        $permissionsArr = [];
        if(!empty($permisionIds)) {
            $permission = DB::table('permissions as p');
            $permission->select('p.*','c.name as category_name');
            $permission->Join('categories as c', 'c.id', '=', 'p.category_id');
            $permission->whereIn('p.id',$permisionIds);
            $permissions = $permission->get();
            foreach ($permissions as $permissionObj) {
                $permissionsArr[$permissionObj->category_name][] = [
                    'id' => $permissionObj->id,
                    'name' => $permissionObj->name,
                ];
            }
        }
        $viewData = [
            'permissions' => $permissionsArr
        ];
        $html = view('users.permission_modal', $viewData)->render();
        $return = [
            'status' => 'success',
            'html' => $html
        ];
        return response()->json($return);
    }
}
