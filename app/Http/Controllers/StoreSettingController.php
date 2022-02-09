<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
use Illuminate\Http\Request;
use App\Models\StoreProductMapping;
use App\Models\UserStoreMapping;
use App\Models\Store;
use App\Models\Contract;
use App\Models\Product;
use App\Models\StoreCoverImage;
use Image;
use File;
use DB;
use Auth;

class StoreSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request, $id)
    {
        $type  = Auth::user()->type;
        $id = last(request()->segments());
        $stores = Store::where('id', $id)->first();
        if(!empty($stores)){
            $dt = [];
            $themes = getThemes();
            $themeColors = getThemeColors();
            $contracts = Contract::whereNull('deleted_at')->get();
            $dt = [
                'stores' => $stores,
                'themes' => $themes,
                'themeColors' => $themeColors,
                'contracts' => $contracts
            ];
            if ($type != 'super_admin') {
                $userId  = Auth::user()->id;
                $userStore = UserStoreMapping::where('user_id', $userId)->first();
                if (!empty($userStore)) {
                    $storeSettings = StoreSetting::with(['cover_images'=>function($query)use($id){
                        $query->where('store_id',$id);
                    }])->where('store_id', $id)->first();
                    $dt['storeSettings'] = $storeSettings;
                } else {
                    return redirect()->route('storeList')->with('error', 'Sorry you cannot edit this settings!');
                }
            } else {
                $storeSettings = StoreSetting::with(['cover_images'=>function($query)use($id){
                    $query->where('store_id',$id);
                }])->where('store_id', $id)->first();

                $dt['storeSettings'] = $storeSettings;
            }

            return view('store_settings.index', $dt);
        } else {
            return redirect()->route('storeList')->with('error', 'Sorry you cannot edit this settings!');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function siteInfo(Request $request)
    {
       $storeId = $request->store_id;
        // print_r($request->all());exit;
        // print_r($request->all());exit;
        // Field Validation
        $request->validate([
            'title' => 'required|max:250',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
            // 'images.*' => 'required_without:id',

        ]);

        $id = $request->id;


        // Logo upload, fit and store inside public folder
        if ($request->hasFile('logo')) {

            //Delete Old Image
            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->logo_path)) {
                $file_path = public_path($old_file->logo_path);

                if (File::isFile($file_path)) {
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $logoNameToStore = 'storeinfo/store_'.$storeId.'/'.$filename . '_' . time() . '.' . $extension;
            $path = public_path('storeinfo/store_'.$storeId);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $thumbnailpath =  $logoNameToStore;
            $img = Image::make($request->file('logo')->getRealPath())->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailpath);
        } else {

            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->logo_path)) {
                $logoNameToStore = $old_file->logo_path;
            } else {
                $logoNameToStore = Null;
            }
        }
        if ($request->hasFile('cart_image')) {

            //Delete Old Image
            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->logo_path)) {
                $file_path = public_path($old_file->cart_image);

                if (File::isFile($file_path)) {
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('cart_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cart_image')->getClientOriginalExtension();
            $cartImageName = 'storeinfo/store_'.$storeId.'/'.$filename . '_' . time() . '.' . $extension;
            // echo $cartImageName;exit;
            $path = public_path('storeinfo/store_'.$storeId);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $thumbnailpath =  $cartImageName;
            $img = Image::make($request->file('cart_image')->getRealPath())->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailpath);
        } else {

            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->cart_image)) {
                $cartImageName = $old_file->cart_image;
            } else {
                $cartImageName = Null;
            }
        }
        if ($request->hasFile('wishlist_image')) {

            //Delete Old Image
            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->logo_path)) {
                $file_path = public_path($old_file->wishlist_image);

                if (File::isFile($file_path)) {
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('wishlist_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('wishlist_image')->getClientOriginalExtension();
            $wishlistImageName = 'storeinfo/store_'.$storeId.'/'.$filename . '_' . time() . '.' . $extension;
            $path = public_path('storeinfo/store_'.$storeId);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $thumbnailpath =  $wishlistImageName;
            $img = Image::make($request->file('wishlist_image')->getRealPath())->resize(null, 80, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailpath);
        } else {

            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->wishlist_image)) {
                $wishlistImageName = $old_file->wishlist_image;
            } else {
                $wishlistImageName = Null;
            }
        }

        if ($request->hasFile('products_cover_image')) {

            //Delete Old Image
            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->logo_path)) {
                $file_path = public_path($old_file->products_cover_image);

                if (File::isFile($file_path)) {
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('products_cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('products_cover_image')->getClientOriginalExtension();
            $productImageName = 'storeinfo/store_'.$storeId.'/'.$filename . '_' . time() . '.' . $extension;
            $path = public_path('storeinfo/store_'.$storeId);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $thumbnailpath =  $productImageName;
            $img = Image::make($request->file('products_cover_image')->getRealPath())->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailpath);
        } else {

            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->products_cover_image)) {
                $productImageName = $old_file->products_cover_image;
            } else {
                $productImageName = Null;
            }
        }



        // Favicon upload, fit and store inside public folder
        if ($request->hasFile('favicon')) {

            //Delete Old Image
            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->favicon_path)) {
                $file_path = public_path($old_file->favicon_path);
                if (File::isFile($file_path)) {
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('favicon')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('favicon')->getClientOriginalExtension();
            $faviconNameToStore = 'storeinfo/store_'.$storeId.'/'.$filename . '_' . time() . '.' . $extension;
    //  echo $faviconNameToStore;exit;
            //Crete Folder Location
            $path = public_path('storeinfo' . '/'.'store_'.$storeId);

            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            //Resize And Crop as Fit image here (64 width, 64 height)
            $thumbnailpath =  $faviconNameToStore;
            // echo $thumbnailpath;exit;
            $img = Image::make($request->file('favicon')->getRealPath())->fit(64, 64, function ($constraint) {
                $constraint->upsize();
            })->save($thumbnailpath);
        } else {

            if($id != -1){
                $old_file = StoreSetting::find($id);
            }

            if (isset($old_file->favicon_path)) {
                $faviconNameToStore = $old_file->favicon_path;
            } else {
                $faviconNameToStore = Null;
            }
        }


        Store::where('id',$id)->update(['name'=>$request->title]);
        // -1 means no data row found
        $bannerImages = $request->images;

    // print_r($multiImg);exit;
        // if ($id == -1) {
        //     // echo "yes";exit;
        //     // Insert Data
        //     $data = new StoreSetting;
        //     // $data->title = $request->title;
        //     $data->store_id = $request->store_id;
        //     // $data->description = $request->description;
        //     // $data->keywords = $request->keywords;
        //     // $data->logo_path = $logoNameToStore;
        //     // $data->favicon_path = $faviconNameToStore;
        //     //      // $data->google_analytics = $request->google_analytics;
        //     // $data->footer_text = $request->footer_text;
        //     // $query = $data->save();
        // }

        $query = StoreSetting::updateOrCreate(
            ['store_id' => $request->store_id],
            ['store_id' => $request->store_id, 'description'=>$request->description,'banner_title'=>$request->banner_title,'cart_image'=>$cartImageName,'wishlist_image'=>$wishlistImageName,
            'products_cover_image'=>$productImageName,'banner_description'=>$request->banner_description,'logo_path'=>$logoNameToStore,'favicon_path'=>$faviconNameToStore,'footer_text'=>$request->footer_text]
        );
        //  if(!empty($request->store_id)) {
        //     // Update Data

        //     $data = StoreSetting::where('store_id',$request->store_id);

        //     // $data->title = $request->title;
        // }

        // if($data == ''){
        //     print_r($data);exit;

        //     $data = new StoreSetting;
        //     $data->store_id = $request->store_id;
        // }

        // $data->description = $request->description;
        // $data->banner_title = $request->banner_title;
        // $data->cart_image = $cartImageName;
        // $data->wishlist_image = $wishlistImageName;
        // $data->products_cover_image = $productImageName;
        // $data->banner_description = $request->banner_description;
        // $data->keywords = $request->keywords;
        // $data->logo_path = $logoNameToStore;
        // $data->favicon_path = $faviconNameToStore;

        // // $data->google_analytics = $request->google_analytics;
        // $data->footer_text = $request->footer_text;
        // $query = $data->save();

        if (!empty($bannerImages)) {
        // $res = StoreCoverImage::where('store_setting_id',$id);
        // if($res){
        //     $res->update(array('deleted_at' => DB::raw('NOW()')));
        // }

            $multiImg = [];
            foreach ($bannerImages as $key => $file) {
                if ($request->images != '') {
                    if ($file) {
                        $filenameWithExt = $file->getClientOriginalName();
                        $passportFile = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $path = public_path('storeinfo/store_'.$storeId);
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0777, true, true);
                        }
                        $extension = $file->getClientOriginalExtension();
                        $input['images'] =  'storeinfo/store_'.$storeId.'/'.$passportFile . '_' . time() . '.' . $extension;
                        $file->move($path, $input['images']);
                    }
                    $multiImg[] = [
                        'store_setting_id'=>$query->id,
                        'image' => $input['images'],
                    ];

            }

        }
        StoreCoverImage::insert($multiImg);
    }
        $return = [
            'status' => 'error',
            'message' => 'Data is  not saved successfully!',
        ];
        if ($query) {
            $return = [
                'status' => 'success',
                'message' => 'Data is saved successfully',
                'id' =>$query->id
            ];
        }
        return response()->json($return);
    }
    public function socialInfo(Request $request)
    {
       // print_r($request->all());exit;
        $id = $request->id;

        // -1 means no data row found
        if ($id == -1) {
            // Insert Data
            $input = $request->all();
            $data = StoreSetting::create($input);
        } else {
            // Update Data
            $data = StoreSetting::find($id);
            $input = $request->all();
            $data->update($input);
        }

        $return = [
            'status' => 'error',
            'message' => 'Data is  not saved successfully!',
        ];
        if ($data) {
            $return = [
                'status' => 'success',
                'message' => 'Data is saved successfully',
                'id'=>$data->id
            ];
        }
        return response()->json($return);
    }

    public function addressInfo(Request $request)
    {

        $id = $request->id;


        // -1 means no data row found
        if ($id == -1) {
            // Insert Data

            $data = new StoreSetting;
            $data->tagline = $request->tagline;
            $data->address = $request->address;
            $data->city = $request->city;
            $data->state = $request->state;
            $data->country = $request->country;
            $data->zip_code = $request->zip_code;
            $data->country = $request->country;
            $data->store_id = $request->store_id;
            $data->save();
        } else {
            // Update Data
            // echo "yes";exit;
            $data = StoreSetting::find($id);
            // print_r($data);exit;
            $data->tagline = $request->tagline;
            $data->address = $request->address;
            $data->city = $request->city;
            $data->state = $request->state;
            $data->country = $request->country;
            $data->zip_code = $request->zip_code;
            $data->country = $request->country;
            $data->store_id = $request->store_id;
            $data->save();
        }

        $return = [
            'status' => 'error',
            'message' => 'Data is  not saved successfully!',
        ];
        if ($data) {
            $return = [
                'status' => 'success',
                'message' => 'Data is saved successfully',
                'id'=>$data->id
            ];
        }
        return response()->json($return);
    }
    public function pannelInfo(Request $request)
    {
        $storeId = $request->store_id;
        $storeLink = $request->store_link;
        $storeSetting = StoreSetting::where('store_id',$storeId)->first();

        if(empty($storeSetting)) {
            $storeSetting = new StoreSetting();
            $storeSetting->store_id = $storeId;
        }
        $domain = getDomainSlug($storeLink);
        $storeSetting->slug = $domain->slug;
        $storeSetting->host = $domain->host;
        $storeSetting->store_link = $storeLink;
        $storeSetting->save();
        $return = [
            'status' => 'success',
            'message' => 'Data is saved successfully',
            'id' => $storeSetting->id
        ];
        return response()->json($return);
    }
    public function sitepages(Request $request)
    {
        $result=new StoreSetting();
        $check=StoreSetting::where('store_id',$request->id)->first();
        if($check){
            //echo "yesss";exit;
            $query=$check->update(array(
                'about_us' =>json_encode($request->about),
                'terms_condition' =>json_encode($request->terms),
                'returns_exchange' =>json_encode($request->returns),
                'shipping_delivery' =>json_encode($request->shiping),
                'privacy_policy' =>json_encode($request->privacy)));




        }else{


            $result->about_us=json_encode($request->about);
            $result->terms_condition=json_encode($request->terms);
            $result->returns_exchange=json_encode($request->returns);
            $result->shipping_delivery=json_encode($request->shiping);
            $result->privacy_policy=json_encode($request->privacy);
            $result->privacy_policy=json_encode($request->privacy);
            $result->store_id=$request->id;
            $query = $result->save();
        }

        $return = [
            'status' => 'error',
            'message' => 'Data is  not saved successfully!',
        ];
        if ($query) {
            $return = [
                'status' => 'success',
                'message' => 'Data is saved successfully',

            ];
        }
        return response()->json($return);




    }
    public function sitetheme(Request $request) {
        $storeId = $request->store_id;
        $theme = $request->theme;
        $themeColor = $request->theme_color;
        $storeSetting = StoreSetting::where('store_id',$storeId)->first();
        if(empty($storeSetting)) {
            $storeSetting = new StoreSetting();
            $storeSetting->store_id = $storeId;
        }
        $storeSetting->theme = $theme;
        $storeSetting->theme_color = $themeColor;
        $storeSetting->save();
        $return = [
            'status' => 'success',
            'message' => 'Data is saved successfully'
        ];
        return response()->json($return);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */
    public function show(StoreSetting $storeSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreSetting $storeSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreSetting $storeSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */

    public function destroy(StoreSetting $storeSetting)
    {
        //
    }

    public function removeCoverImage(Request $request)
    {
        $storeId = last(request()->segments());
        $id = $request->id;
        $res = StoreCoverImage::find($id);
        $path = public_path($res->image);
        if (file_exists($path)) {
            unlink($path);
        }
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Product image is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Product image not deleted try again ']);
        }
    }
}
