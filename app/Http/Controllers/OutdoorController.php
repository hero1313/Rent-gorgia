<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outdoor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Comment;
use App\Models\Material;
use App\Models\Enrollment;
use Carbon\Carbon;


use App\Models\Outdoor_banner_record;

class OutdoorController extends Controller
{
    public function index(Request $request)
    {
        $outdoorBanners = Outdoor::all();

        if ($request->statuss) {
            $outdoorBanners = Outdoor::where('status', '=', $request->statuss)->get();
        }
        if ($request->materials) {
            $outdoorBanners = Outdoor::where('material', '=', $request->materials)->get();
        }
        if ($request->ids) {
            $outdoorBanners = Outdoor::where('c_id', '=', $request->c_id)->get();
        }

        $c_id = ($request->c_id) ? $request->c_id : '';
        $material = ($request->materials) ? $request->materials : '';
        $status = ($request->statuss) ? $request->statuss : '';
        $expires = Outdoor::where('end_date', '<', Carbon::parse('Now +61 days'))->where('status', 1)->where('end_date', '!=', null)
            ->where('status', '=', 2)->get();
        $materials = Material::all();
        return view('main.components.outdoor-banners', compact(['outdoorBanners', 'materials','expires','c_id','material','status']));
    }
    public function show(Request $request, $id)
    {
        $outdoorBannerRecords = Outdoor_banner_record::where('banner_id', $id)->orderBy('created_at', 'DESC')->get();
        $comments = Comment::where('object_id', $id)->where('object_index', 2)->where('reply_comment_id', 0)->orderBy('created_at', 'DESC')->get();
        $materials = Material::all();
        $payments = Enrollment::where('banner_id', $id)->where('index', 2);
        if($request->filter_years){
            $payments = $payments->where('years',$request->filter_years);
        }
        if($request->filter_month){
            $payments = $payments->where('month',$request->filter_month);
        }
        if($request->filter_status){
            $payments = $payments->where('status',$request->filter_status);
        }
        if($request->filter_tenant){
            $payments = $payments->where('tenant', 'LIKE', "%$request->filter_tenant%");
        }
        $payments = $payments->orderBy('created_at', 'DESC')->get();        $outdoorBanner = Outdoor::find($id);
        return view('main.components.outdoor-banner', compact(['outdoorBanner','payments', 'outdoorBannerRecords', 'comments', 'materials']));
    }
    public function store(Request $request)
    {
        $outdoorBanner = new Outdoor;
        $outdoorBanner->id = Outdoor::max('id') +1;
        $outdoorBanner->user_id = Auth::user()->id;
        $outdoorBanner->city = $request->city;
        $outdoorBanner->valuta = $request->valuta;
        $outdoorBanner->material = $request->material;
        $outdoorBanner->c_id = $request->c_id;
        $outdoorBanner->address = $request->address;
        $outdoorBanner->size = $request->size;
        $outdoorBanner->price = $request->price;
        $outdoorBanner->status = 1;
        // $outdoorBanner->start_date = Carbon::now();
        // $outdoorBanner->end_date = Carbon::now();



        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $outdoorBanner->image = "$filename";
        }
        $outdoorBanner->save();
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $outdoorBanner = Outdoor::find($id);
        $outdoorBanner->material = $request->material;
        $outdoorBanner->address = $request->address;
        $outdoorBanner->size = $request->size;
        $outdoorBanner->city = $request->city;
        $outdoorBanner->valuta = $request->valuta;
        $outdoorBanner->price = $request->price;
        if ($request->hasfile('image')) {
            $destination = 'assets/image/' . $outdoorBanner->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $outdoorBanner->image = "$filename";
        }
        $outdoorBanner->update();
        return redirect()->back();
    }
    public function delete($id)
    {
        $outdoorBanner = Outdoor::find($id);
        $outdoorBannerRecords = Outdoor_banner_record::where('banner_id', $id)->get();
        $outdoorBannerPayments= Enrollment::where('banner_id', $id)->where('index', 2)->get();
        foreach($outdoorBannerPayments as $outdoorBannerPayment){
            $outdoorBannerPayment->delete();
        }
        foreach($outdoorBannerRecords as $outdoorBannerRecord){
            $outdoorBannerRecord->delete();
        }
        $outdoorBanner->delete();
        return redirect()->back();
    }


    public function storeOutdoorRecord(Request $request, $id)
    {
        $outdoorBannerRecord = new Outdoor_banner_record();
        $outdoorBannerRecord->id = Outdoor_banner_record::max('id') +1;
        $outdoorBannerRecord->user_id = Auth::user()->id;
        $outdoorBannerRecord->banner_id = $id;
        $outdoorBannerRecord->payed = $request->payed;
        $outdoorBannerRecord->owner = $request->owner;
        $outdoorBannerRecord->owner_identification_code = $request->owner_identification;
        $outdoorBannerRecord->owner_number = $request->owner_number;
        $outdoorBannerRecord->owner_email = $request->owner_email;
        $outdoorBannerRecord->start_date = $request->start_date;
        $outdoorBannerRecord->end_date = $request->end_date;
        $outdoorBannerRecord->total_price = $request->total_price;
        $outdoorBannerRecord->status = 1;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $outdoorBannerRecord->image = "$filename";
        }

        $outdoorBannerRecord->save();
        $banner = Outdoor::find($id);
        $banner->payed = $request->payed;
        $banner->owner = $request->owner;
        $banner->owner_identification_code = $request->owner_identification;
        $banner->owner_number = $request->owner_number;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->total_price = $request->total_price;
        $banner->status = 2;
        $banner->save();


        return redirect()->back();
    }
    public function updateOutdoorRecord(Request $request, $id)
    {
        $outdoorBannerRecord = Outdoor_banner_record::find($id);
        $outdoorBannerRecord->payed = $request->payed;
        $outdoorBannerRecord->owner = $request->owner;
        $outdoorBannerRecord->owner_identification_code = $request->owner_identification;
        $outdoorBannerRecord->owner_number = $request->owner_number;
        $outdoorBannerRecord->owner_email = $request->owner_email;
        $outdoorBannerRecord->start_date = $request->start_date;
        $outdoorBannerRecord->end_date = $request->end_date;
        $outdoorBannerRecord->total_price = $request->total_price;
        $outdoorBannerRecord->status = 2;
        if ($request->hasfile('image')) {
            $destination = 'assets/image/' . $outdoorBannerRecord->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $outdoorBannerRecord->image = "$filename";
        }
        $outdoorBannerRecord->save();
        $banner = Outdoor::find($outdoorBannerRecord->banner_id);

        $banner->payed = $request->payed;
        $banner->image = $outdoorBannerRecord->image;
        $banner->owner = $request->owner;
        $banner->owner_identification_code = $request->owner_identification;
        $banner->owner_number = $request->owner_number;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->total_price = $request->total_price;
        $banner->status = $request->status;
        $banner->update();


        return redirect()->back();
    }
    public function deleteOutdoorRecord($id)
    {
        $outdoorBannerRecord = Outdoor_banner_record::find($id);
        $destination = 'assets/image/' . $outdoorBannerRecord->first_image;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $outdoorBannerRecord->delete();
        return redirect()->back();
    }
}
