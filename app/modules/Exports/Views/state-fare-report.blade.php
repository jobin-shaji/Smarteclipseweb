<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Bus Type</th>
        <th>State</th>
        <th>Plain FPKM</th>
        <th>Hill FPKM</th>
        <th>Minimum Fare</th>
    </tr>
    </thead>
    <tbody>
    @foreach($state_fares as $state_fare)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $state_fare->busType->name }}</td>
            <td>{{ $state_fare->state->name }}</td>
            <td>{{ $state_fare->plain_fpkm }}</td>
            <td>{{ $state_fare->hill_fpkm }}</td>
            <td>{{ $state_fare->min_fare }}</td>
        </tr>
    @endforeach
    </tbody>
</table>