<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class RoleController extends Controller
{
    public function index() {
        $stores = getUserStore(true);
        $dt = [
            'stores' => $stores
        ];
        return view('roles.list', $dt);
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

        $userType = auth()->user()->type;
        $userRoleIds = getRole();
        $role = Role::select('*');
        if($userType != 'super_admin') {
            $role->whereIn('id', $userRoleIds);
        }
        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {
                if ($col == 'id') {
                    $role->where($col, $search);
                }
                if ($col == 'name') {
                    $role->where($col, 'like','%' . $search . '%');
                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $role->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $role->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $role->orderBy("id", "desc");
        }
        $iTotalRecords = $role->count();
        $role->skip($start);
        $role->take($length);
        $roleData = $role->get();
        $data = [];
        $userId = auth()->user()->id;
        foreach ($roleData as $roleObj) {
            $action = "";
            if (hasPermission('assignPermissionRole')) {
                $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon assign_permission" data-id="' . $roleObj->id . '" title="Assign Permission">
                        <i class="la fab la-confluence"></i>
                    </a>';
            }
            if (hasPermission('editRole') && $roleObj->name!='Super Admin') {
                $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="' . $roleObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';
            }
            if (hasPermission('deleteRole') && $roleObj->name!='Super Admin') {
                $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $roleObj->id . '" title="Delete">
                        <i class="la la-trash"></i>
                    </a>';
            }
            $data[] = [
                "id" => $roleObj->id,
                "name" => $roleObj->name,
                "created_at" => Carbon::create($roleObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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
        $role = new Role();
        if($id > 0) {
            $role = Role::findOrFail($id);
        }
        $role->name = $request->name;
        isset($request->store_id) && $request->store_id > 0 ? $storeID=$request->store_id:$storeID=NULL;
        $role->store_id =$storeID ;
        $role->save();
        $return = [
            'status' => 'success',
            'message' => 'Role save successfully',
        ];
        return response()->json($return);
    }

    public function getRoleById(Request $request) {
        $id = $request->id;
        $role = Role::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $role
        ];
        if(empty($role)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        Role::where('id', $id)->delete();
        return response()->json(['status' => 'success','message' => 'Role is deleted successfully']);
    }

    public function rolePermissions(Request $request) {
        $roleId = $request->role_id;
        $permission = DB::table('permissions');
        $permission->select('permissions.*','categories.name as category_name');
        $permission->Join('categories', 'categories.id', '=', 'permissions.category_id');
//        $permission->where('categories.id', '!=', 4);
        $permissions = $permission->get();
        $assignPermissionTORole = DB::table('role_has_permissions')->where('role_id', $roleId)->pluck('permission_id')->toArray();
        $html = '<input type="hidden" name="role_id" value="' . $roleId . '" >';
        $perArr = [];
        foreach ($permissions as $permissionObj) {
            $perArr[$permissionObj->category_name][] = [
                'id' => $permissionObj->id,
                'name' => $permissionObj->name,
            ];
        }
        $userType = auth()->user()->type;
        if(count($perArr)) {
            foreach($perArr as $categoryName => $permission) {
                $printPermissionHeading = true;
                foreach($permission as $p) {
                    $showPermission = true;
                    if($userType != 'super_admin') {
                        if(!hasPermission($p['name'])) {
                            $showPermission = false;
                        }
                    }
                    if($showPermission) {
                        if($printPermissionHeading) {
                            $html .= '<div class="col-sm-12" style="margin:5px 0px;">
                                        <div class="caption">
                                            <i class="icon-user font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase"><b>' . $categoryName . '</b></span>
                                        </div>
                                    </div>';
                            $printPermissionHeading = false;
                        }
                        $checked = '';
                        if (in_array($p['id'], $assignPermissionTORole)) {
                            $checked = 'checked="checked"';
                        }
                        $string = $p['name'];
                        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
                        $replace = '${1} ${2}';
                        $html .= '<div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <label class="checkbox checkbox-square checkbox-danger">
                                        <input type="checkbox" ' . $checked . ' name="permission[]" value="' . $p['id'] . '" >
                                        ' . ucwords(preg_replace($pattern, $replace, $string)) . '
                                        <span></span>
                                    </label>
                                </label>
                            </div>';
                    }
                }
            }
        }
        $return = [
            'status' => 'success',
            'data' => $html
        ];
        return response()->json($return);
    }

    public function assignPermissions(Request $request) {
        $roleId = $request->role_id;
        $permissions = $request->permission;
        DB::table('role_has_permissions')->where('role_id', $roleId)->delete();
        $permissionArr = [];
        foreach ($permissions as $permission) {
            $permissionArr[] = [
                'permission_id' => $permission,
                'role_id' => $roleId
            ];
        }
        if(!empty($permissionArr)) {
            DB::table('role_has_permissions')->insert($permissionArr);
        }
        return response()->json(['status' => 'success','message' => 'Role permissions updated successfully']);
    }
}
