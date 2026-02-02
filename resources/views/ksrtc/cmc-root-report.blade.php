@extends('layouts.eclipse')

@section('content')
<style>
    .cmc-wrap { white-space: normal !important; word-break: break-word; }
</style>
<div class="container-fluid" style="padding:20px">
    <h3 style="margin-bottom:15px">KSRTC CMC Report (Root)</h3>

    <div style="border:1px solid #eee; border-radius:12px; background:#fff; padding:14px;">
        <div style="overflow:auto;">
            <table class="table table-bordered table-sm w-100" style="table-layout:fixed;">
                <thead>
                    <tr>
                        <th style="width:200px;">Period</th>
                        <th style="width:100px;">Expected Count</th>
                        <th style="width:120px;">Expected Total</th>
                        <th style="width:80px;">Invoice Count</th>
                        <th style="width:120px;">Invoice Total</th>
                        <th class="cmc-wrap">Invoices</th>
                        <th style="width:320px;">Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periods as $p)
                        <tr>
                            <td>
                                <b>{{ $p->title }}</b><br>
                                <small>{{ $p->period_start }} to {{ $p->period_end }}</small>
                            </td>
                            <td>{{ $p->eligible_count ?? 0 }}</td>
                            <td>{{ number_format($p->expected_total ?? 0, 2) }}</td>
                            <td>{{ $p->invoice_device_count ?? 0 }}</td>
                            <td class="cmc-wrap">{{ number_format($p->invoice_total ?? 0, 2) }}</td>
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

                                                <form method="POST"
                                                      action="{{ route('ksrtc.cmc.invoice.delete', $inv->id) }}"
                                                      style="display:inline-block;"
                                                      onsubmit="return confirm('Delete this invoice?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <span style="color:#666;">No invoices uploaded</span>
                                @endif
                            </td>

                            <td style="min-width:320px;">
                              <form method="POST" action="{{ route('ksrtc.cmc.invoice.upload') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="period_id" value="{{ $p->id }}">

                                <div style="margin-bottom:6px;">
                                    <input type="file" name="invoice_file" class="form-control form-control-sm" required>
                                </div>

                                <div style="display:flex; gap:6px; margin-bottom:6px;">
                                    <input type="text" name="invoice_no" class="form-control form-control-sm" placeholder="Invoice No">
                                    <input type="date" name="invoice_date" class="form-control form-control-sm">
                                </div>

                                <div style="display:flex; gap:6px;">
                                  <input type="number" step="0.01" name="amount" class="form-control form-control-sm" placeholder="Amount" required>
                                  <input type="number" name="device_count" class="form-control form-control-sm" placeholder="Device Count" required>
                                  <button type="submit" class="btn btn-sm btn-success">Upload</button>
                                </div>

                              </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;">No periods found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
