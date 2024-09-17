<tr>
    <td colspan="{{ $colspan_num }}"><strong> กะ B ก่อนการใช้งาน </strong></td>
</tr>
@foreach ($parts as $part)
    <tr>
        @if (count($part->part_records) > 0)
            @if (isset($part->part_records))
                <td>{{ $part->sequence }} </td>
                <td>{{ $part->name }} </td>

                @foreach ($cheklists as $cheklist)
                    @if (isset($b_before_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]))
                        @if ($b_before_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'pass')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-check rounded-5 btn-success'></i></h4>

                            </td>
                        @endif

                        @if ($b_before_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'NOT')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-x rounded-5 btn-danger'></i></h4>
                            </td>
                        @endif
                    @else
                        <td class="bg-secondary" style="text-align: center ;width: 50px">-</td>
                    @endif
                @endforeach
            @endif
        @endif
@endforeach

<tr>
    <td colspan="{{ $colspan_num }}"><strong> กะ B หลังการใช้งาน </strong></td>
</tr>
@foreach ($parts as $part)
    <tr>
        @if (count($part->part_records) > 0)
            @if (isset($part->part_records))
                <td>{{ $part->sequence }} </td>
                <td>{{ $part->name }} </td>
                @foreach ($cheklists as $cheklist)
                    @if (isset($b_after_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]))
                        @if ($b_after_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'pass')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-check rounded-5 btn-success'></i></h4>

                            </td>
                        @endif

                        @if ($b_after_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'NOT')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-x rounded-5 btn-danger'></i></h4>
                            </td>
                        @endif
                    @else
                        <td class="bg-secondary" style="text-align: center ;width: 50px">-</td>
                    @endif
                @endforeach
            @endif
        @endif
@endforeach

<tr>
    <td colspan="{{ $colspan_num }}"><strong> กะ C ก่อนการใช้งาน </strong></td>
</tr>
@foreach ($parts as $part)
    <tr>
        @if (count($part->part_records) > 0)
            @if (isset($part->part_records))
                <td>{{ $part->sequence }} </td>
                <td>{{ $part->name }} </td>
                @foreach ($cheklists as $cheklist)
                    @if (isset($c_before_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]))
                        @if ($c_before_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'pass')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-check rounded-5 btn-success'></i></h4>

                            </td>
                        @endif

                        @if ($c_before_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'NOT')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-x rounded-5 btn-danger'></i></h4>
                            </td>
                        @endif
                    @else
                        <td class="bg-secondary" style="text-align: center ;width: 50px">-</td>
                    @endif
                @endforeach
            @endif
        @endif
@endforeach

<tr>
    <td colspan="{{ $colspan_num }}"><strong> กะ C หลังการใช้งาน</strong></td>
</tr>
@foreach ($parts as $part)
    <tr>
        @if (count($part->part_records) > 0)
            @if (isset($part->part_records))
                <td>{{ $part->sequence }} </td>
                <td>{{ $part->name }} </td>
                {{-- <td>pic </td> --}}
                @foreach ($cheklists as $cheklist)
                    @if (isset($c_after_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]))
                        @if ($c_after_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'pass')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-check rounded-5 btn-success'></i></h4>

                            </td>
                        @else
                        @endif

                        @if ($c_after_data[$dt->format('Y-m-d')][$part->id][$cheklist->seq]->status == 'NOT')
                            <td class="align-middle" style="text-align: center ;width: 50px">
                                <h4><i class='bx bx-x rounded-5 btn-danger'></i></h4>
                            </td>
                        @endif
                    @else
                        <td class="bg-secondary" style="text-align: center ;width: 50px">-</td>
                    @endif
                @endforeach
            @endif
        @endif
@endforeach
