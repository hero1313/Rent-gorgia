@extends('main.index')
@section('content')
        <div class="mb-3 ml-3 mt-3">
            <h3>რეპორტი > ბანერების მოიჯარეები</h5>
        </div>
    <h3 class="ml-3 mt-3 mb-5">ჯამური შემოსვალი: {{$total}}ლ</h3>
<div class="table-responsive">
    <table class="table table-striped custom-table mb-0 ">
        <thead>
            <form action="{{route('report.own')}}" method="get">
                <tr>
                    <th class="text-center">
                        <div class="form-group">
                            <input autocomplete="off" class="form-control" name='filter_tenant'
                                placeholder="მოიჯარე" type="text">
                        </div>
                    </th>                    <th class="text-center">ID</th>
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
                    <th class="text-center">სრული თანხა</th>
                    <th class="text-center">ჯამური ჩარიცხვა</th>
                    <th class="text-center">ჯამური დავალიანება</th>
                    <th class="text-center"><button class="btn btn-success">გაფილტვრა</button></th>
                </tr>
            </form>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td class="text-center">{{ $payment->tenant }}</td>
                    <td class="text-center"><a href="/own-banner/{{ $payment->banner_id }}">{{ $payment->banner_id }}</a></td>
                    <td class="text-center">
                        @if($payment->month == 1)
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
                    <td class="text-center">{{ $payment->price }}</td>
                    <td class="text-center">{{ $payment->transfer }}</td>
                    <td class="text-center">{{ $payment->debt }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection