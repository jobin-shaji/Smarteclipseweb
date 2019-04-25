<table>
    <thead>
    <tr>
        <th>Stage</th>
        <th>KM</th>
        <th>Fare</th>
    </tr>
    </thead>
    <tbody>
    @foreach($route->stages as $stage)
        <tr>
            <td>{{ $stage->name}}</td>
            <td>{{ $stage->pivot->km}}</td>
            <td>{{\App\Vst\Fare\FareSlab::slabify($stage->id,$route->id,2)}}</td>
    @endforeach
    </tbody>
</table>