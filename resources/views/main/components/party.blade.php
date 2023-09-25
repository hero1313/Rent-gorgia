@extends('main.index')
@section('content')
    <!-- Page Content -->

    <div class="content container-fluid">
        <div class="mb-3">
            <h3>იჯარა > ფართები</h5>
        </div>
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">ID {{ $party->id }}</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="row col-md-7 col-12">
                <div class="col-md-5 col-12 item-img">
                    <img src="../assets/image/{{ $party->image }}">
                </div>
                <div class="col-md-7 col-12 item-desc">
                    <li>
                        მიმდინარე იჯარის დასაწყისი: {{ $party->start_date }}
                    </li>
                    <li>
                        მიმდინარე იჯარის დასასრული: {{ $party->end_date }}
                    </li>
                    <li>
                        მისამართი: {{ $party->address }}
                    </li>
                    <li>
                        სტატუსი:
                        @if ($party->status == 1)
                            გასაქირავებელი
                        @elseif($party->status == 2)
                            გაქირავებული
                        @endif
                    </li>
                    {{-- <li>
                    ფილიალი: {{$party->branch}}
                </li> --}}
                    <li>
                        კვ.მ: {{ $party->size }}
                    </li>
                    <li>
                        კვ.მ ფასი: {{ $party->price_kv }}
                    </li>
                    <li>
                        ჯამური თანხა: {{ $party->total_price }}
                    </li>
                    {{-- <li>
                    ანაზღაურების სტატუსი:
                    @if ($party->payed == 0)
                    აუნაზღაურებელი
                    @elseif($party->payed == 1)
                    ანაზღაურებული
                    @endif
                </li> --}}
                    <li>
                        ავტორი: {{ $party->user_id }}
                    </li>
                    <li>
                        მოიჯარე: {{ $party->tenant }}
                    </li>
                    <li>
                        მოიჯარის ნომერი: {{ $party->tenant_number }}
                    </li>
                    <li>
                        საიდენტიფიკაციო კოდი: {{ $party->tenant_identification }}
                    </li>
                    <li>
                        ვალუტა: {{ $party->valuta }}
                    </li>
                </div>
            </div>
            <div class="row col-md-5 col-12">
                <button class="btn comment-btn btn-success btn-edit" data-toggle="modal"
                    data-target="#edit_party_{{ $party->id }}">რედაქტირება</button>

                <div class="comments">
                    <h4>
                        კომენტარები
                    </h4>
                    <button class="btn comment-btn btn-primary" data-toggle="modal"
                        data-target="#add_comment">დაკომენტარება</button>
                    @if ($party->document)
                        <a role="button" href="../assets/image/{{ $party->document }}" download="ijara">
                            <button class="btn comment-btn btn-success">ხელშეკრულების გადმოწერა</button>
                        </a>
                    @endif

                    @foreach ($comments as $comment)
                        @php
                            $replies = DB::table('comments')
                                ->where('reply_comment_id', '=', $comment->id)
                                ->orderBy('created_at', 'DESC')
                                ->get();
                        @endphp
                        <div class="comment">
                            <div>
                                <button data-toggle="modal" data-target="#delete_comment_{{ $comment->id }}"
                                    class="btn btn-primary reply-btn">წაშლა</button>
                                <button data-toggle="modal" data-target="#update_comment_{{ $comment->id }}"
                                    class="btn btn-primary reply-btn">რედაქტირება</button>
                                <button data-toggle="modal" data-target="#reply_{{ $comment->id }}"
                                    class="btn btn-primary reply-btn">პასუხი</button>
                            </div>
                            <h5 class="comment-name">
                                {{ $comment->user_name }}
                            </h5>
                            <h5 class="comment-date">
                                {{ $comment->created_at }}
                            </h5>
                            <h6 class="comment-text">
                                {{ $comment->text }}
                            </h6>
                            @foreach ($replies as $reply)
                                <div id="update_comment_{{ $reply->id }}" class="modal custom-modal fade"
                                    role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">კომენტარის რედაქტირება</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action=" {{ route('update.comment', ['comment_id' => $reply->id]) }}"
                                                    enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    {{ method_field('put') }}
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>კომენტარი</label>
                                                                <textarea class="form-control" name='comment' type="text" required>
                                                        {{ $reply->text }}
                                                    </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary submit-btn">
                                                            რედაქტირება
                                                        </button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="delete_comment_{{ $reply->id }}" class="modal custom-modal fade"
                                    role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">კომენტარის წაშლა</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action=" {{ route('delete.comment', ['comment_id' => $reply->id]) }}"
                                                    enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary submit-btn">წაშლა</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-comment">
                                    <div class="comment">
                                        <button data-toggle="modal" data-target="#delete_comment_{{ $reply->id }}"
                                            class="btn btn-primary reply-btn">წაშლა</button>
                                        <button data-toggle="modal" data-target="#update_comment_{{ $reply->id }}"
                                            class="btn btn-primary reply-btn">რედაქტირება</button>
                                        <h5 class="comment-name">
                                            {{ $reply->user_name }}
                                        </h5>
                                        <h5 class="comment-date">
                                            {{ $reply->created_at }}
                                        </h5>
                                        <h6 class="comment-text">
                                            {{ $reply->text }}
                                        </h6>
                                        <div class="sub-comment">

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <hr>
        <div class="col mb-5">
            <h3 class="page-title">ჩარიცხვები</h3>
            <div class="row">
                @if (Auth::user())
                    <div class="col-12 float-right ml-12 add-record">
                        <button class="btn add-btn " data-toggle="modal" data-target="#add_payment"><i
                                class="fa fa-plus"></i>ჩარიცხვები დამატება</button>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 ">
                            <thead>
                                <form action="/party/{{ $party->id }}" method="get">
                                    <tr>
                                        <th class="text-center">
                                            <div class="form-group">
                                                <select class="select" name='filter_month'>
                                                    <option value="">თვე</option>
                                                    <option value='1'>იანვარი</option>
                                                    <option value='2'>თებერვალი</option>
                                                    <option value='3'>მარტი</option>
                                                    <option value='4'>აპრილი</option>
                                                    <option value='5'>მაისი</option>
                                                    <option value='6'>ივნისი</option>
                                                    <option value='7'>ივლისი</option>
                                                    <option value='8'>აგვისტო</option>
                                                    <option value='9'>სექტემბერი</option>
                                                    <option value='10'>ოქტომბერი</option>
                                                    <option value='11'>ნოემბერი</option>
                                                    <option value='12'>დეკემბერი</option>
                                                </select>
                                            </div>
                                        </th>
                                        <th class="text-center">
                                            <div class="form-group">
                                                <select class="select" name='filter_years'>
                                                    <option value="">წელი</option>
                                                    <option value='2023'>2023</option>
                                                    <option value='2024'>2024</option>
                                                    <option value='2025'>2025</option>
                                                    <option value='2026'>2026</option>
                                                    <option value='2027'>2027</option>
                                                    <option value='2028'>2028</option>
                                                </select>
                                            </div>
                                        </th>
                                        <th class="text-center">
                                            <div class="form-group">
                                                <select class="select" name='filter_status'>
                                                    <option value="">სტატუსი</option>
                                                    <option value='გაქირავებული'>გაქირავებული</option>
                                                    <option value='გაქირავებული'>გაქირავებული</option>
                                                    <option value='შიდა'>შიდა</option>
                                                </select>
                                            </div>
                                        </th>
                                        <th class="text-center">
                                            <div class="form-group">
                                                <input autocomplete="off" class="form-control" name='filter_tenant'
                                                    placeholder="მოიჯარე" type="text">
                                            </div>
                                        </th>
                                        <th class="text-center">თანხა</th>
                                        <th class="text-center">ჩარიცხვა</th>
                                        <th class="text-center">დავალიანება</th>
                                        <th class="text-center"><button class="btn btn-success">გაფილტვრა</button></th>
                                    </tr>
                                </form>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="text-center">
                                            @if ($payment->month == 1)
                                                იანვარი
                                            @elseif($payment->month == 2)
                                                თებერვალი
                                            @elseif($payment->month == 3)
                                                მარტი
                                            @elseif($payment->month == 4)
                                                აპრილი
                                            @elseif($payment->month == 5)
                                                მაისი
                                            @elseif($payment->month == 6)
                                                ივნისი
                                            @elseif($payment->month == 7)
                                                ივლისი
                                            @elseif($payment->month == 8)
                                                აგვისტო
                                            @elseif($payment->month == 9)
                                                სექტემბერი
                                            @elseif($payment->month == 10)
                                                ოქტომბერი
                                            @elseif($payment->month == 11)
                                                ნოემბერი
                                            @elseif($payment->month == 12)
                                                დეკემბერი
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $payment->years }}</td>
                                        <td class="text-center">{{ $payment->status }}</td>
                                        <td class="text-center">{{ $payment->tenant }}</td>
                                        <td class="text-center">{{ $payment->price }}</td>
                                        <td class="text-center">{{ $payment->transfer }}</td>
                                        <td class="text-center">{{ $payment->debt }}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if (Auth::user())
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#edit_payment_{{ $payment->id }}"><i
                                                                class="fa fa-pencil m-r-5"></i> რედაქტირება</a>
                                                    @endif
                                                    @if (Auth::user() && Auth::user()->role != 2)
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_payment_{{ $payment->id }}"><i
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

        <div class="col">
            <h3 class="page-title">ჩანაწერი</h3>
            <div class="row">
                @if (Auth::user())
                    <div class="col-12 float-right ml-12 add-record">
                        <button class="btn add-btn " data-toggle="modal" data-target="#add_record"><i
                                class="fa fa-plus"></i>ჩანაწერის დამატება</button>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 ">
                            <thead>
                                <tr>
                                    <form action="/123">
                                        <th class="text-center">ID</th>
                                        <th class="text-center">მოიჯარე</th>
                                        <th class="text-center">ს/კ</th>
                                        <th class="text-center">იჯარის დასაწყისი</th>
                                        <th class="text-center">იჯარის დასასრული</th>
                                        <th class="text-center">ჯამური თანხა</th>
                                        <th class="text-center">ხელშეკრულება</th>
                                        <th class="text-center">მოქმედება</th>
                                    </form>
                                </tr>

                            </thead>

                            <body>
                                @foreach ($partyRecords as $partyRecord)
                                    <tr>
                                        <td class="text-center">{{ $partyRecord->id }}</td>
                                        <td class="text-center">{{ $partyRecord->tenant }}</td>
                                        <td class="text-center">{{ $partyRecord->tenant_identification_code }}</td>
                                        <td class="text-center">{{ $partyRecord->start_date }}</td>
                                        <td class="text-center">{{ $partyRecord->end_date }}</td>
                                        <td class="text-center">{{ $partyRecord->total_price }}</td>
                                        <td class="text-center">
                                            @if ($partyRecord->image)
                                                <a role="button" href="../assets/image/{{ $partyRecord->image }}"
                                                    download="ijara">
                                                    <button class="btn comment-btn btn-success">ხელშეკრულება</button>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if (Auth::user())
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#edit_{{ $partyRecord->id }}"><i
                                                                class="fa fa-pencil m-r-5"></i> რედაქტირება</a>
                                                    @endif
                                                    @if (Auth::user() && Auth::user()->role != 2)
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_{{ $partyRecord->id }}"><i
                                                                class="fa fa-trash-o m-r-5"></i>
                                                            წაშლა</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </body>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /Page Content -->

    <div id="add_record" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ჩანაწერის დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.party-record', ['id' => $party->id]) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>მონტაჟის თარიღი</label>
                                    <div>
                                        <input class="form-control " autocomplete="off" id="start_date"
                                            name='start_date' type="date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>დემონტაჟის თარიღი</label>
                                    <div>
                                        <input class="form-control " autocomplete="off" id="end_date" name='end_date'
                                            type="date" onfocusout="calculatePrice()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ჯამური ფასი</label>
                                    <input class="form-control" autocomplete="off" id="total_price" name='total_price'
                                        type="number" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ანაზღაურების სტატუსი</label>
                                    <select class="select" name='payed'>
                                        <option value='1'>ანაზღაურებული</option>
                                        <option value='0'>აუნაზღაურებელი</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>მოიჯარე</label>
                                    <input class="form-control" autocomplete="off" name='tenant' type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>მოიჯარის ს/კ</label>
                                    <input class="form-control" autocomplete="off" name='tenant_identification'
                                        type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>მოიჯარეს ნომერი</label>
                                    <input class="form-control" autocomplete="off" name='tenant_number' type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>მოიჯარეს იმეილი</label>
                                    <input class="form-control" autocomplete="off" name='tenant_email' type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ხელშეკრულება</label>
                                    <input class="form-control" autocomplete="off" name='image' type="file">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit">დამატება</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @foreach ($partyRecords as $partyRecord)
        <div id="edit_{{ $partyRecord->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ჩანაწერის რედაქტირება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.party-record', ['id' => $partyRecord->id]) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მონტაჟის თარიღი</label>
                                        <div>
                                            <input class="form-control " autocomplete="off"
                                                value="{{ $partyRecord->start_date }}" name='start_date' type="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>დემონტაჟის თარიღი</label>
                                        <div>
                                            <input class="form-control " autocomplete="off"
                                                value="{{ $partyRecord->end_date }}" name='end_date' type="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ჯამური თანხა</label>
                                        <input class="form-control" autocomplete="off"
                                            value="{{ $partyRecord->total_price }}" name='total_price' type="number"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ანაზღაურების სტატუსი</label>
                                        <select class="select" name='payed'>
                                            <option value='{{ $partyRecord->payed }}'>
                                                @if ($partyRecord->payed == 0)
                                                    აუნაზღაურებელი
                                                @elseif($partyRecord->payed == 1)
                                                    ანაზღაურებული
                                                @endif
                                            </option>
                                            <option value='1'>ანაზღაურებული</option>
                                            <option value='0'>აუნაზღაურებელი</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მოიჯარე</label>
                                        <input class="form-control" autocomplete="off"
                                            value="{{ $partyRecord->tenant }}" name='tenant' type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მოიჯარის საიდენთიფიკაციო ნომერი</label>
                                        <input class="form-control" autocomplete="off"
                                            value="{{ $partyRecord->tenant_identification_code }}"
                                            name='tenant_identification' type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მოიჯარის ნომერი</label>
                                        <input class="form-control" autocomplete="off"
                                            value="{{ $partyRecord->tenant_number }}" name='tenant_number'
                                            type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მოიჯარის იმეილი</label>
                                        <input class="form-control" autocomplete="off"
                                            value="{{ $partyRecord->tenant_email }}" name='tenant_email' type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ხელშეკრულება</label>
                                        <input class="form-control" value="{{ $partyRecord->image }}" autocomplete="off" name='image' type="file">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>სტატუსი</label>
                                        <select class="select" name='status'>
                                            <option value='{{ $partyRecord->status }}'>
                                                @if ($partyRecord->status == 1)
                                                    დასრულებული
                                                @elseif($partyRecord->status == 2)
                                                    აქტიური
                                                @endif
                                            </option>
                                            <option value='2'>აქტიური</option>
                                            <option value='1'>დასრულებული</option>
                                        </select>
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
        <div id="delete_{{ $partyRecord->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>ბანერის წაშლა</h3>
                            <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('delete.party-record', ['id' => $partyRecord->id]) }}"
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


    <!-- comment -->
    @foreach ($comments as $comment)
        <div id="reply_{{ $comment->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">კომენტარის რედაქტირება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form
                            action=" {{ route('store.comment', ['object_index' => 3, 'object_id' => $party->id, 'comment_id' => $comment->id]) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>კომენტარი</label>
                                        <textarea class="form-control" name='comment' type="text" required>
                                </textarea>
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
        <div id="update_comment_{{ $comment->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">კომენტარის რედაქტირება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action=" {{ route('update.comment', ['comment_id' => $comment->id]) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            {{ method_field('put') }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>კომენტარი</label>
                                        <textarea class="form-control" name='comment' type="text" required>
                                    {{ $comment->text }}
                                </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">
                                    რედაქტირება
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="delete_comment_{{ $comment->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">კომენტარის წაშლა</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action=" {{ route('delete.comment', ['comment_id' => $comment->id]) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            @method('delete')
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">წაშლა</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div id="add_comment" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">კომენტარის დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form
                        action=" {{ route('store.comment', ['object_index' => 3, 'object_id' => $party->id, 'comment_id' => 0]) }}"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>კომენტარი</label>
                                    <textarea class="form-control" name='comment' type="text" required>
                                </textarea>
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

    <div id="edit_party_{{ $party->id }}" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">რედაქტირება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.party', ['id' => $party->id]) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>მისამართი</label>
                                    <input autocomplete="off" class="form-control" value='{{ $party->address }}'
                                        name='address' type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ფილიალი</label>
                                    <select class="select" name='branch'>
                                        <option value='{{ $party->branch }}'>{{ $party->branch }}</option>
                                        @foreach ($branches as $branch)
                                            <option value='{{ $branch->name }}'>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ფასი / კვ.მ</label>
                                    <input autocomplete="off" class="form-control" value='{{ $party->price_kv }}'
                                        name='price_kv' type="number" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ფოტო</label>
                                    <input autocomplete="off" class="form-control" value='{{ $party->image }}'
                                        name='image' type="file">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ზომა / კვ.მ</label>
                                    <input autocomplete="off" class="form-control" value='{{ $party->size }}'
                                        name='size' type="number" required>
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
    <div id="add_payment" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ჩარიცხვის დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.payment', ['id' => $party->id, 'index' => 3]) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>თვე</label>
                                    <select class="select" name='month'>
                                        <option value='1'>იანვარი</option>
                                        <option value='2'>თებერვალი</option>
                                        <option value='3'>მარტი</option>
                                        <option value='4'>აპრილი</option>
                                        <option value='5'>მაისი</option>
                                        <option value='6'>ივნისი</option>
                                        <option value='7'>ივლისი</option>
                                        <option value='8'>აგვისტო</option>
                                        <option value='9'>სექტემბერი</option>
                                        <option value='10'>ოქტომბერი</option>
                                        <option value='11'>ნოემბერი</option>
                                        <option value='12'>დეკემბერი</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>სტატუსი</label>
                                    <select class="select" name='status'>
                                        <option value='გაქირავებული'>გაქირავებული</option>
                                        <option value='გაქირავებული'>გაქირავებული</option>
                                        <option value='შიდა'>შიდა</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>წელი</label>
                                    <select class="select" name='years'>
                                        <option value='2023'>2023</option>
                                        <option value='2024'>2024</option>
                                        <option value='2025'>2025</option>
                                        <option value='2026'>2026</option>
                                        <option value='2027'>2027</option>
                                        <option value='2028'>2028</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>მოიჯარე</label>
                                    <input autocomplete="off" class="form-control" name='tenant' type="text">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>თანხა</label>
                                    <input autocomplete="off" class="form-control tanxa" name='price' type="text">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ჩარიცხვა</label>
                                    <input autocomplete="off" class="form-control charicxva" name='transfer' type="text">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mt-2">
                                    <button class="btn btn-primary gamotvla mt-4" type="button">დავალიანების დათვლა</button>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>დავალიანება</label>
                                    <input autocomplete="off" class="form-control davalianeba" name='debt' type="text">
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

    @foreach ($payments as $payment)
        <div id="edit_payment_{{ $payment->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ჩარიცხვის რედაქტირება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.payment', ['id' => $payment->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>თვე</label>
                                        <select class="select" name='month'>
                                            <option value='{{ $payment->month }}'>
                                                @if ($payment->month == 1)
                                                    იანვარი
                                                @elseif($payment->month == 2)
                                                    თებერვალი
                                                @elseif($payment->month == 3)
                                                    მარტი
                                                @elseif($payment->month == 4)
                                                    აპრილი
                                                @elseif($payment->month == 5)
                                                    მაისი
                                                @elseif($payment->month == 6)
                                                    ივნისი
                                                @elseif($payment->month == 7)
                                                    ივლისი
                                                @elseif($payment->month == 8)
                                                    აგვისტო
                                                @elseif($payment->month == 9)
                                                    სექტემბერი
                                                @elseif($payment->month == 10)
                                                    ოქტომბერი
                                                @elseif($payment->month == 11)
                                                    ნოემბერი
                                                @elseif($payment->month == 12)
                                                    დეკემბერი
                                                @endif
                                            </option>
                                            <option value='1'>იანვარი</option>
                                            <option value='2'>თებერვალი</option>
                                            <option value='3'>მარტი</option>
                                            <option value='4'>აპრილი</option>
                                            <option value='5'>მაისი</option>
                                            <option value='6'>ივნისი</option>
                                            <option value='7'>ივლისი</option>
                                            <option value='8'>აგვისტო</option>
                                            <option value='9'>სექტემბერი</option>
                                            <option value='10'>ოქტომბერი</option>
                                            <option value='11'>ნოემბერი</option>
                                            <option value='12'>დეკემბერი</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>სტატუსი</label>
                                        <select class="select" name='status'>
                                            <option value='{{ $payment->status }}'>{{ $payment->status }}</option>
                                            <option value='გაქირავებული'>გაქირავებული</option>
                                            <option value='თავისუფალი'>თავისუფალი</option>
                                            <option value='შიდა'>შიდა</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>წელი</label>
                                        <select class="select" name='years'>
                                            <option value='{{ $payment->years }}'>{{ $payment->years }}</option>
                                            <option value='2023'>2023</option>
                                            <option value='2024'>2024</option>
                                            <option value='2025'>2025</option>
                                            <option value='2026'>2026</option>
                                            <option value='2027'>2027</option>
                                            <option value='2028'>2028</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>მოიჯარე</label>
                                        <input autocomplete="off" class="form-control" value="{{ $payment->tenant }}"
                                            name='tenant' type="text">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>თანხა</label>
                                        <input autocomplete="off" class="form-control tanxa-{{$payment->id}}" value="{{ $payment->price }}"
                                            name='price' type="text">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ჩარიცხვა</label>
                                        <input autocomplete="off" class="form-control charicxva-{{$payment->id}}" value="{{ $payment->transfer }}"
                                            name='transfer' type="text">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group mt-2">
                                        <button class="btn btn-primary  mt-4" onclick="gamotvla({{ $payment->id }})" type="button">დავალიანების დათვლა</button>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>დავალიანება</label>
                                        <input autocomplete="off" class="form-control davalianeba-{{$payment->id}}" value="{{ $payment->debt }}"
                                            name='debt' type="text">
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
        <div id="delete_payment_{{ $payment->id }}" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>ჩარიცხვის წაშლა</h3>
                            <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('delete.payment', ['id' => $payment->id]) }}"
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

    <script>
        function calculatePrice() {
            var price = "{{ $party->price_kv }}"
            var size = "{{ $party->size }}"
            var first_date = $('#start_date').val()
            var end_date = $('#end_date').val()

            function treatAsUTC(date) {
                var result = new Date(date);
                result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
                return result;
            }

            function daysBetween(startDate, endDate) {
                var millisecondsPerDay = 24 * 60 * 60 * 1000;
                return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
            }

            var total_price = daysBetween(first_date, end_date) * price / 30.5 * size
            $("#total_price").val(parseInt(total_price));

        }
    </script>
@endsection
