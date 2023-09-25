<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Comment;
use App\Models\Enrollment;
use App\Models\Party_record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class PartyController extends Controller
{
    public function index(Request $request)
    {
        $parties = Party::all();
        if ($request->branchs) {
            $parties = Party::where('branch', '=', $request->branchs)->get();
        }
        if ($request->statuss) {
            $parties = Party::where('status', '=', $request->statuss)->get();
        }
        if ($request->c_id) {
            $parties = Party::where('c_id', '=', $request->c_id)->get();
        }
        $expires = Party::where('end_date', '<', Carbon::parse('Now +61 days'))
            ->where('end_date', '!=', null)
            ->where('status', '=', 2)
            ->get();

        $c_id = ($request->c_id) ? $request->c_id : '';
        $status = ($request->statuss) ? $request->statuss : '';
        $branch = ($request->branch) ? $request->branch : '';
        $branches = Branch::all();
        return view('main.components.parties', compact(['parties', 'branches', 'expires', 'c_id', 'status', 'branch']));
    }
    public function show(Request $request, $id)
    {
        $party = Party::find($id);
        $branches = Branch::all();
        $partyRecords = Party_record::where('party_id', $id)->orderBy('created_at', 'DESC')->get();
        $comments = Comment::where('object_id', $id)->where('object_index', 3)->where('reply_comment_id', 0)->orderBy('created_at', 'DESC')->get();
        $payments = Enrollment::where('banner_id', $id)->where('index', 3);
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
        return view('main.components.party', compact(['party', 'payments', 'partyRecords', 'comments','branches']));
    }
    public function store(Request $request)
    {
        $party = new Party;
        $party->id = Party::max('id') +1;
        $party->user_id = Auth::user()->name;
        $party->valuta = $request->valuta;
        $party->branch = $request->branch;
        $party->c_id = $request->c_id;
        $party->address = $request->address;
        $party->size = $request->size;
        $party->price_kv = $request->price_kv;
        $party->status = 1;

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $party->image = "$filename";
        }
        $party->save();
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $party = Party::find($id);
        $party->branch = $request->branch;
        $party->address = $request->address;
        $party->valuta = $request->valuta;
        $party->size = $request->size;
        $party->price_kv = $request->price_kv;
        if ($request->hasfile('image')) {
            $destination = 'assets/image/' . $party->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $party->image = "$filename";
        }
        $party->update();
        return redirect()->back();
    }
    public function delete($id)
    {
        $party = Party::find($id);
        $partyRecords = Party_record::where('party_id', $id)->get();
        $partyPayments= Enrollment::where('banner_id', $id)->where('index', 3)->get();
        foreach($partyPayments as $partyPayment){
            $partyPayment->delete();
        }
        foreach($partyRecords as $partyRecord){
            $partyRecord->delete();
        }
        $destination = 'assets/image/' . $party->image;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $party->delete();
        return redirect()->back();
    }

    public function storePartyRecord(Request $request, $id)
    {
        $partyRecord = new Party_record();
        $party = Party::find($id);
        $partyRecord->id = Party_record::max('id');
        $partyRecord->user_id = Auth::user()->id;
        $partyRecord->party_id = $id;
        $partyRecord->payed = $request->payed;
        $partyRecord->branch = $party->branch;
        $partyRecord->address = $party->address;
        $partyRecord->tenant = $request->tenant;
        $partyRecord->tenant_identification_code = $request->tenant_identification;
        $partyRecord->tenant_number = $request->tenant_number;
        $partyRecord->tenant_email = $request->tenant_email;
        $partyRecord->start_date = $request->start_date;
        $partyRecord->end_date = $request->end_date;
        $partyRecord->total_price = $request->total_price;
        $partyRecord->status = 2;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $partyRecord->image = "$filename";
        }

        $partyRecord->save();
        $party->payed = $request->payed;
        $party->tenant = $request->tenant;
        $party->tenant_identification_code = $partyRecord->tenant_identification_code;
        $party->tenant_number = $request->tenant_number;
        $party->tenant_email = $request->tenant_email;
        $party->start_date = $request->start_date;
        $party->end_date = $request->end_date;
        $party->total_price = $request->total_price;
        $party->status = 2;
        $party->document = $partyRecord->image;
        $party->update();


        return redirect()->back();
    }
    public function updatePartyRecord(Request $request, $id)
    {
        $partyRecord = Party_record::find($id);
        $party = Party::find($partyRecord->party_id);
        $partyRecord->payed = $request->payed;
        $partyRecord->tenant = $request->tenant;
        $partyRecord->tenant_identification_code = $request->tenant_identification;
        $partyRecord->tenant_number = $request->tenant_number;
        $partyRecord->tenant_email = $request->tenant_email;
        $partyRecord->start_date = $request->start_date;
        $partyRecord->end_date = $request->end_date;
        $partyRecord->total_price = $request->total_price;
        $partyRecord->status = $request->status;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('assets/image/', $filename);
            $partyRecord->image = "$filename";
        }
        $partyRecord->update();
        $party->payed = $request->payed;
        $party->tenant = $request->tenant;
        $party->tenant_identification_code = $request->tenant_identification;
        $party->tenant_number = $request->tenant_number;
        $party->tenant_email = $request->tenant_email;
        $party->start_date = $request->start_date;
        $party->end_date = $request->end_date;
        $party->total_price = $request->total_price;
        $party->document = $partyRecord->image;

        if($partyRecord->status == 1){
            $party->payed = null;
            $party->tenant = null;
            $party->tenant_identification_code = null;
            $party->tenant_number = null;
            $party->tenant_email = null;
            $party->start_date = null;
            $party->end_date = null;
            $party->total_price = null;
            $party->document = null;
        }
        $party->update();

        return redirect()->back();
    }
    public function deletePartyRecord($id)
    {
        $partyRecord = Party_record::find($id);
        $partyRecord->delete();
        return redirect()->back();
    }
}
