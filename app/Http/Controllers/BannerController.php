<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Banner_record;
use App\Models\Branch;
use App\Models\Comment;
use App\Models\Section;
use App\Models\Material;
use App\Models\Enrollment;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request as Input;



class BannerController extends Controller
{
    public function index(Request $request)
    {
        $ownBanners = Banner::where('id', '!=' , -2);
        $today = Carbon::now()->subDays(61);

        if ($request->branchs) {
            $ownBanners->where('branch', '=', $request->branchs);
        }
        if ($request->statuss) {
            $ownBanners->where('status', '=', $request->statuss);
        }
        if ($request->materials) {
            $ownBanners->where('material', '=', $request->materials);
        }
        if ($request->types) {
            $ownBanners->where('type', '=', $request->types);
        }
        if($request->expiration == 1){
            $ownBanners->where('end_date', '<', $today);
        }
        if($request->section){
            $ownBanners->where('section', '=', $request->section);
        }

        $ownBanners = $ownBanners->get();

        // if ($request->c_id && $request->c_id != 'აიდი') {
        //     $ownBanners = Banner::where('c_id', '=', $request->c_id)->get();
        // }
        $c_id = ($request->c_id) ? $request->c_id : '';
        $branch = ($request->branchs) ? $request->branchs : '';
        $status = ($request->statuss) ? $request->statuss : '';
        $type = ($request->types) ? $request->types : '';
        $section = ($request->section) ? $request->section : '';


        $expires = Banner::where('end_date', '<', Carbon::parse('Now +61 days'))->where('end_date', '!=', null)
        ->where('status', '=', 2)->get();

        $branches = Branch::all();
        $types = Type::all();
        $sections = Section::all();

        $materials = Material::all();

        return view('main.components.own-banners', compact(['today', 'ownBanners', 'branches', 'sections', 'types', 'materials','expires', 'status', 'section', 'c_id','branch','type',]))->withInput(Input::all());
    }
    public function show(Request $request, $id)
    {
        $branches = Branch::all();
        $types = Type::all();
        $materials = Material::all();
        $ownBanner = Banner::find($id);
        $comments = Comment::where('object_id', $id)->where('object_index', 1)->where('reply_comment_id', 0)->orderBy('created_at', 'DESC')->get();
        $ownBannerRecords = Banner_record::where('banner_id', $id)->orderBy('created_at', 'DESC')->get();
        $payments = Enrollment::where('banner_id', $id)->where('index', 1);
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
        $payments = $payments->orderBy('created_at', 'DESC')->get();
        return view('main.components.own-banner', compact(['ownBanner','payments', 'comments', 'ownBannerRecords', 'branches', 'types', 'materials',]));
    }
    public function store(Request $request)
    {
        $ownBanner = new Banner;
        $ownBanner->user_id = Auth::user()->name;
        $ownBanner->id = Banner::max('id') +1;
        $ownBanner->branch = $request->branch;
        $ownBanner->valuta = $request->valuta;
        $ownBanner->c_id = $request->c_id;
        $ownBanner->material = $request->material;
        $ownBanner->section = $request->section;
        $ownBanner->type = $request->type;
        $ownBanner->address = $request->address;
        $ownBanner->size = $request->size;
        $ownBanner->price = $request->price;
        $ownBanner->status = $request->status;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $ownBanner->first_image = "$filename";
        }
        $ownBanner->save();
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $ownBanner = Banner::find($id);
        $ownBanner->branch = $request->branch;
        $ownBanner->valuta = $request->valuta;
        $ownBanner->material = $request->material;
        $ownBanner->type = $request->type;
        $ownBanner->address = $request->address;
        $ownBanner->size = $request->size;
        $ownBanner->price = $request->price;
        $ownBanner->section = $request->section;
        $ownBanner->status = $request->status;
        $ownBanner->start_date = $request->start_date;
        $ownBanner->end_date = $request->end_date;

        if ($request->hasfile('image')) {
            $destination = 'assets/image/' . $ownBanner->first_image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $ownBanner->first_image = "$filename";
        }
        $ownBanner->update();
        return redirect()->back();
    }
    public function delete($id)
    {
        $ownBanner = Banner::find($id);
        $ownBannerRecords = Banner_record::where('banner_id', $id)->get();
        $ownBannerPayments= Enrollment::where('banner_id', $id)->where('index', 1)->get();
        foreach($ownBannerPayments as $ownBannerPayment){
            $ownBannerPayment->delete();
        }
        foreach($ownBannerRecords as $ownBannerRecord){
            $ownBannerRecord->delete();
        }
        $destination = 'assets/image/' . $ownBanner->first_image;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $ownBanner->delete();
        return redirect()->back();
    }


    public function storeOwnRecord(Request $request, $id)
    {
        $ownBannerRecord = new Banner_record();
        $ownBannerRecord->id = Banner_record::max('id') +1;
        $ownBannerRecord->user_id = Auth::user()->id;
        $ownBannerRecord->banner_id = $id;
        $ownBannerRecord->payed = $request->payed;
        $ownBannerRecord->print_payed = $request->print_payed;
        $ownBannerRecord->tenant = $request->tenant;
        $ownBannerRecord->tenant_identification_code = $request->tenant_identification;
        $ownBannerRecord->tenant_number = $request->tenant_number;
        $ownBannerRecord->tenant_email = $request->tenant_email;
        $ownBannerRecord->start_date = $request->start_date;
        $ownBannerRecord->end_date = $request->end_date;
        $ownBannerRecord->total_price = $request->total_price;
        $ownBannerRecord->status = 2;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $ownBannerRecord->image = "$filename";
        }

        $ownBannerRecord->save();

        $banner = Banner::find($id);
        $banner->payed = $request->payed;
        $banner->print_payed = $request->print_payed;
        $banner->tenant = $request->tenant;
        $banner->tenant_identification_code = $request->tenant_identification;
        $banner->tenant_number = $request->tenant_number;
        $banner->tenant_email = $request->tenant_email;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->total_price = $request->total_price;
        $banner->status = 2;
        $banner->save();


        return redirect()->back();
    }
    public function updateOwnRecord(Request $request, $id)
    {
        $ownBannerRecord = Banner_record::find($id);

        $ownBannerRecord->payed = $request->payed;
        $ownBannerRecord->print_payed = $request->print_payed;
        $ownBannerRecord->tenant = $request->tenant;
        $ownBannerRecord->tenant_identification_code = $request->tenant_identification;
        $ownBannerRecord->tenant_number = $request->tenant_number;
        $ownBannerRecord->tenant_email = $request->tenant_email;
        $ownBannerRecord->start_date = $request->start_date;
        $ownBannerRecord->end_date = $request->end_date;
        $ownBannerRecord->total_price = $request->total_price;
        $ownBannerRecord->status = $request->status;
        if ($request->hasfile('image')) {
            $destination = 'assets/image/' . $ownBannerRecord->first_image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $ownBannerRecord->image = "$filename";
        }

        $ownBannerRecord->save();
        $banner = Banner::find($ownBannerRecord->banner_id);
        $banner->payed = $request->payed;
        $banner->banner_image = $ownBannerRecord->image;
        $banner->print_payed = $request->print_payed;
        $banner->tenant = $request->tenant;
        $banner->tenant_identification_code = $request->tenant_identification;
        $banner->tenant_number = $request->tenant_number;
        $banner->tenant_email = $request->tenant_email;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->total_price = $request->total_price;
        $banner->status = $request->status;
        $banner->update();


        return redirect()->back();
    }
    public function deleteOwnRecord($id)
    {
        $ownBannerRecord = Banner_record::find($id);
        $destination = 'assets/image/' . $ownBannerRecord->first_image;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $ownBannerRecord->delete();
        return redirect()->back();
    }


    public function storePayments(Request $request, $id)
    {
        $payment = new Enrollment();
        $payment->banner_id = $id;
        $payment->index = $request->index;
        $payment->status = $request->status;
        $payment->month = $request->month;
        $payment->years = $request->years;
        $payment->tenant = $request->tenant;
        $payment->price = $request->price;
        $payment->transfer = $request->transfer;
        $payment->debt = $request->debt;
        $payment->save();
        return redirect()->back();
    }
    public function updatePayments(Request $request, $id)
    {
        $payment = Enrollment::find($id);
        $payment->month = $request->month;
        $payment->status = $request->status;
        $payment->years = $request->years;
        $payment->tenant = $request->tenant;
        $payment->price = $request->price;
        $payment->transfer = $request->transfer;
        $payment->debt = $request->debt;

        $payment->update();

        return back();
    }
    public function deletePayments($id)
    {
        $payment = Enrollment::find($id);
        $payment->delete();
        return redirect()->back();
    }
}
