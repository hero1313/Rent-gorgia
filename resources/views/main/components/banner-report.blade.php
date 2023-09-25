@extends('main.index')
@section('content')

<form action="{{route('report.banner')}}" method="GET">
    <div class="row filter-row mt-4 ml-3">
        <div class="mb-3">
            <h3>რეპორტი > ბანერების მოიჯარეები</h5>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>საწყისი თარიღი</label>
                <div>
                    <input class="form-control " autocomplete="off"  name='start_date' type="date">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>საბოლოო თარიღი</label>
                <div>
                    <input class="form-control " autocomplete="off"  name='end_date' type="date">
                </div>
            </div>
        </div>

        <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 col-12 mt-4">
            <button class="btn btn-success btn-block"> მოძებნე </button>
        </div>
    </div>
    <h3 class="ml-3 mt-3 mb-5">ჯამური შემოსვალი: {{$total}}ლ</h3>

</form>
<table class="table table-striped custom-table mb-0 ">
    <thead>
        <tr>
            <form action="/123">
                <th class="text-center">აიდი</th>
                <th class="text-center">მოიჯარე</th>
                <th class="text-center">მოიჯერეს საიდენთიფფიკაციო</th>
                <th class="text-center">მოიჯარის ნომერი</th>
                <th class="text-center">მოიჯარეს იმეილი</th>
                <th class="text-center">მონტაჯიშ თარიღი</th>
                <th class="text-center">დემონტაჟის თარიღი</th>
                <th class="text-center">სრული ფასი</th>
                <th class="text-center">სტატუსი</th>
                <th class="text-center">ბეჭდვის თანხა</th>
                <th class="text-center">ანაზღაურების სტატუსი</th>
                <th class="text-center">ფოტო</th>
                <th class="text-center">მოქმედება</th>
            </form>
        </tr>
    </thead>
    <tbody>
        @foreach($bannerRecords as $ownBannerRecord)
        <tr>
            <td class="text-center">{{$ownBannerRecord->id}}</td>
            <td class="text-center">{{$ownBannerRecord->tenant}}</td>
            <td class="text-center">{{$ownBannerRecord->tenant_identification_code}}</td>
            <td class="text-center">{{$ownBannerRecord->tenant_number}}</td>
            <td class="text-center">{{$ownBannerRecord->tenant_email}}</td>
            <td class="text-center">{{$ownBannerRecord->start_date}}</td>
            <td class="text-center">{{$ownBannerRecord->end_date}}</td>
            <td class="text-center">{{$ownBannerRecord->total_price}}</td>
            <td class="text-center">
                @if($ownBannerRecord->status == 0)
                დასრულებული
                @elseif($ownBannerRecord->status == 1)
                აქტიური
                @endif
            </td>
            <td class="text-center">
                @if($ownBannerRecord->print_payed == 0)
                არაა ანაზღაურებული
                @elseif($ownBannerRecord->print_payed == 1)
                ანაზღაურებული
                @elseif($ownBannerRecord->print_payed == 2)
                არ საჭიროებს
                @endif
            </td>
            <td class="text-center">
                @if($ownBannerRecord->payed == 0)
                არაა ანაზღაურებული
                @elseif($ownBannerRecord->payed == 1)
                ანაზღაურებული
                @endif
            </td>
            <td class="text-center">{{$ownBannerRecord->image}}</td>
            <td class="text-right">
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if(Auth::user())
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_{{$ownBannerRecord->id}}"><i class="fa fa-pencil m-r-5"></i> რედაქტირება</a>
                        @endif
                        @if(Auth::user() && Auth::user()->role != 1)
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_{{$ownBannerRecord->id}}"><i class="fa fa-trash-o m-r-5"></i>
                            წაშლა</a>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection