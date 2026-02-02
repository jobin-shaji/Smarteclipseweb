@extends('layouts.eclipse')

@section('content')
<div class="container" style="padding:20px">
    <h3 style="margin-bottom:15px">KSRTC CMC Report</h3>

    <div style="border:1px solid #eee; border-radius:12px; background:#fff; padding:14px;">
        <div style="overflow:auto;">
            <table class="table table-bordered table-sm" style="min-width:900px;">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Total Invoice Amount</th>
                        <th>Invoices</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periods as $p)
                        <tr>
                            <td>
                                <b>{{ $p->title }}</b><br>
                                <small>{{ $p->period_start }} to {{ $p->period_end }}</small>
                            </td>

                            <td>{{ number_format($p->invoice_total ?? 0, 2) }}</td>

                            <td>
                                @if($p->invoices->count() > 0)
                                    @foreach($p->invoices as $inv)
                                        <div style="border:1px solid #f0f0f0; padding:8px; border-radius:10px; margin-bottom:8px;">
                                            <div><b>{{ $inv->original_name }}</b></div>
                                            <div style="font-size:12px; color:#666;">
                                                Invoice No: {{ $inv->invoice_no ?? '-' }} |
                                                Date: {{ $inv->invoice_date ?? '-' }} |
                                                Amount: {{ number_format($inv->amount, 2) }}
                                            </div>

                                            <div style="margin-top:6px;">
                                                <a class="btn btn-sm btn-primary"
                                                   href="{{ route('ksrtc.cmc.invoice.download', $inv->id) }}">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <span style="color:#666;">No invoices uploaded</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center;">No periods found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
