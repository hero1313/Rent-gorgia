@extends('main.index')
@section('content')
<!-- Page Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header" style="opacity: 0;">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">თანამშრომლები</h3>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="/excel-export" class="btn  excel-btn"></i>ექსელის ჩამოტვირთვა</a>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i>ბანერის დამატება</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Search Filter -->
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center add-nav">
            <div class="col">
                <h3 class="page-title">იჯარა > გორგიას ბანერები</h3>
                <button type="submit" class="btn btn-success mr-3">გაფილტვრა</button>
                <h3 class="page-title mt-4">სულ : {{$ownBanners->count()}} ბანერი</h3>
            </div>
            @if(Auth::user())
            <div class="col">
                <a href="#" class="btn add-btn mt-15" data-toggle="modal" data-target="#add_banner"><i class="fa fa-plus"></i>ბანერის დამატება</a>
            </div>
            @endif
            <form action="{{route('index.own-banner')}}">
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('index.own-banner',['expiration' => '1'])}}" style="margin-right: 20px" class="btn add-btn mr-3">ვადა გასდის</a>
                    <a href="{{route('index.own-banner',['expiration' => '2'])}}" class="btn add-btn mr-3">ყველა ბანერი</a>
                </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Search Filter -->


    <!-- /Search Filter -->

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ID
                            </th>
                            {{-- <th class="text-center"><input autocomplete="off" class="form-control id-input" value="{{ $c_id ? $c_id :  '' }}" type="text" placeholder="აიდი" name="c_id"></th> --}}
                            <th class="text-center">
                                <div class="form-group">
                                    <select class="select" name='branchs'>
                                        <option value='{{ $branch ? $branch : "" }}'>{{ $branch ? $branch : "ფილიალი" }}</option>
                                        <option value=''>ფილიალი</option>
                                        @foreach($branches as $branch)
                                        <option value='{{$branch->name}}'>{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>
                            <th class="text-center">
                                მონტაჟის თარიღი
                            </th>
                            <th class="text-center">
                                <!-- <label>დასრულება</label>
                                    <input name="user_name" type="date" placeholder="ქირაობის თარიღი" class="form-control floating"> -->
                                დემონტაჟის თარიღი
                            </th>
                            <th class="text-center">
                                <div class="form-group">
                                    <select class="select" name='statuss'>
                                        <option value='{{ $status ? $status : "" }}'>
                                            @if($status == 1)
                                            თავისუფალი
                                            @elseif($status == 2)
                                            გაქირავებული
                                            @elseif($status == 3)
                                            შიდა
                                            @else
                                            სტატუსი
                                            @endif
                                        </option>
                                        <option value=''>სტატუსი</option>
                                        <option value='1'>თავისუფალი</option>
                                        <option value='2'>გაქირავებული</option>
                                        <option value='3'>შიდა</option>

                                    </select>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="form-group">
                                    <select class="select" name='types'>
                                        <option value='{{ $type ? $type : "" }}'>{{ $type ? $type : "ტიპი" }}</option>
                                        @foreach($types as $type)
                                        <option value='{{$type->name}}'>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="form-group">
                                    <select class="select" name='section'>
                                        <option value='{{ $section ? $section : "" }}'>{{ $section ? $section : "სექცია" }}</option>
                                        @foreach($sections as $section)
                                        <option value='{{$section->name}}'>{{$section->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>
                            <th class="text-center">ჯამური თანხა</th>
                            <th class="text-center">ანაზღაურების სტატუსი</th>
                            <th class="text-center">მოქმედება</th>
                            <!-- <th class="text-center">
                                    <div class="form-group">
                                        <select class="select" name='materials'>
                                            <option value=''>მასალა</option>
                                            @foreach($materials as $material)
                                            <option value='{{$material->name}}'>{{$material->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </th> -->
                            </form>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ownBanners as $ownBanner)
                        
                        <tr style="background: {{ ($today > $ownBanner->end_date) ? '#fc7474' : ''}}"> 
                            <td class="text-center"><a href="../own-banner/{{$ownBanner->id}}">{{$ownBanner->id}}</a></td>
                            <td class="text-center">{{$ownBanner->branch}}</td>
                            <td class="text-center">{{$ownBanner->start_date}}</td>
                            <td class="text-center">{{$ownBanner->end_date}}</td>
                            <td class="text-center">
                                @if($ownBanner->status == 1)
                                თავისუფალი
                                @elseif($ownBanner->status == 2)
                                გაქირავებული
                                @elseif($ownBanner->status == 3)
                                შიდა
                                @endif
                            </td>
                            <td class="text-center">{{$ownBanner->type}}</td>
                            <td class="text-center">{{$ownBanner->section}}
                            
                            </td>
                            <td class="text-center">{{$ownBanner->total_price}}</td>
                            <td class="text-center">
                                @if($ownBanner->payed == 1)
                                ანაზღაურებული
                                @else
                                აუნაზღაურებელი
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_{{$ownBanner->id}}"><i class="fa fa-pencil m-r-5"></i> რედაქტირება</a>
                                        @if(Auth::user() && Auth::user()->role != 2)
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_{{$ownBanner->id}}"><i class="fa fa-trash-o m-r-5"></i>
                                            წაშლა</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->

<!-- Add employee -->
<div id="add_banner" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ბანერის დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action=" {{route('store.own-banner')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სტატუსი</label>
                                <select class="select" name='status'>
                                    <option value='1'>თავისუფალი</option>
                                    <option value='2'>გაქირავებული</option>
                                    <option value='3'>შიდა</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფილიალი</label>
                                <select class="select" name='branch'>
                                    @foreach($branches as $branch)
                                    <option value='{{$branch->name}}'>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ტიპი</label>
                                <select class="select" name='type'>
                                    @foreach($types as $type)
                                    <option value='{{$type->name}}'>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>მასალა</label>
                                <select class="select" name='material'>
                                    @foreach($materials as $material)
                                    <option value='{{$material->name}}'>{{$material->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ზომა</label>
                                <input autocomplete="off" class="form-control" name='size' type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>მისამართი</label>
                                <input autocomplete="off" class="form-control" name='address' type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სექცია</label>
                                <select class="select" name='section'>
                                    <option>სექცია</option>
                                    @foreach($sections as $section)
                                    <option value='{{$section->name}}'>{{$section->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფასი</label>
                                <input autocomplete="off" class="form-control" name='price' type="number" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ვალუტა</label>
                                <select class="select" name='valuta'>
                                    <option value='₾'>₾</option>
                                    <option value='$'>$</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფოტო</label>
                                <input autocomplete="off" class="form-control" name='image' type="file">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">დამატება</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add employee-->

<!-- Edit  Modal -->
@foreach($ownBanners as $ownBanner)
<div id="edit_{{$ownBanner->id}}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ბანერის რედაქტირება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('update.own-banner', ['id' => $ownBanner->id])}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფილიალი</label>
                                <select class="select" name='branch'>
                                    <option value='{{$ownBanner->branch}}'>{{$ownBanner->branch}}</option>
                                    @foreach($branches as $branch)
                                    <option value='{{$branch->name}}'>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სექცია</label>
                                <select class="select" name='section'>
                                    <option value='{{$ownBanner->section}}'>{{$ownBanner->section}}</option>
                                    @foreach($sections as $section)
                                    <option value='{{$section->id}}'>{{$section->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ტიპი</label>
                                <select class="select" name='type'>
                                    <option value='{{$ownBanner->type}}'>{{$ownBanner->type}}</option>
                                    @foreach($types as $type)
                                    <option value='{{$type->name}}'>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სტატუსი</label>
                                <select class="select" name='status'>
                                    @if($ownBanner->status == 1)
                                    <option value='1'>თავისუფალი</option>
                                    @elseif($ownBanner->status == 2)
                                    <option value='2'>გაქირავებული</option>
                                    @elseif($ownBanner->status == 3)
                                    <option value='3'>შიდა</option>
                                    @endif
                                    <option value='1'>თავისუფალი</option>
                                    <option value='2'>გაქირავებული</option>
                                    <option value='3'>შიდა</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>მისამართი</label>
                                <input autocomplete="off" class="form-control" name='address' value="{{$ownBanner->address}}" type="text" placeholder="მისამართი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ზომა</label>
                                <input autocomplete="off" class="form-control" name='size' value="{{$ownBanner->size}}" type="text" required placeholder="ზომა">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფასი</label>
                                <input autocomplete="off" class="form-control" name='price' value="{{$ownBanner->price}}" type="number" required placeholder="ფასი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ვალუტა</label>
                                <select class="select" name='valuta'>
                                    <option value='{{ $ownBanner->valuta }}'>{{ $ownBanner->valuta }}</option>
                                    <option value='₾'>₾</option>
                                    <option value='$'>$</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფოტო</label>
                                <input autocomplete="off" class="form-control" name='image' value="{{$ownBanner->first_image}}" type="file">
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">განახლება</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /delete  Modal -->

<div class="modal custom-modal fade" id="delete_{{$ownBanner->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>ბანერის წაშლა</h3>
                    <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action=" {{route('delete.own-banner', ['id' => $ownBanner->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary continue-btn">დადასურება</button>
                            </div>
                            <div class="col-6">
                                <button type="button" data-dismiss="modal" class="btn btn-primary cancel-btn">გაუქმება</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<div id="expires" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ვადა გასდის</h5>
            </div>
            <div class="modal-body">
                <table class="table table-striped custom-table mb-0 ">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">ქირაობის თარიღი</th>
                            <th class="text-center">ქირაობის ვადა</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expires as $expire)
                        <tr>
                            <td class="text-center">{{$expire->id}}</td>
                            <td class="text-center">{{$expire->start_date}}</td>
                            <td class="text-center">{{$expire->end_date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .content {
        margin-left: 240px !important;
    }
</style>