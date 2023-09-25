@extends('main.index')
@section('content')

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
                    <a href="#" class="btn add-btn mt-15" data-toggle="modal" data-target="#add_employee"><i
                            class="fa fa-plus"></i>ბანერის დამატება</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center add-nav">
                <div class="col">
                    <h3 class="page-title">იჯარა > ნაქირავები ბანერები</h3>
                    <button type="submit" class="btn btn-success mr-3">გაფილტვრა</button>
                    <h3 class="page-title mt-4">სულ : {{$outdoorBanners->count()}} ბანერი</h3>
                </div>
                @if (Auth::user())
                    <div class="col">
                        <a href="#" class="btn add-btn mt-15" data-toggle="modal" data-target="#add_banner"><i
                                class="fa fa-plus"></i>ბანერის დამატება</a>
                    </div>
                @endif
                <form action="{{ route('index.outdoor-banner') }}">
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
                                <th class="text-center">ID</th>
                                <th class="text-center">მეიჯარე</th>
                                <th class="text-center">მისამართი</th>
                                <th class="text-center">
                                    მონტაჟის თარიღი
                                </th>
                                <th class="text-center">
                                    დემონტაჟის თარიღი
                                </th>
                                <th class="text-center">
                                    <div class="form-group">
                                        <select class="select" name='statuss'>
                                            <option value='{{ $status ? $status : '' }}'>
                                                @if ($status == 1)
                                                    თავისუფალი
                                                @elseif($status == 2)
                                                    ნაქირავები
                                                @else
                                                    სტატუსი
                                                @endif
                                            </option>
                                            <option value=''>სტატუსი</option>
                                            <option value='1'>თავისუფალი</option>
                                            <option value='2'>ნაქირავები</option>
                                        </select>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group">
                                        <select class="select" name='materials'>
                                            <option value='{{ $material ? $material : '' }}'>
                                                {{ $material ? $material : 'მასალა' }}</option>
                                            <option value=''>მასალა</option>
                                            @foreach ($materials as $material)
                                                <option value='{{ $material->name }}'>{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </th>
                                <th class="text-center">ჯამური თანხა</th>
                                <th class="text-center">მოქმედება</th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($outdoorBanners as $outdoorBanner)
                                <tr>
                                    <td class="text-center"><a
                                            href="../outdoor-banner/{{ $outdoorBanner->id }}">{{ $outdoorBanner->id }}</a>
                                    </td>
                                    <td class="text-center">{{ $outdoorBanner->owner }}</td>
                                    <td class="text-center">{{ $outdoorBanner->address }}</td>
                                    <td class="text-center">{{ $outdoorBanner->start_date }}</td>
                                    <td class="text-center">{{ $outdoorBanner->end_date }}</td>
                                    <td class="text-center">
                                        @if ($outdoorBanner->status == 1)
                                            თავისუფალი
                                        @elseif($outdoorBanner->status == 2)
                                            ნაქირავები
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $outdoorBanner->material }}</td>
                                    <td class="text-center">{{ $outdoorBanner->total_price }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if (Auth::user())
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#edit_{{ $outdoorBanner->id }}"><i
                                                            class="fa fa-pencil m-r-5"></i> რედაქტირება</a>
                                                @endif
                                                @if (Auth::user() && Auth::user()->role != 2)
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#delete_{{ $outdoorBanner->id }}"><i
                                                            class="fa fa-trash-o m-r-5"></i>
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
                    <form action=" {{ route('store.outdoor-banner') }}" enctype="multipart/form-data" method="post">
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
                                    <label>ქალაქი</label>
                                    <select class="select" name='city'>
                                        <option value='თბილისი'>თბილისი</option>
                                        <option value='გორი'>გორი</option>
                                        <option value='ბათუმი'>ბათუმი</option>
                                        <option value='რუსთავი'>რუსთავი</option>
                                        <option value='ქუთაისი'>ქუთაისი</option>
                                        <option value='ზუგდიდი'>ზუგდიდი</option>
                                        <option value='თელავი'>თელავი</option>
                                        <option value='ხაშური'>ხაშური</option>
                                        <option value='ქარელი'>ქარელი</option>
                                        <option value='სურამი'>სურამი</option>
                                        <option value='მცხეთა'>მცხეთა</option>
                                    </select>
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
                                    <label>მასალა</label>
                                    <select class="select" name='material'>
                                        @foreach ($materials as $material)
                                            <option value='{{ $material->name }}'>{{ $material->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ფასი</label>
                                    <input autocomplete="off" class="form-control" name='price' type="number"
                                        required>
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
                                    <label>ზომა</label>
                                    <input autocomplete="off" class="form-control" name='size' type="text"
                                        required>
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
    @foreach ($outdoorBanners as $outdoorBanner)
        <!-- Edit Ticket Modal -->
        <div id="edit_{{ $outdoorBanner->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ბანერის რედაქტირება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.outdoor-banner', ['id' => $outdoorBanner->id]) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მისამართი</label>
                                        <input autocomplete="off" class="form-control" name='address'
                                            value="{{ $outdoorBanner->address }}" type="text"
                                            placeholder="მისამართი">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ქალაქი</label>
                                        <select class="select" name='city'>
                                            <option value='{{ $outdoorBanner->city }}'>{{ $outdoorBanner->city }}</option>
                                            <option value='თბილისი'>თბილისი</option>
                                            <option value='გორი'>გორი</option>
                                            <option value='ბათუმი'>ბათუმი</option>
                                            <option value='რუსთავი'>რუსთავი</option>
                                            <option value='ქუთაისი'>ქუთაისი</option>
                                            <option value='ზუგდიდი'>ზუგდიდი</option>
                                            <option value='თელავი'>თელავი</option>
                                            <option value='ხაშური'>ხაშური</option>
                                            <option value='ქარელი'>ქარელი</option>
                                            <option value='სურამი'>სურამი</option>
                                            <option value='მცხეთა'>მცხეთა</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ვალუტა</label>
                                        <select class="select" name='valuta'>
                                            <option value='{{ $outdoorBanner->valuta }}'>{{ $outdoorBanner->valuta }}</option>
                                            <option value='₾'>₾</option>
                                            <option value='$'>$</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მასალა</label>
                                        <select class="select" name='material'>
                                            @foreach ($materials as $material)
                                                <option value='{{ $material->name }}'>{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ფასი</label>
                                        <input autocomplete="off" class="form-control" name='price'
                                            value="{{ $outdoorBanner->price }}" type="number" required
                                            placeholder="ფასი">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ფოტო</label>
                                        <input autocomplete="off" class="form-control" name='image'
                                            value="{{ $outdoorBanner->image }}" type="file">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ზომა</label>
                                        <input autocomplete="off" class="form-control" name='size'
                                            value="{{ $outdoorBanner->size }}" type="text" required
                                            placeholder="ზომა">
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
        <!-- /Edit Ticket Modal -->
        <div id="delete_{{ $outdoorBanner->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>ბანერის წაშლა</h3>
                            <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('delete.outdoor-banner', ['id' => $outdoorBanner->id]) }}"
                                enctype="multipart/form-data" method="post">
                                @csrf
                                @method('delete')
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn">დადასურება</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-primary cancel-btn">გაუქმება</button>
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
                            @foreach ($expires as $expire)
                                <tr>
                                    <td class="text-center">{{ $expire->id }}</td>
                                    <td class="text-center">{{ $expire->start_date }}</td>
                                    <td class="text-center">{{ $expire->end_date }}</td>
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
