@extends('main.index')
@section('content')
<!-- Page Content -->
<div class="mb-3">
    <h3>/sd/sd</h5>
</div>
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
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i>თანამშრომლის დამატება</a>
            </div>
        </div>
    </div>

    <!-- Search Filter -->
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center add-nav">
            <div class="col">
                <h3 class="page-title">იჯარა > ფართები</h3>
                <button type="submit" class="btn btn-success mr-3">გაფილტვრა</button>
                <h3 class="page-title mt-4">სულ : {{$parties->count()}} ფართი</h3>
            </div>

            @if(Auth::user())
            <div class="col">
                <a href="#" class="btn add-btn mt-15" data-toggle="modal" data-target="#add_party"><i class="fa fa-plus"></i>ფართების დამატება</a>
            </div>
            @endif
            <form action="{{route('index.party')}}">
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#expires">ვადა გასდის</a>
                </div>
        </div>
    </div>

    <!-- Search Filter -->


    <!-- /Search Filter -->

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 ">
                    <thead>
                        <tr>
                            <th class="text-center"><input class="form-control id-input" autocomplete="off" value="{{ $c_id ? $c_id : '' }}" type="text" placeholder="აიდი" name="c_id"></th>
                            <th class="text-center">მისამართი</th>
                            <th class="text-center">
                                <div class="form-group">
                                    <select class="select" name='branchs'>
                                        <option value='{{ $branch ? $branch : "" }}'>{{ $branch ? $branch : "ადგილი" }}</option>
                                        <option value=''>ადგილი</option>
                                        @foreach($branches as $branch)
                                        <option value='{{$branch->name}}'>{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>
                            <!-- <th class="text-center">
                                    <label>ქირაობა</label>
                                </th>
                                <th class="text-center">
                                    <label>დასრულება</label>
                                </th> -->
                            <th class="text-center">ფასი 1კვ.მ</th>
                            <th class="text-center">მოიჯარე</th>

                            <th class="text-center">
                                <div class="form-group">
                                    <select class="select" name='statuss'>
                                        <option value='{{ $status ? $status : "" }}'>
                                                @if($status == 1)
                                                    თავისუფალი
                                                @elseif($status == 2)
                                                    გაქირავებული
                                                @else
                                                    სტატუსი
                                                @endif
                                        </option>
                                        <option value=''>სტატუსი</option>
                                        <option value='1'>გასაქირავებელი</option>
                                        <option value='2'>გაქირავებული</option>
                                    </select>
                                </div>
                            </th>
                            <th class="text-center">ჯამური თანხა</th>
                            <th class="text-center">მოქმედება</th>
                            </form>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parties as $party)
                        <tr>
                            <td class="text-center"><a href="/party/{{$party->id}}">{{$party->id}}</a></td>
                            <td class="text-center">{{$party->address}}</td>
                            <td class="text-center">{{$party->branch}}</td>
                            <td class="text-center">{{$party->price_kv}}</td>
                            <td class="text-center">{{$party->tenant}}</td>
                            <td class="text-center">
                                @if($party->status == 1)
                                არაა გაქირავებული
                                @elseif($party->status == 2)
                                გაქირავებული
                                @endif
                            </td>
                            <td class="text-center">{{$party->total_price}}</td>

                            <!-- <td class="text-center">{{$party->start_date}}</td>
                            <td class="text-center">{{$party->end_date}}</td> -->
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if(Auth::user())
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_{{$party->id}}"><i class="fa fa-pencil m-r-5"></i> რედაქტირება</a>
                                        @endif
                                        @if(Auth::user() && Auth::user()->role != 2)
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_{{$party->id}}"><i class="fa fa-trash-o m-r-5"></i>
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
<div id="add_party" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ფართის დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('store.party')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>მისამართი</label>
                                <input autocomplete="off" class="form-control" name='address' type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ადგილი</label>
                                <select class="select" name='branch'>
                                    @foreach($branches as $branch)
                                    <option value='{{$branch->name}}'>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფოტო</label>
                                <input autocomplete="off" class="form-control" name='image' type="file">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფასი/კვ.მ</label>
                                <input autocomplete="off" class="form-control" name='price_kv' type="number" required>
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
                                <label>ზომა/კვ.მ</label>
                                <input  autocomplete="off" class="form-control" name='size' type="number" required>
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

<!-- Edit Ticket Modal -->

@foreach($parties as $party)
<div id="edit_{{$party->id}}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">რედაქტირება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('update.party', ['id' => $party->id])}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>მისამართი</label>
                                <input autocomplete="off" class="form-control" value='{{$party->address}}' name='address' type="text" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფილიალი</label>
                                <select class="select" name='branch'>
                                    <option value='{{$party->branch}}'>{{$party->branch}}</option>
                                    @foreach($branches as $branch)
                                    <option value='{{$branch->name}}'>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ზომა/კვ.მ</label>
                                <input autocomplete="off" class="form-control" value='{{$party->size}}' name='size' type="number" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფოტო</label>
                                <input autocomplete="off" class="form-control" value='{{$party->image}}' name='image' type="file" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფასი/კვ.მ</label>
                                <input autocomplete="off" class="form-control" value='{{$party->price_kv}}' name='price_kv' type="number" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ვალუტა</label>
                                <select class="select" name='valuta'>
                                    <option value='{{ $party->valuta }}'>{{ $party->valuta }}</option>
                                    <option value='₾'>₾</option>
                                    <option value='$'>$</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
            </div>
            <div class="submit-section">
                <button class="btn btn-primary submit-btn">განახლება</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- /Edit Ticket Modal -->


<div class="modal custom-modal fade" id="delete_{{$party->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>ფართის წაშლა</h3>
                    <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{route('delete.party', ['id' => $party->id])}}" method="post">
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